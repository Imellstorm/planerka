
{{ Form::open(array('role' => 'form', 'url' => 'admin/rating/store')) }}
    <h3 class="text-center" style="margin:20px">Изменение рейтинга пользователя</h3>
    <div style="padding:20px">
        <div class='form-group'>
            {{ Form::label('amount', 'Количество (число с минусом для снятия баллов)') }}
            {{ Form::text('amount', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
     
        <div class='form-group'>
            {{ Form::label('reason', 'Причина') }}
            {{ Form::textarea('reason',null, array('class' => 'form-control','required'=>'required')) }}
        </div>

        {{ Form::hidden('userId', $userId, array('class' => 'form-control')) }}

        <div class='form-group text-center'>
            {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
        </div>
    </div>

{{ Form::close() }}
 