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
                <input type="hidden" class="form-control socNet">
                <input type="hidden" class="form-control socId">
                <input type="hidden" class="form-control socImage">
                <div class="social-message"></div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control username" placeholder="Planerca.ru/Ник нэйм">
                <div class="username error"></div>
                <div class="alias error"></div>
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