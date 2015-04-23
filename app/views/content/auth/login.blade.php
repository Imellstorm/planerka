@extends('containers.frontend')
@section('main')
<div class="row">
    <div class='login_box col-md-4 col-md-offset-4'>

        <h1><i class='fa fa-unlock-alt'></i> Вход</h1>
     
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
