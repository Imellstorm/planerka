<?php

class Review extends \Eloquent {
	protected $table = 'reviews';
    protected $guarded = array('_token');
}