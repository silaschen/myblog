@extends('index.layout')
@section('content')
  <link rel="stylesheet" href="{{config('url')}}/com/jQuery-File-Upload-9.9.3/css/jquery.fileupload.css">
  <script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
  <div class="box box-solid">
 <link href="https://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.css" rel="stylesheet">
    <div class="box-header with-border">
      <h3 class="box-title">Write new Blog</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
         <form method="POST" id='form'>
   
            <div class='form-group'>
              <label>文章标题：</label>
              <input type='text' name='title' class='form-control'>
            </div>
            <div class='form-group'>
              <label>封面图片：</label>
                <a href="javascript:$('#cover').val('');$('.showcover').html('');" onclick="return confirm('确定清除封面？');" class='pull-right'>清除封面</a> <br>
                  <button type='button' class='btn btn-success btn-sm fileinput-button'><i class="glyphicon glyphicon-picture"></i> <small>推荐尺寸 400*300 点击上传</small><input  id="uploadcover" type="file" name="files" accept="image/*" ></button>
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <div id="files" class="files">
                    </div>
                    <div class='showcover'>
                          <img src="">
                    </div>
                <input class='hide' name='cover' id='cover' value="">
            </div>


            <div class='form-group'>
              <label>内容：</label>
                <textarea id="editor_id" name="content" style="width:100%;min-height:260px;"></textarea>
            </div>



            <div class="form-group">
                <label>Content</label>
                <textarea name="editor1" id="editor1" rows="5" cols="80">
                This is my textarea to be replaced with CKEditor.
                </textarea>

            </div>

            <div class="form-group">
              <label>tag(请用空格 隔开)</label>
              <input type="text" name="tag" class="form-control">
            </div>
   
      
         </form>
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
      <button type="button" onclick="saveart();" class="btn btn-success pull-right saveart">确定</button>
    </div>   
  </div>
<div class="temp hide"></div>
<script charset="utf-8" src="{{config('url')}}/com/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="{{config('url')}}/com/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">

CKEDITOR.replace( 'editor1' );


KindEditor.ready(function(K) {
    window.editor = K.create('#editor_id',{
      uploadJson:"{{url('upload')}}",
       extraFileUploadParams : {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }

    });
    editor.html($('.temp').html());
});


function saveart(){

  $("#editor_id").val(editor.html());

    $(".saveart").addClass('disabled');

 $.ajax({
type: 'POST',
url: 'write',
data: $("#form").serialize(),
dataType: 'json',
headers: {
'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
},
success: function(data){
  console.log(data);
},
error: function(xhr, type){
alert('Ajax error!')
}
});

}
</script>
<script src="{{config('url')}}/com/jQuery-File-Upload-9.9.3/js/vendor/jquery.ui.widget.js"></script>
<script src="{{config('url')}}/com/jQuery-File-Upload-9.9.3/js/load-image.all.min.js"></script>
<script src="{{config('url')}}/com/jQuery-File-Upload-9.9.3/js/canvas-to-blob.min.js"></script>
<script src="{{config('url')}}/com/jQuery-File-Upload-9.9.3/js/jquery.iframe-transport.js"></script>
<script src="{{config('url')}}/com/jQuery-File-Upload-9.9.3/js/jquery.fileupload.js"></script>
<script src="{{config('url')}}/com/jQuery-File-Upload-9.9.3/js/jquery.fileupload-process.js"></script>
<script src="{{config('url')}}/com/jQuery-File-Upload-9.9.3/js/jquery.fileupload-image.js"></script>
<script type="text/javascript">
$(function(){
    $('#uploadcover').fileupload({
        url: "uploadImg",
        dataType: 'JSON',
        headers: {
'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
},
        acceptFileTypes: 'jpg,png,gif,jpeg,bmp',
      maxFileSize: 8000000, // 800kb
      disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator && navigator.userAgent),
        imageMaxWidth: 1920, //自动裁剪保持该宽度
        // imageMaxHeight: 300,
        // imageCrop: true,
        done: function (e, data) {
          console.log(data);
          if(data.result.ret == 1){

              $("input[name='cover']").val(data.result.file);
              $(".showcover").html("<img src='"+data.result.file+"'>");
            }else{
              // alert(data.result.msg);
            }
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

});
</script>
@endsection