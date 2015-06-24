<div class="popup_dialog_cont" style="padding-top:10px">
    @if(!empty($messages))
        @foreach($messages as $message)
            @include('content.front.messages.messageblock')
        @endforeach
    @endif
</div>  
{{ Form::open(array('role' => 'form', 'url' => 'message/store')) }}
    <div style="padding:10px">
        {{ Form::hidden('username', $user->username, array('class' => 'username','required')) }}
        {{ Form::hidden('user_id', $user->id, array('class' => 'user_id','required')) }}

        <div class='form-group' style="margin: 0 10px;">
            {{ Form::textarea('text', null, array('class' => 'form-control text','style'=>'height:100px','placeholder'=>'Введите сообщение','required')) }}
        </div>
        <div class="btn-main send_message_btn">Отправить</div>
    </div>
{{ Form::close() }}