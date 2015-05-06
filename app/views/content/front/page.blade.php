@extends('containers.frontend')
 
@section('title') {{ $page->title }} @stop

@section('main')
<h1 class="text-center section-title decor" style="margin-top:50px;">{{ $page->title }}</h1>
<div class="row">	                           
    <div class="col-md-8 col-md-offset-2 text-center">
        {{ $page->content }}    
	</div>
</div>
@stop

