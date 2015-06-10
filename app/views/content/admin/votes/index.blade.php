@extends('containers.admin')
@section('title') Опрос @stop
@section('main')

<h1 class="fa fa-edit pull-left"> Опросы</h1>
{{ link_to('admin/vote/create/', 'Создать', array('class'=>'pull-right btn btn-primary top20 left10')) }}
  
<?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    {{ Form::open(array('role' => 'form', 'url' => 'admin/vote', 'method' =>'get', 'class' => 'pull-right top20 table-search-form')) }}
        {{ Form::select('field',$search_fields,'',array('class'=>'form-control pull-left')) }} 
        {{ Form::text('search','',array('class'=>'form-control pull-left')) }}
        {{ Form::submit('Поиск',array('class'=>'btn btn-info')) }}
    {{ Form::close() }} 

    @if (count($votes))
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                    <th style="width: 250px;">Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($votes as $vote)
                    <tr>
                        <td>{{ $vote->question }}</td>
                        <td>{{ $vote->created_at }}</td>
                        <td>{{ $vote->updated_at }}</td>
                        <td>
                            @if($vote->active==0)
                                {{ link_to('admin/vote/activate/'.$vote->id, 'включить', array('class' => 'left10 btn btn-info btn-xs pull-left', 'title'=>'Включить')) }}
                            @endif
                            {{ link_to('admin/vote/edit/'.$vote->id, 'править', array('class' => 'btn btn-info btn-xs pull-left left10', 'title'=>'Править')) }}
                            {{ Form::open(array('url' => 'admin/vote/destroy/' . $vote->id, 'method' => 'DELETE')) }}
                                {{ Form::submit('удалить', array('class' => 'btn btn-danger btn-xs left10','onclick'=>'return confirm(\'Удалить?\')?true:false;'))}}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $votes->links() }}    
    @endif

@stop

