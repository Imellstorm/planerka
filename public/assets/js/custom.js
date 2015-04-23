$(document).ready(function() {

	//PLACEHOLDER FOR OLD BROWSERS
	$('input, textarea').placeholder();
	
	//CLEAR AND SET PLACEHOLDER  
    $('input,textarea').focus(function(){
       $(this).data('placeholder',$(this).attr('placeholder'))
       $(this).attr('placeholder','');
    });
    $('input,textarea').blur(function(){
       $(this).attr('placeholder',$(this).data('placeholder'));
    });

    //SHOW DETAIL FOR PERFORMER
    $('.hover').mouseenter(function() {
        /* Act on the event */
        $('.detail-info').toggleClass('block');
    });

    //MASK INPUT
    $.mask.definitions['~'] = "[+-]";
    $("#phone").mask("+3 (999) 999-99-99");
	
	//FANCYBOX
	$(".fancybox").fancybox({
		padding: 0,

        openEffect : 'elastic',
        openSpeed  : 150,

        closeEffect : 'elastic',
        closeSpeed  : 150,

        'beforeClose': function(event) { 
           $('input.red_input').tooltipster('hide');
        }
	});

	//CAROUSEL
	$('.jcarousel').jcarousel({
		wrap: 'circular'
	});
    $('.prev')
        .jcarouselControl({
            target: '-=1'
        });
    $('.next')
        .jcarouselControl({
            target: '+=1'
        });
});