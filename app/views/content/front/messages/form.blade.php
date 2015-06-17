<div style="padding-top:10px">
    @if(!empty($messages))
        @foreach($messages as $message)
            <div class="row" style="margin:10px;max-width:500px;padding:10px;">
                <div class="col-md-12">
                    <img src="{{ Common_helper::getUserAvatar($message->user_id) }}" style="width:40px; float:left; margin-right:10px">
                    @if(!empty($message->name) || !empty($message->surname))
                        <div class="pull-left" style="font-weight:bold">{{ $message->name }} {{ $message->surname }}</div>
                    @else
                        <div class="pull-left" style="font-weight:bold">{{ $message->alias }}</div>
                    @endif
                    <span class="online"></span>
                    <div style="font-size:12px; margin-bottom:10px">{{ $message->city }}</div>
                </div>
                <div class="col-md-12" style="background:#FAFAF5;padding:20px;">
                    <div style="font-size:12px">{{ $message->created_at }}</div>
                    <div>{{ $message->text }}</div>
                </div>
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
            {{ Form::textarea('text', null, array('class' => 'form-control','style'=>'height:100px','placeholder'=>'Введите сообщение','required')) }}
        </div>

        {{ Form::submit('Отправить', array('class' => 'btn-main', 'style'=>'margin:0 auto')) }}
    </div>
{{ Form::close() }}