<?php

class Image extends \Eloquent {
	protected $table = 'images';
    protected $guarded = array('_token');
}