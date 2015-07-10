@extends('containers.frontend')

@section('title') {{ $subcategory->name }} @stop

@section('main')
	<div id="blog">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-title decor">
					{{ $category->name }}
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<ul class="inner-nav">
						<li><a href="/blog">{{ $category->name }}</a></li>
						<li><a class="active">{{ $subcategory->name }}</a></li>
						@if(Auth::check())
							<li class="last"><a href="/blog/createtheme/{{ $subcategory->id }}" class="btn-main fancybox_ajax">Написать</a></li>
						@endif
					</ul>
				</div>
			</div>

			{{ $themes->links() }}

			<div class="row">
				<div class="col-sm-12">
					@if(count($themes))
						@foreach($themes as $theme)
							<div class="single-blog" style="position:relative">
								<a href="/blog/theme/{{ $theme->id }}">
									<h3>{{ $theme->name }}</h3>
								</a>
								<p>{{ $theme->text }}</p>
								<footer>
									<div class="user-info">
										<a href="/{{ $theme->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($theme->user_id) }}" alt=""></a>
										<div class="name">
											@if(!empty($theme->user_name) || !empty($theme->surname))
												<a href="/{{ $theme->alias }}">{{ $theme->user_name }} {{ $theme->surname }}</a>
											@else
												<a href="/{{ $theme->alias }}">{{ $theme->alias }}</a>
											@endif
											<span class="{{ $theme->online?'online':'offline' }}"></span>
											@if($theme->pro)
												<span class="status">PRO</span>
											@endif
										</div>
										<span class="place">{{ $theme->city }}</span>
										<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
									</div>
									<ul class="meta">
										<li>Опубликовано: <span>{{ $theme->created_at }}</span></li>
									</ul>
								</footer>
								@if(Auth::check() && (Auth::user()->id==$theme->user_id || Auth::user()->role_id==1))
									<a href="/blog/deletetheme/{{ $theme->id }}" class="fa fa-times delete-image"></a>
								@endif
							</div>
						@endforeach
					@endif
				</div>
			</div>

			{{ $themes->links() }}

		</div>
	</div>	
@stop