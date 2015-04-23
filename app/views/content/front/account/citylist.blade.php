<div class='form-group'>
	{{ Form::label('city', 'Город*', array('class'=>'city_list')) }}
	{{ Form::select('city', $cities, $cityId, array('class' => 'form-control')) }}
</div>