@extends('containers.frontend')

@section('title') {{ 'Профиль|календарь' }} @stop

@section('main')
	<div id="user-page">
		<div class="container">
			@include('content.front.profile.menu')
			<div class="row">
				<div class="col-sm-6">
					<div class="clndr-msg">
						Используйте календарь - это позволит вам занимать первые места в поисковой выдаче. Отметье день как занятый, кликнув на требуемую дату. Планёрка не будет отправлять вам заказы на это число. Заказы принятые через наш сервис автоматически проставляются в календарь
					</div>
				</div>
				<div class="col-sm-6 text-center">
					<div class="calendar">
						<div id="with-altField"></div>
					</div>
					@if($userInfo->user_id == Auth::user()->id)
						{{ Form::open(array('role' => 'form', 'url' => 'calendar/store')) }}
							<input type="hidden" name="dates" id="altField">
							<input type="submit" value="Сохранить" class="btn-main" style="position:relative;left:125px;top:10px;">
						{{ Form::close() }}
					@endif
				</div>
			</div>
		</div>
	</div>	
@stop

@section('scripts')
	<script type="text/javascript" src="/assets/js/jquery-ui.multidatespicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php 
				$datesStr = '';
				if(count($dates)){
					echo 'dates = [];';
					$datesStr = 'dates.push(';
					foreach ($dates as $key => $val) {
						$datesStr.= 'new Date("'.date('m-d-Y',strtotime($val->date)).'")';
						if(isset($dates[$key+1])){
							$datesStr.=',';
						}
					}
					$datesStr.=')';
					echo $datesStr;
				}
			?>

			$('#with-altField').multiDatesPicker({
				altField: '#altField',
				minDate: 0 {{ !empty($datesStr)?', addDates: dates':'' }}
			});
		});
	</script>
@stop