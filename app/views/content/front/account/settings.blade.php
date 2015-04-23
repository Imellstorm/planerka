<div class="row" style="margin:0 0 20px 0">
	{{ Form::open(array('role' => 'form', 'url' => '/user/settings/update')) }}
    	<div class='form-group'>
			<input type="checkbox" name="get_mail" id="get_mail" value="1"  {{ $getMail==1?'checked':'' }}>
			<label for="get_mail">Получать уведомления о новых объявлениях на сайте</label>			
	    </div>
	    <input type="submit" value="Сохранить" class="btn btn-success">   
    {{ Form::close() }}
</div>