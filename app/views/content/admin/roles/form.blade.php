@extends('containers.admin')
 
@section('title') Виды пользователей @stop
 
@section('main')


    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/roles/store')) }}
    @else
        {{ Form::model($role, array('role' => 'form', 'url' => 'admin/roles/update/' . $role->id, 'method' => 'PUT')) }}
    @endif    

    <div class="col-md-4 col-md-offset-4">   
        <h1 class="fa fa-edit"> {{Request::segment(3)=='create'?'Добавить':'Править'}} тип пользователя</h1>

        <div class='form-group'>
            {{ Form::label('type', 'Категория') }}
            {{ Form::select('type', array('системная'=>'системная','основная'=>'основная','другое'=>'другое'),isset($role->type)?$role->type:'',array('class'=>'form-control')); }}
        </div>

        <div class='form-group'>
            {{ Form::label('name', 'Название*') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>         
            {{ Form::checkbox('show_in_menu',1,!empty($role->show_in_menu)?'$role->show_in_menu':'',array('id' => 'show_in_menu')) }}
            {{ Form::label('show_in_menu', 'Показывать в поиске') }}
        </div>

        <div class='form-group'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div> 
    </div>

    {{ Form::close() }}
 
@stop