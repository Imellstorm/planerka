@extends ('containers.admin')

@section('title') Комментарии @stop

@section('main')

    <h1 class="fa fa-comments pull-left"> Комментарии</h1>

    <?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    {{ Form::open(array('role' => 'form', 'url' => 'admin/comments', 'method' =>'get', 'class' => 'pull-right top20 table-search-form')) }}
        {{ Form::select('field',$search_fields,'',array('class'=>'form-control pull-left')) }} 
        {{ Form::text('search','',array('class'=>'form-control pull-left')) }}
        {{ Form::submit('Искать',array('class'=>'btn btn-info')) }}
    {{ Form::close() }} 

    @if ($comments->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                    <th style="width: 150px;">Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <td>{{ $comment->username }}</td>
                        <td><a href="/post/{{ $comment->post_id }}">{{ $comment->post }}</a></td>
                        <td>{{ $comment->created_at }}</td>
                        <td>                            
                            {{ Form::open(array('url' => 'admin/comments/destroy/' . $comment->id, 'method' => 'DELETE')) }}
                                {{ Form::submit('удалить', array('class' => 'btn btn-danger btn-xs left10','onclick'=>'return confirm(\'Удалить?\')?true:false;'))}}
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $comments->links() }}    
    @endif

@stop