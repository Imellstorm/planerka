@if(count($albums))
	<div style="max-width:630px">
		@foreach($albums as $album)
			<div style="position:relative;float:left;margin:5px;width:200px;height:200px;background:lightgrey;">
	        	<img src="/{{ !empty($album->image)?$album->image:'assets/img/noimage.png' }}" style="cursor:pointer;width:200px;height:200px" class="album_image" album_id="{{ $album->id }}">
	        	<div style="  position:absolute;top:170px;width:100%;background:rgba(0,0,0,0.7);color:white;padding:5px;">
	        		{{ $album->name }}
	        	</div>
	        </div>
		@endforeach
	</div>
@endif