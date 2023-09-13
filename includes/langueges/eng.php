<?php
function lang($phrase)
{
    static $lang = [

    //DASHBOARD
    'ADMIN_NAME' => 'Amine',
    'ADMIN_HOME' => 'HOME',
    'ADMIN_PROFILE_EDIT' => 'Edit Profile',
    'ADMIN_SETTINGS' => 'Settings',
    'ADMIN_PROFILE_LOGOUT' => 'Logout',

    //DASHBOARD NAVBAR
    'CATEGORIES' => 'Cartegories',
    'ITEMS' => 'Items',
    'MEMBERS' => 'Members',
    'STATISTICS' => 'Statistics',
    'LOGS' => 'Logs',
    'COMMENTS' => 'Comments',

    //SHOP NAVBAR
    'SHOP' => 'SHOP',
    'A PROPOS' => 'A PROPOS',
    'CONTACT' => 'CONTACT',
    'MON COMPTE' => 'MON COMPTE'
    ];

    return $lang[$phrase];
}
;