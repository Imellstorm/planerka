@section('styles')
	<link rel="stylesheet" href="{{ asset('assets/packs/fullcalendar-2.2.2/fullcalendar.css') }}" />
@stop

@section('scripts')
	<script src="{{ asset('assets/packs/fullcalendar-2.2.2/lib/moment.min.js') }}"></script>
	<script src="{{ asset('assets/packs/fullcalendar-2.2.2/fullcalendar.js') }}"></script>
	<script src="{{ asset('assets/packs/fullcalendar-2.2.2/lang-all.js') }}"></script>
	<script>
		$(document).ready(function() {
		    $('#vip_calendar').fullCalendar({
		        lang: 'ru',
		        height: 500,

		        dayClick: function(date, allDay, jsEvent, view) {			        			        
			        if($(this).hasClass('fc-past')){
			        	alert('Данный день уже прошел');			        	
			        } else if($(this).attr('full')==1){
			        	alert('Данный день занят!');
			        } else {

			        	$('#vip_calendar').fullCalendar( 'addEventSource', [{start: date.format(), rendering:'background'}]);

			        	dayEvents = $('#vip_calendar').fullCalendar('clientEvents',function(event){
			        			if(event.start._i == date.format()){
			        				return true;
			        			} else {
			        				return false;
			        			}
			        		});

			        	total = parseInt($('.vip_sum').text());

			        	if(dayEvents[1]!=undefined){
			        		Event0 = dayEvents[0]._id;
			        		Event1 = dayEvents[1]._id;
			        		$('#vip_calendar').fullCalendar('removeEvents',Event0);
			        		$('#vip_calendar').fullCalendar('removeEvents',Event1);
			        		$('.vip_sum').text(parseInt(total-{{ $price }}));
			        		$('#'+Event0).remove();
			        	} else {			        		
			        		$('.vip_sum').text(parseInt(total+ {{ $price }} ));
			        		$('.vip_days').append('<input type="hidden" name="days[]" value="'+date.format()+'" id="'+dayEvents[0]._id+'">');
			        	}
					  
					}

		    	},				

		    	@if(!empty($bookedDays))
			    	dayRender: function (date, cell) {
			    		if( {{$bookedDays}} ){
			    			cell.css('background-color','rgb(255,221,221)');
			    			cell.attr('full',1);
			    		}
			    	}
		    	@endif

   			})
		});   
	</script>
@stop

<div id="vip_calendar"></div>

<form method="POST" action="/account/buyvip" class="vip_days">
	<div class="vip_cost">
		Общая стоимость <span class="vip_sum">0</span>
	</div>
	<input type="hidden" name="post_id" value="{{ $postId }}">
	<input type="hidden" name="param" value="{{ $param }}">
	<input type="submit" value="Купить">
</form>