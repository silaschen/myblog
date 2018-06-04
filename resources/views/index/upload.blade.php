@extends('index.layout')
@section('content')
  <link rel="stylesheet" href="{{config('url')}}/com/jQuery-File-Upload-9.9.3/css/jquery.fileupload.css">
  <div class="box box-solid">
 <link href="https://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.css" rel="stylesheet">

    <div class="container">

       

            <div class='form-group'>
              <label>图片分享：</label>
                <a href="javascript:$('#cover').val('');$('.showcover').html('');" onclick="return confirm('确定清除封面？');" class='pull-right'>清除封面</a> <br>
                  <button type='button' class='btn btn-success btn-sm fileinput-button'><i class="glyphicon glyphicon-picture"></i><small>select files</small><input  id="uploadcover" type="file" name="files" multiple="multiple" accept="image/*" ></button>
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <div id="files" class="files">
                    </div>
                    <div class='showcover'>
                          
                    </div>
                  
            </div>


             <div class="form-group">
                <button type="button" style="height: 50px;" onclick="savephoto();" class="btn btn-success btn-block savephoto">确定</button>
            </div> 


    </div><!-- /.box-body -->

  </div>



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
        url: "{{url('uploadImgForShare')}}",
        dataType: 'JSON',
        headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      },
        acceptFileTypes: 'jpg,png,gif,jpeg,bmp',

        done: function (e, data) {
          console.log(data);
          if(data.result.ret == 1){

             var file=`<div class="col-xs-6 col-md-3">
              <input type="hidden" name='album[]' value=`+data.result.file+` data-thumb=`+data.result.thumbpath+`>
                  <a href="#" class="thumbnail">
                    <img src="{{config('url')}}/`+data.result.file+`" alt="...">
                  </a>
                </div>`;
              $(".showcover").append(file);

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

function savephoto(){
  var file={
    'album':[]
  };

  $("input[name='album[]']").each(function(k,obj){
    var filepath = $(obj).val();
    var thumb = $(obj).attr('data-thumb');
    file.album.push({'path':filepath,'thumb':thumb});
  });


  console.log(file);
       $.ajax({
        type: 'POST',
        url: "{{url('doalbum')}}",
        data:JSON.stringify(file),
        dataType: 'json',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(data){
             
        },
        error: function(xhr, type){
        alert('Ajax error!')
        }
    });
   


}
</script>
@endsection