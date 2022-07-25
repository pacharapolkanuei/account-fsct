<?php
/**
 * Created by PhpStorm.
 * User: pacharapol
 * Date: 1/14/2018 AD
 * Time: 9:59 PM
 */

namespace App\Api;
use  App\Api\Connectdb;
use DB;


class Maincenter
{
    public static function databranchbycode($code_branch){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[hr_base].branch.*
                FROM $db[hr_base].branch
                WHERE $db[hr_base].branch.code_branch = '$code_branch'";

        $dataquery = DB::select($sql);

        return $dataquery;
    }

    public static function datacompany($id){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[hr_base].working_company.*
                FROM $db[hr_base].working_company
                WHERE $db[hr_base].working_company.id = '$id'";

        $dataquery = DB::select($sql);

        return $dataquery;
    }

    public static  function getdatacompemp($codeemp){
        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[hr_base].emp_data.*
                FROM $db[hr_base].emp_data
                WHERE $db[hr_base].emp_data.code_emp_old = '$codeemp'";

        $dataquery = DB::select($sql);

        return $dataquery;
    }

  	public static function yearCorverttoBE ($date){

        $year=substr($date,0,4);
  			$month=substr($date,5,2);
  			$day=substr($date,8,2);
  			$yearBE = $year+543;
  			$dateBE=$yearBE."-".$month."-".$day;

        return $dateBE;
      }

      public static function getdatacustomer($customerid){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctmain].customers.*
                FROM $db[fsctmain].customers
                WHERE $db[fsctmain].customers.customerid LIKE '%$customerid%' ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

	   public static function getdatacustomeridandname($customerid){

        $db = Connectdb::Databaseall();

        $sql ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
                    CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
                     '.$db['fsctmain'].'.customers.customer_terms as customer_terms,
                     '.$db['fsctmain'].'.customers.customerid as id
               FROM '.$db['fsctmain'].'.customers
               INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
			   WHERE $db[fsctmain].customers.customerid LIKE '%$customerid%' ';

        $model = DB::connection('mysql')->select($sql);

        return $model;
    }

      public static function getbillrent($idbillrent,$iddate){

        // echo "<pre>";
        // print_r($iddatetime);
        // echo "<br>";
        // print_r($idbranch_id);
        // exit;
        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctmain].bill_rent.*,
                       $db[fsctmain].bill_return_head.*
                FROM $db[fsctmain].bill_rent
                INNER JOIN $db[fsctmain].bill_return_head
                   ON $db[fsctmain].bill_rent.id = $db[fsctmain].bill_return_head.bill_rent
                WHERE $db[fsctmain].bill_return_head.bill_rent = '$idbillrent'
                AND $db[fsctmain].bill_return_head.time LIKE '%$iddate%'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getbillrentengine($idbillrent,$iddate){

        // echo "<pre>";
        // print_r($idbillrent);
        // echo "<br>";
        // print_r($iddate);
        // exit;
        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctmain].billengine_rent.*,
                       $db[fsctmain].billengine_return_head.*
                FROM $db[fsctmain].billengine_rent
                INNER JOIN $db[fsctmain].billengine_return_head
                   ON $db[fsctmain].billengine_rent.id = $db[fsctmain].billengine_return_head.bill_rent
                WHERE $db[fsctmain].billengine_return_head.bill_rent = '$idbillrent'
                AND $db[fsctmain].billengine_return_head.time LIKE '%$iddate%'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatacustomercash($customerid){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctmain].customers.*
                FROM $db[fsctmain].customers
                WHERE $db[fsctmain].customers.customerid LIKE '%$customerid%'";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatapodetail($poid){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].po_detail.*
                FROM $db[fsctaccount].po_detail
                WHERE $db[fsctaccount].po_detail.po_headid LIKE '%$poid%'
                AND $db[fsctaccount].po_detail.statususe NOT IN (99)
                ";

        $dataquery = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataquery);
        // exit;
        return $dataquery;
      }

      public static function getdatara($ra){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_abb.*
                FROM $db[fsctaccount].taxinvoice_abb
                WHERE $db[fsctaccount].taxinvoice_abb.id = '$ra'
                ";

        $dataquery = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataquery);
        // exit;
        return $dataquery;
      }

      public static function getdatarn($rn){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_more_abb.*
                FROM $db[fsctaccount].taxinvoice_more_abb
                WHERE $db[fsctaccount].taxinvoice_more_abb.id = '$rn'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatarl($rl){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_loss_abb.*
                FROM $db[fsctaccount].taxinvoice_loss_abb
                WHERE $db[fsctaccount].taxinvoice_loss_abb.id = '$rl'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatacn($cn){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_creditnote.*
                FROM $db[fsctaccount].taxinvoice_creditnote
                WHERE $db[fsctaccount].taxinvoice_creditnote.id = '$cn'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatati($ti){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_insurance.*
                FROM $db[fsctaccount].taxinvoice_insurance
                WHERE $db[fsctaccount].taxinvoice_insurance.id = '$ti'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdataci($ci){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_insurance_creditnote.*
                FROM $db[fsctaccount].taxinvoice_insurance_creditnote
                WHERE $db[fsctaccount].taxinvoice_insurance_creditnote.bill_rent = '$ci'
                AND $db[fsctaccount].taxinvoice_insurance_creditnote.status NOT IN (99)
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatars($rs){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_special_abb.*
                FROM $db[fsctaccount].taxinvoice_special_abb
                WHERE $db[fsctaccount].taxinvoice_special_abb.id = '$rs'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatacs($cs){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_creditnote_special_abb.*
                FROM $db[fsctaccount].taxinvoice_creditnote_special_abb
                WHERE $db[fsctaccount].taxinvoice_creditnote_special_abb.id = '$cs'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdataro($ro){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_partial_abb.*
                FROM $db[fsctaccount].taxinvoice_partial_abb
                WHERE $db[fsctaccount].taxinvoice_partial_abb.id = '$ro'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatass($ss){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctmain].stock_sell_head.*
                FROM $db[fsctmain].stock_sell_head
                WHERE $db[fsctmain].stock_sell_head.id = '$ss'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatasupplier($supplierid){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].supplier.*
                FROM $db[fsctaccount].supplier
                WHERE $db[fsctaccount].supplier.id = '$supplierid'";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatasupplierterms($suppliertermsid){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].supplier_terms.*
                FROM $db[fsctaccount].supplier_terms
                WHERE $db[fsctaccount].supplier_terms.id = '$suppliertermsid'";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getcash($cash){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].cash.*
                FROM $db[fsctaccount].cash
                WHERE $db[fsctaccount].cash.branch_id = '$cash'
                ";

        $dataquery = DB::connection('mysql')->select($sql);

        return $dataquery;
      }

      public static function getdatasupplierpo($po){

        $db = Connectdb::Databaseall();

        $po_id = explode(",",trim(($po)));
        // $po_id[0];


        $sql = "SELECT $db[fsctaccount].po_head.*
                FROM $db[fsctaccount].po_head
                WHERE $db[fsctaccount].po_head.id = '$po_id[0]'";

        $data = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($data);
        // exit;

        if($data[0]->supplier_id){
          $sqlsuplier = "SELECT $db[fsctaccount].supplier.*
                         FROM $db[fsctaccount].supplier
                         WHERE $db[fsctaccount].supplier.id = '".$data[0]->supplier_id."'
                        ";

          $dataquery = DB::connection('mysql')->select($sqlsuplier);
        }
        // echo "<pre>";
        // print_r($dataquery);
        // exit;

        return $dataquery;
      }


      public static function getdatabillrent_ra($billrent_ra){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].taxinvoice_abb.gettypemoney
                FROM $db[fsctaccount].taxinvoice_abb
                WHERE $db[fsctaccount].taxinvoice_abb.bill_rent = '$billrent_ra'
                ";

        $dataquery = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataquery);
        // exit;
        return $dataquery;
      }


      public static function getdatabillrent_tk($billrent_tk){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].insertcashrent.typetranfer
                FROM $db[fsctaccount].insertcashrent
                WHERE $db[fsctaccount].insertcashrent.ref = '$billrent_tk'
                AND $db[fsctaccount].insertcashrent.typedoc = 2
                ";

        $dataquery = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataquery);
        // exit;
        return $dataquery;
      }


      public static function getdataid_rl($id_rl){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].insertcashrent.typetranfer
                FROM $db[fsctaccount].insertcashrent
                WHERE $db[fsctaccount].insertcashrent.typereftax = '$id_rl'
                AND $db[fsctaccount].insertcashrent.typedoc = 2
                ";

        $dataquery = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataquery);
        // exit;
        return $dataquery;
      }


      public static function getdatabillrent_tm($billrent_tm){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctaccount].insertcashrent.typetranfer
                FROM $db[fsctaccount].insertcashrent
                WHERE $db[fsctaccount].insertcashrent.ref = '$billrent_tm'
                AND $db[fsctaccount].insertcashrent.typedoc = 1
                ";

        $dataquery = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataquery);
        // exit;
        return $dataquery;
      }


      public static function databranch_bank1($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].bank.*,
                         $db[fsctaccount].accounttype.*

                 FROM $db[fsctaccount].bank
                 INNER JOIN $db[fsctaccount].accounttype
                    ON $db[fsctaccount].bank.accounttypeno = $db[fsctaccount].accounttype.accounttypeno
                  WHERE $db[fsctaccount].bank.branch_id = '$codebranch'
                  AND $db[fsctaccount].bank.id_cash = 1
                  ";

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;

          return $dataquery;
      }

      public static function databranch_bank2($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].bank.*,
                         $db[fsctaccount].accounttype.*

                 FROM $db[fsctaccount].bank
                 INNER JOIN $db[fsctaccount].accounttype
                    ON $db[fsctaccount].bank.accounttypeno = $db[fsctaccount].accounttype.accounttypeno
                  WHERE $db[fsctaccount].bank.branch_id = '$codebranch'
                  AND $db[fsctaccount].bank.id_cash = 2
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }

      public static function databranch_bank3($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].bank.*,
                         $db[fsctaccount].accounttype.*

                 FROM $db[fsctaccount].bank
                 INNER JOIN $db[fsctaccount].accounttype
                    ON $db[fsctaccount].bank.accounttypeno = $db[fsctaccount].accounttype.accounttypeno
                  WHERE $db[fsctaccount].bank.branch_id = '$codebranch'
                  AND $db[fsctaccount].bank.id_cash = 3
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }

      public static function databranch_bank4($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].bank.*,
                         $db[fsctaccount].accounttype.*

                 FROM $db[fsctaccount].bank
                 INNER JOIN $db[fsctaccount].accounttype
                    ON $db[fsctaccount].bank.accounttypeno = $db[fsctaccount].accounttype.accounttypeno
                  WHERE $db[fsctaccount].bank.branch_id = '$codebranch'
                  AND $db[fsctaccount].bank.id_cash = 4
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdatadetail_bill($idbill){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctmain].bill_detail.loss,
                       $db[fsctmain].bill_detail.amount,
                       $db[fsctmain].bill_detail.material_id,
                       $db[fsctmain].material.name

                FROM $db[fsctmain].bill_detail
                INNER JOIN $db[fsctmain].material
                   ON $db[fsctmain].bill_detail.material_id = $db[fsctmain].material.id
                WHERE $db[fsctmain].bill_detail.bill_rent = '$idbill'
                ";

        $dataquery = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataquery);
        // exit;

        return $dataquery;
      }


      public static function getdatadetail_billengine($idbillengine){

        $db = Connectdb::Databaseall();
        $sql = "SELECT $db[fsctmain].billengine_detail.loss,
                       $db[fsctmain].billengine_detail.amount,
                       $db[fsctmain].billengine_detail.material_id,
                       $db[fsctmain].engine.name_engine

                FROM $db[fsctmain].billengine_detail
                INNER JOIN $db[fsctmain].engine
                   ON $db[fsctmain].billengine_detail.material_id = $db[fsctmain].engine.id
                WHERE $db[fsctmain].billengine_detail.bill_rent = '$idbillengine'
                ";

        $dataquery = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataquery);
        // exit;

        return $dataquery;
      }


      public static function getdataconfig_ra_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 1
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_tf_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 2
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_rl_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 3
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_tk_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 4
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_rn_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 5
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_tm_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 6
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_ro_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 7
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_tp_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 8
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_cn_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 9
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_rs_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 10
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_ss_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 11
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_ti_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 12
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_ci_acc($codebranch){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.branch = '$codebranch'
                  AND $db[fsctaccount].config_acc_tax.tax_type = 13
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdataconfig_acc($code){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].config_acc_tax.*,
                         $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].config_acc_tax
                  INNER JOIN $db[fsctaccount].accounttype
                     ON $db[fsctaccount].config_acc_tax.acc_ref = $db[fsctaccount].accounttype.id

                  WHERE $db[fsctaccount].config_acc_tax.tax_type = '$code'
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdatamaterial_ss($id){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctmain].stock_sell_detail.*,
                         SUM($db[fsctmain].material.pricenew * $db[fsctmain].stock_sell_detail.amount) as totalpricenew,
                         SUM($db[fsctmain].material.pricedepreciation * $db[fsctmain].stock_sell_detail.amount) as totalpricedepreciation

                  FROM $db[fsctmain].stock_sell_detail
                  INNER JOIN $db[fsctmain].material
                     ON $db[fsctmain].material.id = $db[fsctmain].stock_sell_detail.material_id

                  WHERE $db[fsctmain].stock_sell_detail.bill_head = '$id'
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;
      }


      public static function getdatamaterial_rl($id,$bill_rent,$type){
          // echo "<pre>";
          // print_r($id);
          // print_r($bill_rent);
          // print_r($type);
          // exit;

          $db = Connectdb::Databaseall();

          if($type == "0"){ // นั่งร้าน

            $sql = "SELECT $db[fsctaccount].taxinvoice_loss_abb.id,
                           $db[fsctmain].bill_rent.bill_rent,
                           $db[fsctmain].bill_detail.material_id,
                           SUM($db[fsctmain].material.pricenew * $db[fsctmain].bill_detail.amount) as totalpricenew,
                           SUM($db[fsctmain].material.pricedepreciation * $db[fsctmain].bill_detail.amount) as totalpricedepreciation

                    FROM $db[fsctaccount].taxinvoice_loss_abb
                    INNER JOIN $db[fsctmain].bill_rent
                       ON $db[fsctmain].bill_rent.id = $db[fsctaccount].taxinvoice_loss_abb.bill_rent

                    INNER JOIN $db[fsctmain].bill_detail
                       ON $db[fsctmain].bill_detail.bill_rent = $db[fsctmain].bill_rent.id

                    INNER JOIN $db[fsctmain].material
                       ON $db[fsctmain].material.id = $db[fsctmain].bill_detail.material_id

                    WHERE $db[fsctmain].bill_rent.id = '$bill_rent'
                      AND $db[fsctaccount].taxinvoice_loss_abb.id = '$id'
                    ";

            $dataquery = DB::select($sql);

          }
          elseif ($type == "2") { //เครื่องยนต์

            $sql = "SELECT $db[fsctaccount].taxinvoice_loss_abb.id,
                           $db[fsctmain].billengine_rent.billengine_rent,
                           $db[fsctmain].billengine_detail.material_id,
                           $db[fsctmain].engine.pk_engine,
                           SUM($db[fsctmain].engine_detail.loss * $db[fsctmain].billengine_detail.amount) as totalpricenew,
                           SUM($db[fsctmain].engine_detail.pricedepreciation * $db[fsctmain].billengine_detail.amount) as totalpricedepreciation

                    FROM $db[fsctaccount].taxinvoice_loss_abb
                    INNER JOIN $db[fsctmain].billengine_rent
                       ON $db[fsctmain].billengine_rent.id = $db[fsctaccount].taxinvoice_loss_abb.bill_rent

                    INNER JOIN $db[fsctmain].billengine_detail
                       ON $db[fsctmain].billengine_detail.bill_rent = $db[fsctmain].billengine_rent.id

                    INNER JOIN $db[fsctmain].engine
                       ON $db[fsctmain].engine.id = $db[fsctmain].billengine_detail.material_id

                    INNER JOIN $db[fsctmain].engine_detail
                       ON $db[fsctmain].engine_detail.id = $db[fsctmain].engine.pk_engine

                    WHERE $db[fsctmain].billengine_rent.id = '$bill_rent'
                      AND $db[fsctaccount].taxinvoice_loss_abb.id = '$id'
                    ";

            $dataquery = DB::select($sql);

          }
          // echo "<pre>";
          // print_r($dataquery);
          // exit;

          return $dataquery;
      }


      public static function getdatamaterial_tk($id,$bill_rent,$type){
          // echo "<pre>";
          // print_r($id);
          // echo "<br>";
          // print_r($bill_rent);
          // echo "<br>";
          // print_r($type);
          // exit;

          $db = Connectdb::Databaseall();

          if($type == "0"){ // นั่งร้าน

            $sql = "SELECT $db[fsctaccount].taxinvoice_loss.id,
                           $db[fsctmain].bill_rent.bill_rent,
                           $db[fsctmain].bill_detail.material_id,
                           SUM($db[fsctmain].material.pricenew * $db[fsctmain].bill_detail.amount) as totalpricenew,
                           SUM($db[fsctmain].material.pricedepreciation * $db[fsctmain].bill_detail.amount) as totalpricedepreciation

                    FROM $db[fsctaccount].taxinvoice_loss
                    INNER JOIN $db[fsctmain].bill_rent
                       ON $db[fsctmain].bill_rent.id = $db[fsctaccount].taxinvoice_loss.bill_rent

                    INNER JOIN $db[fsctmain].bill_detail
                       ON $db[fsctmain].bill_detail.bill_rent = $db[fsctmain].bill_rent.id

                    INNER JOIN $db[fsctmain].material
                       ON $db[fsctmain].material.id = $db[fsctmain].bill_detail.material_id

                    WHERE $db[fsctmain].bill_rent.id = '$bill_rent'
                      AND $db[fsctaccount].taxinvoice_loss.id = '$id'
                    ";

            $dataquery = DB::select($sql);

          }
          elseif ($type == "2") { //เครื่องยนต์

          $sql = "SELECT $db[fsctaccount].taxinvoice_loss.id,
                           $db[fsctmain].billengine_rent.billengine_rent,
                           $db[fsctmain].billengine_detail.material_id,
                           $db[fsctmain].engine.pk_engine,
                           SUM($db[fsctmain].engine_detail.loss * $db[fsctmain].billengine_detail.amount) as totalpricenew,
                           SUM($db[fsctmain].engine_detail.pricedepreciation * $db[fsctmain].billengine_detail.amount) as totalpricedepreciation

                    FROM $db[fsctaccount].taxinvoice_loss
                    INNER JOIN $db[fsctmain].billengine_rent
                       ON $db[fsctmain].billengine_rent.id = $db[fsctaccount].taxinvoice_loss.bill_rent

                    INNER JOIN $db[fsctmain].billengine_detail
                       ON $db[fsctmain].billengine_detail.bill_rent = $db[fsctmain].billengine_rent.id

                    INNER JOIN $db[fsctmain].engine
                       ON $db[fsctmain].engine.id = $db[fsctmain].billengine_detail.material_id

                    INNER JOIN $db[fsctmain].engine_detail
                       ON $db[fsctmain].engine_detail.id = $db[fsctmain].engine.pk_engine

                    WHERE $db[fsctmain].billengine_rent.id = '$bill_rent'
                      AND $db[fsctaccount].taxinvoice_loss.id = '$id'
                    ";

            $dataquery = DB::select($sql);

          }
          // echo "<pre>";
          // print_r($dataquery);
          // exit;

          return $dataquery;
      }


      public static function getdatajournal_general($id){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].journalgeneral_detail.*

                  FROM $db[fsctaccount].journalgeneral_detail

                  WHERE $db[fsctaccount].journalgeneral_detail.id_journalgeneral_head = '$id'
                  AND $db[fsctaccount].journalgeneral_detail.status IN (1)
                  ";

          $dataquery = DB::select($sql);

          return $dataquery;

      }


      public static function getdataaccount_name($valuereturn,$datepicker){ //หน้างบทดลอง

          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($valuereturn);
          // print_r($datepicker);
          // exit;

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdataaccount_name_all($acc_code,$datepicker){

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdatatrial_budget_before($valuereturn,$datepicker){ //งบทดลองก่อนปรับปรุง (รายสาขา)

          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($valuereturn);
          // print_r($datepicker);
          // exit;

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.type_general IN (0,1,2)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdatatrial_budget_before_forward($valuereturn,$datepicker){ //ยอดยกมา งบทดลองก่อนปรับปรุง (รายสาขา)

          $db = Connectdb::Databaseall();

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          // $end_date = $datepicker[1];
          // $e2 = explode("/",trim(($datepicker2[1])));
          //         if(count($e2) > 0) {
          //             $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
          //             $end_dateold = $e2[2]-1 . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน (ปีเก่า)
          //         }

          // echo "<pre>";
          // print_r($accontcode);
          // print_r($start_dateold);
          // print_r($end_dateold);
          // exit;

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.type_general IN (0,1,2)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdatatrial_budget_after($valuereturn,$datepicker){ //รายการปรับปรุง (รายสาขา)

          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($valuereturn);
          // print_r($datepicker);
          // exit;

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                          AND '.$db['fsctaccount'].'.ledger.type_general = 3
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdatatrial_budget_after_forward($valuereturn,$datepicker){ //ยอดยกมา รายการปรับปรุง (รายสาขา)

          $db = Connectdb::Databaseall();

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                          AND '.$db['fsctaccount'].'.ledger.type_general = 3
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdataincome($valuereturn,$datepicker){ //งบกำไรขาดทุน (รายสาขา)

          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($valuereturn);
          // print_r($datepicker);
          // exit;

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal IN (4,5)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdataincome_forward($valuereturn,$datepicker){ //ยอดยกมา งบกำไรขาดทุน (รายสาขา)

          $db = Connectdb::Databaseall();

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal IN (4,5)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdatafinancial($valuereturn,$datepicker){ //งบแสดงฐานะการเงิน (รายสาขา)

          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($valuereturn);
          // print_r($datepicker);
          // exit;

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal IN (1,2,3)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdatafinancial_forward($valuereturn,$datepicker){ //ยอดยกมา งบแสดงฐานะการเงิน (รายสาขา)

          $db = Connectdb::Databaseall();

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal IN (1,2,3)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdatatrial_budget_allbefore($acc_code,$datepicker){ //งบทดลองก่อนปรับปรุง (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.type_general IN (0,1,2)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdatatrial_budget_allbefore_forward($accontcode,$datepicker){ //ยอดยกมา งบทดลองก่อนปรับปรุง (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$accontcode.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.type_general IN (0,1,2)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdatatrial_budget_allafter($acc_code,$datepicker){ //รายการปรับปรุง (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                          AND '.$db['fsctaccount'].'.ledger.type_general = 3
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdatatrial_budget_allafter_forward($accontcode,$datepicker){ //ยอดยกมา รายการปรับปรุง (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$accontcode.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                          AND '.$db['fsctaccount'].'.ledger.type_general = 3
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdataincome_all($acc_code,$datepicker){ //งบกำไรขาดทุน (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal IN (4,5)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdataincome_all_forward($accontcode,$datepicker){ //ยอดยกมา งบกำไรขาดทุน (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$accontcode.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.type_journal IN (4,5)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdatafinancial_all($acc_code,$datepicker){ //งบแสดงฐานะการเงิน (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.type_journal IN (1,2,3)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdatafinancial_all_forward($accontcode,$datepicker){ //ยอดยกมา งบแสดงฐานะการเงิน (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$accontcode.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.type_journal IN (1,2,3)
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdatabroughtforward($accontcode,$datepicker){ //ยอดยกมา หน้าแยกประเภท (ทั้งหมด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          // $end_date = $datepicker[1];
          // $e2 = explode("/",trim(($datepicker2[1])));
          //         if(count($e2) > 0) {
          //             $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
          //             $end_dateold = $e2[2]-1 . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน (ปีเก่า)
          //         }

          // echo "<pre>";
          // print_r($accontcode);
          // print_r($start_dateold);
          // print_r($end_dateold);
          // exit;

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$accontcode.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                          AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdatabroughtforward_branch($valuereturn,$datepicker){ //ยอดยกมา หน้าแยกประเภท (รายสาขา)

          $db = Connectdb::Databaseall();

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          // $end_date = $datepicker[1];
          // $e2 = explode("/",trim(($datepicker2[1])));
          //         if(count($e2) > 0) {
          //             $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
          //             $end_dateold = $e2[2]-1 . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน (ปีเก่า)
          //         }

          // echo "<pre>";
          // print_r($accontcode);
          // print_r($start_dateold);
          // print_r($end_dateold);
          // exit;

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                          AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.branch
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }

      public static function getdatabroughtforward_detail($accontcode,$datepicker){ //ยอดยกมา หน้างบทดลอง (รายละเอียด)

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$accontcode.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                          AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                          AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.branch
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdataaccount_name_after($valuereturn,$datepicker){ //หน้างบทดลองหลังปิดบัญชี
                                                                                  //กรณี ไม่เอาหมวด 1 2 3
          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($valuereturn);
          // print_r($datepicker);
          // exit;

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "1%"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "2%"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "3%"
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdataaccount_name_after_select($valuereturn,$datepicker){ //หน้างบทดลองหลังปิดบัญชี
                                                                                         //กรณี ข้อมูลของหมวดที่ 1 2 3
          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($valuereturn);
          // print_r($datepicker);
          // exit;

          $acccode_accbranch = explode(" ",trim($valuereturn));
          $acc_code = $acccode_accbranch[0];
          $branch_id = $acccode_accbranch[1];

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "4%"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "5%"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "6%"
                          AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdataaccount_name_all_after($acc_code,$datepicker){ //หน้างบทดลองหลังปิดบัญชี
                                                                                   //กรณี ไม่เอาหมวด 1 2 3

          $db = Connectdb::Databaseall();

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "1%"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "2%"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "3%"
                          AND '.$db['fsctaccount'].'.ledger.status != 99
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function getdataaccount_name_all_after_select($acc_code,$datepicker){ //หน้างบทดลองหลังปิดบัญชี
                                                                                             //กรณี ข้อมูลของหมวดที่ 1 2 3
          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($valuereturn);
          // print_r($datepicker);
          // exit;

          $datepicker2 = explode("-",trim($datepicker));

          $e1 = explode("/",trim(($datepicker2[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker2[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

          $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                           SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                           SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                        FROM '.$db['fsctaccount'].'.ledger

                        WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                          AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "4%"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "5%"
                          AND '.$db['fsctaccount'].'.ledger.acc_code NOT LIKE "6%"
                          AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                        ';

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;
          return $dataquery;

      }


      public static function dataaccounttype($acc_code){

          $db = Connectdb::Databaseall();
          $sql = "SELECT $db[fsctaccount].accounttype.*

                  FROM $db[fsctaccount].accounttype

                  WHERE $db[fsctaccount].accounttype.accounttypeno = '$acc_code'
                  AND $db[fsctaccount].accounttype.status != 99
                  ";

          $dataquery = DB::select($sql);
          // echo "<pre>";
          // print_r($dataquery);
          // exit;

          return $dataquery;
      }

























}
