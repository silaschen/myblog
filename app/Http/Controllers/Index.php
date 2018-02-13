<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
define('PAGE_SIZE', 5);
class Index extends Controller{
	const UPLOAD_PATH = 'upload/ck';

	public function index(){

		$rank=DB::select("select * from blog order by view desc limit 3");
		$tag = DB::select("select * from tag order by relation desc");
		return view('index/index',['nowpage'=>1,'rank'=>$rank,'tag'=>$tag]);

	}

	public function blog(){

		$tag = filter_input(INPUT_POST, 'tag') ? filter_input(INPUT_POST, 'tag') : null;
		$search = filter_input(INPUT_POST, 'search') ? filter_input(INPUT_POST, 'search') :null;
		$page = filter_input(INPUT_POST, 'page') ? filter_input(INPUT_POST, 'page') :1;
		$start = ($page-1)*PAGE_SIZE;

		$sql = "select id,title,updatetime,cover,content from blog where title like '%s' ";
		if($tag){
		
			$sql .= "and id in %s ";
			$sql .= " order by updatetime desc limit %d,%d";
			$sql = sprintf($sql,"%".$search."%","(select blogid from tag_blog where tagid=$tag)",$start,PAGE_SIZE);
		}else{
			$sql .= " order by updatetime desc limit %d,%d";
			$sql = sprintf($sql,"%".$search."%",$start,PAGE_SIZE);
		}
		
		$list = DB::select($sql);
		foreach($list as $k=> $ret){
			$list[$k]->desc = mb_substr($list[$k]->content,0,80,'utf8');
			unset($list[$k]->content);
		}
		exit(json_encode(['blog'=>$list,'page'=>$page]));

	}


	//READ BLOG
	public function read($id){
		$blog = DB::select("select * from blog where id=?",[$id])[0];
		$comment = DB::select(sprintf("select * from blog_comment where blogid=%d order by id desc",$id));
		DB::update("update blog set view=? where id=?",[$blog->view+1,$id]);
		return view('index/read',['blog'=>$blog,'comment'=>$comment]);

	}


	public function write(){
		if($_SERVER['REQUEST_METHOD'] === 'GET'){

			return view('index/write');
		}else{

			$data = $_POST;
			$blog['uid'] = 1;
			$blog['updatetime'] = time();
			$blog['title']= $data['title'];
			$blog['cover'] = $data['cover'];
			$blog['content']= $data['content'];
			$tag = explode(" ", $data['tag']);
			$sql1 = DB::table('blog')->insertGetId($blog);
			if($tag){

				for ($i=0; $i < count($tag); $i++) { 
					
					$flag = DB::select("select * from tag where name=?",[$tag[$i]]);
			$flag = $flag?$flag[0]:null;
					if($flag){
						DB::update("update tag set relation=? where id=?",[$flag->relation+1,$flag->id]);
						$tagid = $flag->id;
					}else{

						$tagid = DB::table("tag")->insertGetId(['name'=>$tag[$i],'relation'=>1]);
					}

					DB::insert("insert into tag_blog (tagid,blogid) values (?,?)",[$tagid,$sql1]);
				}


			}
			exit(json_encode(['code'=>1,'id'=>$sql1]));
		}


	}


	public function edit($id){

		$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
		if($method === 'GET'){
			$essay = DB::table('blog')->find($id);
			return view('index/edit',['blog'=>$essay]);
		}else{
			$blog = $_POST;
			DB::table('blog')->where(['id'=>$blog['id']])->update(['title'=>$blog['title'],'cover'=>$blog['cover'],'content'=>$blog['content']]);
			exit(json_encode(['code'=>1]));
		}



	}

		#上传#
	public function uploadImg(Request $request){

			$file = $_FILES['files'];
			$img = $request->file('files');
			$filename = 'upload/img/'.'aaa'.time().'.jpg';
			move_uploaded_file($file['tmp_name'],$filename);
			exit(json_encode(['file'=>$filename,'ret'=>1]));
		
	}


		#kindeditor上传#
	public function uploadeditor(){

			$file = $_FILES['imgFile'];
			$target = self::UPLOAD_PATH."/".md5(time()).'.jpg';
			move_uploaded_file($file['tmp_name'], $target);
			exit(json_encode(['error'=>0,'url'=>config('url').'/'.$target]));
	
		
	}


	//comment
	public function comment($id){

		$comment = filter_input(INPUT_POST, 'content');
		if(!empty($comment)){
			$sql = sprintf("insert into blog_comment (blogid,content,time) values (%d,'%s','%s')",$id,$comment,time());
			DB::insert($sql);
			exit(json_encode(['code'=>1,'time'=>date("M d,Y H:i",time()),'content'=>$comment]));
		}


	}

	//http curl
	public function Curl_Http($url,$header=array(),$data=null){
		$handler = curl_init();
		curl_setopt($handler,CURLOPT_URL,$url);
		curl_setopt($handler,CURLOPT_RETURNTRANSFER,true);
		if($method === 'post'){
			curl_setopt($handler,CURLOPT_POST,true);
			curl_setopt($handler,CURLOPT_POSTFIELDS,json_encode($data));
		}
		
		if($header){
			 $header = array_merge(array('Content-type: application/json', 'Accept: application/json'),$header);


		}

		curl_setopt($handler,CURLOPT_HTTPHEADER,$header);

		$res = curl_exec($handler);

		return json_decode($res,true);
	}






}
