<!-- <div class='login_box'>
    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <span class="glyphicon glyphicon-info-sign pull-left" style="margin-right:5px;"> </span>
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif

    <h1><i class='fa fa-unlock-alt'></i> Вход</h1>
 
    {{ Form::open(array('url' => '/auth', 'role' => 'form')) }}
 
    <div class='form-group'>
        {{ Form::label('username', 'E-mail адрес') }}
        {{ Form::text('username', null, array('placeholder' => 'admin@domain.com', 'class' => 'form-control')) }}
    </div>
 
    <div class='form-group'>
        {{ Form::label('password', 'Пароль') }}
        {{ Form::password('password', array('placeholder' => 'password', 'class' => 'form-control')) }}
    </div>
 
    <div class='form-group'>
        {{ Form::submit('Вход', array('class' => 'btn btn-success')) }}
    </div>
 
    {{ Form::close() }}                 
</div> -->

<div class="custom-modal" id="modal-login">
    <div class="title">Регистрация на планерке</div>

    <div class="social-login">
        <p>Войдите с помощью:</p>
        <a href="#null" class="facebook"></a>
        <a href="#null" class="vk"></a>
        <a href="#null" class="twitter"></a>
    </div>

    <form class="login">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Planerca.ru/Ник нэйм">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Электронная почта">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Пароль">
        </div>
    </form>

    <footer>
        <a href="#null" class="rules">Прочитать правила</a>
        <a href="#null" class="btn-main">Создать аккаунт</a>
    </footer>
</div>
