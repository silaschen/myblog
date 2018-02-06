<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class Index extends Controller{


	public function index(){
		
		$list = DB::select("select * from blog order by updatetime desc limit ?,4",[0]);
		$rank=DB::select("select * from blog order by view desc limit 3");

		return view('index/index',['list'=>$list,'nowpage'=>1,'rank'=>$rank]);

	}

	public function list($page){
		$page = $page?$page:1;
		$start = ($page-1)*4;
		$list = DB::select("select * from blog order by updatetime desc limit ?,4",[$start]);


		return view('index/list',['list'=>$list,'nowpage'=>$page]);

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
			$data['uid'] = 1;
			$data['updatetime'] = time();
			$tag = explode(" ", $data['tag']);
			DB::beginTransaction();

			$sql1 = DB::table('blog')->insert($data);
			if($tag){

				for ($i=0; $i < count($tag); $i++) { 
					

					$flag = DB::select("select * from tag where name=?",[$tag[$i]]);
					if($flag){
						DB::update("update tag set relation=?",[$flag[0]->relation+1]);
					}else{

						DB::table("tag")->insert(['name'=>$tag['id'],'relation'=>1]);
					}

					DB::table();
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








}
