@extends('containers.frontend')

@section('title') {{ 'Главная' }} @stop

@section('main')
<!-- LATEST POSTS
    ============================= -->
    <div class="latest-posts">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-title decor">
                    Наши последние обновления
                </div>
            </div>
            <div class="row">
                <div class="single-post col-md-3 col-sm-6">
                    <div class="image">
                        <img src="/assets/img/post.jpg" alt="">
                    </div>
                    <a href="#" class="btn-more">Новости</a>
                    <a href="#" class="post-title">Оригинальные салаты, которые не оставят гостей равнодушными</a>
                </div>
                <div class="single-post col-md-3 col-sm-6">
                    <div class="image">
                        <img src="/assets/img/post.jpg" alt="">
                    </div>
                    <a href="#" class="btn-more">Новости</a>
                    <a href="#" class="post-title">Оригинальные салаты, которые не оставят гостей равнодушными</a>
                </div>
                <div class="single-post col-md-3 col-sm-6">
                    <div class="image">
                        <img src="/assets/img/post.jpg" alt="">
                    </div>
                    <a href="#" class="btn-more">Новости</a>
                    <a href="#" class="post-title">Оригинальные салаты, которые не оставят гостей равнодушными</a>
                </div>
                <div class="single-post col-md-3 col-sm-6">
                    <div class="image">
                        <img src="/assets/img/post.jpg" alt="">
                    </div>
                    <a href="#" class="btn-more">Новости</a>
                    <a href="#" class="post-title">Оригинальные салаты, которые не оставят гостей равнодушными</a>
                </div>
            </div>
        </div>
    </div>

<!-- MIDDLE CONTENT
    ============================= -->
    <div class="container middle-contant">
        <div class="row">
            <div class="latest-themes col-md-8">
                <div class="section-title">Популярные темы форума</div>
                <div class="sort-by">
                    <a href="#" class="active">За все время</a>
                    <a href="#">В этом месяце</a>
                    <a href="#">На этой неделе</a>
                </div>
                <ul class="theme-list">
                    <li>
                        <div class="title">Об удивительном свадебном платье мечтают с детства!</div>
                        <div class="comment">1978</div>
                        <div class="date">30 сентября 2014</div>
                    </li>
                    <li>
                        <div class="title">Fashion-показ свадебных платьев Joanne Fleming в Санкт-Петербурге</div>
                        <div class="comment">1978</div>
                        <div class="date">30 сентября 2014</div>
                    </li>
                    <li>
                        <div class="title">Свадебная палитра: айвори, янтарный, золотой и белые тыквы</div>
                        <div class="comment">1978</div>
                        <div class="date">30 сентября 2014</div>
                    </li>
                    <li>
                        <div class="title">В данный момент я очарована…сказочной церемонией на крыше. Это просто нечто!</div>
                        <div class="comment">1978</div>
                        <div class="date">30 сентября 2014</div>
                    </li>
                </ul>
            </div>
            <div class="sidebar col-md-4">
                @if(!empty($vote->question) && !empty($answers))
                    <div class="votes">
                        <div class="title">Актуальный опрос</div>
                        <div class="question">{{ $vote->question }}</div>
                        @if(Auth::user()->voted==1)
                            @foreach($answers as $answer)
                                <div style="margin:5px 0">
                                    {{ $answer->text }} - {{ $answer->click_count }} 
                                    <i class="fa fa-thumbs-o-up"></i>
                                </div>
                            @endforeach
                        @else
                            {{ Form::open(array('role' => 'form', 'url' => '/vote/proccess')) }}
                                <?php $i=1 ?>
                                @foreach($answers as $answer)
                                    <div class="radio">
                                        <input type="radio" name="answer" id="radio{{$i}}" value="{{ $answer->id }}" {{ $i==1?'checked':'' }}>
                                        <label for="radio{{$i}}">
                                           {{ $answer->text }}
                                        </label>
                                    </div>
                                    <?php $i++ ?>
                                @endforeach
                                <input type="submit" class="btn-confirm" style="background:#44B39B" value="Ответить">
                            {{ Form::close() }}
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

<!-- RELATED PERFORMERS
    ============================= -->
    <div class="performers">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-title decor">
                    Лучшие свадебные исполнители
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <article id="card">
                        <figure>
                            <a href="#null"><img src="/assets/img/photog.jpg" alt=""></a>
                        </figure>
                        <div class="user-info">
                            <a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
                            <div class="info-cont">
                                <div class="name">
                                    <a href="#null">Сергей Боровой</a>
                                    <span class="online"></span>
                                    <span class="status">PRO</span>
                                </div>
                                <div class="place">Москва</div>
                                <div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
                            </div>
                        </div>
                        <div class="detail-info">
                            <header>
                                <a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
                                <div class="name">
                                    <a href="#null">Сергей Боровой</a>
                                    <span class="online"></span>
                                    <span class="status">PRO</span>
                                </div>
                                <span class="place">Москва</span>
                                <div class="meta">
                                    <div class="review"><span>10</span>отзывов</div>
                                    <div class="orders"><span>48</span>заказов</div>
                                    <div class="rait"><a href="javascript:void(0);" onclick="return bookmark(this);"><img src="/assets/img/star.png" alt=""></a></div>
                                </div>
                            </header>
                            <ul class="portfolio">
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                            </ul>
                            <div class="price">
                                <p>Ведущий на свадьбу <span>от 20 000</span></p>
                                <p>Портрет <span>от 6 000</span></p>
                                <p>Мероприятия <span>от 25 000</span></p>
                                <p>Дети <span>от 5 000</span></p>
                            </div>
                            <a href="#null" class="btn-message">Сообщение</a>
                            <a href="#null" class="btn-order">Заказать</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-3 col-sm-6">
                    <article id="card">
                        <figure>
                            <a href="#null"><img src="/assets/img/photog_2.jpg" alt=""></a>
                        </figure>
                        <div class="user-info">
                            <a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
                            <div class="info-cont">
                                <div class="name">
                                    <a href="#null">Сергей Боровой</a>
                                    <span class="online"></span>
                                    <span class="status">PRO</span>
                                </div>
                                <div class="place">Москва</div>
                                <div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
                            </div>
                        </div>
                        <div class="detail-info">
                            <header>
                                <a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
                                <div class="name">
                                    <a href="#null">Сергей Боровой</a>
                                    <span class="online"></span>
                                    <span class="status">PRO</span>
                                </div>
                                <span class="place">Москва</span>
                                <div class="meta">
                                    <div class="review"><span>10</span>отзывов</div>
                                    <div class="orders"><span>48</span>заказов</div>
                                    <div class="rait"><img src="/assets/img/star.png" alt=""></div>
                                </div>
                            </header>
                            <ul class="portfolio">
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                            </ul>
                            <div class="price">
                                <p>Ведущий на свадьбу <span>от 20 000</span></p>
                                <p>Портрет <span>от 6 000</span></p>
                                <p>Мероприятия <span>от 25 000</span></p>
                                <p>Дети <span>от 5 000</span></p>
                            </div>
                            <a href="#null" class="btn-message">Сообщение</a>
                            <a href="#null" class="btn-order">Заказать</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-3 col-sm-6">
                    <article id="card">
                        <figure>
                            <a href="#null"><img src="/assets/img/photog_3.jpg" alt=""></a>
                        </figure>
                        <div class="user-info">
                            <a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
                            <div class="info-cont">
                                <div class="name">
                                    <a href="#null">Сергей Боровой</a>
                                    <span class="online"></span>
                                    <span class="status">PRO</span>
                                </div>
                                <div class="place">Москва</div>
                                <div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
                            </div>
                        </div>
                        <div class="detail-info">
                            <header>
                                <a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
                                <div class="name">
                                    <a href="#null">Сергей Боровой</a>
                                    <span class="online"></span>
                                    <span class="status">PRO</span>
                                </div>
                                <span class="place">Москва</span>
                                <div class="meta">
                                    <div class="review"><span>10</span>отзывов</div>
                                    <div class="orders"><span>48</span>заказов</div>
                                    <div class="rait"><img src="/assets/img/star.png" alt=""></div>
                                </div>
                            </header>
                            <ul class="portfolio">
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                            </ul>
                            <div class="price">
                                <p>Ведущий на свадьбу <span>от 20 000</span></p>
                                <p>Портрет <span>от 6 000</span></p>
                                <p>Мероприятия <span>от 25 000</span></p>
                                <p>Дети <span>от 5 000</span></p>
                            </div>
                            <a href="#null" class="btn-message">Сообщение</a>
                            <a href="#null" class="btn-order">Заказать</a>
                        </div>
                    </article>
                </div>
                <div class="col-md-3 col-sm-6">
                    <article id="card">
                        <figure>
                            <a href="#null"><img src="/assets/img/photog_4.jpg" alt=""></a>
                        </figure>
                        <div class="user-info">
                            <a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
                            <div class="info-cont">
                                <div class="name">
                                    <a href="#null">Сергей Боровой</a>
                                    <span class="online"></span>
                                    <span class="status">PRO</span>
                                </div>
                                <div class="place">Москва</div>
                                <div class="rait">Рейтинг:&nbsp;&nbsp;452.5</div>
                            </div>
                        </div>
                        <div class="detail-info">
                            <header>
                                <a href="#null" class="avatar"><img src="/assets/img/avatar.jpg" alt=""></a>
                                <div class="name">
                                    <a href="#null">Сергей Боровой</a>
                                    <span class="online"></span>
                                    <span class="status">PRO</span>
                                </div>
                                <span class="place">Москва</span>
                                <div class="meta">
                                    <div class="review"><span>10</span>отзывов</div>
                                    <div class="orders"><span>48</span>заказов</div>
                                    <div class="rait"><img src="/assets/img/star.png" alt=""></div>
                                </div>
                            </header>
                            <ul class="portfolio">
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                                <li><a href="#null"><img src="/assets/img/port.jpg" alt=""></a></li>
                            </ul>
                            <div class="price">
                                <p>Ведущий на свадьбу <span>от 20 000</span></p>
                                <p>Портрет <span>от 6 000</span></p>
                                <p>Мероприятия <span>от 25 000</span></p>
                                <p>Дети <span>от 5 000</span></p>
                            </div>
                            <a href="#null" class="btn-message">Сообщение</a>
                            <a href="#null" class="btn-order">Заказать</a>
                        </div>
                    </article>
                </div>  
            </div>
        </div>
    </div>
@stop

