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
<br>
<a href="/account/messages/inbox" class="fa fa-reply right5" title="К списку сообщений"></a>
<span>Отправитель: {{ $message->from_name }} | Получатель: {{ $message->to_name }} | Отправлено: {{ $message->created_at }}</span>
@if($message->from != Auth::User()->id)
	<a class="pointer sendmessage fa fa-envelope-o right5" href="/message/create/{{ $message->from }}" title="Ответить"></a>
@endif
<hr style="margin-top:10px">
<div style="margin:20px">{{ $message->text }}</div> 