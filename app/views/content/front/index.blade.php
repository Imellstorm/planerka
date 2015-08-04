@extends('containers.frontend')

@section('title') {{ 'Главная' }} @stop

@section('main')
<!-- LATEST POSTS
    ============================= -->
    @if(count($frontArticles))
        <div class="latest-posts">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 section-title decor">
                        Наши последние обновления
                    </div>
                </div>
                <div class="text-center">
                    @foreach($frontArticles as $item)
                        <div class="single-post">
                            <div class="image">
                                <img src="{{ $item->thumb }}" alt="" style="opacity:0.65">
                                <a href="/page/{{ $item->alias }}" class="btn-more">Новости</a>
                                <a href="/page/{{ $item->alias }}" class="post-title">{{ $item->title }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

<!-- MIDDLE CONTENT
    ============================= -->
    <div class="container middle-contant">
        <div class="row">
            <div class="latest-themes col-md-8">
                <div class="section-title">Популярные темы форума</div>
                <div class="sort-by">
                    <a source="/blog/lastblogthemes" cont="theme_list_cont" class="active">За все время</a>
                    <a source="/blog/lastblogthemes/month" cont="theme_list_cont">В этом месяце</a>
                    <a source="/blog/lastblogthemes/week" cont="theme_list_cont">На этой неделе</a>
                </div>
                @if(count($blogThemes))
                    <div class="theme_list_cont">
                        @include('content.front.blog.themeslist')
                    </div>
                @endif
            </div>
            <div class="sidebar col-md-4">
                @if(!empty($vote->question) && !empty($answers))
                    <div class="votes">
                        <div class="title">Актуальный опрос</div>
                        <div class="question">{{ $vote->question }}</div>
                        @if(Auth::check() && !empty($userVoted))
                            @foreach($answers as $answer)
                                <div style="margin:10px 0">
                                    <div class="pull-left">
                                        {{ $answer->text }} 
                                    </div>
                                    <div class="pull-right">{{ $answer->click_count }} 
                                        <i class="fa fa-thumbs-o-up"></i>
                                    </div>
                                    <div style="clear:both"></div>
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
            @if(count($frontUsers))
                <div class="row">
                    <div class="col-md-12 section-title decor">
                        Лучшие свадебные исполнители
                    </div>
                </div>
                <div class="row text-center">
                    @foreach($frontUsers as $item)
                        <div style="margin:0 10px; display:inline-block">
                            @include('content.front.usercard')
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript">
    function getContent(from,to){
        $.ajax({
            url:from,
            type:'get',
            success: function(res){
                elem = '.'+to
                $(elem).html(res);
            }
        })
    }

    $(document).ready(function(){
        $('.latest-themes .sort-by a').on('click',function(){
            $('.sort-by a').removeClass('active');
            $(this).addClass('active');
            getContent($(this).attr('source'),$(this).attr('cont'));
        })
    })
</script>
@stop

