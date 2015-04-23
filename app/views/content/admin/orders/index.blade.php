@extends('containers.admin')
@section('title') История платежей @stop
@section('main')

<h1 class="fa fa-usd pull-left"> История платежей </h1> <a href="/admin/users/edit/{{ $user->id }}" style="margin-top:30px;display:block;float:left;">({{ $user->email }})</a>
  
<?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    {{ Form::open(array('role' => 'form', 'url' => '/admin/orders/'.$user->id, 'method' =>'get', 'class' => 'pull-right top20 table-search-form')) }}
        {{ Form::select('field',$search_fields,'',array('class'=>'form-control pull-left')) }} 
        {{ Form::text('search','',array('class'=>'form-control pull-left')) }}
        {{ Form::submit('Поиск',array('class'=>'btn btn-info')) }}
    {{ Form::close() }}  

    @if ($orders->count())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <tr>
                        <td>{{ $item->amount }}</td>
                        <td>{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}  
    @else
    <h4 class="text-center" style="margin-top:100px">Платежи отсутствуют</h4>  
    @endif

@stop

