<!-- banner start -->
<?php $__env->startSection('content'); ?>




<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed">
    <div class="am-u-md-8 am-u-sm-12">

    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <article class="am-g blog-entry-article">
            <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                <img src="<?php echo e(config('app.url')); ?>/<?php echo e($vo->cover); ?>" alt="" class="am-u-sm-12">
            </div>
            <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                <span><a href="" class="blog-color">article &nbsp;</a></span>
                <span> @4w  &nbsp;</span>
                <span><?php echo e(date('Y-m-d',$vo->updatetime)); ?></span>
                <h1><a href="read/<?php echo e($vo->id); ?>"><?php echo e($vo->title); ?></a></h1>
                <p>我们一直在坚持着，不是为了改变这个世界，而是希望不被这个世界所改变。
                </p>
                <p><a href="" class="blog-continue">continue reading</a></p>
            </div>
        </article>

       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <ul class="am-pagination">
        <?php if($nowpage > 1): ?>
  <li class="am-pagination-prev"><a href="<?php echo e(url('list')); ?>/<?php echo e($nowpage-1); ?>">&laquo; Prev</a></li>
  <?php endif; ?>
  <li class="am-pagination-next"><a href="<?php echo e(url('list')); ?>/<?php echo e($nowpage+1); ?>">Next &raquo;</a></li>
</ul>
    </div>




    <div class="am-u-md-4 am-u-sm-12 blog-sidebar">
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-text-center blog-title"><span>About ME</span></h2>
            <img src="<?php echo e(config('app.url')); ?>/assets/i/f14.jpg" alt="about me" class="blog-entry-img" >
            <p>Boy</p>
            <p>
        I am 4w,a name from siwei.chen.
        </p><p>我不想成为一个庸俗的人。十年百年后，当我们死去，质疑我们的人同样死去，后人看到的是裹足不前、原地打转的你，还是一直奔跑、走到远方的我？</p>
        </div>
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-text-center blog-title"><span>Contact ME</span></h2>
            <p>
                <a href=""><span class="am-icon-qq am-icon-fw am-primary blog-icon"></span></a>
                <a href=""><span class="am-icon-github am-icon-fw blog-icon"></span></a>
                <a href=""><span class="am-icon-weibo am-icon-fw blog-icon"></span></a>
                <a href=""><span class="am-icon-reddit am-icon-fw blog-icon"></span></a>
                <a href=""><span class="am-icon-weixin am-icon-fw blog-icon"></span></a>
            </p>
        </div>
        <div class="blog-clear-margin blog-sidebar-widget blog-bor am-g ">
            <h2 class="blog-title"><span>TAG cloud</span></h2>
            <div class="am-u-sm-12 blog-clear-padding">


            <a href="" class="blog-tag">git</a>
         
            </div>
        </div>
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-title"><span>么么哒</span></h2>
            <ul class="am-list">
                <li><a href="#">每个人都有一个死角， 自己走不出来，别人也闯不进去。</a></li>
                <li><a href="#">我把最深沉的秘密放在那里。</a></li>
                <li><a href="#">你不懂我，我不怪你。</a></li>
                <li><a href="#">每个人都有一道伤口， 或深或浅，盖上布，以为不存在。</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- content end -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('index.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>