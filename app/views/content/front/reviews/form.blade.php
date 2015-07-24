  
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
            {{ Form::textarea('text', null, array('class' => 'form-control review_textarea','required')) }}
        </div>

        <div class='form-group'>
            <div class="text-center">
                <label for="good_estimation">(◉◡◉)</label>
                <input type="radio" name="estimation" value="good" id="good_estimation" required style="margin-right:40px">
                <label for="normal_estimation">(◉_◉)</label>
                <input type="radio" name="estimation" value="normal" id="normal_estimation" required style="margin-right:40px">
                <label for="bad_estimation">(◉︿◉)</label>
                <input type="radio" name="estimation" value="bad" id="bad_estimation" required>
            </div>
        </div>

        {{ Form::submit('Отправить', array('class' => 'btn-main', 'style'=>'margin:0 auto')) }}
    </div>
{{ Form::close() }}