<?php

class Video extends \Eloquent {
	protected $table = 'video';
    protected $guarded = array('_token');
}