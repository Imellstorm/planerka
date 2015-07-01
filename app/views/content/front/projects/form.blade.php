<script type="text/javascript">
$(document).ready(function(){
	$('.create_project_form').on('submit',function(){
		$('.create_project_btn').hide();
		$('.create_project_loading').show();
	})

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

<div class="custom-modal" id="new-project" style="display:block;">
	<div class="title" style="padding:10px 0 ">Создать проэкт</div>
	{{ Form::open(array('role' => 'form', 'url' => '/project/store', 'class'=>'project create_project_form','files'=> true)) }}

		<div class="form-group">
			<label for="theme">Заголовок</label>
			<input type="text" class="form-control" name="title" required>
			<div class="comment">Что требуется сделать? например “Ведущий на свадьбу”</div>
		</div>	
		<div class="form-group">
			<label for="text">Задание</label>
			<textarea id="text" class="form-control" name="description"></textarea>
		</div>
		<div class="form-group">
			<label for="select-parth">Разделы</label>

			{{ Form::select('role_id',$roles,'',array('class'=>'selectpicker sel-green')); }}
			<div class="comment">Выберите специализацию из каталога</div>
		</div>
		<div class="form-group">
			<label for="bj">Бюджет</label>
			<input type="text" id="bj" class="form-control price-input" name="budget">

			<select class="selectpicker sel-green" name="term">
			    <option value="1">За день</option>
			    <option value="2">За два</option>
			    <option value="3">За три</option>
			</select>
		</div>
		<div class="form-group">
			<label for="">Фильтр</label>

			<div class="checkbox">
			    <input type="checkbox" id="checkbox4" name="pro_only" value="1">
			    <label for="checkbox4" class="project-checkbox">
			    	<span>Только для <div class="status">PRO</div></span>
			    </label>
			</div>
		</div>

		<div class="form-group">
			<label class="pull-left">Добавить фото</label>
			<input type="file" name="image" style="position:relative; top:15px;">
		</div>
		<div class="form-group" style="padding-top: 10px;">
			<div class="text-center create_project_loading" style="margin-top:20px; display:none">
				<img src="/assets/img/loading.gif" style="width:20px">
			</div>
			<input type="submit" class="btn-main create_project_btn" value="Опубликовать">
		</div>
	{{ Form::close() }}
</div>