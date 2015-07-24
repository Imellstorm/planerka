<?php

class Ratinghistory extends \Eloquent {
	protected $table = 'rating_history';
    protected $guarded = array('_token');
}