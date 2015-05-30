  
{{ Form::open(array('role' => 'form', 'url' => 'message/store')) }}
    <div style="padding:10px">
        <h3 class="text-center" style="margin-bottom:10px">Личное сообщение</h3>
        <div class='form-group'>
            {{ Form::text('username', $user->username, array('class' => 'form-control', 'disabled' => 'disabled', 'required')) }}
            {{ Form::hidden('user_id', $user->id) }}
        </div>

        <div class='form-group'>
            {{ Form::label('text','Текст сообщения') }}
            {{ Form::textarea('text', null, array('class' => 'form-control','required')) }}
        </div>

        {{ Form::submit('Отправить', array('class' => 'btn-main', 'style'=>'margin:0 auto')) }}
    </div>
{{ Form::close() }}