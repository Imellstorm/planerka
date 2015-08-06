@extends('containers.admin')
 
@section('title') Настройки @stop
 
@section('main')

    {{ Form::model($settings, array('role' => 'form', 'url' => '/admin/settings/update', 'method' => 'PUT','files'=> true)) }}   

        <div class="col-md-6 col-md-offset-3">   
            <h1 class="fa fa-gear"> Настройки</h1>

            <div class="form-group">
                {{ Form::label('usercard', 'Обложка сайта') }}
                {{ Form::text('main_cover',null,array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::file('cover', array('id' => 'cover')) }}
            </div>
            <div class="form-group">
                {{ Form::label('usercard', 'Автор обложки') }}
                {{ Form::text('cover_author',null,array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
                {{ Form::label('slogan', 'Слоган') }}
                {{ Form::textarea('slogan',null,array('class' => 'form-control')) }}
            </div>

            <div class='form-group' style="margin-top:40px">
                {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
            </div> 
        </div>

    {{ Form::close() }}
 
@stop