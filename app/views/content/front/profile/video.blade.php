@extends('containers.frontend')

@section('title') {{ 'Профиль|видео' }} @stop

@section('main')
<style type="text/css">
	.btn-file {
	  position: relative;
	  overflow: hidden;
	}
	.btn-file input[type=file] {
	  position: absolute;
	  top: 0;
	  right: 0;
	  min-width: 100%;
	  min-height: 100%;
	  font-size: 100px;
	  text-align: right;
	  filter: alpha(opacity=0);
	  opacity: 0;
	  background: red;
	  cursor: inherit;
	  display: block;
	}
	input[readonly] {
	  background-color: white !important;
	  cursor: text !important;
	}
</style>
<script type="text/javascript">
	$(document).on('change', '.btn-file :file', function() {
	  var input = $(this),
	      numFiles = input.get(0).files ? input.get(0).files.length : 1,
	      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	  input.trigger('fileselect', [numFiles, label]);
	});

	$(document).ready( function() {
	    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
	        
	        var input = $(this).parents('.input-group').find(':text'),
	            log = numFiles > 1 ? numFiles + ' files selected' : label;
	        
	        if( input.length ) {
	            input.val(log);
	        } else {
	            if( log ) alert(log);
	        }
	        
	    });
	});
</script>
    <div id="user-page">
        <div class="container">
            @include('content.front.profile.menu')
            @if(!empty($video))
            	<div class="row" style="margin-top:20px">
	            	@foreach($video as $item)
	            		<div class="col-md-6">
	            			<div>Загружено: {{ $item->created_at }}</div>
							<video width="100%" controls>
								<source src="/{{ $item->path }}" type="video/mp4">
								Ваш браузер не поддерживает HTML5 видео.
							</video>
							<a href="/video/delete/{{ $item->id }}" class="fa fa-times delete-image" onclick="return confirm('Удалить?')?true:false;" style="top:5px;right:0px;"></a>
						</div>
	            	@endforeach
            	</div>
            @endif
            @if($userInfo->user_id == Auth::user()->id)
	            {{ Form::open(array('role' => 'form', 'url' => '/video/store', 'files' => true)) }}
	            	<div class="row" style="margin-top:20px">
			            <div class="form-group col-md-6">
				            <h4 style="margin-bottom:10px">Выберите видео файл</h4>
				            <div class="input-group">
				                <span class="input-group-btn">
				                    <span class="btn btn-success btn-file">
				                        Выбрать&hellip; <input type="file" name="video" multiple>
				                    </span>
				                </span>
				                <input type="text" class="form-control" style="height:35px; line-height:20px" readonly>
				            </div>
				            <span class="help-block">
				                Загружайте видео в формате mp4. Максимальный размер файла {{ ini_get('upload_max_filesize') }}
				            </span>
				        </div>
			    	</div>
	            	{{ Form::submit('Сохранить', array('class' => 'btn-main')) }}
	            {{ Form::close() }}
            @endif
        </div>
    </div>
@stop