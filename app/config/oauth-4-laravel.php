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

    )

);