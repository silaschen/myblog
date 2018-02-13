@extends('index.layout')
@section('content')
  <link rel="stylesheet" href="{{config('url')}}/com/jQuery-File-Upload-9.9.3/css/jquery.fileupload.css">
  <div class="box box-solid">
 <link href="https://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.css" rel="stylesheet">

    <div class="container">
         <form method="POST" id='form'>
   
            <div class='form-group'>
              <label>Titile：</label>
              <input type='text' name='title' class='form-control' value="{{$blog->title}}">
            </div>
            <div class='form-group'>
              <label>cover blog：</label>
                <a href="javascript:$('#cover').val('');$('.showcover').html('');" onclick="return confirm('确定清除封面？');" class='pull-right'>清除封面</a> <br>
                  <button type='button' class='btn btn-success btn-sm fileinput-button'><i class="glyphicon glyphicon-picture"></i> <small> blog cover Upload</small><input  id="uploadcover" type="file" name="files" accept="image/*" ></button>
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <div id="files" class="files">
                    </div>
                    <div class='showcover'>
                          <img src="{{config('url')}}/{{$blog->cover}}">
                    </div>
                <input class='hide' name='cover' id='cover' value="{{$blog->cover}}">
            </div>


            <div class='form-group'>
              <label>content of blog：</label>
                <textarea id="editor_id" name="content" style="width:100%;min-height:460px;"></textarea>
            </div>
         </form>
             <div class="form-group">
                <button type="button" style="height: 50px;" onclick="saveart();" class="btn btn-success btn-block saveart">确定</button>
            </div> 



    </div><!-- /.box-body -->

  </div>
<div class="temp hide">{!!$blog->content!!}</div>
<script charset="utf-8" src="{{config('url')}}/com/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="{{config('url')}}/com/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
KindEditor.ready(function(K) {
    window.editor = K.create('#editor_id',{
      uploadJson:"{{url('uploadeditor')}}?_token={{csrf_token()}}",
    });
    editor.html($('.temp').html());
});

function saveart(){
  $("#editor_id").val(editor.html());
    $(".saveart").addClass('disabled');
     $.ajax({
        type: 'POST',
        url: "{{url('edit')}}/{{$blog->id}}",
        data: $("#form").serialize(),
        dataType: 'json',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(data){
          if(data.code === 1){
            location.href = "{{url('read')}}/{{$blog->id}}";
          }
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
        url: "{{url('uploadImg')}}",
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
              $(".showcover").html("<img src='{{config('url')}}/"+data.result.file+"'>");
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