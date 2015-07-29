@extends('containers.frontend')

@section('title') Мои посты @stop

@section('main')
	<div id="blog">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-title decor">
					Мои посты
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<ul class="inner-nav">
						<li><a href="/blog">Блоги</a></li>
						@if(Auth::check())
							<li><a href="/blog/myposts" class="active">Мои посты</a></li>
						@endif
					</ul>
				</div>
			</div>

			{{ $themes->links() }}

			<div class="row">
				<div class="col-sm-12">
					@if(count($themes))
						@foreach($themes as $theme)
							<div class="single-blog">
								<a href="/blog/theme/{{ $theme->id }}">
									<h3>{{ $theme->name }}</h3>
								</a>	
								<footer>
									<div class="user-info">
										<div style="overflow:hidden">
											<a href="#null" class="avatar"><img src="{{ Common_helper::getUserAvatar($theme->user_id) }}" alt=""></a>
											<div class="name">
												@if(!empty($theme->user_name) || !empty($theme->surname))
													<a href="/{{ $theme->alias }}">{{ $theme->user_name }} {{ $theme->surname }}</a>
												@else
													<a href="/{{ $theme->alias }}">{{ $theme->alias }}</a>
												@endif
												<span class="{{ $theme->online?'online':'offline' }}"></span>
												@if($theme->pro > date('Y-m-d'))
													<span class="status">PRO</span>
												@else
													<span class="status not_active">PRO</span>
												@endif
											</div>
											<span class="place">{{ $theme->city }}</span>
											<div class="rait">Рейтинг:&nbsp;&nbsp;{{ $theme->rating }}</div>
										</div>
										<div style="margin-top:10px">Опубликовано: <span>{{ $theme->created_at }}</span></div>
									</div>
									<ul class="meta">
										<li>{{ $theme->text }}</li>
									</ul>
								</footer>
							</div>
						@endforeach
					@else
						<div class="text-center">Посты отсутствуют</div>
					@endif
				</div>
			</div>

			{{ $themes->links() }}

		</div>
	</div>	
@stop