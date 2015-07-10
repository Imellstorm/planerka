<div class="custom-modal" id="create-blog" style="display:block">
	<div class="title">Написать блог</div>

	{{ Form::open(array('role' => 'form', 'url' => '/blog/storetheme', 'method' => 'post', 'class'=>'blog-msg')) }}
		<div class="form-group">
			<label for="theme">Тема сообщения</label>
			<input type="text" name="theme_name" class="form-control" required>
		</div>	
		<div class="form-group">
			<label for="text">Текст сообщения</label>
			<textarea id="text" name="text" class="form-control" required></textarea>
		</div>
		<!-- <a href="#null" class="btn-photo">Добавить фото</a> -->
		<input type="hidden" name="subcategory_id" value="{{ $category_id }}">
		<input type="submit" class="btn-main pull-right" value="Опубликовать">
	 {{ Form::close() }}
</div>