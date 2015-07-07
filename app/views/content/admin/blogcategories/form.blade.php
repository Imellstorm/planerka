@extends('containers.admin')
 
@section('title') Категории блога @stop
 
@section('main')


    @if (Request::segment(4)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/blog/categories/store')) }}
    @else
        {{ Form::model($category, array('role' => 'form', 'url' => 'admin/blog/categories/update/' . $category->id, 'method' => 'PUT')) }}
    @endif    

    <div class="col-md-8 col-md-offset-2">   
        <h1 class="fa fa-edit"> {{Request::segment(4)=='create'?'Добавить':'Править'}} категорию блога</h1>

        <div class='form-group'>
            {{ Form::label('name', 'Название*') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div> 
    </div>

    {{ Form::close() }}
 
@stop