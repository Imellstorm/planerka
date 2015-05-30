<?php

class Notifications extends \Eloquent {
	protected $table = 'notifications';
    protected $guarded = array('_token');
}