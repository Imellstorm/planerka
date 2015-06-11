@extends('containers.frontend')

@section('title') {{ 'Профиль|отзывы' }} @stop

@section('main')
    <div id="user-page">
		<div class="container">
			@include('content.front.profile.menu')
			<div class="row">
				@if(count($reviews))
					<div class="col-sm-12 user-review">
						@foreach($reviews as $review)
							<div class="review">
								<div class="user-info">
									<a href="/{{ $review->alias }}" class="avatar"><img src="{{ Common_helper::getUserAvatar($review->user_id) }}" alt=""></a>
									<div class="name">
										<a href="/{{ $review->alias }}">{{ $review->name }} {{ $review->surname }}</a>
										<span class="online"></span>
										@if(!empty($review->created_at->pro))
											<span class="status">PRO</span>
										@endif
									</div>
									<span class="place">{{ $review->city }}</span>
									<div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
								</div>
								<div class="cont">
									<div class="date">
										{{ $review->created_at }}
										<div>Отзыв по проекту - {{ $review->project_title }}</div>
									</div>
									<div>{{ $review->text }}</div>
									<!-- <ul class="photo-list">
										<li>
											<img src="#" alt="">
										</li>
										<li>
											<img src="#" alt="">
										</li>
										<li>
											<img src="#" alt="">
										</li>
									</ul> -->
								</div>
							</div>
						@endforeach
					</div>
				@endif
			</div>
		</div>
	</div>	
@stop