@extends('index.layout')
@section('content')
  <link rel="stylesheet" href="{{config('app.url')}}/assets/album/css/main.css" />
		<!-- Wrapper -->
			<div id="wrapper">


					<div id="main">

						 @foreach($list as $v)
						<article class="thumb">
							<a href="{{config('url')}}/{{$v->path}}" class="image"><img src="{{config('url')}}/{{$v->thumb}}" alt="" /></a>
							<h2>show from my life</h2>
							<p>This is some photos from my life,including some moments in my real life..</p>
						</article>
						 @endforeach


					<!-- 	<article class="thumb">
							<a href="{{config('url')}}/images/fulls/02.jpg" class="image"><img src="{{config('url')}}/images/thumbs/02.jpg" alt="" /></a>
							<h2>Nisl adipiscing</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/03.jpg" class="image"><img src="{{config('url')}}/images/thumbs/03.jpg" alt="" /></a>
							<h2>Tempus aliquam veroeros</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/04.jpg" class="image"><img src="{{config('url')}}/images/thumbs/04.jpg" alt="" /></a>
							<h2>Aliquam ipsum sed dolore</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/05.jpg" class="image"><img src="{{config('url')}}/images/thumbs/05.jpg" alt="" /></a>
							<h2>Cursis aliquam nisl</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/06.jpg" class="image"><img src="{{config('url')}}/images/thumbs/06.jpg" alt="" /></a>
							<h2>Sed consequat phasellus</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/07.jpg" class="image"><img src="{{config('url')}}/images/thumbs/07.jpg" alt="" /></a>
							<h2>Mauris id tellus arcu</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/08.jpg" class="image"><img src="{{config('url')}}/images/thumbs/08.jpg" alt="" /></a>
							<h2>Nunc vehicula id nulla</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/09.jpg" class="image"><img src="{{config('url')}}/images/thumbs/09.jpg" alt="" /></a>
							<h2>Neque et faucibus viverra</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/10.jpg" class="image"><img src="{{config('url')}}/images/thumbs/10.jpg" alt="" /></a>
							<h2>Mattis ante fermentum</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/11.jpg" class="image"><img src="{{config('url')}}/images/thumbs/11.jpg" alt="" /></a>
							<h2>Sed ac elementum arcu</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article>
						<article class="thumb">
							<a href="{{config('url')}}/images/fulls/12.jpg" class="image"><img src="{{config('url')}}/images/thumbs/12.jpg" alt="" /></a>
							<h2>Vehicula id nulla dignissim</h2>
							<p>Nunc blandit nisi ligula magna sodales lectus elementum non. Integer id venenatis velit.</p>
						</article> -->
					</div>
			</div>

		<!-- Scripts -->


@endsection
