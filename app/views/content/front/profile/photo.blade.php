@extends('containers.frontend')

@section('title') {{ 'Профиль' }} @stop

@section('main')

<!-- MAIN CONTENT
    ============================= -->   
    <div id="user-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="inner-nav">
                        <li><a href="#null" class="active">Фотографии</a></li>
                        <li><a href="#null">Видео</a></li>
                        <li><a href="#null">Информация</a></li>
                        <li><a href="#null">Отзывы</a></li>
                        <li><a href="#null">Календарь</a></li>
                        <li class="last"><a href="#null" class="btn-main">Заказать</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="profile-info">
                        <h3>Ведущий на свадьбу</h3>
                        <span class="price">от 25 000</span>
                        <p>Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода Срочно нужен рыбный текст! рыба рыба кит. делаем стандартное окошко для ввода</p>
                    </div>
                    <div class="profile-data">
                        <dl>
                            <dt>Мобильний телефон</dt>
                            <dd>+7 921 000 00 00</dd>

                            <dt>E-mail</dt>
                            <dd>parfenov@planerka.ru</dd>

                            <dt>Сайт</dt>
                            <dd>parfenof.info</dd>

                            <dt>Просмотр профиля</dt>
                            <dd>20</dd>

                            <dt>Лайков</dt>
                            <dd>30</dd>

                            <dt>Выполненных заказов</dt>
                            <dd>12</dd>

                            <dt>Регистрация на сайте</dt>
                            <dd>1 год и 5 дней</dd>
                        </dl>
                        <footer>
                            <p>Выезжаю в другой город</p>
                            <p>Выезжаю за рубеж</p>
                        </footer>
                    </div>
                    <div class="profile-albums">
                        <div class="album">
                            <div class="overflow"></div>
                            <a href="#null"><img src="/assets/img/album.png" alt=""></a>
                            <h4><a href="#null">Необычная свадьба <br>Саши и Миши</a></h4>
                            <p>25 фото</p>
                        </div>
                        <div class="photos">
                            <ul>
                                <li><a href="#null"><img src="/assets/img/photo.png" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/photo.png" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/photo.png" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/photo.png" alt=""></a></li>
                                <li class="add_more"><a href="#null"></a><p>Еще хочу посмотреть<br> немного фото</p><span>+ 5</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="add_album">
                        <a href="#null"></a>
                        <p>Создать новый альбом</p>
                        <span>+</span>
                    </div>  
                </div>
            </div>
        </div>
    </div>  
@stop