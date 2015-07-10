@extends('containers.frontend')

@section('title') {{ 'Блог' }} @stop

@section('main')

<div id="blog">
	<div class="container">
		<div class="row">
			<div class="col-md-12 section-title decor">
				Свадебные блоги
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<ul class="inner-nav">
					<li><a href="/blog" class="active">Блоги</a></li>
					@if(Auth::check())
						<li><a href="/blog/myposts">Мои посты</a></li>
					@endif
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="blog-cont">
					@if(count($categories))
						@foreach($categories as $key=>$item)
							@if($key==0 || $item->category_id!=$categories[$key-1]->category_id)
								<div class="category">
									<div class="cat-title">{{ $item->parent_name }}</div>
							@endif
									<div class="post">
										<div class="post-cont">
											<h3><a href="/blog/category/{{ $item->id }}">{{ $item->name }}</a></h3>
											<p>{{ $item->description }}</p>
										</div>
										<div class="post-info">
											<dl>
												<dt>Темы:</dt>
												<dd>{{ $item->themes_count }}</dd>
											</dl>
											<dl>
												<dt>Сообщений:</dt>
												<dd>{{ $item->posts_count }}</dd>
											</dl>
										</div>
									</div>
							@if($key==0 || $item->category_id!=$categories[$key-1]->category_id)		
								</div>
							@endif			
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@stop	