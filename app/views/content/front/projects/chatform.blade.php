<div class="order-review">
	<div class="title">Обсуждение заказа</div>
	{{ Form::open(array('role' => 'form', 'url' => 'projectmessages/store')) }}
		<div class="form-group">
			<textarea name="text" placeholder="Новое сообщение" required></textarea>
		</div>
		{{ Form::hidden('project_id', $project->project_id) }}
		@if(isset($userId) && !empty($userId))
			{{ Form::hidden('to_user', $userId) }}
		@endif
		<!-- <div class="add-file">
		    <div class="file-title">Добавить файл</div>
		    <input type="file" name="upload" class="upload" title="Choose a file to upload">
		</div> -->
		<span class="add-file-path"></span>
		<input type="submit" class="btn-main" value="Опубликовать сообщение">
	{{ Form::close() }}
</div>