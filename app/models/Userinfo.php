<?php

class Userinfo extends \Eloquent {
	protected $table = 'user_info';
    protected $guarded = array('_token');
}