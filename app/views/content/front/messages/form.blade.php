  
<h4>{{ Lang::get('main.private_message') }}</h4>

{{ Form::open(array('role' => 'form', 'url' => 'message/store')) }}

   <div class='form-group'>
        {{ Form::label('username', Lang::get('main.to')) }}
        {{ Form::text('username', $user->username, array('class' => 'form-control', 'disabled' => 'disabled')) }}
        {{ Form::hidden('user_id', $user->id) }}
    </div>

    <div class='form-group'>
        {{ Form::label('text',  Lang::get('main.text') ) }}
        {{ Form::textarea('text', null, array('class' => 'form-control')) }}
    </div>

<div style="text-align:center">
    {{ Form::submit(Lang::get('main.send'), array('class' => 'btn btn-primary')) }}
</div>
{{ Form::close() }}