<div class="row top-20">
    <div class="col-md-6">                   
        {{ Form::model($user, array('role' => 'form', 'url' => 'admin/users/update/' . $user->id, 'method' => 'PUT', 'class' => 'accaunt_user_data')) }}

           <div class='form-group'>
                {{ Form::label('username', 'Имя') }}
                {{ Form::text('username', null, array('placeholder' => 'Username', 'class' => 'form-control')) }}
            </div>
         
            <div class='form-group'>
                {{ Form::label('email', 'Email') }}
                {{ Form::email('email', null, array('placeholder' => 'Email', 'class' => 'form-control')) }}
            </div>

            <div class='form-group'>
                {{ Form::label('address', 'Адрес') }}
                {{ Form::text('address', null, array('placeholder' => 'Address', 'class' => 'form-control')) }}
            </div>

            <div class='form-group'>
                {{ Form::label('phone', 'Телефон') }}
                {{ Form::text('phone', null, array('placeholder' => 'Phone', 'class' => 'form-control')) }}
            </div>

            <div class='form-group'>
                {{ Form::label('legal_form', 'Правовая форма') }}
                {{ Form::select('legal_form', array('0'=>'Частное лицо','1'=>'Организация'),isset($user->legal_form)?$user->legal_form:'0',array('class'=>'form-control')); }}
            </div>
         
            <div class='form-group'>
                {{ Form::label('password', 'Пароль') }}
                {{ Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control')) }}
            </div>
         
            <div class='form-group'>
                {{ Form::label('password_confirmation', 'Подтверждение пароля') }}
                {{ Form::password('password_confirmation', array('placeholder' => 'Confirm Password', 'class' => 'form-control')) }}
            </div>
         
            <div class='form-group'>
                {{ Form::submit('Сохранить', array('class' => 'btn btn-success')) }}
            </div>
     
        {{ Form::close() }}                        
    </div>
    <div class="col-md-6" style="padding-top:79px">
        @if (empty($user->email_verify))
            <div class="bs-callout bs-callout-danger">
                <h4>Внимание!</h4>
                <div>
                    {{ Form::open(array('role' => 'form', 'url' => 'account/sendemailverification')) }}
                        Почта не подтверждена. <br>
                        Для подтверждения почты нажмите <input type="submit" class="btn btn-info btn-xs" value="сюда">
                    {{ Form::close() }}
                </div>
            </div>
        @elseif ($user->email_verify=='1')
            <div class="bs-callout bs-callout-success">
                <h4>Ваша почта подтверждена!</h4>
                <div>
                    Спасибо.
                </div>
            </div>
        @else
            <div class="bs-callout bs-callout-info">
                <h4>Письмо отправлено!</h4>
                <div>
                    {{ Form::open(array('role' => 'form', 'url' => 'account/sendemailverification')) }}
                        На ваш почтовый ящик отправлено письмо с инструкцией для подтверждения почты.<br>
                        Если письмо не пришло, проверте спам. <br>
                        Вы также можете повторно <input type="submit" class="btn btn-info btn-xs" value="отправить письмо">
                    {{ Form::close() }}    
                </div>
            </div>
        @endif

                    
    </div>
</div>