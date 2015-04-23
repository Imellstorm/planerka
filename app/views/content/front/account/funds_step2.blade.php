<div class="row" style="margin:0 0 20px 0">
	<h4>Вы собираетесь оплатить {{ $amount }} грн.</h4>
    <form method="POST" accept-charset="utf-8" action="https://www.liqpay.com/api/checkout">
		<input type="hidden" name="data" value="{{ $data }}" />
		<input type="hidden" name="signature" value="{{ $signature }}" />
		<input type="submit" name="btn_text" class="btn btn-success" value="Оплатить"/>
	</form>
</div>