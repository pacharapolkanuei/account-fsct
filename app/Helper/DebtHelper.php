<?php

function StartCheckDate($datebill)
{
    $year = echo subtok($datebill,'-',0,1);
    $month = echo subtok($datebill,'-',1,1);
    $day = echo subtok($datebill,'-',2,1);

    if ($month == 01) {
        return "2020-01-01";
    }elseif ($month == 02){
        return "2020-02-01";
    }elseif ($month == 03){
        return "2020-03-01";
    }elseif ($month == 04){
        return "2020-04-01";
    }elseif ($month == 05){
        return "2020-05-01";
    }elseif ($month == 06){
        return "2020-06-01";
    }elseif ($month == 07){
        return "2020-07-01";
    }elseif ($month == 08){
        return "2020-08-01";
    }elseif ($month == 09){
        return "2020-09-01";
    }elseif ($month == 10){
        return "2020-10-01";
    }elseif ($month == 11){
        return "2020-11-01";
    }elseif ($month == 12){
        return "2020-12-01";
    }
}

function EndCheckDate($datebill)
{
    $year = echo subtok($datebill,'-',0,1);
    $month = echo subtok($datebill,'-',1,1);
    $day = echo subtok($datebill,'-',2,1);

    if ($month == 01) {
        return "2020-01-01";
    }elseif ($month == 02){
        return "2020-02-01";
    }elseif ($month == 03){
        return "2020-03-01";
    }elseif ($month == 04){
        return "2020-04-01";
    }elseif ($month == 05){
        return "2020-05-01";
    }elseif ($month == 06){
        return "2020-06-01";
    }elseif ($month == 07){
        return "2020-07-01";
    }elseif ($month == 08){
        return "2020-08-01";
    }elseif ($month == 09){
        return "2020-09-01";
    }elseif ($month == 10){
        return "2020-10-01";
    }elseif ($month == 11){
        return "2020-11-01";
    }elseif ($month == 12){
        return "2020-12-01";
    }
}
