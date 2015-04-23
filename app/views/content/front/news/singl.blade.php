@extends('containers.frontend')
 
@section('title') {{ $page->title }} @stop

@section('main')
<h1>{{ $page->title }}</h1>
<div class="row">	                           
    <div class="col-md-12">
        {{ $page->content }}    
	</div>
</div>
@stop

