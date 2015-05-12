<?php

class Usersettings extends \Eloquent {
	protected $table = 'user_settings';
    protected $guarded = array('_token');
}