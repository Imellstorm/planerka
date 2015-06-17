<script type="text/javascript">
	$(document).ready(function(){
		$('#datepicker, .datepicker').datepicker({
			inline: true,
			showOtherMonths: true,
	        changeMonth: true,        
	      	changeYear: true

		});
	})
</script>
<div class="custom-modal" id="modal-order" style="display:block; width:600px">
	<div class="title" style="padding: 20px 0;">Заказ</div>
	{{ Form::open(array('role' => 'form', 'url' => '/project/store', 'class'=>'modal-order-form')) }}
		<div class="form-group">	
			<label for="theme">Заголовок</label>
			<input type="text" class="form-control" name="title" style="width: 385px;" required>
		</div>
		<div class="form-group">
			<label>Тема</label>
			{{ Form::select('role_id',$roles,'',array('class'=>'form-control')); }}
		
			<input type="text" placeholder="Дата" name="date" class="form-control date green datepicker">
		</div>
		<div class="form-group">
		    {{ Form::label('budget', 'Стоимость') }}
			{{ Form::text('budget', null, array('class' => 'form-control price-input','placeholder'=>'в рублях','required')) }}
			
			<select class="selectpicker sel-green" name="term" style="margin-left:15px">
			    <option value="1">За день</option>
			    <option value="2">За два</option>
			    <option value="3">За три</option>
			</select>
		</div>
		<div class="form-group">
			<label for="modal-order-place">Город</label>
			<input type="text" id="modal-order-place" name="city"  class="form-control green ">
		</div>
		<div class="form-group">
			<label for="modal-order-text">Комментарий<br> к заказу</label>
			<textarea id="modal-order-text" class="form-control" name="description" rows="3"></textarea>
		</div>
		<div class="form-group">
			<label for="modal-order-phone">Телефон</label>
			<input type="text" id="modal-order-phone" placeholder="" name="phone" class="form-control green ">
		</div>
		<input type="hidden" name="performer" value="{{ $userId }}">
		<input type="submit" class="btn-main btn-order" style="margin-top:0" value="Заказать">
	{{ Form::close() }}
</div>