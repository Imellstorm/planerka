@extends('containers.admin')
 
@section('title') Статьи @stop

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/packs/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: "textarea",
        height : 300,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor textcolor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste jbimages, pagebreak"
        ],
        pagebreak_separator: "<pagebreak>",
        //outdent indent
        toolbar: "insertfile undo redo | styleselect | fontsizeselect | fontselect | backcolor | forecolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image jbimages",
        relative_urls: false
    });
</script>
@stop
 
@section('main')

<div class='col-4 col-offset-4'>

    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/articles/store')) }}
    @else
        {{ Form::model($article, array('role' => 'form', 'url' => 'admin/articles/update/' . $article->id, 'method' => 'PUT')) }}
    @endif
 
    <h1 class="fa fa-edit"> {{Request::segment(3)=='create'?'Добавить':'Править'}} статью</h1>

    <div class="row">

        <div class='form-group col-md-6'>
            {{ Form::label('title', 'Название') }}
            {{ Form::text('title', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group col-md-6'>
            {{ Form::label('alias', 'Алиас') }}
            {{ Form::text('alias', null, array('placeholder' => 'Оставить пустым если это новость', 'class' => 'form-control')) }}
        </div>

        <div class='form-group col-md-12'>
            {{ Form::textarea('content', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group col-md-12'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div>

    </div>

    {{ Form::close() }}
 
</div>
 
@stop