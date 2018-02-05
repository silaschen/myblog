<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class Index extends Controller{


	public function index(){
		
		$list = DB::select("select * from blog order by updatetime desc limit ?,4",[0]);


		return view('index/index',['list'=>$list,'nowpage'=>1]);

	}

	public function list($page){
		$page = $page?$page:1;
		$start = ($page-1)*4;
		$list = DB::select("select * from blog order by updatetime desc limit ?,4",[$start]);


		return view('index/list',['list'=>$list,'nowpage'=>$page]);

	}

	//READ BLOG
	public function read($id){
		$blog = DB::select("select * from blog where id=?",[$id]);
		DB::update("update blog set view=?",[$blog['view']+1]);
		return view('index/read',['blog'=>$blog]);

	}


	public function write(){
		if($_SERVER['REQUEST_METHOD'] === 'GET'){

			return view('index/write');
		}else{

			$data = $_POST;
			$data['uid'] = 1;
			$data['updatetime'] = time();
			DB::table('blog')->insert($data);
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








}
