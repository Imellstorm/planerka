window.onbeforeunload = function() {
    $.ajax({url:"/setoffline", async:false})
    //return "Wait! Have you claimed Your FREE CD Yet?"
}

$(document).ready(function() {

	//SHOW SUB MENU


  $('#sub-menu-show').on('click',function() {
    $('.sub-menu').toggle(200);
  });

	// $('.top_menu>ul>li:last-child>a').click(function(event) {
	// 	$('.menu ul').toggle(200);
  //    return false;
	// });

  $('body').on('click',function(event){
    if($(event.target).closest('#sub-menu-show').length) return;
    $('.menu ul').hide();
  });



	//USER MENU 
	/*, .menu-panel .name*/
	$('#show-user-menu').click(function(event) {
    firstClick = true;
		$('#user-menu').toggle();

	});

  $('body').on('click',function(event){
    if($(event.target).closest("#show-user-menu").length) return;
    $('#user-menu').hide();
  });




	// CUSTOM SELECT FOR BOOTSTRAP

	$('.selectpicker').selectpicker();



	//CLEAR AND SET PLACEHOLDER  

    $('input,textarea').focus(function(){

       $(this).data('placeholder',$(this).attr('placeholder'))

       $(this).attr('placeholder','');

    });

    $('input,textarea').blur(function(){

       $(this).attr('placeholder',$(this).data('placeholder'));

    });



    //SHOW DETAIL FOR PERFORMER

    $('.user-info .info-cont .name a').mouseenter(function() {

    	$(this).parent().parent().parent().parent().children('.detail-info').show();

    });

     //SHOW DETAIL FOR PERFORMER

    $('.user-info .name a').mouseenter(function() {

    	$(this).parent().parent().parent().children('.detail-info').show();

    });



    $('.detail-info, #card').mouseleave(function(event) {

    	$('.detail-info').hide();

    });

    //SHOW HIDE SEARCH IN MOBILE VERSION

    $('.search .mobile-title').click(function() {

    	$('#header .search .form-inline').toggle();

    });

    //SHOW HIDE MENU MOBILE

    $('.show-menu').click(function(event) {

    	$('#mobile-menu .menu').toggle();

    });

    //DATEPICKER 

	$.datepicker.regional['ru'] = {

        closeText: 'Закрыть',

        prevText: '&#x3c;Пред',

        nextText: 'След&#x3e;',

        currentText: 'Сегодня',

        monthNames: ['Января','Февраля','Марта','Апреля','Мая','Июня',

        'Июля','Августа','Сентября','Октября','Ноября','Декабря'],

        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',

        'Июл','Авг','Сен','Окт','Ноя','Дек'],

        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],

        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],

        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],

        weekHeader: 'Не',

        dateFormat: 'dd-mm-yy',

        firstDay: 1,

        isRTL: false,

        showMonthAfterYear: false,

        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['ru']);



	$('#datepicker, .datepicker').datepicker({

		inline: true,

		showOtherMonths: true,

        changeMonth: true,
        
      	changeYear: true

	});

	$('#prof-birth').datepicker({

		showOtherMonths: true,

		dateFormat: 'd MM yy',

        changeMonth: true,
        
      	changeYear: true,

        yearRange: "-100:+0",

	});



	// INPUT FILE 

		// Span

		var span = document.getElementsByClassName('upload-path');

		// Button

		var uploader = document.getElementsByName('upload');

		// On change

		for( item in uploader ) {

		  // Detect changes

		  uploader[item].onchange = function() {

		    // Echo filename in span

		    span[0].innerHTML = this.files[0].name;

		  }

		}

	// MAIN INPUT FILE 

		// Span

		var span = document.getElementsByClassName('add-file-path');

		// Button

		var uploader = document.getElementsByName('upload');

		// On change

		for( item in uploader ) {

		  // Detect changes

		  uploader[item].onchange = function() {

		    // Echo filename in span

		    span[0].innerHTML = this.files[0].name;

		  }

		}	



	$('.img-wrapp').mouseenter(function(event) {

		/* Act on the event */

		$(this).children('.cont-box').slideDown(200);

	});

	$('.img-wrapp').mouseleave(function(event) {

		/* Act on the event */

		$('.cont-box').slideUp(200);

	});

        

   /* $(document).ready(function() {

        

    });*/


    /*function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
 
    $( "#city" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "http://gd.geobytes.com/AutoCompleteCity",
          dataType: "jsonp",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
      minLength: 3,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.label :
          "Nothing selected, input was " + this.value);
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });*/

	var availableTags = [
      "Москва",
      "Санкт-Петербург",
      "Новосибирск",
      "Екатеринбург",
      "Нижний Новгород",
      "Казань",
      "Самара",
      "Челябинск",
      "Омск",
      "Ростов-на-Дону",
      "Уфа",
      "Красноярск",
      "Пермь",
      "Волгоград",
      "Воронеж",
      "Саратов",
      "Краснодар",
      "Тольятти",
      "Тюмень",
      "Ижевск",
      "Барнаул",
      "Ульяновск",
      "Иркутск",
      "Владивосток",
      "Ярославль",
      "Хабаровск",
      "Махачкала",
      "Оренбург",
      "Томск",
      "Новокузнецк",
      "Кемерово",
      "Астрахань",
      "Рязань",
      "Набережные Челны",
      "Пенза",
      "Липецк",
      "Тула",
      "Киров",
      "Чебоксары",
      "Калининград"
    ];
    $( "#city" ).autocomplete({
      source: availableTags
    });
    $( "#modal-order-place" ).autocomplete({
      source: availableTags
    });
    $( "#city_search" ).autocomplete({
      source: availableTags
    });


    $('.create-account').on('click',function(){
      var button = $(this);
      var modalCont = $(this).parent().parent().parent();
      username = $(modalCont).find('.username').val();
      email = $(modalCont).find('.email').val();
      password = $(modalCont).find('.password').val();
      password_confirmation = $(modalCont).find('.confirm_password').val();
      captcha_code = $(modalCont).find('.captcha_code').val();
      socnet = $(modalCont).find('.socNet').val();
      socid = $(modalCont).find('.socId').val();
      socimage = $(modalCont).find('.socImage').val();


      $(modalCont).find('.error').text('');
      $.ajax({
        url: '/admin/users/validate',
        type: 'post',
        dataType: 'json',
        data:{
          username: username,
          email: email,
          password: password,
          password_confirmation: password_confirmation,
          captcha_code: captcha_code
        },
        success: function(ret){
          if(ret.success == 'success'){
              $.fancybox(ret.view);
            } else {
            $.each(ret, function(key,val) {               
              modalCont.find('.'+key+'.error').text(val);
            });
            jQuery('#captcha').prop('src', '/assets/packs/securimage/securimage_show.php?sid=' + Math.random());
          }
        }
      });
    });

    $('body').on('click','.role_main',function(){
      $(this).parent().parent().hide();
      $('.loading').show();
      $.ajax({
        url: '/admin/users/store',
        type: 'post',
        dataType: 'json',
        data:{
          username: username,
          email: email,
          password: password,
          password_confirmation: password_confirmation,
          role: $(this).attr('role'),
          socnet: socnet,
          socid : socid,
          socimage: socimage
        },
        success: function(ret){
          $('.loading').hide();
          if(ret.success == 'success'){
            $.fancybox(ret.view);
          }
        }
      });
    });

    $('body').on('click','.rules',function(){
      $('.register-cont').toggle();
      $('.rules').toggle();
      $.fancybox.update();
    });

    $('body').on('click','.role_other',function(){
      $('.main-roles').toggle();
      $('.additional-roles').toggle();
      $.fancybox.update();
    });

    $('body').on('click','.password_reset_submit',function(){
      var modalCont = $(this).parent().parent().parent();
      var password = $(modalCont).find('.password').val();
      var password_confirmation = $(modalCont).find('.confirm_password').val();
      var token = $(modalCont).find('.token').val();
      console.log(password);
      $.ajax({
        url: '/password/reset',
        type: 'post',
        dataType: 'json',
        data:{
          token: token,
          password: password,
          password_confirmation: password_confirmation
        },
        success: function(ret){
          if(ret.success == 'success'){
            $.fancybox(ret.view);
          } else {
            $.each(ret, function(key,val) {               
              modalCont.find('.'+key+'.error').text(val);
            });
          }
        }
      });
    });  

    $('.fancybox').fancybox({
      openEffect: 'fade',
      closeEffect: 'fade',
      openSpeed: 400,
      closeSpeed: 400,
      afterClose: function() {
        $('.register-cont input').val('');
        $('.social-message').text('');
        $('.social-login').show();
        $('.error').html('');
        jQuery('#captcha').prop('src', '/assets/packs/securimage/securimage_show.php?sid=' + Math.random());
      },
      helpers: {
        overlay: {
          locked: false
        }
      }
    });

    $('.fancybox_ajax_scroll').fancybox({
      type: 'ajax',
      openEffect: 'fade',
      closeEffect: 'fade',
      openSpeed: 400,
      closeSpeed: 400,
      afterShow: function(){
        $(".fancybox-inner").animate({
            scrollTop: $('.fancybox-inner')[0].scrollHeight,
        });
      },
      helpers: {
        overlay: {
          locked: false
        }
      }
    });

    $('.fancybox_ajax').fancybox({
      type: 'ajax',
      openEffect: 'fade',
      closeEffect: 'fade',
      openSpeed: 400,
      closeSpeed: 400,
      helpers: {
        overlay: {
          locked: false
        }
      }
    });

    $('.favorites_button').on('click',function(){
      $(this).parent().hide();
    });

    $('body').on('click','.send_message_btn',function(){
        text = $('textarea.text').val();
        $('textarea.text').val('');
        if(text==''){
          alert('Вы не можете отправить пустое сообщение');
        } else {

          $.ajax({
              url:'/message/store',
              type:'post',
              data:{
                  username:$('.username').val(),
                  user_id:$('.user_id').val(),
                  text:text,
              },
              success: function(res){
                $.ajax({
                  url:'/message/messageblock',
                  type:'get',
                  data: {
                    text:text
                  },
                  success:function(ret){
                    $('.popup_dialog_cont').append(ret);
                    $(".fancybox-inner").animate({
                          scrollTop: $('.fancybox-inner')[0].scrollHeight,
                      });
                     $.fancybox.update();
                  }
                });
              }
          })
        }
    });
});
