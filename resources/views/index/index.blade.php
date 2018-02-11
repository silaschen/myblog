@extends('index.layout')
<!-- banner start -->
@section('content')
<div class="am-g am-g-fixed blog-fixed am-u-sm-centered blog-article-margin">
    <div data-am-widget="slider" class="am-slider am-slider-b1" data-am-slider='{&quot;controlNav&quot;:false}' >
    <ul class="am-slides">
      <li>
            <img src="{{config('app.url')}}/assets/i/b1.jpg">
            <div class="blog-slider-desc am-slider-desc ">
                <div class="blog-text-center blog-slider-con">
                    <span><a href="" class="blog-color">Article &nbsp;</a></span>               
                    <h1 class="blog-h-margin"><a href="">总在思考一句积极的话</a></h1>
                    <p>那时候刚好下着雨，柏油路面湿冷冷的，还闪烁着青、黄、红颜色的灯火。
                    </p>
                    <span class="blog-bor">2015/10/9</span>
                    <br><br><br><br><br><br><br>                
                </div>
            </div>
      </li>
      <li>
            <img src="{{config('app.url')}}/assets/i/b2.jpg">
            <div class="am-slider-desc blog-slider-desc">
                <div class="blog-text-center blog-slider-con">
                    <span><a href="" class="blog-color">Article &nbsp;</a></span>               
                    <h1 class="blog-h-margin"><a href="">总在思考一句积极的话</a></h1>
                    <p>那时候刚好下着雨，柏油路面湿冷冷的，还闪烁着青、黄、红颜色的灯火。
                    </p>
                    <span>2015/10/9</span>                
                </div>
            </div>
      </li>
      <li>
            <img src="{{config('app.url')}}/assets/i/b3.jpg">
            <div class="am-slider-desc blog-slider-desc">
                <div class="blog-text-center blog-slider-con">
                    <span><a href="" class="blog-color">Article &nbsp;</a></span>               
                    <h1 class="blog-h-margin"><a href="">总在思考一句积极的话</a></h1>
                    <p>那时候刚好下着雨，柏油路面湿冷冷的，还闪烁着青、黄、红颜色的灯火。
                    </p>
                    <span>2015/10/9</span>                
                </div>
            </div>
      </li>
      <li>
            <img src="{{config('app.url')}}/assets/i/b2.jpg">
            <div class="am-slider-desc blog-slider-desc">
                <div class="blog-text-center blog-slider-con">
                    <span><a href="" class="blog-color">Article &nbsp;</a></span>               
                    <h1 class="blog-h-margin"><a href="">总在思考一句积极的话</a></h1>
                    <p>那时候刚好下着雨，柏油路面湿冷冷的，还闪烁着青、黄、红颜色的灯火。
                    </p>
                    <span>2015/10/9</span>                
                </div>
            </div>
      </li>
    </ul>
    </div>
</div>
<!-- banner end -->



<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed">
    <div class="am-u-md-8 am-u-sm-12">

        <div id="blog_box"></div>
        
        <ul class="am-pagination">
        @if($nowpage > 1)
  <li class="am-pagination-prev"><a href="{{url('list')}}">&laquo; Prev</a></li>
  @endif
  <li class="am-pagination-next"><a href="{{url('list')}}/{{$nowpage+1}}">Next &raquo;</a></li>
</ul>
    </div>




    <div class="am-u-md-4 am-u-sm-12 blog-sidebar">
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-text-center blog-title"><span>About ME</span></h2>
            <img src="{{config('app.url')}}/assets/i/f14.jpg" alt="about me" class="blog-entry-img">
	<p>我不想成为一个庸俗的人。十年百年后，当我们死去，质疑我们的人同样死去，后人看到的是裹足不前、原地打转的你，还是一直奔跑、走到远方的我？</p>
        </div>
  
        <div class="blog-clear-margin blog-sidebar-widget blog-bor am-g ">
            <h2 class="blog-title"><span>TAG cloud</span></h2>
            <div class="am-u-sm-12 blog-clear-padding">

                @foreach($tag as $v)
            <a href="" class="blog-tag">{{$v->name}}</a>
         @endforeach
            </div>
        </div>
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-title"><span>blog rank</span></h2>
            <ul class="am-list">
               @foreach($rank as $rvo) <li><a href="{{url('read')}}/{{$rvo->id}}"}>{{$rvo->title}}</a></li>@endforeach
            </ul>
        </div>
    </div>
</div>



<script type="text/javascript">
    
    function loadblog(){


         $.ajax({
        type: 'POST',
        url: "{{url('blog')}}",
        data: {'tag':'','search':''},
        dataType: 'json',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(data){
            var content = '';
            $(data).each(function(k,v){


                        content +=   `<article class="am-g blog-entry-article">
            <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                <img src="{{config('app.url')}}/`+v.cover+`" alt="" class="am-u-sm-12">
            </div>
            <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                <span><a href="" class="blog-color">article &nbsp;</a></span>
                <span> @4w &nbsp;</span>
                <span>{{date('Y-m-d',`+v['updatetime']+`)}}</span>
                <h1><a href="{{url('read')}}/`+v.id+`">`+v.title+`</a></h1>
                <p>我们一直在坚持着，不是为了改变这个世界，而是希望不被这个世界所改变。
                </p>
                <p><a href="" class="blog-continue">continue reading</a></p>
            </div>
        </article>`;







            });
      

            $("#blog_box").html(content);
        },
        error: function(xhr, type){
         alert('Ajax error!')
        }
        });

    }
loadblog();


</script>
<!-- content end -->
@endsection
