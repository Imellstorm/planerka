<div class="row" style="margin:0 0 20px 0">
	<div class="col-md-12">
		<h4>На вашем балансе {{ $user->balance }} гривен</h4>
	</div>

    <div class="col-md-12">	
		@if ($subscribe)
	        <div class="bs-callout bs-callout-success col-md-12">
	            <h4>Активная учётная запись</h4>
	            <div>
	                Действие учётной записи истекает {{ $user->expires }}   
	            </div>
	        </div>            
	    @else
	        <div class="bs-callout bs-callout-danger col-md-12">
	            <h4>Действие учётной записи приостановлено</h4>
	            <div>
	                На вашей учётной записи закончилась подписка. Вы не можете размещать объявления.   
	            </div>
	        </div>            
	    @endif
	    
	    <div class="bs-callout bs-callout-info col-md-12">
	        @if ($user->type == 'trial')
	            <h4>Приобрести подписку</h4>
	        @else
	            <h4>Продлить подписку</h4>
	        @endif
	        <div>
	            {{ Form::open(array('role' => 'form', 'url' => 'account/buysubscription')) }}
	                Купив подписку, вы сможете оставлять объявления в течении месяца<br>
	                Стоимость подписки {{ $subscribe_price }} кредитов <br><br>
	                <input type="submit" class="btn btn-info" value="купить">
	            {{ Form::close() }}  
	        </div>
	    </div>

	    <form method="POST" accept-charset="utf-8" action="/account/funds/step2">
			<div>
				<label for="amount">Пополнить баланс на сумму:</label>
			</div>
			<div style="max-width:400px">
				<input type="text" name="amount" class="form-control">
			</div>
			<div style="margin-top:20px">
				<input type="submit" name="btn_text" class="btn btn-success" value="перейти к оплате"/>
			</div>	
		</form>
    </div>       
</div>