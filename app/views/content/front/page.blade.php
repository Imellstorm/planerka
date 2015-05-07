@extends('containers.frontend')
 
@section('title') {{ $page->title }} @stop

@section('main')
<h1 class="text-center section-title decor" style="margin-top:50px;">{{ $page->title }}</h1>
<div class="container">
	<div class="row">	                           
	    <div class="col-md-12 text-center">
	        {{ $page->content }}    
		</div>
	</div>
</div>
@stop

