@extends('containers.frontend')

@section('title') {{ 'Специализация' }} @stop

@section('main')
<!-- MAIN CONTENT
	============================= -->	
	<div id="user-page">
		<div class="container">
			@include('content.front.account.menu_one')
			<div class="row">
				@if (empty($mainRole))
				    {{ Form::open(array('role' => 'form', 'url' => '/specializations/store', 'class'=>'prof')) }}
				@else
				    {{ Form::open(array('role' => 'form', 'url' => '/specializations/update/', 'method' => 'PUT', 'class'=>'prof')) }}
				@endif
					<div class="col-sm-12">
						<div class="specif main">
							<div class="title">Основная специализация</div>
							<div class="form-group">
								<?php if(isset($mainRole->role_id)) $rolesAdd=$roles; $rolesAdd[$mainRole->role_id]=$mainRole->name ?>
	    						{{ Form::select('role[]',$rolesAdd,isset($mainRole->role_id)?$mainRole->role_id:'',array('class'=>'sel-green')); }}
								<div class="comment">Выберите раздел и специализацию из каталога</div>
							</div>
							<div class="form-group">
								<label for="count-service">Стоимость услуги</label>
								<input type="text" name="price[]" class="form-control price-input" placeholder="только цифры" value="{{ isset($mainRole->price)?$mainRole->price:'' }}">
							</div>
							<div class="form-goup">
								<label for="description">Что входит в стоимость</label>
								<textarea id="description" name="description[]" class="form-control">{{ isset($mainRole->description)?$mainRole->description:'' }}</textarea>
							</div>
							@if(!count($otheRoles))
								<span class="add-specif">Добавить другую специализацию</span>
							@endif
						</div>
						@if(isset($otheRoles) && !empty($otheRoles))
							@foreach($otheRoles as $key=>$val)
								<div class="specif main">
									<div class="title">Дополнительная специализация</div>
									<div class="form-group">
										<?php $rolesAdd=$roles; $rolesAdd[$val->role_id]=$val->name ?>
										{{ Form::select('role[]',$rolesAdd,$val->role_id,array('class'=>'sel-green')); }}
										<a href="#null" class="delate">Удалить</a>
										<div class="comment">Выберите раздел и специализацию из каталога</div>
									</div>
									<div class="form-group">
										<label for="count-service">Стоимость услуги</label>
										<input type="text" name="price[]" class="form-control price-input" placeholder="только цифры" value="{{ $val->price }}">
									</div>
									<div class="form-goup">
										<label for="description">Что входит в стоимость</label>
										<textarea name="description[]" class="form-control">{{ $val->description }}</textarea>
									</div>
									@if(!isset($otheRoles[$key+1]))
										<span class="add-specif">Добавить другую специализацию</span>
									@endif
								</div>
							@endforeach
						@endif						
					</div>
					<div class="form-group">
                        <input type="submit" class="btn-main" value="Сохранить" style="margin-left:178px">
                    </div>
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<div class="add-specif-block" style="display:none">
		<div class="specif">
			<div class="title">Дополнительная специализация</div>
			<div class="form-group">
				{{ Form::select('role[]',$roles,null,array('class'=>'sel-green')); }}
				<a href="#null" class="delate">Удалить</a>
				<div class="comment">Выберите раздел и специализацию из каталога</div>
			</div>
			<div class="form-group">
				<label for="count-service">Стоимость услуги</label>
				<input type="text" name="price[]" class="form-control price-input" placeholder="только цифры">
			</div>
			<div class="form-goup">
				<label for="description">Что входит в стоимость</label>
				<textarea name="description[]" class="form-control"></textarea>
			</div>
			<span class="add-specif">Добавить другую специализацию</span>
		</div>
	</div>	
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){

			var i=0;
			$('body').on('click','.add-specif',function(){
				if(i < {{ $maxRoles-1 }}){		
					var slctdElem = $(this).parent().find('option:selected').val();
					$('.add-specif-block').find($('option[value='+slctdElem+']')).remove();
					// $.each($('option[value='+slctdElem+']:not(selected)'),function(key,val){
					// 	$(this).remove();
					// });


					var html = $('.add-specif-block').html();		
					$(this).parent().after(html);		
					$(this).remove();
					i++;
				} else {
					alert('Вы добавили все возможные роли');
				}		
			});

			$('body').on('click','.delate',function(){
				elem = $(this);
				$.each($('.sel-green'),function(key,val){
					var id = elem.parent().parent().find(':selected').val();
					var name = elem.parent().parent().find(':selected').text();
					$(this).append('<option value="'+id+'" selected="selected">'+name+'</option>');
				});
				elem.parent().parent().remove();
				i--;
			});

			$('body').on('keydown','.price-input',function (e) {
		        // Allow: backspace, delete, tab, escape, enter and .
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		             // Allow: Ctrl+A
		            (e.keyCode == 65 && e.ctrlKey === true) ||
		             // Allow: Ctrl+C
		            (e.keyCode == 67 && e.ctrlKey === true) ||
		             // Allow: Ctrl+X
		            (e.keyCode == 88 && e.ctrlKey === true) ||
		             // Allow: home, end, left, right
		            (e.keyCode >= 35 && e.keyCode <= 39)) {
		                 // let it happen, don't do anything
		                 return;
		        }
		        // Ensure that it is a number and stop the keypress
		        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		            e.preventDefault();
		        }
		    });
		});
	</script>
@stop