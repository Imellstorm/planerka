@extends('containers.admin')
 
@section('title') Подкатегории блога @stop
 
@section('main')


    @if (Request::segment(4)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/blog/subcategories/store')) }}
    @else
        {{ Form::model($subcategory, array('role' => 'form', 'url' => 'admin/blog/subcategories/update/' . $subcategory->id, 'method' => 'PUT')) }}
    @endif    

    <div class="col-md-8 col-md-offset-2">   
        <h1 class="fa fa-edit"> {{Request::segment(4)=='create'?'Добавить':'Править'}} подкатегорию блога</h1>
        <div class='form-group'>
            {{ Form::label('name', 'родительская категория*') }}
            {{ Form::select('category_id', $categories,isset($subcategory->category_id)?$subcategory->category_id:'0',array('class'=>'form-control')); }}
        </div>
        <div class='form-group'>
            {{ Form::label('name', 'Название*') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>
        <div class='form-group'>
            {{ Form::label('name', 'Описание') }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div> 
    </div>

    {{ Form::close() }}
 
@stop