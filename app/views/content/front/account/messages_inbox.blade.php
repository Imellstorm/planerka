@section('styles')
<link rel='stylesheet' href="{{ asset('assets/packs/fancyBox/jquery.fancybox.css') }}">
@stop
@section('scripts')
<script type="text/javascript" src="{{ asset('assets/packs/fancyBox/jquery.fancybox.pack.js?v=2.1.5') }}"></script>
    <script>
        $(document).ready(function() {
            $(".fancybox").fancybox();
            $(".sendmessage").fancybox({
                type: 'ajax',
                helpers : {
                    title : null            
                }  
            });

        });
    </script>
@stop

    <?php 
        $search_fields = array_flip($table_fields);
        $search_fields = array_combine($search_fields, $search_fields);
    ?>
    @if ($messages->count())

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    {{ Common_helper::sorting_table_fields($table_fields) }}
                    <td style="min-width:130px"></td>
                </tr>
            </thead>

            <tbody>
                @foreach ($messages as $message)                    
                        <tr>
                            <td>{{ $message->from_name }}</td>
                            <td>{{ $message->created_at }}</td>
                            <td>
                                {{ empty($message->readed)?'<div style="color:green; font-weight:bold">не прочитано</div>':'прочитано' }}
                            </td>
                            <td>
                                <a href="/account/message/{{ $message->id }}" class="right5">Прочесть</a>
                                <a class="pointer sendmessage fa fa-envelope-o right5" href="/message/create/{{ $message->from }}" title="Ответить"></a>                                    
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
