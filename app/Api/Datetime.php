<?php

namespace App\Api;


class Datetime
{
      public static function convertMonth($intMonth)
          {
            $intMonth=(int)$intMonth;
            $arrMonth = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
            return $arrMonth [$intMonth-1];
          }

      public static function createArrayMonth()
          {
            $arrMonth = [];
            for($i=1;$i<=12;$i++) {
                $arrMonth[$i] = self::mappingMonth($i);
            }
            return $arrMonth;
          }

      public static function arrMonthTh()
          {
              $arrMonth = ['1'=>'มกราคม',
                  '2'=>'กุมภาพันธ์',
                  '3'=>'มีนาคม',
                  '4'=>'เมษายน',
                  '5'=>'พฤษภาคม',
                  '6'=>'มิถุนายน',
                  '7'=>'กรกฎาคม',
                  '8'=>'สิงหาคม',
                  '9'=>'กันยายน',
                  '10'=>'ตุลาคม',
                  '11'=>'พฤศจิกายน',
                  '12'=>'ธันวาคม'];
              return $arrMonth;
            }


        public static function mappingMonth($intMonth)
            {
              $intMonth=(int)$intMonth;
              $arrMonth = ['1'=>'มกราคม',
                           '2'=>'กุมภาพันธ์',
                           '3'=>'มีนาคม',
                           '4'=>'เมษายน',
                           '5'=>'พฤษภาคม',
                           '6'=>'มิถุนายน',
                           '7'=>'กรกฎาคม',
                           '8'=>'สิงหาคม',
                           '9'=>'กันยายน',
                           '10'=>'ตุลาคม',
                           '11'=>'พฤศจิกายน',
                           '12'=>'ธันวาคม'];

              return $arrMonth[$intMonth];
            }
        public static function mappingMonthContraction($intMonth)
            {
              $intMonth=(int)$intMonth;
              $arrMonth = ['1'=>'ม.ค.',
                           '2'=>'ก.พ.',
                           '3'=>'มี.ค.',
                           '4'=>'เม.ย.',
                           '5'=>'พ.ค.',
                           '6'=>'มิ.ย.',
                           '7'=>'ก.ค.',
                           '8'=>'ส.ค.',
                           '9'=>'ก.ย.',
                           '10'=>'ต.ค.',
                           '11'=>'พ.ย.',
                           '12'=>'ธ.ค.'];

              return $arrMonth[$intMonth];
            }


        public static function calculateAge($bithdayDate)
            {
              if($bithdayDate != null && $bithdayDate !='0000-00-00') {
                  $date = new \DateTime($bithdayDate);
                  $now = new \DateTime();
                  $interval = $now->diff($date);
                  return $interval->y;
              }
              else {
                  return '-';
              }
            }



        public static function ThaiDateTime($dt)
            {
              if ($dt == '' || $dt == null || $dt=='0000-00-00 00:00:00') {
                  return '';
              } else {
                  $x = explode(" ", trim($dt));
                  $e1 = explode("-", trim($x[0]));
                  $t = null;
                  if(count($x[1]) > 0) {
                      $t = ' '.substr($x[1],0,8);
                  }
                  $f = $e1[2] . '/' . $e1[1] . '/' . $e1[0].$t;
                  return $f;
              }
            }

        public static function ThaiDateNoTime($dt)
            {
              if ($dt == '' || $dt == null || $dt=='0000-00-00 00:00:00') {
                  return '';
              } else {
                  $x = explode(" ", trim($dt));
                  $e1 = explode("-", trim($x[0]));
                  $f = $e1[2] . '/' . $e1[1] . '/' . $e1[0];
                  return $f;
              }
            }

        public static function CalendarDateNotime($dt)
            {
              if ($dt == '' || $dt == null || $dt=='0000-00-00 00:00:00') {
                  return '';
              } else {
                  $x = explode(" ", trim($dt));
                  $e1 = explode("-", trim($x[0]));
                  $f = $e1[2] . '/' . $e1[1] . '/' . $e1[0];
                  return $f;
              }
            }

        public static function CalendarDate($dt)
            {
              if ($dt == '' || $dt == null || $dt=='0000-00-00') {
                  return '';
              } else {
                  $e1 = explode("-", trim($dt));
                  $f = $e1[2] . '/' . $e1[1] . '/' .$e1[0];
                  return $f;
              }
            }

        public static function DateToMysqlDB($dt)
            {
              $f = null;
              if ($dt == '' || $dt == null) {
                  return null;
              } else {
                  $e1 = explode("/",trim($dt));
                  if(count($e1) > 0) {
                      $f = $e1[2] . '-' . $e1[0] . '-' . $e1[1]; //ปี - เดือน - วัน
                  }
              }
              return $f;
            }

          public static function FormatDateFromCalendarRange($DateString)
            {
                if($DateString !=null) {
                    $tmp = explode("-",$DateString);
                    $_start = $tmp[0];
                    $_end = $tmp[1];
                    return [
                        'start_date'=>self::DateToMysqlDB($_start),
                        'end_date'=>self::DateToMysqlDB($_end),
                    ];
                }
                else return null;
            }

            public static function resultmonthzero($month){
                     $count = strlen($month);
                     if($count==1){
                       $month = '0'.$month;
                     }else{
                       $month = $month;
                     }
                  return $month;
              }

              public static function dateDifference($date_1 , $date_2 , $diffDay = '%a',$diffHours = '%h',$diffMinute = '%i' )
                {
                    $datetime1 = date_create($date_1);
                    $datetime2 = date_create($date_2);

                    $interval = date_diff($datetime1, $datetime2);

                    $arrResult = [ 'Day'=>$interval->format($diffDay),
                        'Hours'=>$interval->format($diffHours),
                        'Minute'=>$interval->format($diffMinute),
                    ];

                    return $arrResult;

                }


            public static function convertdateengtotth($dateen){

                  $dateen = explode('-',$dateen);
                  // print_r($dateen);

                  $intMonth=(int)$dateen[1];
                  $arrMonth = ['1'=>'ม.ค.',
                               '2'=>'ก.พ.',
                               '3'=>'มี.ค.',
                               '4'=>'เม.ย.',
                               '5'=>'พ.ค.',
                               '6'=>'มิ.ย.',
                               '7'=>'ก.ค.',
                               '8'=>'ส.ค.',
                               '9'=>'ก.ย.',
                               '10'=>'ต.ค.',
                               '11'=>'พ.ย.',
                               '12'=>'ธ.ค.'];



                  $dd = $dateen[2];
                  $mm = $arrMonth[$intMonth];
                  $yy = $dateen[0]+543;

                  return ['dd'=>$dd,'mm'=>$mm,'yy'=>$yy];


            }


            public static function convertStartToEnd($date){
                  $dateset = explode('-',$date);
                  $startdate = $dateset[0];
                  $s = explode('/',$startdate);
                  $s = $s[2].'-'.$s[0].'-'.$s[1];


                  $enddate = $dateset[1];
                  $e = explode('/',$enddate);
                  $e = $e[2].'-'.$e[0].'-'.$e[1];


                  return ['start'=>str_replace(' ', '', $s),'end'=>str_replace(' ', '', $e)];

            }

            public static function convertDateEnd($date){
                  $dateset = explode('-',$date);
                  $enddate = $dateset[0];
                  $e = explode('/',$enddate);
                  $e = $e[2].'-'.$e[0].'-'.$e[1];

                  return ['end'=>str_replace(' ', '', $e)];

            }





}
