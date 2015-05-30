@extends('containers.admin')
 
@section('title') Ответ опроса @stop
 
@section('main')


    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/vote/store')) }}
    @else
        {{ Form::model($answer, array('role' => 'form', 'url' => 'admin/vote/update/' . $answer->id, 'method' => 'PUT')) }}
    @endif    

    <div class="col-md-6 col-md-offset-3">   
        <h1 class="fa fa-edit"> {{Request::segment(3)=='create'?'Добавить':'Править'}} ответ опроса</h1>

        <div class='form-group'>
            {{ Form::label('name', 'Текст отвата*') }}
            {{ Form::textarea('text', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group text-center'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div> 
    </div>

    {{ Form::close() }}
 
@stop