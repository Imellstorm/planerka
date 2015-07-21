@extends('containers.admin')
 
@section('title') 
    @if (Request::segment(3)=='create') 
        Создать пользователя
    @else
        Редактировать пользователя
    @endif
@stop
 
@section('main')
  
<h1 style="margin-left:20px"><i class='fa fa-user'></i> {{Request::segment(3)=='create'?'Создать пользователя':'Редактировать пользователя'}}</h1>

@if (Request::segment(3)=='create')
    {{ Form::open(array('role' => 'form', 'url' => 'admin/users/store')) }}
@else
    {{ Form::model($user, array('role' => 'form', 'url' => 'admin/users/update/' . $user->id, 'method' => 'PUT')) }}
@endif

<div class='col-lg-6'>

   <div class='form-group'>
        {{ Form::label('username', 'Имя') }}
        {{ Form::text('username', null, array('placeholder' => 'Username', 'class' => 'form-control')) }}
    </div>
 
    <div class='form-group'>
        {{ Form::label('email', 'Email') }}
        {{ Form::email('email', null, array('placeholder' => 'Email', 'class' => 'form-control')) }}
    </div>

    <div class='form-group'>
        {{ Form::label('role', 'Роль') }}
        {{ Form::select('role', $roles_dd,isset($user->role->id)?$user->role->id:'3',array('class'=>'form-control')); }}
    </div>

    <div class='form-group'>
        {{ Form::label('onfront', 'Показывать на главной') }}
        {{ Form::checkbox('onfront', 1, 0, array('id' => 'onfront')) }}
    </div>

</div>

<div class='col-lg-6'>

    <div class='form-group'>
        {{ Form::label('balance', 'Счёт') }}
        {{ Form::text('balance', null, array('placeholder' => 'Balance', 'class' => 'form-control')) }}
    </div>

 
    <div class='form-group'>
        {{ Form::label('password', 'Пароль') }}
        {{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control')) }}
    </div>
 
    <div class='form-group'>
        {{ Form::label('password_confirmation', 'Подтверждение пароля') }}
        {{ Form::password('password_confirmation', array('placeholder' => 'Confirm Password', 'class' => 'form-control')) }}
    </div>

 </div> 

<div class='form-group' style="text-align:center">
    {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
</div>

{{ Form::close() }}
 
@stop