@extends('containers.frontend')

@section('title') {{ 'Настройки' }} @stop

@section('main')
<!-- MAIN CONTENT
    ============================= -->   
    <div id="user-page">
        <div class="container">
            @include('content.front.account.menu_one')
            <div class="row">
                <div class="col-sm-12">
                    @if (empty($settings))
                        {{ Form::open(array('role' => 'form', 'url' => '/settings/store', 'class'=>'account')) }}
                    @else
                        {{ Form::model($settings, array('role' => 'form', 'url' => '/settings/update/' . $settings->id, 'method' => 'PUT', 'class'=>'account')) }}
                    @endif
                        <div class="form-group">
                            <label for="oldpass">Старый пароль</label>
                            <input type="password" name="oldpass" class="form-control" id="oldpass">
                        </div>
                        <div class="form-group">
                            <label for="newpass">Новый пароль</label>
                            <input type="password" name="newpass" class="form-control" id="newpass">
                        </div>
                        <div class="form-group">
                            <label for="passconf">Подтвердите</label>
                            <input type="password" name="passconf" class="form-control" id="passconf">
                        </div>
                        <div class="form-group chbox">
                            <label for="">Рассылка</label>
                            <div class="cbeckbox-body">
                                <div class="checkbox">
                                    {{ Form::checkbox('adminmail', 1, null, array('id' => 'adminmail')) }}
                                    {{ Form::label('adminmail', 'Рассылка администрации') }}
                                </div>
                                <div class="checkbox">
                                    {{ Form::checkbox('blogmail', 1, null, array('id' => 'blogmail')) }}
                                    {{ Form::label('blogmail', 'Подписка на комментарии к постам в блоге') }}
                                </div>
                                <div class="checkbox">
                                    {{ Form::checkbox('privatemail', 1, null, array('id' => 'privatemail')) }}
                                    {{ Form::label('privatemail', 'Личные сообщения') }}
                                </div>
                                @if(Auth::user()->role_id!=2)
                                    <div class="pro-box">
                                        <div class="checkbox">
                                            {{ Form::checkbox('projectsmail', 1, null, array('id' => 'projectsmail')) }}
                                            {{ Form::label('projectsmail', 'Рассылка новых подходящих проектов под вашу специализацию') }}
                                            <span>Только для <div class="status">PRO</div></span>
                                        </div>
                                    </div>
                                @endif
                            </div>  
                        </div>
                        <input type="submit" class="btn-main" value="Сохранить">
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop