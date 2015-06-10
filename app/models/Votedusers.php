<?php

class Votedusers extends \Eloquent {
	protected $table = 'voted_users';
    protected $guarded = array('_token');
}