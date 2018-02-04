<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class Index extends Controller{


	public function index(){
		
		$list = DB::select("select * from blog order by updatetime desc");

		return view('index/index',['list'=>$list]);

	}

	//READ BLOG
	public function read($id){
		return view('index/read');

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
