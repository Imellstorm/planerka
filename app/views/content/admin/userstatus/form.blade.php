@extends('containers.admin')
 
@section('title') Типы пользователей @stop
 
@section('main')


    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/user_status/store')) }}
    @else
        {{ Form::model($userstatus, array('role' => 'form', 'url' => 'admin/user_status/update/' . $userstatus->id, 'method' => 'PUT')) }}
    @endif    

    <div class="col-md-4 col-md-offset-4">   
        <h1 class="fa fa-edit"> {{Request::segment(3)=='create'?'Добавить':'Править'}} тип</h1>

        <div class='form-group'>
            {{ Form::label('name', 'Название*') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('icon', 'Иконка') }}
            <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="blank">font awesome class</a>
            {{ Form::text('icon', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('desk', 'Описание') }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div> 
    </div>

    {{ Form::close() }}
 
@stop