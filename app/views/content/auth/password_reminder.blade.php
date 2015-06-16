<div class="custom-modal" id="fancybox_password" style="display:block">
    <div>
        <div class="title">Напоминание пароля</div>
        {{ Form::open(array('url' =>'/password/remind', 'role' => 'form', 'class'=>'login')) }}
            <div class="form-group">
                <input type="email" required class="form-control email" name="email" placeholder="Электронная почта">
            </div>
            <footer>
                <input type="submit" style="margin:0 auto" class="btn-main rulesDone" value="Отправить">
            </footer>

        {{ Form::close() }}   
    </div>
</div>