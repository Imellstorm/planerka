@extends('containers.admin')
 
@section('title') Формы собственности @stop
 
@section('main')


    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/ownerships/store')) }}
    @else
        {{ Form::model($ownership, array('role' => 'form', 'url' => 'admin/ownerships/update/' . $ownership->id, 'method' => 'PUT')) }}
    @endif    

    <div class="col-md-4 col-md-offset-4">   
        <h1 class="fa fa-edit"> {{Request::segment(3)=='create'?'Добавить':'Править'}} форму</h1>
        <div class='form-group'>
            {{ Form::label('abr', 'Сокращение*') }}
            {{ Form::text('abr', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('abr_ukr', 'Сокращение (украинский)*') }}
            {{ Form::text('abr_ukr', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('name', 'Название*') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('name_ukr', 'Название (украинский)*') }}
            {{ Form::text('name_ukr', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div> 
    </div>

    {{ Form::close() }}
 
@stop