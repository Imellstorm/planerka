<?php

class Favorites extends \Eloquent {
	protected $table = 'favorites';
    protected $guarded = array('_token');
}