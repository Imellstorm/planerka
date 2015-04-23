@extends('containers.admin')
 
@section('title') 
    @if (Request::segment(3)=='create') 
        Создать комментарий
    @else
        Редактировать комментарий
    @endif
@stop

@section('scripts')
<script src="{{ asset('assets/packs/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        height : 300,
        plugins: [
            "advlist autolink lists link charmap print anchor textcolor",
            "searchreplace visualblocks code",
            "insertdatetime table contextmenu paste, pagebreak"
        ],
        pagebreak_separator: "<pagebreak>",
        resize: false,
        toolbar: "insertfile backcolor | forecolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist link",
        relative_urls: false
    });
</script> 
@stop
 
@section('main')
  
<h1 class="center"><i class='fa fa-user'></i> {{Request::segment(3)=='create'?'Создать комментарий':'Редактировать комментарий'}}</h1>

@if (Request::segment(3)=='create')
    {{ Form::open(array('role' => 'form', 'url' => 'admin/users/store')) }}
@else
    {{ Form::model($article, array('role' => 'form', 'url' => 'admin/users/update/' . $user->id, 'method' => 'PUT')) }}
@endif
<div class="col-md-4 col-md-offset-4">
    <div class='form-group'>
        {{ Form::label('author', 'Автор') }}
        {{ Form::text('author', null, array('class' => 'form-control')) }}
    </div>

    <div class='form-group'>
        {{ Form::label('post', 'Объявление') }}
        {{ Form::text('post', null, array('class' => 'form-control')) }}
    </div>

    <div class='form-group' style="text-align:center">
        {{ Form::submit('Сохранить', ('class' => 'btn btn-primary')) }}
    </div>
</div>

{{ Form::close() }}
 
@stop