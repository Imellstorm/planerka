<div class="custom-modal" id="modal-reg-second" style="display:block;">
    <div class="title">Выберите тип вашего аккаунта</div>
    <div class="account-tipes main-roles">
        <div class="tipe role_main" role="2">
            <figure>
                <a href="#null" class="rings"></a>
            </figure>
            <a href="#null">Я заказчик,<br> ищу исполнителя</a>
        </div>
        <div class="tipe role_main" role="3">
            <figure>
                <a href="#null" class="mic"></a>
            </figure>
            <a href="#null">Я ведущий<br> или тамада</a>
        </div>
        <div class="tipe role_main" role="4">
            <figure>
                <a href="#null" class="photo"></a>
            </figure>
            <a href="#null">Я фотограф<br> или оператор</a>
        </div>
        <div class="tipe role_main" role="5">
            <figure>
                <a href="#null" class="make"></a>
            </figure>
            <a href="#null">Я стилист<br> или визажист</a>
        </div>
        <div class="tipe role_main" role="6">
            <figure>
                <a href="#null" class="anim"></a>
            </figure>
            <a href="#null">Я организатор<br> мероприятий</a>
        </div>
        <div class="tipe role_other">
            <figure>
                <a href="#null" class="other"></a>
            </figure>
            <a href="#null">Другое</a>
        </div>
    </div> 

    <div class="account-tipes additional-roles" style="display:none">
        <div class="text-center role_other">Предыдущие роли</div>
        @if(!empty($otherRoles))
            @foreach($otherRoles as $role)
                <div class="tipe role_main" role="{{ $role->id }}">
                    <figure>
                        <a href="#null" class="rings"></a>
                    </figure>
                    <a href="#null">{{ $role->name }}</a>
                </div>
            @endforeach
        @else
            Другие роли отсутствуют
        @endif
    </div>                     
</div>
<div class="loading" style="text-align:center;display:none">
    <img src="/assets/img/loading.gif" style="width:40px;margin-top:100px;">
</div>