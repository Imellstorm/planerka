<?php

class SiteSettings extends \Eloquent {
	protected $table = 'sitesettings';
    protected $guarded = array('_token');
}