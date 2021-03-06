<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "Index@index");
Route::get('list/{page}',"Index@list");
Route::get('read/{id}',"Index@read");
Route::any('write',"Index@write");
Route::post('uploadImg',"Index@uploadImg");
Route::post('/blog','Index@blog');
Route::any('uploadeditor','Index@uploadeditor');
Route::any("edit/{id}","Index@edit");
Route::post("comment/{id}","Index@comment");
Route::get("/about","Index@about");
Route::get("/album","Index@album");
Route::any('/uploadShare',"Index@uploadShare");
Route::any("/uploadImgForShare",'Index@uploadImgForShare');
Route::any("/doalbum","Index@doalbum");
Route::any("/chat","Index@chat");
Route::post("/onlinenum","Index@online");
Route::get('/test',"Index@test");
