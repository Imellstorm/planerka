@extends('containers.frontend')

@section('title') {{ 'Профиль' }} @stop

@section('main')

<!-- MAIN CONTENT
    ============================= -->   
    <div id="user-page">
        <div class="container">
            @include('content.front.account.menu_one')
            <div class="row">
                <div class="col-sm-12">
                    <div class="user-profile">
                        <form class="prof">
                            <div class="form-group">
                                <label for="">Аватар</label>
                                <div class="avatar">
                                    <input type="file" id="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="prof-name">Имя</label>
                                <input type="text" id="prof-name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="prof-last-name">Фамилия</label>
                                <input type="text" id="prof-last-name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="prof-city">Город</label>
                                <input type="text" id="prof-city" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="prof-birth">Дата рождения</label>
                                <input type="text" id="prof-birth" class="form-control">
                            </div>
                            <div class="form-group sex">
                                <label for="radio">Пол</label>
                                <div class="radio">
                                    <input type="radio" name="radio1" id="radio1" value="option1" checked>
                                    <label for="radio1">
                                        <p>М</p>
                                    </label>
                                </div>
                                <div class="radio">
                                    <input type="radio" name="radio1" id="radio2" value="option2">
                                    <label for="radio2">
                                        <p>Ж</p>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="prof-mobile">Мобильный телефон</label>
                                <input type="text" id="prof-mobile" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="prof-bio">Биография</label>
                                <textarea id="prof-bio" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="prof-email">Электронная почта</label>
                                <input type="text" id="prof-email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="prof-site">Сайт</label>
                                <input type="text" id="prof-site" class="form-control">
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox6">
                                    <label for="checkbox6">
                                        Могу выезжать в другой город
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <input type="checkbox" id="checkbox7">
                                    <label for="checkbox7">
                                        Могу выезжать за рубеж
                                    </label>
                                </div>
                            </div>
                            <a href="#null" class="btn-main">Сохранить</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>  
@stop