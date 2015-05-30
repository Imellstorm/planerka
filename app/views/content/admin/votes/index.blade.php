@extends('containers.admin')
@section('title') Опрос @stop
@section('main')

<h1 class="fa fa-edit pull-left"> Опрос</h1>
{{ link_to('admin/vote/create/', 'Добавить ответ', array('class'=>'pull-right btn btn-primary top20 left10')) }}
  
<?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    {{ Form::open(array('role' => 'form', 'url' => 'admin/vote', 'method' =>'get', 'class' => 'pull-right top20 table-search-form')) }}
        {{ Form::select('field',$search_fields,'',array('class'=>'form-control pull-left')) }} 
        {{ Form::text('search','',array('class'=>'form-control pull-left')) }}
        {{ Form::submit('Поиск',array('class'=>'btn btn-info')) }}
    {{ Form::close() }} 

    @if(empty($vote))
        {{ Form::open(array('role' => 'form', 'url' => 'admin/vote/storequestion')) }}
    @else
        {{ Form::model($vote, array('role' => 'form', 'url' => 'admin/vote/updatequestion/' . $vote->id, 'method' => 'PUT')) }}
    @endif    
        <div class='form-group'>
            {{ Form::textarea('question', null, array('class' => 'form-control','style' => 'height:50px','placeholder'=>'текст опроса')) }}
        </div>
        <div class='form-group text-center'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div> 
    {{ Form::close() }} 

    @if (count($answers))
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                    <th style="width: 150px;">Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($answers as $answer)
                    <tr>
                        <td>{{ $answer->text }}</td>
                        <td>{{ $answer->click_count }}</td>
                        <td>{{ $answer->created_at }}</td>
                        <td>{{ $answer->updated_at }}</td>
                        <td>
                            {{ link_to('admin/vote/edit/'.$answer->id, 'править', array('class' => 'btn btn-info btn-xs pull-left', 'title'=>'Править')) }}
                            {{ Form::open(array('url' => 'admin/vote/destroy/' . $answer->id, 'method' => 'DELETE')) }}
                                {{ Form::submit('удалить', array('class' => 'btn btn-danger btn-xs left10','onclick'=>'return confirm(\'Удалить?\')?true:false;'))}}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $answers->links() }}    
    @endif

@stop

