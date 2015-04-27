<div class="custom-modal" id="modal-login">
    <div class="rules" style="display:none">
        {{ $rules->content }}
        <a href="#" class="btn-main rulesDone" style="margin-top:5px;">Прочитано</a>
    </div>
    <div class="register-cont">
        <div class="title">Регистрация на планерке</div>

        <div class="social-login">
            <p>Войдите с помощью:</p>
            <a href="#null" class="facebook"></a>
            <a href="#null" class="vk"></a>
            <a href="#null" class="twitter"></a>
        </div>

        <form class="login">
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
        
            <footer>
                <div class="pull-left">
                    <div>
                        <a href="#" class="rules fancybox2">Прочитать правила</a>
                    </div>
                </div>
                <a href="#modal-reg-second" class="btn-main create-account" style="margin-top:5px;">Создать аккаунт</a>
            </footer>
        </form>
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