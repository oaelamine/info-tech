<?php 
    function lang ( $phrase ) {
        static $lang = [
            'MESSAGE' => 'مرحبا',
            'ADMIN' => 'المدير'
        ];

        return $lang[$phrase];
    };
