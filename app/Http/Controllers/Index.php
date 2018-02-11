<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
define('PAGE_SIZE', 6);
class Index extends Controller{
	

	public function index(){
		
		$list = DB::select("select * from blog order by updatetime desc limit ?,4",[0]);
		$rank=DB::select("select * from blog order by view desc limit 3");
		$tag = DB::select("select * from tag order by relation desc");
		return view('index/index',['list'=>$list,'nowpage'=>1,'rank'=>$rank,'tag'=>$tag]);

	}

	public function blog(){

		$tag = filter_input(INPUT_POST, 'tag') ? filter_input(INPUT_POST, 'tag') : null;
		$search = filter_input(INPUT_POST, 'search') ? filter_input(INPUT_POST, 'search') :null;
		$page = filter_input(INPUT_POST, 'page') ? filter_input(INPUT_POST, 'page') :1;
		$start = ($page-1)*PAGE_SIZE;

		$sql = "select a.id,a.title,a.updatetime from blog where title like '%s' ";
		if($tag){
		
			$sql .= "and id in %s ";
			$param = ["%".$search."%","(select blogid from tag_blog where tag='$tag')",$start,PAGE_SIZE];
		}else{

			$param = ["%".$search."%",$start,PAGE_SIZE];

		}
		$sql .= " order by updatetime desc limit %d,%d";

		
		$sql = sprintf($sql,$param);
		var_dump($sql);
		$list = DB::select($sql);
		var_dump($list);

	}

	public function list($page){
		$page = $page?$page:1;
		$start = ($page-1)*4;
		$list = DB::select("select * from blog order by updatetime desc limit ?,4",[$start]);
		$rank=DB::select("select * from blog order by view desc limit 3");
		$tag = DB::select("select * from tag order by relation desc");

		return view('index/list',['list'=>$list,'nowpage'=>$page,'rank'=>$rank,'tag'=>$tag]);

	}

	//READ BLOG
	public function read($id){
		$blog = DB::select("select * from blog where id=?",[$id])[0];
		DB::update("update blog set view=? where id=?",[$blog->view+1,$id]);
		return view('index/read',['blog'=>$blog]);

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
			exit(json_encode(['s'=>1]));
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
