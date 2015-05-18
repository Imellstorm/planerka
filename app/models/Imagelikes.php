<?php

class Imagelikes extends \Eloquent {
	protected $table = 'image_likes';
    protected $guarded = array('_token');
}