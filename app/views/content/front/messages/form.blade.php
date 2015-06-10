<div style="padding-top:10px">
    @if(!empty($messages))
        @foreach($messages as $message)
            <div class="row" style="margin:10px;  border-bottom: dotted 1px lightgrey;   padding: 10px;">
                <div class="col-md-5">
                    <img src="/{{ $message->avatar }}" style="width:40px; float:left; margin-right:10px">
                    <div style="font-weight:bold">{{ $message->name }} {{ $message->surname }}</div>
                    <div style="font-size:12px; margin-bottom:10px">{{ $message->created_at }}</div>
                </div>
                <div class="col-md-7" style="max-width:350px">{{ $message->text }}</div>
            </div>
        @endforeach
    @endif
</div>  
{{ Form::open(array('role' => 'form', 'url' => 'message/store')) }}
    <div style="padding:10px">
        <h3 class="text-center" style="margin-bottom:10px">Личное сообщение</h3>
        <div class='form-group'>
            <div class="text-center">для {{ $user->username }}</div>
            {{ Form::hidden('username', $user->username, array('class' => 'form-control', 'disabled' => 'disabled', 'required')) }}
            {{ Form::hidden('user_id', $user->id) }}
        </div>

        <div class='form-group'>
            {{ Form::label('text','Текст сообщения') }}
            {{ Form::textarea('text', null, array('class' => 'form-control','style'=>'height:100px','required')) }}
        </div>

        {{ Form::submit('Отправить', array('class' => 'btn-main', 'style'=>'margin:0 auto')) }}
    </div>
{{ Form::close() }}