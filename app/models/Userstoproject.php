<?php

class Userstoproject extends \Eloquent {
	protected $table = 'users_to_project';
	protected $guarded = array('_token');
}