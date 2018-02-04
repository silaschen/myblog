<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>BLOG </title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="icon" type="image/png" href="<?php echo e(config('app.url')); ?>/assets/i/favicon.png">
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="icon" sizes="192x192" href="<?php echo e(config('app.url')); ?>/assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
  <meta name="_token" content="<?php echo e(csrf_token()); ?>"/>
  <link rel="apple-touch-icon-precomposed" href="<?php echo e(config('app.url')); ?>/assets/i/app-icon72x72@2x.png">
  <meta name="msapplication-TileImage" content="<?php echo e(config('app.url')); ?>/assets/i/app-icon72x72@2x.png">
  <meta name="msapplication-TileColor" content="#0e90d2">
  <link rel="stylesheet" href="<?php echo e(config('app.url')); ?>/assets/css/amazeui.min.css">
  <link rel="stylesheet" href="<?php echo e(config('app.url')); ?>/assets/css/app.css">
  <script src="<?php echo e(config('app.url')); ?>/assets/js/jquery.min.js"></script>
</head>

<body id="blog">

<!-- <header class="am-g am-g-fixed blog-fixed blog-text-center blog-header">
    <div class="am-u-sm-8 am-u-sm-centered">
        <img width="200" src="http://s.amazeui.org/media/i/brand/amazeui-b.png" alt="Amaze UI Logo"/>
        <h2 class="am-hide-sm-only">中国首个开源 HTML5 跨屏前端框架</h2>
    </div>
</header> -->
<hr>
<!-- nav start -->
<nav class="am-g am-g-fixed blog-fixed blog-nav">
<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only blog-button" data-am-collapse="{target: '#blog-collapse'}" ><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="blog-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li class="am-active"><a href="lw-index.html">Home</a></li>
      <li><a href="lw-article.html">blog</a></li>
      <li><a href="lw-img.html">album</a></li>
      <li><a href="lw-timeline.html">about me</a></li>
    </ul>
    <form class="am-topbar-form am-topbar-right am-form-inline" role="search">
      <div class="am-form-group">
        <input type="text" class="am-form-field am-input-sm" placeholder="搜索">
      </div>
    </form>
  </div>
</nav>
<hr>
<!-- nav end -->


     <?php echo $__env->yieldContent('content'); ?>



  <footer class="blog-footer">
    <div class="am-g am-g-fixed blog-fixed am-u-sm-centered blog-footer-padding">
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
            God help those who help themselves.<br><br>
            Don't say sorry because we don't mind.</p>
        </div>
        <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
            <h3>社交账号</h3>
            <p>
                <a href="" title="434684326"><span class="am-icon-qq am-icon-fw am-primary blog-icon blog-icon"></span></a>
                <a href="https://github.com/silaschen"><span class="am-icon-github am-icon-fw blog-icon blog-icon"></span></a>
                <a href="https://weibo.com/u/5653506601?is_all=1"><span class="am-icon-weibo am-icon-fw blog-icon blog-icon"></span></a>
           
                <a href="javascript:alert('talentchensw')"><span class="am-icon-weixin am-icon-fw blog-icon blog-icon"></span></a>
            </p>
            <h3>Credits</h3>
            <p>I am a slow walker,but I never walk backwards.</p>          
        </div>
   
    </div>    
    <div class="blog-text-center">© <?php echo e(date('Y',time())); ?> 4wBlog  Made with love By chen siwei</div>  </footer>





<!--[if (gte IE 9)|!(IE)]><!-->

<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="<?php echo e(config('app.url')); ?>/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="<?php echo e(config('app.url')); ?>/assets/js/amazeui.min.js"></script>
</body>
</html>
