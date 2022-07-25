<?php
/**
 * Created by PhpStorm.
 * User: pacharapol
 * Date: 1/14/2018 AD
 * Time: 4:04 PM
 */

namespace App\Api;
use  App\Api\Connectdb;
use DB;
use App\Ledger;

class Accountcenter
{
    public static function datacodeaccount($id){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].accounttype.*
                     FROM $db[fsctaccount].accounttype
                     WHERE $db[fsctaccount].accounttype.id = '$id'";

        $dataquery = DB::connection('mysql')->select($sql);



        return $dataquery;
    }

    public static function dataterms($id){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].supplier_terms.*
                     FROM $db[fsctaccount].supplier_terms
                     WHERE $db[fsctaccount].supplier_terms.id = '$id'";

        $dataquery = DB::connection('mysql')->select($sql);



        return $dataquery;
    }


    public static function converttobath($number){
      $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
      $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
      $number = str_replace(",","",$number);
      $number = str_replace(" ","",$number);
      $number = str_replace("บาท","",$number);
      $number = explode(".",$number);
      if(sizeof($number)>2){
          return 'ทศนิยมหลายตัวนะจ๊ะ';
          exit;
      }
      $strlen = strlen($number[0]);
      $convert = '';
      for($i=0;$i<$strlen;$i++){
          $n = substr($number[0], $i,1);
          if($n!=0){
              if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; }
              elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; }
              elseif($i==($strlen-2) AND $n==1){ $convert .= ''; }
              else{ $convert .= $txtnum1[$n]; }
              $convert .= $txtnum2[$strlen-$i-1];
          }
      }

      $convert .= 'บาท';
      if($number[1]=='0' OR $number[1]=='00' OR
          $number[1]==''){
          $convert .= 'ถ้วน';
      }else{
          $strlen = strlen($number[1]);
          for($i=0;$i<$strlen;$i++){
              $n = substr($number[1], $i,1);
              if($n!=0){
                  if($i==($strlen-1) AND $n==1){$convert
                      .= 'เอ็ด';}
                  elseif($i==($strlen-2) AND
                      $n==2){$convert .= 'ยี่';}
                  elseif($i==($strlen-2) AND
                      $n==1){$convert .= '';}
                  else{ $convert .= $txtnum1[$n];}
                  $convert .= $txtnum2[$strlen-$i-1];
              }
          }
          $convert .= 'สตางค์';
      }
      return $convert;
  }



    public static function getdetailporunstock($namelist,$idpo){

    }

    public static function calwithholding($price,$whd){
      $resultwth = $price * ($whd/100);
      return $resultwth;

    }
    public static function getdatainformdetail($id){
      $db = Connectdb::Databaseall();
      $sql = "SELECT $db[fsctaccount].inform_po_detail.*,
                     $db[fsctaccount].good.name
                   FROM $db[fsctaccount].inform_po_detail
                   INNER JOIN $db[fsctaccount].good
                   ON $db[fsctaccount].inform_po_detail.materialid = $db[fsctaccount].good.id
                   WHERE $db[fsctaccount].inform_po_detail.inform_po_head = '$id'
                   AND statususe = '1' ";
      $dataquery = DB::connection('mysql')->select($sql);

      return $dataquery;
    }

    public static function inserttoledger($request)
    {
      $ins_ledger = new Ledger;
      $ins_ledger->setConnection('mysql2');

      if ($request->get('company_pay')) {
        $ins_ledger->company_pay_wht = $request->get('company_pay');
      }
      if ($request->get('company_pay')) {
        $ins_ledger->company_pay_wht = $request->get('company_pay');
      }
      if ($request->get('company_pay')) {
        $ins_ledger->company_pay_wht = $request->get('company_pay');
      }
      if ($request->get('company_pay')) {
        $ins_ledger->company_pay_wht = $request->get('company_pay');
      }
      if ($request->get('company_pay')) {
        $ins_ledger->company_pay_wht = $request->get('company_pay');
      }
      if ($request->get('company_pay')) {
        $ins_ledger->company_pay_wht = $request->get('company_pay');
      }
    }
	
		public static function accincome(){

        $resulte = ['acccash'=>'1',
					'accetc'=>'',
                    'accdiscount'=>121,
					'accwht'=>160,
					'accvat'=>160,
					'accinsurance'=>160,];

        return $resulte;

    }

}
