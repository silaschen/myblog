@extends('index.layout')
@section('content')
<style type="text/css">
  .well{background: #FFF;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,.05);
    border-radius: 8px;
    padding: 32px;
    width: inherit;
    position: relative;
    cursor: pointer;
    margin-bottom: 12px;}
</style>
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed blog-content">
    <div class="am-u-sm-12 readbox">
      <article class="am-article blog-article-p">
        <div class="am-article-hd">
          <h1 class="am-article-title blog-text-center">{{$blog->title}}</h1>
          <p class="am-article-meta blog-text-center">
              <span><a href="#" class="blog-color">article &nbsp;</a></span>-
              <span><a href="#">@4w&nbsp;</a></span>-
              <span><a href="#">{{date('M d,Y',$blog->updatetime)}}</a></span>
          </p>
        </div>        
        <div class="am-article-bd">
        <img src="{{config('app.url')}}/{{$blog->cover}}" alt="" class="blog-entry-img blog-article-margin">          
      {!!$blog->content!!}
        </div>
      </article>
        
        <div class="am-g blog-article-widget blog-article-margin">
          <div class="am-u-lg-4 am-u-md-5 am-u-sm-7 am-u-sm-centered blog-text-center">
            <span class="am-icon-tags"> &nbsp;</span>

            @foreach($tags as $tag)
            <a href="javascript:setTag({{$tag->id}})">{{$tag->name}}</a>,

            @endforeach
            <hr>
            <a href=""><span class="am-icon-qq am-icon-fw am-primary blog-icon"></span></a>
            <a href=""><span class="am-icon-wechat am-icon-fw blog-icon"></span></a>
            <a href=""><span class="am-icon-weibo am-icon-fw blog-icon"></span></a>
          </div>
        </div>

        <hr>
        <div class="am-g blog-author blog-article-margin">
          <div class="am-u-sm-3 am-u-md-3 am-u-lg-2">
            <img src="{{config('app.url')}}/u.jpg" alt="" class="blog-author-img am-circle">
          </div>
          <div class="am-u-sm-9 am-u-md-9 am-u-lg-10">
          <h3><span>作者 &nbsp;: &nbsp;</span><span class="blog-color">4w</span></h3>
            <p>我们不必羡慕他人的才能，也不必悲叹自己的平庸，各人都有他的个性魅力。</p>
          </div>
        </div>
        <hr>
  
        


        <form class="am-form am-g">
            <h3 class="blog-comment">评论</h3>
          <fieldset>

        
            <div class="am-form-group">
              <textarea class="" rows="5" placeholder="一字千金"></textarea>
            </div>
        
            <p><button type="button" class="am-btn am-btn-default" onclick="comment()">发表评论</button></p>
          </fieldset>


  

          <div id="commentbox">
              
                    @foreach($comment as $comm)
              <div class="well"><p>{{$comm->content}}</p><br><span>{{date("M d,Y H:i",$comm->time)}}</span></div>
                    @endforeach

          </div>
            

            

    
        </form>

    
    </div>
</div>

<script type="text/javascript">
  
  function comment(){
    var comment = $("textarea").val();
    if(comment === ''){
      alert('评论内容不能为空！苍井空！');
      return false;
    }

    $.ajax({

      url:"{{url('comment')}}/{{$blog->id}}",
      type:'POST',
      data:{'content':comment},
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      },
      success:function(ret){
        var newcomm = `<div class="well"><p>`+ret.content+`</p><br><span>`+ret.time+`</span></div>`;

        $("#commentbox").prepend(newcomm);

      }
    });
  }
var tag = null;
search = null;
page=1;
function setTag(id){
tag = id;
$(".readbox").empty();
loadblog();
}

   function loadblog(){
        
        $.ajax({
        type: 'POST',
        url: "{{url('blog')}}",
        data: {'tag':tag,'search':search,'page':page},
        dataType: 'json',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(data){
            var content = '';
            page = data.page;
            $(data.blog).each(function(k,v){


        content +=   `<article class="am-g blog-entry-article">
            <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                <img src="{{config('app.url')}}/`+v.cover+`" alt="" class="am-u-sm-12">
            </div>
            <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                <span><a href="" class="blog-color">article &nbsp;</a></span>
                <span> @4w &nbsp;</span>
                <span>`+v.updatetime+`</span>
                <h1><a href="{{url('read')}}/`+v.id+`">`+v.title+`</a></h1>
                <p>`+v.desc+`
                </p>
                <p><a href="" class="blog-continue">continue reading</a></p>
            </div>
        </article>`;
            });
            content += ` <ul class="am-pagination">

  <li class="am-pagination-prev"><a href="javascript:pagego(1)">&laquo; Prev</a></li>

  <li class="am-pagination-next"><a href="javascript:pagego(2)">Next &raquo;</a></li>
</ul>`;
      

            $(".readbox").html(content);
        },
        error: function(xhr, type){
         alert('Ajax error!')
        }
        });

    }
 function pagego(direction){
        if(direction === 1){
            page = parseInt(page)-1;
            
        }else{
            page = parseInt(page)+1;
        }
        loadblog();
    }
</script>
<!-- content end -->
@endsection

