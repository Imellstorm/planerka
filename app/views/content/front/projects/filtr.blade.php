<div class="custom-modal" id="modal-filter" style="display:block">
	<div class="title" style="padding: 10px 0 20px 0;">Фильтр</div>
	<form class="project" method="get" action="/project/list">
		<div class="form-group">
			<label for="bj">Бюджет</label>
			<input type="text" id="bj" name="budjet" class="form-control">

			<select class="selectpicker sel-green" name="term">
			    <option value="1">За день</option>
			    <option value="2">За два</option>
			    <option value="3">За три</option>
			</select>
		</div>
		<div class="form-group">
			<div class="checkbox">
			    <input type="checkbox" id="checkbox5" name="pro" value="1">
			    <label for="checkbox5">
			    	Только для 
			    </label>
			    <span><div class="status">PRO</div></span>
			</div>
			<div class="checkbox">
			    <input type="checkbox" id="checkbox6" name="myprof" value="1">
			    <label for="checkbox6">
			    	Только моей специализации
			    </label>
			</div>
		</div>
		<div class="form-group" style="margin-bottom:0;">
			<label for="city">Город</label>
			<input type="text" id="city" class="form-control" name="city">
		</div>
		<input type="submit" class="btn-main" style="margin-bottom:20px;" value="Применить фильтр">
	</form>
</div>