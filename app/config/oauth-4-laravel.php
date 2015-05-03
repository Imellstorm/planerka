<?php
return array( 

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => 'Session', 

    /**
     * Consumers
     */
    'consumers' => array(

        /**
         * Facebook
         */
        'facebook' => array(
            'client_id'     => '1587232944881759',
            'client_secret' => 'a63e3f552a056c1aa165a86ee70f20e3',
            'scope'         => array('email','read_friendlists','user_online_presence'),
        ), 
        /**
         * Twitter
         */
        'twitter' => array(
            'client_id'     => 'nf0Q0JyrMNhOJLP8MaYjRlsn0',
            'client_secret' => 'tUGOo58ygNFeCiQ5kNthnBPdaaVyS25ZPtzfYbekFOSukX2Ox5',
        ),           

    )

);