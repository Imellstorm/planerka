@extends ('containers.admin')

@section('title') Пользователи @stop

@section('main')

    <h1 class="fa fa-users pull-left"> Все пользователи</h1>
    {{ link_to('admin/users/create/', 'Добавить', array('class'=>'pull-right btn btn-primary top20 left10')) }}

    <?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    {{ Form::open(array('role' => 'form', 'url' => 'admin/users', 'method' =>'get', 'class' => 'pull-right top20 table-search-form')) }}
        {{ Form::select('field',$search_fields,'',array('class'=>'form-control pull-left')) }} 
        {{ Form::text('search','',array('class'=>'form-control pull-left')) }}
        {{ Form::submit('Искать',array('class'=>'btn btn-info')) }}
    {{ Form::close() }} 

    @if ($users->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                    <th style="width: 215px;">Действия</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><a href="/{{ $user->alias }}">{{ $user->username }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->city }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->balance }}</td>
                        <td>
                            {{ link_to('admin/orders/'.$user->id, 'платежи', array('class' => 'btn btn-info btn-xs pull-left', 'title'=>'pay history')) }}
                            {{ link_to('admin/users/edit/'.$user->id, 'править', array('class' => 'btn btn-info btn-xs pull-left left10', 'title'=>'edit')) }}
                            @if($user->username!='admin')
                                {{ Form::open(array('url' => 'admin/users/destroy/' . $user->id, 'method' => 'DELETE')) }}
                                    {{ Form::submit('удалить', array('class' => 'btn btn-danger btn-xs left10','onclick'=>'return confirm(\'Удалить?\')?true:false;'))}}
                                {{ Form::close() }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}    
    @endif

@stop