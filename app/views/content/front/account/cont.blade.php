@extends ('containers.frontend')
@section('title') Личный кабинет @stop 
@section('middle_menu')
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="{{ Request::segment(2)=='userinfo'?'active':'' }}"><a href="/account/userinfo">{{ Lang::get('main.my_data') }}</a></li>
        <li class="{{ Request::segment(2)=='posts'?'active':'' }}"><a href="/account/posts">{{ Lang::get('main.posts') }}</a></li>
        <li class="{{ Request::segment(2)=='comments'?'active':'' }}"><a href="/account/comments">{{ Lang::get('main.comments') }}</a></li>
        <li class="{{ Request::segment(2)=='messages'||Request::segment(2)=='message'?'active':'' }}"><a href="/account/messages/inbox">{{ Lang::get('main.messages') }}</a></li>
        <li class="{{ Request::segment(2)=='settings'?'active':'' }}"><a href="/account/settings">{{ Lang::get('main.notification') }}</a></li>
        <li class="{{ Request::segment(2)=='funds'?'active':'' }}"><a href="/account/funds/step1">{{ Lang::get('main.balance') }}: {{ $user->balance }}</a></li>
    </ul>
    <!-- Tab panes -->  
@stop
@section('heading')
    <h2 class="fa fa-user"></h2>
@stop
@section('main')    
    <div class="account_cont">        
        <div class="tab-content">
            {{$content}}
        </div>
    </div>    
@stop