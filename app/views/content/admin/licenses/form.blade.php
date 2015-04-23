@extends('containers.admin')
 
@section('title') Лицензия @stop
 
@section('main')


    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/licenses/store')) }}
    @else
        {{ Form::model($license, array('role' => 'form', 'url' => 'admin/licenses/update/' . $license->id, 'method' => 'PUT')) }}
    @endif    

    <div class="col-md-6 col-md-offset-3">   
        <h1 class="fa fa-edit"> {{Request::segment(3)=='create'?'Добавить':'Править'}} лицензию</h1>
        <div class='form-group'>
            {{ Form::label('abr', 'Сокращение*') }}
            {{ Form::text('abr', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('abr_ukr', 'Сокращение* (украинский)') }}
            {{ Form::text('abr_ukr', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('name', 'Название*') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('name_ukr', 'Название* (украинский)') }}
            {{ Form::text('name_ukr', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div> 
    </div>

    {{ Form::close() }}
 
@stop