@extends('containers.admin')
 
@section('title') Настройки @stop
 
@section('main')

    {{ Form::model($settings, array('role' => 'form', 'url' => 'admin/settings/update/' . $settings->id, 'method' => 'PUT')) }}   
    <div class="row">
    <div class="col-md-4 col-md-offset-2">   
        <h1 class="fa fa-gear"> Настройки</h1>

        <div class='form-group'>
            {{ Form::label('subscribe_price', 'Стоимость подписки*') }}
            {{ Form::text('subscribe_price', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('main_vip_price', 'Стоимость VIP на главной*') }}
            {{ Form::text('main_vip_price', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('region_vip_price', 'Стоимость VIP для региона*') }}
            {{ Form::text('region_vip_price', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('city_vip_price', 'Стоимость VIP для города*') }}
            {{ Form::text('city_vip_price', null, array('class' => 'form-control')) }}
        </div>  

        <div class='form-group'>
            {{ Form::label('post_keep_account', 'Количество VIP объявлений') }}
            {{ Form::text('vip_per_day', null, array('class' => 'form-control')) }}
        </div> 
         
    </div>
    <div class="col-md-4">
        <div class='form-group' style="margin-top:65px">
            {{ Form::label('liqpay_private_key', 'Liqpay private key') }}
            {{ Form::text('liqpay_private_key', null, array('class' => 'form-control')) }}
        </div>   

        <div class='form-group'>
            {{ Form::label('liqpay_public_key', 'Liqpay public key') }}
            {{ Form::text('liqpay_public_key', null, array('class' => 'form-control')) }}
        </div>

        <div class='form-group'>
            {{ Form::label('post_keep_front', 'Время показа объявлений на главной (дней)') }}
            {{ Form::text('post_keep_front', null, array('class' => 'form-control')) }}
        </div>   

        <div class='form-group'>
            {{ Form::label('post_keep_account', 'Время показа в личном кабинете (дней)') }}
            {{ Form::text('post_keep_account', null, array('class' => 'form-control')) }}
        </div>    
    </div>
    </div>
    <div class='form-group text-center'>
        {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
    </div> 

    {{ Form::close() }}
 
@stop