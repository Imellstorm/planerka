@extends('containers.frontend')
 
@section('title') Регистрация @stop
 
@section('main')
 

<div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-8">
        <h2><i class='fa fa-user'></i> Регистрация</h2>
        {{ Form::open(array('role' => 'form', 'url' => 'admin/users/store')) }}

        <div class='form-group'>
            {{ Form::label('username', 'Имя пользователя') }}*
            {{ Form::text('username', null, array('placeholder' => 'vasya', 'class' => 'form-control')) }}
        </div>
     
        <div class='form-group'>
            {{ Form::label('email', 'E-mail адрес') }}*
            {{ Form::email('email', null, array('placeholder' => 'admin@domain.com', 'class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('phone', 'Телефон') }}
            {{ Form::text('phone', null, array('placeholder' => '044 111 22 33', 'class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('legal_form', 'Правовая форма') }}
            {{ Form::select('legal_form', array('0'=>'Частное лицо','1'=>'Организация'),0,array('class'=>'form-control')); }}
        </div>
     
        <div class='form-group'>
            {{ Form::label('password', 'Пароль') }}*
            {{ Form::password('password', array('placeholder' => 'password', 'class' => 'form-control')) }}
        </div>
     
        <div class='form-group'>
            {{ Form::label('password_confirmation', 'Подтверждение пароля') }}*
            {{ Form::password('password_confirmation', array('placeholder' => 'password', 'class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::checkbox('license_agreement',1,null,array('id' => 'license_agreement')) }}
            <label for='license_agreement'>
                Я прочитал и принимаю условия <a href="/agreement" class="license_link">лицензионного соглацения</a>
            </label>
        </div>

        <img id="captcha" src="/assets/packs/securimage/securimage_show.php" alt="CAPTCHA Image" />
        <input type="text" name="captcha_code" size="10" maxlength="6" />
        <a href="#" onclick="document.getElementById('captcha').src = '/assets/packs/securimage/securimage_show.php?' + Math.random(); return false">
            <img src="/assets/img/refresh.jpg" style="width:35px;margin-top:-6px;">
        </a>
     
        <div class='form-group' style="margin-top:20px">
            {{ Form::submit('Зарегистрировать', array('class' => 'btn btn-success')) }}
        </div>
     
        {{ Form::close() }}

        Поля отмеченные * обязательны к заполнению
        <br><br>
    </div>
</div> 
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $(".license_link").fancybox({
                type: 'ajax'
            });
        });
    </script>
@stop