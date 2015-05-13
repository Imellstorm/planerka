@extends('containers.frontend')

@section('title') {{ 'Профиль|видео' }} @stop

@section('main')
    <div id="user-page">
        <div class="container">
            @include('content.front.profile.menu')
            <h1 class="text-center">Страница с видео</h1>
        </div>
    </div>
@stop