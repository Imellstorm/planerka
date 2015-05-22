<?php

class Calendar extends \Eloquent {
	protected $table = 'calendar';
    protected $guarded = array('_token');
}