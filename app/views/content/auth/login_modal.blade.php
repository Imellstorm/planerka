<div class="custom-modal" id="modal-login" style="display:block; width:530px;">
    <div>
        <div class="title">Вход на сайт</div>

        <div class="social-login mobile">
            <p>Войдите с помощью:</p>
            <a href="/auth/loginfacebook" class="facebook social"></a>
            <a href="/auth/loginvk" class="vk social"></a>
            <a href="/auth/logintwitter" class="twitter social"></a>
        </div>

        {{ Form::open(array('url' =>'/auth', 'role' => 'form', 'class'=>'login')) }}
            <div class="form-group">
                <input type="text" class="form-control email" name="username" placeholder="Электронная почта">
            </div>
            <div class="form-group">
                <input type="password" class="form-control password" name="password" placeholder="Пароль">
            </div>
            <footer>
                <div class="pull-left">
                    <div class='form-group'>
                        <a href="/auth/showpasswordreminder" class="fancybox_ajax">Забыли пароль?</a>
                    </div>
                </div>
                <input type="submit" style="margin:0 auto" class="btn-main rulesDone" value="Войти">
            </footer>

        {{ Form::close() }}   
    </div>
</div>