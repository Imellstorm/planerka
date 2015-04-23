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
        //outdent indent
        toolbar: "insertfile backcolor | forecolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist link",
        relative_urls: false
    });

    $(document).ready(function(){
        {{ isset($post->city_id)?'cityId='.$post->city_id.';':'cityId="";' }}
        if($('#region').val()!=0 && cityId!=""){
            getCityList($('#region').val(),cityId);
        }        
    });    

    FileInputcount = 0;
    LicenseInputcount = 0;

    function addFileInput(){           
        if(FileInputcount<10){
            FileInputcount++;
            $('.add_file_input').after('<div class="file_input"><input type="button" value="-" class="remove_file_input" onClick="removeFileInput(this)"><input name="files[]" type="file"></div>');        
        } else {
            alert('Максимальное количество загружаемых файлов - 10');
        }
    }

    function addLicense(){
        if(LicenseInputcount<10){  
            LicenseInputcount++;         
            $('.add_license').after('<div><input type="button" class="pull-left license_remove_button" value="-" onClick="removeLicense(this)">{{ Form::select('license[]', $license,'null',array('class' => 'form-control license_input')) }}</div>');        
        } else {
            alert('Максимальное количество лицензий - 10');
        }    
    }

    function removeLicense(item){
        LicenseInputcount--; 
        $(item).parent().remove();
    }
    
    function removeFileInput(item){
        FileInputcount--; 
        $(item).parent().remove();
    }
</script> 
@stop

<div id="create_post_form">
    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => '/post/store', 'class' => 'top-20', 'enctype' => 'multipart/form-data')) }}
    @else
        {{ Form::model($post, array('role' => 'form', 'url' => '/post/update/' . $post->id, 'method' => 'PUT', 'class' => 'top-20', 'enctype' => 'multipart/form-data')) }}
    @endif
        <div>
            <div class="row">
                <div class="col-md-6">
                    <div class='form-group'>
                        {{ Form::label('title', 'Hазвание предприятия*') }}
                        {{ Form::text('title', null, array('class' => 'form-control')) }} 
                    </div>
                </div>
                <div class="col-md-6">
                    <div class='form-group'>                              
                        {{ Form::label('ownership', 'Форма собственности*') }}
                        {{ Form::select('ownership', $ownership,isset($post->ownership)?$post->ownership:'',array('class' => 'form-control')) }}
                    </div>   
                </div>
            </div>                                                  
            <div class="row">
                <div class="col-md-6">
                    <div class='form-group'>
                        {{ Form::label('price', 'Цена*') }}
                        {{ Form::text('price', null, array('class' => 'form-control')) }} 
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class='form-group'> 
                        {{ Form::label('nds', 'Форма налогообложения') }}                                            
                        {{ Form::select('nds', $nds,isset($post->nds)?$post->nds:'',array('class' => 'form-control')) }}      
                    </div>                             
                </div>   
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class='form-group'> 
                        {{ Form::label('region', 'Регион* (область)') }}                                            
                        {{ Form::select('region', $regions,isset($post->region_id)?$post->region_id:'',array('class' => 'form-control', 'onChange'=>'getCityList(this.selectedIndex)')) }}
                    </div>
                </div>
                <div class="col-md-6 city_list">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class='form-group'>            
                        {{ Form::label('license', 'Лицензии (если есть)') }}
                        <input type="button" value='+' onClick="addLicense()" class="add_license">
                        @if(!empty($post->licenses))
                            <?php $post->licenses = explode(',',$post->licenses) ?>
                            @foreach($post->licenses as $key => $val)
                                <div>
                                    <input type="button" class="pull-left license_remove_button" value="-" onClick="removeLicense(this)">
                                    {{ Form::select('license[]', $license,$val,array('class' => 'form-control license_input')) }}
                                </div>
                            @endforeach
                        @endif                                                   
                    </div>
                    <div class='form-group'>
                        {{ Form::label('file', 'Прилагаемые файлы.') }}                 
                        <input type="button" value='+' onClick="addFileInput()" class="add_file_input">
                        @if(!empty($post->files))
                            <?php $files = json_decode($post->files) ?>
                            @if(!empty($files))
                                @foreach($files as $key => $val)
                                    <div class="file_input"><input type="button" value="-" class="remove_file_input" onClick="removeFileInput(this)"><input name="existFiles[{{ $key }}]" type="hidden" value="{{ $val }}">{{ $key }}</div>
                                @endforeach
                            @endif
                        @endif
                        <div>Допустимые форматы: jpg, jpeg, bmp, png, gif, doc, docx, pdf, rtf, xlsx, xls, txt</div>
                        <div>Максимальный размер файла - 1000kB (1MB)</div>
                    </div>
                    <div class='form-group'>
                        {{ Form::label('description', 'Описание') }}  
                        {{ Form::textArea('description') }}
                        <input type="submit" class="btn btn-success account_post_save_btn" value="Сохранить">
                    </div>
                </div> 
            </div>                            
        </div>                             
    {{ Form::close() }}
</div>