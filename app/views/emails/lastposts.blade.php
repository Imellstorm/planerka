<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
@if(!empty($posts))
	@foreach($posts as $post)
		<h3>Новые объявления на сайте Firm Market</h3>
		<div>
			<a href="{{ URL::to('/').'/post/'.$post->id }}">{{ $post->title }}</a>
			Добавлено {{ $post->created_at }}
		</div>
	@endforeach
@endif
</body>
</html>