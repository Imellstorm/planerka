@extends('containers.admin')
 
@section('title') Ответ опроса @stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.add_answer').on('click',function(){
                var form = '@include("content.admin.votes.answerform")';
                $(this).before(form);
            });

            $('body').on('click','.del_answer',function(){
                $(this).parent().remove();
            })
        })
    </script>
@stop
 
@section('main')

    @if (Request::segment(3)=='create')
        {{ Form::open(array('role' => 'form', 'url' => 'admin/vote/store')) }}
    @else
        {{ Form::model($vote, array('role' => 'form', 'url' => 'admin/vote/update/' . $vote->id, 'method' => 'PUT')) }}
    @endif
        <h1 class="pull-left" style="margin-left:20px"><i class='fa fa-user'></i> {{Request::segment(3)=='create'?'Создать опрос':'Редактировать опрос'}}</h1>
        <div class='form-group pull-right' style="margin: 25px 20px 0 0;">
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div>
        <div style="clear:both"></div>
        <div class="vote_form_cont"> 
            <div class='form-group'>
                {{ Form::label('question', 'Текст вопроса*') }}
                {{ Form::textarea('question', null, array('class' => 'form-control')) }}
            </div>

            @if(!empty($answers))
                @foreach($answers as $answer)
                    @include("content.admin.votes.answerform")
                @endforeach
            @endif

            <div class='form-group text-center'>
                <input type="button" value="+ Добавить ответ" class="add_answer">
            </div>
        </div>
    {{ Form::close() }}
 
@stop