<?php

namespace App\Api;

class Connectdb
{
    public static function Databaseall(){

      $dberp = [ 'admin_hrdemo'=> 'admin_hr',
                 'admin_accdemo'=>'admin_acc',
                 'admin_main'=>'admin_main',
                 'hr_base'=> 'admin_hr',
                  'fsctaccount'=>'admin_acc',
                  'fsctmain'=>'admin_main',
                  'fsctweb'=>'admin_web',
                  'admin_maindemo'=>'admin_main'
               ];

        return $dberp;
    }
}

$dberp = [ 'admin_hrdemo'=> 'admin_hrdemo',
           'admin_accdemo'=>'admin_accdemo',
           'admin_main'=>'admin_main',
           'hr_base'=> 'admin_hr',
            'fsctaccount'=>'admin_accdemo',
            'fsctmain'=>'admin_main',
            'fsctweb'=>'admin_webdemo',
            'admin_maindemo'=>'admin_maindemo'
         ];
