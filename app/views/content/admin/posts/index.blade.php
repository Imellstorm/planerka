@extends ('containers.admin')

@section('title') Объявления @stop

@section('main')

    <h1 class="fa fa-bars pull-left"> Объявления</h1>
    {{ link_to('admin/posts/create/', 'Добавить', array('class'=>'pull-right btn btn-primary top20 left10')) }}

    <?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    {{ Form::open(array('role' => 'form', 'url' => 'admin/posts', 'method' =>'get', 'class' => 'pull-right top20 table-search-form')) }}
        {{ Form::select('field',$search_fields,'',array('class'=>'form-control pull-left')) }} 
        {{ Form::text('search','',array('class'=>'form-control pull-left')) }}
        {{ Form::submit('Искать',array('class'=>'btn btn-info')) }}
    {{ Form::close() }} 

    @if ($posts->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                    <th style="width: 150px;">Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->ownership }}</td>
                        <td>{{ $post->price }}</td>
                        <td>{{ $post->username }}</td>
                        <td>{{ $post->city }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td>
                            {{ link_to('admin/posts/edit/'.$post->id, 'править', array('class' => 'btn btn-info btn-xs pull-left', 'title'=>'edit')) }}
                            {{ Form::open(array('url' => 'admin/posts/destroy/' . $post->id, 'method' => 'DELETE')) }}
                                {{ Form::submit('удалить', array('class' => 'btn btn-danger btn-xs left10','onclick'=>'return confirm(\'Удалить?\')?true:false;'))}}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $posts->links() }}    
    @endif

@stop