<?php

class Vote extends \Eloquent {
	protected $table = 'votes';
    protected $guarded = array('_token');
}