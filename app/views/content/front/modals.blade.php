<div class="custom-modal" id="modal-register">
    <div class="rules" style="display:none">
        {{ $rules->content }}
        <a href="#" class="btn-main rulesDone" style="margin-top:5px;">Прочитано</a>
    </div>
    <div class="register-cont">
        <div class="title">Регистрация на планерке</div>

        <div class="social-login">
            <p style="width:165px;margin-top:0">Зарегистируйтесь с помощью:</p>
            <a href="/auth/loginfacebook/reg" class="facebook social"></a>
            <a href="/auth/loginvk/reg" class="vk social"></a>
            <a href="/auth/logintwitter/reg" class="twitter social"></a>
        </div>

        <form class="login">
             <div class="form-group">
                <input type="text" class="form-control socNet">
                <input type="text" class="form-control socId">
                <input type="text" class="form-control socImage">
                <div class="social-message"></div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control username" placeholder="Planerca.ru/Ник нэйм">
                <div class="username error"></div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control email" placeholder="Электронная почта">
                <div class="email error"></div>
            </div>
            <div class="form-group">
                <input type="password" class="form-control password" placeholder="Пароль">
                <div class="password error"></div>
            </div>
            <div class="form-group">
                <input type="password" class="form-control confirm_password" placeholder="Пароль повторно">
            </div>

            <img id="captcha" src="/assets/packs/securimage/securimage_show.php" alt="CAPTCHA Image" />
            <input type="text" name="captcha_code" size="10" maxlength="6" class="captcha_code form-control" style="width:130px" />
            <a href="#" onclick="document.getElementById('captcha').src = '/assets/packs/securimage/securimage_show.php?' + Math.random(); return false">
                <img src="/assets/img/refresh.jpg" style="width:35px;margin-top:-6px;">
            </a>
            <div class="captcha error"></div>
        
            <footer>
                <div class="pull-left">
                    <div>
                        <a href="#" class="rules">Прочитать правила</a>
                    </div>
                </div>
                <a href="#modal-reg-second" class="btn-main create-account" style="margin-top:5px;">Создать аккаунт</a>
            </footer>
        </form>
    </div>
</div>

<div class="custom-modal" id="modal-login">
    <div>
        <div class="title">Вход на сайт</div>

        <div class="social-login">
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
                    <div>
                        <a href="#fancybox_password" class="fancybox">Забыли пароль?</a>
                    </div>
                </div>
                <input type="submit" style="margin:0 auto" class="btn-main rulesDone" value="Войти">
            </footer>

        {{ Form::close() }}   
    </div>
</div>

<div class="custom-modal" id="fancybox_password">
    <div>
        <div class="title">Напоминание пароля</div>


        {{ Form::open(array('url' =>'/password/remind', 'role' => 'form', 'class'=>'login')) }}
            <div class="form-group">
                <input type="text" class="form-control email" name="email" placeholder="Электронная почта">
            </div>
            <footer>
                <input type="submit" style="margin:0 auto" class="btn-main rulesDone" value="Отправить">
            </footer>

        {{ Form::close() }}   
    </div>
</div>

<div class="custom-modal" id="fancybox_password">
    <div>
        <div class="title">Напоминание пароля</div>


        {{ Form::open(array('url' =>'/password/remind', 'role' => 'form', 'class'=>'login')) }}
            <div class="form-group">
                <input type="text" class="form-control email" name="email" placeholder="Электронная почта">
            </div>
            <footer>
                <input type="submit" style="margin:0 auto" class="btn-main rulesDone" value="Отправить">
            </footer>

        {{ Form::close() }}   
    </div>
</div>

<a href="#fancybox_reset_password" class="fancybox" id="fancybox_reset_password_btn" style="display:none">link</a>
<div class="custom-modal" id="fancybox_reset_password">
    <div>
        <div class="title">Восстановление пароля</div>
            <input type="hidden" class="form-control token" name="token" value="{{ Session::has('token')?Session::get('token'):'' }}">
            <div class="form-group">
                <input type="password" class="form-control password" placeholder="Пароль" name="password" >
            </div>
            <div class="form-group">
                <input type="password" class="form-control confirm_password" placeholder="Пароль повторно" name="password_confirmation">
                <div class="password error"></div>
            </div>
            <footer>
                <input type="submit" style="margin:0 auto" class="btn-main rulesDone password_reset_submit" value="Сохранить">
            </footer>
    </div>
</div>




<div class="custom-modal" id="modal-reg-second" >
    <div class="title">Выберите тип вашего аккаунта</div>
    <div class="account-tipes">
        <div class="tipe">
            <figure>
                <a href="#null" class="role_chose" user_role="rings"></a>
            </figure>
            <a href="#null">Я заказчик,<br> ищу исполнителя</a>
        </div>
        <div class="tipe">
            <figure>
                <a href="#null" class="role_chose" user_role="mic"></a>
            </figure>
            <a href="#null">Я ведущий<br> или тамада</a>
        </div>
        <div class="tipe">
            <figure>
                <a href="#null" class="role_chose" user_role="photo"></a>
            </figure>
            <a href="#null">Я фотограф<br> или оператор</a>
        </div>
        <div class="tipe">
            <figure>
                <a href="#null" class="role_chose" user_role="make"></a>
            </figure>
            <a href="#null">Я стилист<br> или визажист</a>
        </div>
        <div class="tipe">
            <figure>
                <a href="#null" class="role_chose" user_role="anim"></a>
            </figure>
            <a href="#null">Я организатор<br> мероприятий</a>
        </div>
        <div class="tipe">
            <figure>
                <a href="#null" class="role_chose" user_role="other"></a>
            </figure>
            <a href="#null">Другое</a>
        </div>
    </div>                      
</div>