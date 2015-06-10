<div class="row" style="padding:10px 20px; margin:0">
	<div class="col-sm-12">
		<div class="proj-answ">
			<h2 class="title text-center">Пригласить исполнителя</h2>
			{{ Form::open(array('role' => 'form', 'url' => 'projectmessages/store')) }}
				<div class="form-group">
				    {{ Form::label('price', 'Стоимость') }}
					{{ Form::text('price', null, array('class' => 'form-control price-input','placeholder'=>'в рублях','required')) }}
				</div>
				<div class="form-group">
					{{ Form::label('term', 'Срок', array('style'=>'text-align:right;padding-right:20px;')) }}
					{{ Form::text('term', null, array('class' => 'form-control','required')) }}
				</div>
				<div class="form-group">
					{{ Form::label('project_id', 'Проект', array('style'=>'text-align:right;padding-right:20px;')) }}
					{{ Form::select('project_id',$projects,'',array('class'=>'form-control')); }}
				</div>
				<div class="form-group">
					{{ Form::label('text', 'Текст') }}
					{{ Form::textarea('text', null, array('class' => 'form-control','style'=>'height:150px','required')) }}
				</div>
				{{ Form::hidden('to_user',$userId) }}

				<div class="form-group">
					<input type="submit" class="btn-main" value="Пригласить" style="margin:0 auto">
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>