<div class="custom-modal" id="modal-reg-second" style="display:block;">
    <div class="title">Выберите тип вашего аккаунта</div>
    <div class="account-tipes">
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