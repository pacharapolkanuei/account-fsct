<?php
/**
 * Created by PhpStorm.
 * User: pacharapol
 * Date: 1/14/2018 AD
 * Time: 4:04 PM
 */

namespace App\Api;
use  App\Api\Connectdb;
use  App\Api\Maincenter;
use DB;


class Vendorcenter
{
    public static function getdatavendorcenter($id){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].supplier.*
                     FROM $db[fsctaccount].supplier
                     WHERE $db[fsctaccount].supplier.id = '$id'";

        $dataquery = DB::connection('mysql')->select($sql);

       // print_r($dataquery);


        return $dataquery;
    }

    public static function getstatusvendor($id){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].accountstatusforprogram.*
                     FROM $db[fsctaccount].accountstatusforprogram
                     WHERE $db[fsctaccount].accountstatusforprogram.numberstatus = '$id'";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
    }

    public static function ckstatus($id){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].accountstatusforprogram.*
                     FROM $db[fsctaccount].accountstatusforprogram
                     WHERE $db[fsctaccount].accountstatusforprogram.numberstatus = '$id'";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
    }

    public static function getdatadetailpr($id){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].ppr_detail.*
                     FROM $db[fsctaccount].ppr_detail
                     WHERE $db[fsctaccount].ppr_detail.ppr_headid = '$id'
                     AND status = '1'
                     AND approvedstatusmd = '1'
                     AND approvedstatus = '1' ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
        //
    }

    public static function getapprovedpr($idppr){
        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].approved_pr.*
                     FROM $db[fsctaccount].approved_pr
                     WHERE $db[fsctaccount].approved_pr.id_prhead = '$idppr'
                     AND status = '1'";

        $dataquery = DB::connection('mysql')->select($sql);
        $dataemp = Maincenter::getdatacompemp($dataquery[0]->id_approvedby);


        return  $dataemp;

    }

    public static function getpaybillemp($idpo){
        $db = Connectdb::Databaseall();
        $sql = "SELECT SUM($db[fsctaccount].po_bill_run_money.pay_real) as sumpay_real
                     FROM $db[fsctaccount].po_bill_run_money
                     WHERE $db[fsctaccount].po_bill_run_money.po_headid = '$idpo'
                     AND status = '1'";

        $dataquery = DB::connection('mysql')->select($sql);

       return $dataquery;
    }


    public static function getstatusresultpo($statusresult){

        if($statusresult==0){
            $status = '<font color="red">ขออนุมัติ</font>';
        }else if($statusresult==1){
            $status = '<font color="green">อนุมัติเรียบร้อยแล้ว</font>';
        }else if($statusresult==2){
            $status = '<font color="blue">โอนเรียบร้อย</font>';
        }else if($statusresult==3){
            $status = '<font color="#4b0082">คืนครบ</font>';
        }else if($statusresult==4){
            $status = '<font color="#4b0082">มีเงินทอน</font>';
        }else if($statusresult==5){
            $status = '<font color="#4b0082">ขาด</font>';
        }else {
            $status = '<font color="#red">ยกเลิก</font>';
        }
        return  $status;
    }


    public static function getdatagroupsupp($idgroupsupp){
        $db = Connectdb::Databaseall();
        $sql = "SELECT *
                     FROM $db[fsctaccount].config_group_supp
                     WHERE $db[fsctaccount].config_group_supp.id = '$idgroupsupp' ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
    }

    public static function configweekpr(){
        $db = Connectdb::Databaseall();
        $sql = "SELECT *  FROM $db[fsctaccount].config_week_pr ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
    }



    public static function getdatagoodgroup($idd){
        $db = Connectdb::Databaseall();
        $sql = "SELECT name_group
                     FROM $db[fsctaccount].group_good
                     WHERE $db[fsctaccount].group_good.id = '$idd' ";
        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
    }


	    public static function getdatagoodtype($idd){
        $db = Connectdb::Databaseall();
        $sql = "SELECT name_type
                     FROM $db[fsctaccount].type_good
                     WHERE $db[fsctaccount].type_good.id = '$idd' ";
        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
    }

		    public static function getdataaccounttype($idd){
        $db = Connectdb::Databaseall();
        $sql = "SELECT accounttypefull
                     FROM $db[fsctaccount].accounttype
                     WHERE $db[fsctaccount].accounttype.id = '$idd' ";
        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
    }
        public static function getdatapodetail($id){
          $db = Connectdb::Databaseall();
          $sql = "SELECT *
                       FROM $db[fsctaccount].po_detail
                       WHERE $db[fsctaccount].po_detail.po_headid = '$id'
                        AND status IN (1,2) AND statususe = '1' ";
          $dataquery = DB::connection('mysql')->select($sql);

          return $dataquery;
        }



}
