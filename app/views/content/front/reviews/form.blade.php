  
{{ Form::open(array('role' => 'form', 'url' => 'review/store')) }}
    <div style="padding:10px">
        <h3 class="text-center" style="margin-bottom:10px">Отзыв о пользователе</h3>
        <div class='form-group'>
            <div class="text-center">{{ $user->name }} {{ $user->surname }}</div>
            {{ Form::hidden('to_user', $user->user_id) }}
            {{ Form::hidden('project_id', $projectId) }}
        </div>

        <div class='form-group'>
            {{ Form::label('text','Текст отзыва') }}
            {{ Form::textarea('text', null, array('class' => 'form-control','required')) }}
        </div>

        {{ Form::submit('Отправить', array('class' => 'btn-main', 'style'=>'margin:0 auto')) }}
    </div>
{{ Form::close() }}