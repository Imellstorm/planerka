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
										@if(!empty($review->name) || !empty($review->surname))
											<a href="/{{ $review->alias }}">{{ $review->name }} {{ $review->surname }}</a>
										@else
											<a href="/{{ $review->alias }}">{{ $review->alias }}</a>
										@endif
										<span class="{{ $review->online?'online':'offline' }}"></span>
										@if($review->pro > date('Y-m-d'))
											<span class="status">PRO</span>
										@else
											<span class="status not_active">PRO</span>
										@endif
									</div>
									<span class="place">{{ $review->city }}</span>
									<div class="rait">Рейтинг:&nbsp;&nbsp;{{ $review->rating }}</div>
								</div>
								<div class="cont">
									<div class="date">
										{{ $review->created_at }}
										<div>Отзыв по проекту - {{ $review->project_title }}</div>
									</div>
									<div>{{ $review->text }}</div>
								</div>
							</div>
						@endforeach
					</div>
				@endif
			</div>
		</div>
	</div>	
@stop