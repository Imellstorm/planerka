<?php

class Album extends \Eloquent {
	protected $table = 'albums';
    protected $guarded = array('_token');
}