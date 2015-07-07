@extends('containers.admin')

@section('title') Подкатегории блога @stop

@section('main')

<h1 class="fa fa-folder-o pull-left"> Подкатегории блога </h1>
{{ link_to('admin/blog/subcategories/create', 'Добавить', array('class'=>'pull-right btn btn-primary top20 left10')) }}
  
<?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    {{ Form::open(array('role' => 'form', 'url' => '/admin/blog/subcategories/', 'method' =>'get', 'class' => 'pull-right top20 table-search-form')) }}
        {{ Form::select('field',$search_fields,'',array('class'=>'form-control pull-left')) }} 
        {{ Form::text('search','',array('class'=>'form-control pull-left')) }}
        {{ Form::submit('Поиск',array('class'=>'btn btn-info')) }}
    {{ Form::close() }}  

    @if (count($subcategories))
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($subcategories as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->parent_name }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            {{ link_to('admin/blog/subcategories/edit/'.$item->id, 'Edit', array('class' => 'btn btn-info btn-xs pull-left', 'title'=>'edit')) }}

                            {{ Form::open(array('url' => 'admin/blog/subcategories/destroy/' . $item->id, 'method' => 'DELETE')) }}
                                {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-xs left10','onclick'=>'return confirm(\'Delete menu?\')?true:false;'))}}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $subcategories->links() }}  
    @else
        <h4 class="text-center" style="margin-top:100px">Подкатегории отсутствуют</h4>  
    @endif
@stop