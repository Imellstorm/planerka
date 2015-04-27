<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">{{ link_to('/','Planerka',array('class'=>'navbar-brand')) }}</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Planerka</a>
    </div>
    <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Контент <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li class="{{ Request::segment(2)=='articles'?'active':'' }}">{{ link_to('admin/articles','Страницы') }}</li>  
                  </ul>
                </li>                
                <li class="{{ Request::segment(2)=='users'?'active':'' }}">{{ link_to('admin/users','Пользователи') }}</li>
                <li class="{{ Request::segment(2)=='menus'?'active':'' }}">{{ link_to('admin/menus','Меню') }}</li>        
                <!-- <li class="{{ Request::segment(2)=='settings'?'active':'' }}">{{ link_to('admin/settings/edit','Настройки') }}</li>                                -->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>{{ link_to('auth/logout','Выход') }}</li>
            </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>
<div style="height:70px"></div>
