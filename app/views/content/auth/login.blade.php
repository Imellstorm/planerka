@extends('containers.frontend')
@section('main')
<div style="margin:0">
    <div class='login_box' style="max-width:500px; margin:0 auto; padding:10px 20px">

        <h1><i class='fa fa-unlock-alt'></i> Вход</h1>

        <div class="social-login mobile">
            <p>Войдите с помощью:</p>
            <a href="/auth/loginfacebook" class="facebook social"></a>
            <a href="/auth/loginvk" class="vk social"></a>
            <a href="/auth/logintwitter" class="twitter social"></a>
        </div>
     
        {{ Form::open(array('role' => 'form')) }}
     
        <div class='form-group'>
            {{ Form::label('username', 'E-mail адрес') }}
            {{ Form::text('username', null, array('placeholder' => 'admin@domain.com', 'class' => 'form-control')) }}
        </div>
     
        <div class='form-group'>
            {{ Form::label('password', 'Пароль') }}
            {{ Form::password('password', array('placeholder' => 'password', 'class' => 'form-control')) }}
        </div>
     
        <div class='form-group'>
            {{ Form::submit('Вход', array('class' => 'btn btn-submit')) }}
        </div>
     
        {{ Form::close() }}                 
    </div>
</div>
@stop
