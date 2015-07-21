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

    function generateSlug () {
        var str = $('.article-title-input').val();
        if(str.length>1){
            var space = '_';
            str = str.toLowerCase();
            var transl = {
                'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 
                'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
                'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
                'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya'
            }
            var link = '';
            for (var i = 0; i < str.length; i++) {
                if(/[а-яё]/.test(str.charAt(i))) { //если текущий символ - русская буква, то меняем его
                    link += transl[str.charAt(i)];
                } else if (/[a-z0-9]/.test(str.charAt(i))) {
                    link += str.charAt(i); //если текущий символ - английская буква или цифра, то оставляем как есть
                } else {
                    if (link.slice(-1) !== space) link += space; // если не то и не другое то вставляем space
                }
            }
            $('.article-alias-input').val(link);
        }
    } 

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function(){
        $('body').on('change','#imgInp',function(){
            readURL(this); 
        });
        
        $('.delete_image').on('click',function(){
            $('#img_preview').attr('src','/assets/img/noimage.png');
            $('#imgInp').val('');
            $('#image_path').val('');
            $('#image_thumb').val('');
        });
    });
</script>
@stop
 
@section('main')

<div class='col-4 col-offset-4'>

    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/articles/store', 'files' => true)) }}
    @else
        {{ Form::model($article, array('role' => 'form', 'url' => 'admin/articles/update/' . $article->id, 'method' => 'PUT', 'files' => true)) }}
    @endif
 
    <h1 class="fa fa-edit"> {{Request::segment(3)=='create'?'Добавить':'Править'}} статью</h1>

    <div class='pull-right' style="margin:35px 20px 0 0">
        {{ Form::label('onfront', 'Показывать на главной') }}
        {{ Form::checkbox('onfront', 1, 0, array('id' => 'onfront')) }}
    </div>

    <div class="row">

        <div class="form-group col-md-6" style="overflow:hidden">
            <div class="col-md-10">
                {{ Form::label('title', 'Название') }}
                {{ Form::text('title', null, array('class' => 'form-control article-title-input')) }}
            </div>
            <div class="col-md-2">
                <a class="btn btn-default" onClick="generateSlug()" style="margin: 33px 0 0 -25px;">Автоалиас</a>
            </div>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('alias', 'Алиас') }}
            {{ Form::text('alias', null, array('class' => 'form-control article-alias-input')) }}
        </div>


        <div class="form-group col-md-9">
            <div class="col-md-12">
                {{ Form::textarea('content', null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-md-3">   
            <div class="upload_img_cont form-group"> 
                <i class="fa fa-times delete_image pull-right image_delete_cross" title="Delete"></i>                                            
                <img id="img_preview" src="{{ !empty($article->image)?'/'.$article->image:'/assets/img/noimage.png' }}" alt="your image" /><br><br>
                {{ Form::file('userfile', array('id' => 'imgInp')) }}
                <input type="hidden" name="image" id="image_path" value="{{ !empty($article->image)?$article->image:'' }}">
            </div>

            <div class="form-group col-md-12 text-center" style="margin-top:20px">
                {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
            </div>
        </div>

    </div>

    {{ Form::close() }}
 
</div>
 
@stop