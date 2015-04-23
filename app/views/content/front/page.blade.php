@extends('containers.frontend')
 
@section('title') {{ $page->title }} @stop

@section('main')
<h1 class="text-center">{{ $page->title }}</h1>
<div class="row">	                           
    <div class="col-md-12 text-center">
        {{ $page->content }}    
	</div>
</div>
@stop

