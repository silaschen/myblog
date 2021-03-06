<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
define('PAGE_SIZE', 5);
class Index extends Controller{
	const UPLOAD_PATH = 'upload/ck';
	private static $ranknum = 6;
	public function index(){
		$rank=DB::select(sprintf("select * from blog order by view desc limit %d",self::$ranknum));
		$tag = DB::select("select * from tag order by relation desc");
		//count view number
		$redis = new \Redis();
		$redis->connect('127.0.0.1','6379');
		$redis->select(3);
		$viewkey = self::getViewKey();
		$number = $redis->get($viewkey);
		$redis->set($viewkey,$number+1);
		$joke=self::getJoke();
//		print_r($joke);
//	exit;	
		return view('index/index',['nowpage'=>1,'rank'=>$rank,'tag'=>$tag,'joke'=>$joke]);

	}
	
	static private function getJoke(){
		
		 $redis = new \Redis();
                $redis->connect('127.0.0.1','6379');
                $redis->select(3);
	
		return json_decode($redis->get('JOKE'),true);
		

	}

	static private function getViewKey(){
		
		return sprintf("%s|%s",'VIEW_NUM','blog');

	}

	public function test(){
		

		$ret = self::CallServer("http://mservicetst.cochat.lenovo.com/coreport/index.html",'GET');
			var_dump($ret);
	}



	public static function CallServer($url,$method='GET',$header=array(),$data=array()){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		if(!empty($header)) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置http头信息
		curl_setopt($ch, CURLOPT_HEADER, false);//开启将输出数据流
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//	TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
		if($method === 'POST'){
			curl_setopt($ch, CURLOPT_POST, true);//发起post请求
			curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data):$data);
		}
		$content = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//	var_dump(curl_error($ch));
        curl_close($ch);
        return array(
            'code' => $code,
            'content' => $content,
        );
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
			$list[$k]->desc = mb_substr($list[$k]->content,0,50,'utf8');
			$list[$k]->updatetime = date("Y-m-d",$list[$k]->updatetime);
			unset($list[$k]->content);
		}
		exit(json_encode(['blog'=>$list,'page'=>$page]));

	}


	//READ BLOG
	public function read($id){
		//var_dump($_SERVER);
		if(array_key_exists("HTTP_DAAUTH",$_SERVER)){
			$token = $_SERVER['HTTP_DAAUTH'];
		echo $token;
		 $header = array('CODATAPARTNER:38cee49a34b3f78c06407720f645afc0','DAAUTH:'.$token,'User-Agent:SADWE23432423432','IP:127.0.0.1');
               $ret =self::CallServer("https://codata.lenovo.com/partner/auth/mobiletoken",'GET',$header);
              print_r($ret);

	}
		
		$blog = DB::select("select * from blog where id=?",[$id])[0];
		$comment = DB::select(sprintf("select * from blog_comment where blogid=%d order by id desc",$id));
		$tags = DB::select(sprintf("SELECT * FROM tag where id in (select tagid from tag_blog where blogid=%d)",$id));
		DB::update("update blog set view=? where id=?",[$blog->view+1,$id]);
		return view('index/read',['blog'=>$blog,'comment'=>$comment,'tags'=>$tags]);

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

	public function album(){
		$list = Db::select(sprintf("select * from album order by id desc"));
		return view('index/album',['list'=>$list]);
	}

		#上传#
	public function uploadImg(Request $request){
			$file = $_FILES['files'];
			$img = $request->file('files');
			$filename = 'upload/img/'.'aaa'.time().'.jpg';
			move_uploaded_file($file['tmp_name'],$filename);
			exit(json_encode(['file'=>$filename,'ret'=>1]));
		
	}


	public function uploadImgForShare(Request $request){

			$file = $_FILES['files'];
			$img = $request->file('files');
			$filename = 'upload/img/full/'.md5(time().rand(1,1000)).'.jpg';
			move_uploaded_file($file['tmp_name'],$filename);
			//剪切成缩略图
			$thupath = 'upload/img/thumb/'.md5(time().rand(30,3000)).'.jpg';
			$this->img_create_small($filename, 360,247, $thupath);
			exit(json_encode(['file'=>$filename,'thumbpath'=>$thupath,'ret'=>1]));
	}


	public function doalbum(){
		$data = json_decode(file_get_contents("php://input"),true)['album'];

		foreach ($data as $key => $val) {
			DB::insert("insert into album (path,thumb) values (?,?)",[$val['path'],$val['thumb']]);
		}
		header("Content-Type: application/json; charset=UTF-8");
		echo json_encode(['code'=>1]);
	
	}

	//上传图片，多张
	public function uploadShare(){

		return view('index/upload');
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

	//about me
	public function about(){
		return view('index/about');
	}
	
	
	//http curl
	public function Curl_Http($url,$method='GET',$header=array(),$data=[]){
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



	function img_create_small($big_img, $width=360, $height=247, $small_img) {//原始大图地址，缩略图宽度，高度，缩略图地址
		$imgage = getimagesize($big_img); //得到原始大图片
		switch ($imgage[2]) { // 图像类型判断
		case 1:
		$im = imagecreatefromgif($big_img);
		break;
		case 2:
		$im = imagecreatefromjpeg($big_img);
		break;
		case 3:
		$im = imagecreatefrompng($big_img);
		break;
		}
		$src_W = $imgage[0]; //获取大图片宽度
		$src_H = $imgage[1]; //获取大图片高度
		$tn = imagecreatetruecolor($width, $height); //创建缩略图
		imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $src_W, $src_H); //复制图像并改变大小
		imagejpeg($tn, $small_img); //输出图像
	}

	public function online(){
		$redis = new \Redis();
		$redis->connect('127.0.0.1',6379);
		$redis->select(3);
		$num = $redis->llen('USER');
		header("Content-Type:application/json");
		echo json_encode(['num'=>$num]);



	}


}
