<?php 
    $search_fields = array_flip($table_fields);
    $search_fields = array_combine($search_fields, $search_fields);
?>
@if ($messages->count())

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                {{ Common_helper::sorting_table_fields($table_fields) }}
                <td style="min-width:110px"></td>
            </tr>
        </thead>

        <tbody>
            @foreach ($messages as $message)                    
                    <tr>
                        <td>{{ $message->to_name }}</td>
                        <td>{{ $message->created_at }}</td>
                        <td>
                            <a href="/account/message/{{ $message->id }}" class="right5">Прочесть</a>
                            <a href="/account/message/{{ $type }}/delete/{{ $message->id }}" class="fa fa-times right5" title="Удалить" onclick="return confirm('Удалить?')?true:false"></a>                           
                        </td>
                    </tr>                    
            @endforeach
        </tbody>
    </table>
    {{ $messages->links() }}     
@else
    <br>
    <h4 style="text-align:center">Сообщения отсутствуют</h4>
@endif    
