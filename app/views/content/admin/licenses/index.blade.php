@extends('containers.admin')
@section('title') Формы налогообложения @stop
@section('main')

<h1 class="fa fa-certificate pull-left"> Лицензии</h1>
{{ link_to('admin/licenses/create/', 'Добавить', array('class'=>'pull-right btn btn-primary top20 left10')) }}
  
<?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    {{ Form::open(array('role' => 'form', 'url' => 'admin/licenses', 'method' =>'get', 'class' => 'pull-right top20 table-search-form')) }}
        {{ Form::select('field',$search_fields,'',array('class'=>'form-control pull-left')) }} 
        {{ Form::text('search','',array('class'=>'form-control pull-left')) }}
        {{ Form::submit('Поиск',array('class'=>'btn btn-info')) }}
    {{ Form::close() }}  

    @if ($licenses->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                    <th style="width: 150px;">Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($licenses as $item)
                    <tr>
                        <td>{{ $item->abr }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            {{ link_to('admin/licenses/edit/'.$item->id, 'править', array('class' => 'btn btn-info btn-xs pull-left', 'title'=>'Править')) }}
                            {{ Form::open(array('url' => 'admin/licenses/destroy/' . $item->id, 'method' => 'DELETE')) }}
                                {{ Form::submit('удалить', array('class' => 'btn btn-danger btn-xs left10','onclick'=>'return confirm(\'Удалить?\')?true:false;'))}}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $licenses->links() }}    
    @endif

@stop

