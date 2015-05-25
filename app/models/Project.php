<?php

class Project extends \Eloquent {
	protected $table = 'projects';
    protected $guarded = array('_token');
}