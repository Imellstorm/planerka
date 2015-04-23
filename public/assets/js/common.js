$(function(){
	
$('#modal-login input').tooltipster({
    trigger: 'custom',
    animation:'grow',
    theme: 'tooltipster-shadow',
    onlyOne: false,
    position: 'right'
});
$('#modal-login-udp input').tooltipster({
    trigger: 'custom',
    animation:'grow',
    theme: 'tooltipster-shadow',
    onlyOne: false,
    position: 'right'
});
$('#modal-in-login input').tooltipster({
    trigger: 'custom',
    animation:'grow',
    theme: 'tooltipster-shadow',
    onlyOne: false,
    position: 'right'
});
$('#create-news input').tooltipster({
    trigger: 'custom',
    animation:'grow',
    theme: 'tooltipster-shadow',
    onlyOne: false,
    position: 'right'
});
$('#myform input').tooltipster({
    trigger: 'custom',
    animation:'grow',
    theme: 'tooltipster-shadow',
    onlyOne: false,
    position: 'right'
});
$('#add_type_new input').tooltipster({
    trigger: 'custom',
    animation:'grow',
    theme: 'tooltipster-shadow',
    onlyOne: false,
    position: 'right'
});
$('#add_type_new textarea').tooltipster({
    trigger: 'custom',
    animation:'grow',
    theme: 'tooltipster-shadow',
    onlyOne: false,
    position: 'right'
});

$('.type').click(function(){
    var type = $(this).attr('data-id');
    //alert(type);
    $.ajax({
        url: '/ajax.php',
        data: 'action=save_type&type='+type,
        success: function(data){
            //$.fancybox.open(paramsFancy);
            $.fancybox.close();
        }
    });
});

$('.user_nick').keyup(function(){
    /*alert(document.location.href);
    alert(window.location.hostname);*/
    var type = $(this).val();
    //alert(type);
    var pattern = /^[a-zA-Z0-9_]{5,}$/;
    if(pattern.test($(this).val())){
        MyThis=$(this);
        $.ajax({
            url: '/ajax.php',
            data: 'action=check_nick&nickname='+type,
            dataType: "json",
            success: function(data){
                //$.fancybox.open(paramsFancy);
                //$.fancybox.close();
                //$('#error_nickname').text(data.message);
                if (data.error==1){
                    MyThis.focus();
                    MyThis.addClass('red_input');
                    MyThis.tooltipster('update', data.message);
                    // console.log(MyThis);
                    //$(this).tooltipster('show');
                }
                else{
                    MyThis.removeClass('red_input');
                    MyThis.tooltipster('hide');
                    //alert(1);
                    //console.log(MyThis);
                }
            }
        });
    }else{
        //alert(1);
        $(this).focus();
        $(this).addClass('red_input');
        $(this).tooltipster('update', 'Никнейм должен состоять хотя бы из 5 символов и содержать только латинские буквы или цифры');
        $(this).tooltipster('show');
    }
    
});
$('#user_email').keyup(function(){
    var email = $(this).val();
    var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
    if(pattern.test($(this).val())){
        MyThis=$(this);
        
        $.ajax({
            url: '/ajax.php',
            data: 'action=check_email&email='+email,
            dataType: "json",
            success: function(data){
                //$.fancybox.open(paramsFancy);
                //$.fancybox.close();
                //$('#error_nickname').text(data.message);
                if (data.error==1){
                    MyThis.focus();
                    MyThis.addClass('red_input');
                    MyThis.tooltipster('update', data.message);
                    // console.log(MyThis);
                    //$(this).tooltipster('show');
                }
                else{
                    MyThis.removeClass('red_input');
                    MyThis.tooltipster('hide');
                    //alert(1);
                    //console.log(MyThis);
                }
            }
        });
    }
    else{
        $(this).focus();
        $(this).addClass('red_input');
        $(this).tooltipster('update', 'E-mail указан неверно.');
        $(this).tooltipster('show');
    }
});

$('.pass2').keyup(function(){
    //alert($('#pass1').val()+' - '+$(this).val());
    if ($('.pass1').val() == $(this).val()){
        //alert(1);
        $(this).removeClass('red_input');
        $(this).tooltipster('hide');
    }else{
        
        $(this).focus();
        $(this).addClass('red_input');
        $(this).tooltipster('update', 'Пароли должны совпадать.');
        $(this).tooltipster('show');
    }
});

$('.sending').click(function(){
    validate=1;
    validate_msg='';
   // alert($(this).attr('rel'));
    form=$('#'+$(this).attr('rel'));
    jQuery.each(form.find('.validate'), function(key, value) {
        if($(this).val()==''){
            validate_msg+=$(this).attr('title')+'\n';validate=0;
           // $(this).focus();
     //      alert(1);
            $(this).addClass('red_input');
            $(this).tooltipster('update',$(this).attr('placeholder'));//^[a-zA-Z0-9_]{5,}$     
            $(this).tooltipster('show');
        }else if($(this).hasClass('validate_nickname')){
                var pattern = /^[a-zA-Z0-9_]{5,}$/;
                if(pattern.test($(this).val())){
                                
                }
                else{
                    validate = 0;
                    //validate_msg+='E-mail указан неверно<br>';
                   // $(this).focus();
                    $(this).addClass('red_input');
                    $(this).tooltipster('update', $(this).attr('Ваш никнейм должен содержать только латинские буквы или цифры.'));
                    $(this).tooltipster('show');
                }
        }else if($(this).hasClass('validate_email')){
                var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
                if(pattern.test($(this).val())){
                                
                }
                else{
                    validate = 0;
                    //validate_msg+='E-mail указан неверно<br>';
                   // $(this).focus();
                    $(this).addClass('red_input');
                    $(this).tooltipster('update', $(this).attr('E-mail указан неверно.'));
                    $(this).tooltipster('show');
                }
        }else{
            $(this).tooltipster('hide');
            $(this).removeClass('red_input');
        }
    });
    if(validate==1){
        $.ajax({
            url: '/ajax.php',
            //data: 'action=send_form&'+form.serialize(),
            data:form.serialize(),
            dataType: "json",
            success: function(data){
                //$.fancybox.open(paramsFancy);
                if (data.error==0){
                    document.location='http://'+window.location.hostname+'/user/profile';
                    form.trigger('reset');
                }else
                    alert('Ошибка!!!');
            }
        });

    }else{
        /*alert(validate_msg);*/
    } 
});




$('.login').click(function(){
    validate=1;
    validate_msg='';
    form=$('#'+$(this).attr('rel'));
    jQuery.each(form.find('.validate'), function(key, value) {
        if($(this).val()==''){
            //validate_msg+=$(this).attr('title')+'\n';
            validate=0;
           // $(this).focus();
           //alert(1);
            $(this).addClass('red_input');
            $(this).tooltipster('update', $(this).attr('placeholder') );//^[a-zA-Z0-9_]{5,}$    
            $(this).tooltipster('show');
        }else{
            $(this).tooltipster('hide');
            $(this).removeClass('red_input');
        }
    });
    if(validate==1){
        $.ajax({
            url: '/ajax.php',
            //data: 'action=send_form&'+form.serialize(),
            data:form.serialize(),
            dataType: "json",
            success: function(data){
                //$.fancybox.open(paramsFancy);
                //alert(data);
                if (data.error==0){
                    document.location='http://'+window.location.hostname+'/user/profile';
                    $('#login_em').tooltipster('hide');
                    $('#login_em').removeClass('red_input');
                    $('#login_pas').tooltipster('hide');
                    $('#login_pas').removeClass('red_input');
                    form.trigger('reset');
                }else if (data.error==1){
                    $('#login_pas').addClass('red_input');
                    $('#login_pas').tooltipster('update', data.mes_pas );
                    $('#login_pas').tooltipster('show');
                    $('#login_em').tooltipster('hide');
                    $('#login_em').removeClass('red_input');
                }else{
                    $('#login_pas').addClass('red_input');
                    $('#login_pas').tooltipster('update', data.mes_pas );
                    $('#login_pas').tooltipster('show');
                    
                    $('#login_em').addClass('red_input');
                    $('#login_em').tooltipster('update', data.mes_em );
                    $('#login_em').tooltipster('show');
                }
                    
            }
        });

    }else{
        /*alert(validate_msg);*/
    } 
    
});

$('#save_acc').click(function(){
    // onclick=" return false;"
    validate=1;
    validate_msg='';
    form=$('#myform');
    jQuery.each(form.find('.red_input'), function(key, value) {
        validate=0;
        /*
        if($(this).val()==''){
            //validate_msg+=$(this).attr('title')+'\n';
            validate=0;
           // $(this).focus();
           //alert(1);
            $(this).addClass('red_input');
            $(this).tooltipster('update', $(this).attr('placeholder') );//^[a-zA-Z0-9_]{5,}$    
            $(this).tooltipster('show');
        }else{
            $(this).tooltipster('hide');
            $(this).removeClass('red_input');
        }*/
    });
    if (validate==1)
        document.getElementById('myform').submit();
});
$('#show_add').click(function(){
    $('#add_type').show(500);
});


/**/
$('.send').click(function(){
    var paramsFancy={
        'scrolling':0,
        'autoScale': true,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 500,
        'speedOut': 300,
        'autoDimensions': true,
        'centerOnScroll': true,
        'href' : '#modal-order-send',
        'padding' : '0',
        'height' : 'auto',
        helpers: {
                overlay: {
                  locked: false
                }
            }
        };
    validate=1;
    validate_msg='';
   // alert($(this).attr('rel'));
    form=$('#'+$(this).attr('rel'));
    jQuery.each(form.find('.validate'), function(key, value) {
        if($(this).val()==''){
            validate_msg+=$(this).attr('title')+'\n';validate=0;
           // $(this).focus();
     //      alert(1);
            $(this).addClass('red_input');
            $(this).tooltipster('update',$(this).attr('placeholder'));//^[a-zA-Z0-9_]{5,}$     
            $(this).tooltipster('show');
        }else if($(this).hasClass('user_nick')){
                var pattern = /^[a-zA-Z0-9_]{5,}$/;
                var type = $(this).val();
                if(pattern.test($(this).val())){
                    MyThis=$(this);
                    $.ajax({
                        url: '/ajax.php',
                        data: 'action=check_nick&nickname='+type,
                        dataType: "json",
                        async: false,
                        success: function(data){
                            //$.fancybox.open(paramsFancy);
                            //$.fancybox.close();
                            //$('#error_nickname').text(data.message);
                            if (data.error==1){
                                MyThis.focus();
                                MyThis.addClass('red_input');
                                MyThis.tooltipster('update', data.message);
                                validate = 0;
                                //alert(validate);
                                // console.log(MyThis);
                                //$(this).tooltipster('show');
                            }
                            else{
                                MyThis.removeClass('red_input');
                                MyThis.tooltipster('hide');
                                //alert(1);
                                //console.log(MyThis);
                            }
                        }
                    });
                }
                else{
                    validate = 0;
                    //validate_msg+='E-mail указан неверно<br>';
                   // $(this).focus();
                    $(this).addClass('red_input');
                    $(this).tooltipster('update', $(this).attr('Ваш никнейм должен содержать только латинские буквы или цифры.'));
                    $(this).tooltipster('show');
                }
        }else{
            $(this).tooltipster('hide');
            $(this).removeClass('red_input');
        }
    });
   // alert(validate);
    if(validate==1){
        $.ajax({
            url: '/ajax.php',
            //data: 'action=send_form&'+form.serialize(),
            data:form.serialize(),
            //dataType: "json",
            success: function(data){
                //$.fancybox.open(paramsFancy);
                /*
                if (data.error==0){
                    document.location='http://'+window.location.hostname+'/user/profile';
                    form.trigger('reset');
                }else
                    alert('Ошибка!!!');
                */
               form.trigger('reset');
               $('#add_type').hide(500);
               $('#add_spec_aj').append(data);
               $('#user_modal_message').text('Ваши данные были успешно сохранены.');
               $.fancybox.open(paramsFancy);
            }
        });

    }else{
        /*alert(validate_msg);*/
    } 
});


$(".col-sm-12").delegate(".save", "click", function(){
     var paramsFancy={
        'scrolling':0,
        'autoScale': true,
        'transitionIn': 'elastic',
        'transitionOut': 'elastic',
        'speedIn': 500,
        'speedOut': 300,
        'autoDimensions': true,
        'centerOnScroll': true,
        'href' : '#modal-order-send',
        'padding' : '0',
        'height' : 'auto',
        helpers: {
                overlay: {
                  locked: false
                }
            }
        };
    validate=1;
    validate_msg='';
   // alert($(this).attr('rel'));
    form=$('#'+$(this).attr('rel'));
    jQuery.each(form.find('.validate'), function(key, value) {
        if($(this).val()==''){
            validate_msg+=$(this).attr('title')+'\n';validate=0;
           // $(this).focus();
     //      alert(1);
            $(this).addClass('red_input');
            $(this).tooltipster('update',$(this).attr('placeholder'));//^[a-zA-Z0-9_]{5,}$     
            $(this).tooltipster('show');
        }else{
            $(this).tooltipster('hide');
            $(this).removeClass('red_input');
        }
    });
    if(validate==1){
        $.ajax({
            url: '/ajax.php',
            //data: 'action=send_form&'+form.serialize(),
            data:form.serialize(),
            //dataType: "json",
            success: function(data){
                $('#user_modal_message').text('Ваши данные были успешно сохранены.');
                $.fancybox.open(paramsFancy);
                /*
                if (data.error==0){
                    document.location='http://'+window.location.hostname+'/user/profile';
                    form.trigger('reset');
                }else
                    alert('Ошибка!!!');
                *//*
               form.trigger('reset');
               $('#add_type').hide(500);
               $('#add_spec_aj').append(data)*/
            }
        });

    }else{
        /*alert(validate_msg);*/
    } 
});

/*
$('.save').click(function(){
    validate=1;
    validate_msg='';
   // alert($(this).attr('rel'));
    form=$('#'+$(this).attr('rel'));
    jQuery.each(form.find('.validate'), function(key, value) {
        if($(this).val()==''){
            validate_msg+=$(this).attr('title')+'\n';validate=0;
           // $(this).focus();
     //      alert(1);
            $(this).addClass('red_input');
            $(this).tooltipster('update',$(this).attr('placeholder'));//^[a-zA-Z0-9_]{5,}$     
            $(this).tooltipster('show');
        }else{
            $(this).tooltipster('hide');
            $(this).removeClass('red_input');
        }
    });
    if(validate==1){
        $.ajax({
            url: '/ajax.php',
            //data: 'action=send_form&'+form.serialize(),
            data:form.serialize(),
            //dataType: "json",
            success: function(data){
                //$.fancybox.open(paramsFancy);
                /*
                if (data.error==0){
                    document.location='http://'+window.location.hostname+'/user/profile';
                    form.trigger('reset');
                }else
                    alert('Ошибка!!!');
                *//*
               form.trigger('reset');
               $('#add_type').hide(500);
               $('#add_spec_aj').append(data)
            }
        });

    }else{
       
    } 
});
*/
/*
$('.del').click(function(){
    var type = $(this).attr('rel');
    var div = $('#'+$(this).attr('data-id'));
    //alert(type);
    $.ajax({
        url: '/ajax.php',
        data: 'action=del_type&id='+type,
        success: function(data){
            //$.fancybox.open(paramsFancy);
            //$.fancybox.close();
            div.hide(500);
        }
    });
});
*/
$(".col-sm-12").delegate(".del", "click", function(){
    if (confirm("Вы действительно хотите удалить специализацию?")) {
        var type = $(this).attr('rel');
        var div = $('#'+$(this).attr('data-id'));
        //alert(type);
        $.ajax({
            url: '/ajax.php',
            data: 'action=del_type&id='+type,
            success: function(data){
                //$.fancybox.open(paramsFancy);
                //$.fancybox.close();
                div.hide(500);
            }
        });
    }

    
});
/*

$('.sending').click(function(){
    form=$('#'+$(this).attr('rel'));
    validate=1;
    validate_msg='';
    jQuery.each(form.find('.validate'), function(key, value) {
        if($(this).val()==''){  
            validate = 0;
            validate_msg+='Заполните пожалуйста - '+$(this).attr('rel')+'<br>';validate=0;
        }else if($(this).hasClass('validate_email')){
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            if(pattern.test($(this).val())){

            }
            else{
                validate = 0;
                validate_msg+='E-mail указан неверно<br>';
            }
        }
    });
    if(validate==1){
            $.ajax({
                url: '/ajax.php',
                data: 'action=send_form&'+form.serialize(),
                success: function(data){
                        $('#message').removeClass('hidden');
                        $('#message').html(data);
                }
            });


    }else{
        $('#message').removeClass('hidden');
        $('#message').html(validate_msg);
        //alert(validate_msg);
    }
});
    /*$('form input[type="text"]').tooltipster({
        trigger: 'custom',
        animation:'grow',
        theme: 'tooltipster-shadow',
        onlyOne: false,
        position: 'right'
    });
    $('form input[type="phone"]').tooltipster({
        trigger: 'custom',
        animation:'grow',
        theme: 'tooltipster-shadow',
        onlyOne: false,
        position: 'right'
    });
    $('form input[type="email"]').tooltipster({
        trigger: 'custom',
        animation:'grow',
        theme: 'tooltipster-shadow',
        onlyOne: false,
        position: 'right'
    });*/
});