@extends('containers.frontend')

@section('title') {{ 'Аккаунт' }} @stop

@section('scripts')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
                $('#img_preview').show();
                $('.delete_image').show();
                $('.image-exist').val(1);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
     $(document).ready(function(){
            $('body').on('change','#imgInp',function(){
                readURL(this); 
            });
            
            $('.delete_image').on('click',function(){
                $('#img_preview').hide();
                $('.delete_image').hide();
                $('#imgInp').val('');
                $('.image-exist').val(0);
            });
        });
</script>
@stop

@section('main')
<!-- MAIN CONTENT
    ============================= -->   
    <div id="user-page">
        <div class="container">
            @include('content.front.account.menu_one')
            <div class="row">
                <div class="col-sm-12">
                    <div class="user-profile">
                        @if (empty($userinfo))
                            {{ Form::open(array('role' => 'form', 'url' => '/userinfo/store', 'class'=>'prof','files'=> true)) }}
                        @else
                            {{ Form::model($userinfo, array('role' => 'form', 'url' => '/userinfo/update/' . $userinfo->id, 'method' => 'PUT', 'class'=>'prof','files'=> true)) }}
                        @endif

                            <div class="form-group">
                                <label for="">Аватар</label>
                                <img id="img_preview" src="{{ !empty($userinfo->avatar)?'/'.$userinfo->avatar:'' }}" style="display:{{ !empty($userinfo->avatar)?'block':'none' }}" alt="your image" />
                                <i class="fa fa-times delete_image pull-right" title="Delete" style="display:{{ !empty($userinfo->avatar)?'block':'none' }}"></i>
                                <input type="hidden" class="image-exist" name="imageexist" value="{{ !empty($userinfo->avatar)?1:0 }}">
                                <div class="avatar">
                                    {{ Form::file('userfile', array('id' => 'imgInp')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('name', 'Имя') }}
                                {{ Form::text('name', null, array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('surname', 'Фамилия') }}
                                {{ Form::text('surname', null, array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('city', 'Город') }}
                                {{ Form::text('city', null, array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('birthday', 'Дата рождения') }}
                                {{ Form::text('birthday',isset($userinfo->birthday)&&!empty($userinfo->birthday)?$userinfo->birthday:'', array('class' => 'form-control','id'=>'prof-birth')) }}
                            </div>
                            <div class="form-group sex">
                                <label for="radio">Пол</label>
                                <div class="radio">
                                    {{ Form::radio('gender','male',isset($userinfo->gender)?$userinfo->gender:1, array('id' => 'radio1')) }}
                                    <label for="radio1">
                                        <p>М</p>
                                    </label>
                                </div>
                                <div class="radio">
                                    {{ Form::radio('gender','female',isset($userinfo->gender)?$userinfo->gender:0, array('id' => 'radio2')) }}
                                    <label for="radio2">
                                        <p>Ж</p>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('phone', 'Мобилный телефон') }}
                                {{ Form::text('phone', null, array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('biography', 'Биография') }}
                                {{ Form::textarea('biography', null, array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('additional_email', 'Электронная почта') }}
                                {{ Form::text('additional_email', null, array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('site', 'Сайт') }}
                                {{ Form::text('site', null, array('class' => 'form-control')) }}
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    {{ Form::checkbox('country_departure', 1, isset($userinfo->city_departure)?$userinfo->city_departure:0,array('id'=>'checkbox6')); }}
                                    <label for="checkbox6">
                                        Могу выезжать в другой город
                                    </label>
                                </div>
                                <div class="checkbox">
                                    {{ Form::checkbox('country_departure', 1, isset($userinfo->country_departure)?$userinfo->country_departure:0,array('id'=>'checkbox7')); }}
                                    <label for="checkbox7">
                                        Могу выезжать за рубеж
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn-main" value="Сохранить">
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>  
@stop	