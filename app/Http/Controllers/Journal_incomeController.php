<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;
use Excel;
use Session;
use App\Api\Connectdb;
use App\Api\Datetime;
use App\Api\Accountcenter;
use App\Api\Maincenter;
use App\Branch;


class journal_incomeController extends Controller {


      public function journal_income(){

      return view('journal.journal_income');
      }

//       public function journal_income(){

//        return view('journal.journal_come_bak');
//        }

      public function serachjournal_income(){

        $data = Input::all();
        $db = Connectdb::Databaseall();
        $dateStartset = '2020-06-05 00:00:00';
        // echo "<br>";
        // echo "<pre>";
        // print_r($data);
        //

        $datepicker = explode("-",trim(($data['daterange'])));

        // $start_date = $datepicker[0];
        $e1 = explode("/",trim(($datepicker[0])));
                if(count($e1) > 0) {
                    $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]; //ปี - เดือน - วัน
                    $start_date2 = $start_date." 00:00:00";
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]; //ปี - เดือน - วัน
                    $end_date2 = $end_date." 23:59:59";
                }

        $branch_id = $data['branch'];


		$brfirst = $branch_id[0];
        // print_r($end_date);

		$branch_id = '('.implode(",",$branch_id).')';

      // echo "start_date2===>".$start_date2;
      // echo "<br>";
      // echo "end_date2===>".$end_date2;


        $sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_abb.*

               FROM '.$db['fsctaccount'].'.taxinvoice_abb

                WHERE  '.$db['fsctaccount'].'.taxinvoice_abb.status = "1"
                ';

			if($brfirst!='all'){

          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqlra .= ' AND '.$db['fsctaccount'].'.taxinvoice_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_abb.branch_id IN '.$branch_id.' ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqlra .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_abb.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_abb.number_taxinvoice,7,4) IN '.$branch_id.') ';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqlra .= ' AND '.$db['fsctaccount'].'.taxinvoice_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_abb.number_taxinvoice,7,4) IN '.$branch_id.' ';
          }

			}

		$datataxra = DB::connection('mysql')->select($sqlra);


        $sqltf = 'SELECT '.$db['fsctaccount'].'.taxinvoice.*

               FROM '.$db['fsctaccount'].'.taxinvoice

                WHERE  '.$db['fsctaccount'].'.taxinvoice.status = 1
               ';

			if($brfirst!='all'){

          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqltf .= ' AND '.$db['fsctaccount'].'.taxinvoice.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice.branch_id IN '.$branch_id.' ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqltf .= ' AND  ('.$db['fsctaccount'].'.taxinvoice.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice.number_taxinvoice,7,4) IN '.$branch_id.') ';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqltf .= ' AND '.$db['fsctaccount'].'.taxinvoice.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice.number_taxinvoice,7,4) IN '.$branch_id.' ';
          }


			}
      // echo $sqltf;
  		//

        $datataxtf = DB::connection('mysql')->select($sqltf);


        $sqlcn = 'SELECT '.$db['fsctaccount'].'.taxinvoice_creditnote.*

               FROM '.$db['fsctaccount'].'.taxinvoice_creditnote

                WHERE  '.$db['fsctaccount'].'.taxinvoice_creditnote.status = 1
               ';

			if($brfirst!='all'){

          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqlcn .= ' AND '.$db['fsctaccount'].'.taxinvoice_creditnote.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_creditnote.branch_id IN '.$branch_id.' ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqlcn .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_creditnote.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_creditnote.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_creditnote.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_creditnote.number_taxinvoice,7,4) IN '.$branch_id.') ';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqlcn .= ' AND '.$db['fsctaccount'].'.taxinvoice_creditnote.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_creditnote.number_taxinvoice,7,4) IN '.$branch_id.' ';
          }

			}



        $datataxcn = DB::connection('mysql')->select($sqlcn);


        $sqlcs = 'SELECT '.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.*

               FROM '.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb

                WHERE   '.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.status = 1
               ';

			if($brfirst!='all'){
				// $sqlcs .= ' AND '.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.branch_id IN '.$branch_id.' ';
          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqlcs .= ' AND '.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.branch_id IN '.$branch_id.' ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqlcs .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.number_taxinvoice,7,4) IN '.$branch_id.') ';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqlcs .= ' AND '.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_creditnote_special_abb.number_taxinvoice,7,4) IN '.$branch_id.' ';
          }
			}

      //
      // echo $sqlcs;
      //


        $datataxcs = DB::connection('mysql')->select($sqlcs);


        $sqltk = 'SELECT '.$db['fsctaccount'].'.taxinvoice_loss.*

               FROM '.$db['fsctaccount'].'.taxinvoice_loss

                WHERE  '.$db['fsctaccount'].'.taxinvoice_loss.status = 1
               ';
			if($brfirst!='all'){
				// $sqltk .= ' AND '.$db['fsctaccount'].'.taxinvoice_loss.branch_id IN '.$branch_id.' ';

            if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
                // echo "<br>";
                // echo "oldcode";
                // echo "<br>";
                $sqltk .= ' AND '.$db['fsctaccount'].'.taxinvoice_loss.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND '.$db['fsctaccount'].'.taxinvoice_loss.branch_id IN '.$branch_id.' ';
            }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
                // echo "<br>";
                // echo "balance";
                // echo "<br>";
                $sqltk .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_loss.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND '.$db['fsctaccount'].'.taxinvoice_loss.branch_id IN '.$branch_id.')
                          OR ('.$db['fsctaccount'].'.taxinvoice_loss.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND substr('.$db['fsctaccount'].'.taxinvoice_loss.number_taxinvoice,7,4) IN '.$branch_id.') ';


            }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
                // echo "<br>";
                // echo "newcode";
                // echo "<br>";
                $sqltk .= ' AND '.$db['fsctaccount'].'.taxinvoice_loss.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND substr('.$db['fsctaccount'].'.taxinvoice_loss.number_taxinvoice,7,4) IN '.$branch_id.' ';
            }

			}

      // echo $sqltk;
      //


        $datataxtk = DB::connection('mysql')->select($sqltk);


        $sqlrl = 'SELECT '.$db['fsctaccount'].'.taxinvoice_loss_abb.*

               FROM '.$db['fsctaccount'].'.taxinvoice_loss_abb

                WHERE   '.$db['fsctaccount'].'.taxinvoice_loss_abb.status = 1
               ';
			if($brfirst!='all'){
				// $sqlrl .= ' AND '.$db['fsctaccount'].'.taxinvoice_loss_abb.branch_id IN '.$branch_id.' ';
            if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
                // echo "<br>";
                // echo "oldcode";
                // echo "<br>";
                $sqlrl .= ' AND '.$db['fsctaccount'].'.taxinvoice_loss_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND '.$db['fsctaccount'].'.taxinvoice_loss_abb.branch_id IN '.$branch_id.' ';
            }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
                // echo "<br>";
                // echo "balance";
                // echo "<br>";
                $sqlrl .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_loss_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND '.$db['fsctaccount'].'.taxinvoice_loss_abb.branch_id IN '.$branch_id.')
                          OR ('.$db['fsctaccount'].'.taxinvoice_loss_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND substr('.$db['fsctaccount'].'.taxinvoice_loss_abb.number_taxinvoice,7,4) IN '.$branch_id.') ';


            }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
                // echo "<br>";
                // echo "newcode";
                // echo "<br>";
                $sqlrl .= ' AND '.$db['fsctaccount'].'.taxinvoice_loss_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND substr('.$db['fsctaccount'].'.taxinvoice_loss_abb.number_taxinvoice,7,4) IN '.$branch_id.' ';
            }
			}

      // echo $sqlrl;
      //
        $datataxrl = DB::connection('mysql')->select($sqlrl);


        $sqltm = 'SELECT '.$db['fsctaccount'].'.taxinvoice_more.*

               FROM '.$db['fsctaccount'].'.taxinvoice_more

                WHERE '.$db['fsctaccount'].'.taxinvoice_more.status = 1
               ';
			if($brfirst!='all'){
				// $sqltm .= ' AND '.$db['fsctaccount'].'.taxinvoice_more.branch_id IN '.$branch_id.' ';
        // $sqlrl .= ' AND '.$db['fsctaccount'].'.taxinvoice_loss_abb.branch_id IN '.$branch_id.' ';
            if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
                // echo "<br>";
                // echo "oldcode";
                // echo "<br>";
                $sqltm .= ' AND '.$db['fsctaccount'].'.taxinvoice_more.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND '.$db['fsctaccount'].'.taxinvoice_more.branch_id IN '.$branch_id.' ';
            }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
                // echo "<br>";
                // echo "balance";
                // echo "<br>";
                $sqltm .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_more.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND '.$db['fsctaccount'].'.taxinvoice_more.branch_id IN '.$branch_id.')
                          OR ('.$db['fsctaccount'].'.taxinvoice_more.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND substr('.$db['fsctaccount'].'.taxinvoice_more.number_taxinvoice,7,4) IN '.$branch_id.') ';


            }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
                // echo "<br>";
                // echo "newcode";
                // echo "<br>";
                $sqltm .= ' AND '.$db['fsctaccount'].'.taxinvoice_more.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND substr('.$db['fsctaccount'].'.taxinvoice_more.number_taxinvoice,7,4) IN '.$branch_id.' ';
            }
			}

      // echo $sqltm;
      //
        $datataxtm = DB::connection('mysql')->select($sqltm);


        $sqlrn = 'SELECT '.$db['fsctaccount'].'.taxinvoice_more_abb.*

               FROM '.$db['fsctaccount'].'.taxinvoice_more_abb

                WHERE   '.$db['fsctaccount'].'.taxinvoice_more_abb.status = 1
               ';
			if($brfirst!='all'){
  				// $sqlrn .= ' AND '.$db['fsctaccount'].'.taxinvoice_more_abb.branch_id IN '.$branch_id.' ';
          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqlrn .= ' AND '.$db['fsctaccount'].'.taxinvoice_more_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_more_abb.branch_id IN '.$branch_id.' ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqlrn .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_more_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_more_abb.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_more_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_more_abb.number_taxinvoice,7,4) IN '.$branch_id.') ';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqlrn .= ' AND '.$db['fsctaccount'].'.taxinvoice_more_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_more_abb.number_taxinvoice,7,4) IN '.$branch_id.' ';
          }
			}
        $datataxrn = DB::connection('mysql')->select($sqlrn);


        $sqltp = 'SELECT '.$db['fsctaccount'].'.taxinvoice_partial.*

               FROM '.$db['fsctaccount'].'.taxinvoice_partial

                WHERE  '.$db['fsctaccount'].'.taxinvoice_partial.status = 1
               ';
			if($brfirst!='all'){
				// $sqltp .= ' AND '.$db['fsctaccount'].'.taxinvoice_partial.branch_id IN '.$branch_id.' ';
          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqltp .= ' AND '.$db['fsctaccount'].'.taxinvoice_partial.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_partial.branch_id IN '.$branch_id.' ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqltp .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_partial.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_partial.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_partial.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_partial.number_taxinvoice,7,4) IN '.$branch_id.') ';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqltp .= ' AND '.$db['fsctaccount'].'.taxinvoice_partial.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_partial.number_taxinvoice,7,4) IN '.$branch_id.' ';
          }
			}
        $datataxtp = DB::connection('mysql')->select($sqltp);


        $sqlro = 'SELECT '.$db['fsctaccount'].'.taxinvoice_partial_abb.*

               FROM '.$db['fsctaccount'].'.taxinvoice_partial_abb

                WHERE '.$db['fsctaccount'].'.taxinvoice_partial_abb.status = 1
               ';
			if($brfirst!='all'){
				// $sqlro .= ' AND '.$db['fsctaccount'].'.taxinvoice_partial_abb.branch_id IN '.$branch_id.' ';
          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqlro .= ' AND '.$db['fsctaccount'].'.taxinvoice_partial_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_partial_abb.branch_id IN '.$branch_id.' ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqlro .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_partial_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_partial_abb.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_partial_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_partial_abb.number_taxinvoice,7,4) IN '.$branch_id.') ';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqlro .= ' AND '.$db['fsctaccount'].'.taxinvoice_partial_abb.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_partial_abb.number_taxinvoice,7,4) IN '.$branch_id.' ';
          }
			}
        $datataxro = DB::connection('mysql')->select($sqlro);


        $sqlrs = 'SELECT '.$db['fsctaccount'].'.taxinvoice_special_abb.*

               FROM '.$db['fsctaccount'].'.taxinvoice_special_abb

                WHERE  '.$db['fsctaccount'].'.taxinvoice_special_abb.status = 1
               ';
			if($brfirst!='all'){
				// $sqlrs .= ' AND '.$db['fsctaccount'].'.taxinvoice_special_abb.branch_id IN '.$branch_id.' ';
          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqlrs .= ' AND '.$db['fsctaccount'].'.taxinvoice_special_abb.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_special_abb.branch_id IN '.$branch_id.' ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqlrs .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_special_abb.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_special_abb.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_special_abb.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_special_abb.number_taxinvoice,7,4) IN '.$branch_id.')
                        AND  '.$db['fsctaccount'].'.taxinvoice_special_abb.status = 1';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqlrs .= ' AND '.$db['fsctaccount'].'.taxinvoice_special_abb.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_special_abb.number_taxinvoice,7,4) IN '.$branch_id.'
                        AND  '.$db['fsctaccount'].'.taxinvoice_special_abb.status = 1';
          }
			}

      // echo $sqlrs;
      //
        $datataxrs = DB::connection('mysql')->select($sqlrs);


        $sqlss = 'SELECT '.$db['fsctmain'].'.stock_sell_head.*

               FROM '.$db['fsctmain'].'.stock_sell_head

                WHERE  '.$db['fsctmain'].'.stock_sell_head.status = 1
               ';
			if($brfirst!='all'){
				// $sqlss .= ' AND '.$db['fsctmain'].'.stock_sell_head.branch_id IN '.$branch_id.' ';
            if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
                // echo "<br>";
                // echo "oldcode";
                // echo "<br>";
                $sqlss .= ' AND '.$db['fsctmain'].'.stock_sell_head.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND '.$db['fsctmain'].'.stock_sell_head.branch_id IN '.$branch_id.' ';
            }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
                // echo "<br>";
                // echo "balance";
                // echo "<br>";
                $sqlss .= ' AND  ('.$db['fsctmain'].'.stock_sell_head.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND '.$db['fsctmain'].'.stock_sell_head.branch_id IN '.$branch_id.')
                          OR ('.$db['fsctmain'].'.stock_sell_head.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND substr('.$db['fsctmain'].'.stock_sell_head.bill_no,5,4) IN '.$branch_id.') ';


            }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
                // echo "<br>";
                // echo "newcode";
                // echo "<br>";
                $sqlss .= ' AND '.$db['fsctmain'].'.stock_sell_head.date_approved BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                          AND substr('.$db['fsctmain'].'.stock_sell_head.bill_no,5,4) IN '.$branch_id.' ';
            }

			}
      // echo $sqlss;
      //
        $datataxss = DB::connection('mysql')->select($sqlss);


        $sqlti = 'SELECT '.$db['fsctaccount'].'.taxinvoice_insurance.*

               FROM '.$db['fsctaccount'].'.taxinvoice_insurance

                WHERE  '.$db['fsctaccount'].'.taxinvoice_insurance.status = 1
               ';
			if($brfirst!='all'){
				// $sqlti .= ' AND '.$db['fsctaccount'].'.taxinvoice_insurance.branch_id IN '.$branch_id.' ';
          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqlti .= ' AND '.$db['fsctaccount'].'.taxinvoice_insurance.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_insurance.branch_id IN '.$branch_id.' 
						AND '.$db['fsctaccount'].'.taxinvoice_insurance.grandtotal != "0" ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqlti .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_insurance.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_insurance.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_insurance.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_insurance.number_taxinvoice,7,4) IN '.$branch_id.')  
						AND '.$db['fsctaccount'].'.taxinvoice_insurance.grandtotal != "0"';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqlti .= ' AND '.$db['fsctaccount'].'.taxinvoice_insurance.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_insurance.number_taxinvoice,7,4) IN '.$branch_id.'  
						AND '.$db['fsctaccount'].'.taxinvoice_insurance.grandtotal != "0"';
          }
			}
        $datataxti = DB::connection('mysql')->select($sqlti);


        $sqlci = 'SELECT '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.*

               FROM '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote

                WHERE   '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.status = 1
               ';
			if($brfirst!='all'){
				// $sqlci .= ' AND '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.branch_id IN '.$branch_id.' ';
          if($start_date2 <= $dateStartset && $end_date2 <= $dateStartset){
              // echo "<br>";
              // echo "oldcode";
              // echo "<br>";
              $sqlci .= ' AND '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.branch_id IN '.$branch_id.'   ';
          }else if($start_date2 <= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "balance";
              // echo "<br>";
              $sqlci .= ' AND  ('.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.branch_id IN '.$branch_id.')
                        OR ('.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.number_taxinvoice,7,4) IN '.$branch_id.')  ';


          }else if($start_date2 >= $dateStartset && $end_date2 >= $dateStartset){
              // echo "<br>";
              // echo "newcode";
              // echo "<br>";
              $sqlci .= ' AND '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.time BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND substr('.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.number_taxinvoice,7,4) IN '.$branch_id.'  ';
          }
			}
        $datataxci = DB::connection('mysql')->select($sqlci);

    //
    // echo $brfirst;
    // echo "<br>";


			if($brfirst!='all'){

        $sqlcash = 'SELECT '.$db['fsctaccount'].'.checkbank.*
                  FROM '.$db['fsctaccount'].'.checkbank

                   WHERE '.$db['fsctaccount'].'.checkbank.time  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                   AND '.$db['fsctaccount'].'.checkbank.status = "1"
                   AND '.$db['fsctaccount'].'.checkbank.branch_id IN '.$branch_id.'
                  ';
			}else{
        $sqlcash = 'SELECT '.$db['fsctaccount'].'.checkbank.*
                    FROM '.$db['fsctaccount'].'.checkbank

                     WHERE '.$db['fsctaccount'].'.checkbank.time  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                     AND '.$db['fsctaccount'].'.checkbank.status = "1"
                    ';
      }
    //   echo $sqlcash;
    //
         $datacash = DB::connection('mysql')->select($sqlcash);



        $sqlpo = 'SELECT '.$db['fsctaccount'].'.po_head.*

               FROM '.$db['fsctaccount'].'.po_head

                WHERE '.$db['fsctaccount'].'.po_head.po_date_ap  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                  AND '.$db['fsctaccount'].'.po_head.status_head IN (2,3,4,5)
               ';
			if($brfirst!='all'){
				$sqlpo .= ' AND '.$db['fsctaccount'].'.po_head.branch_id IN '.$branch_id.' ';
			}
        $datapo = DB::connection('mysql')->select($sqlpo);





         $sqljournal_general = 'SELECT '.$db['fsctaccount'].'.journal_5.*
                               FROM '.$db['fsctaccount'].'.journal_5
                                WHERE '.$db['fsctaccount'].'.journal_5.datebill  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                                  AND '.$db['fsctaccount'].'.journal_5.type_module = 4
                                  AND '.$db['fsctaccount'].'.journal_5.status = 1
               ';
			if($brfirst!='all'){
				$sqljournal_general .= ' AND '.$db['fsctaccount'].'.journal_5.code_branch IN '.$branch_id.' ';
			}



        $datajournal_general = DB::connection('mysql')->select($sqljournal_general);


        // $sqlbill = 'SELECT '.$db['fsctmain'].'.bill_rent.*
        //
        //        FROM '.$db['fsctmain'].'.bill_rent
        //
        //        INNER JOIN  '.$db['fsctmain'].'.bill_detail
        //                        ON '. $db['fsctmain'].'.bill_rent.id = '. $db['fsctmain'].'.bill_detail.bill_rent
        //
        //        INNER JOIN  '.$db['fsctmain'].'.material
        //                        ON '. $db['fsctmain'].'.bill_detail.material_id = '. $db['fsctmain'].'.material.id
        //
        //         WHERE '.$db['fsctmain'].'.bill_rent.branch_id = '.$branch_id.'
        //           AND '.$db['fsctmain'].'.bill_rent.startdate  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
        //           AND '.$db['fsctmain'].'.bill_rent.status IN (3,4)
        //        ';
        //
        // $databill = DB::connection('mysql')->select($sqlbill);
        //
        //
        // $sqlbillengine = 'SELECT '.$db['fsctmain'].'.billengine_rent.*
        //
        //        FROM '.$db['fsctmain'].'.billengine_rent
        //
        //        INNER JOIN  '.$db['fsctmain'].'.billengine_detail
        //                        ON '. $db['fsctmain'].'.billengine_rent.id = '. $db['fsctmain'].'.billengine_detail.bill_rent
        //
        //        INNER JOIN  '.$db['fsctmain'].'.engine
        //                        ON '. $db['fsctmain'].'.billengine_detail.material_id = '. $db['fsctmain'].'.engine.id
        //
        //         WHERE '.$db['fsctmain'].'.billengine_rent.branch_id = "'.$branch_id.'"
        //           AND '.$db['fsctmain'].'.billengine_rent.startdate  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
        //           AND '.$db['fsctmain'].'.billengine_rent.status IN (3,4)
        //        ';
        //
        // $databillengine = DB::connection('mysql')->select($sqlbillengine);


        // echo "<pre>";
        // print_r($databill);
        //

        return view('journal.journal_income',[
          'data'=>true,
          'datataxra'=>$datataxra,
          'datataxtf'=>$datataxtf,
          'datataxcn'=>$datataxcn,
          'datataxcs'=>$datataxcs,
          'datataxtk'=>$datataxtk,
          'datataxrl'=>$datataxrl,
          'datataxtm'=>$datataxtm,
          'datataxrn'=>$datataxrn,
          'datataxtp'=>$datataxtp,
          'datataxro'=>$datataxro,
          'datataxrs'=>$datataxrs,
          'datataxss'=>$datataxss,
          'datataxti'=>$datataxti,
          'datataxci'=>$datataxci,
          'datacash'=>$datacash,
          'datapo'=>$datapo,
          'datajournal_general'=>$datajournal_general,
          // 'databill'=>$databill,
          // 'databillengine'=>$databillengine,
          'datepicker'=>$data['daterange'],
          'branch'=>$branch_id
          // 'datepicker2'=>$datetime
        ]);

      }


      public function journalincome_filter(){

        $data = Input::all();
        $db = Connectdb::Databaseall();


        $idInsert = $data['check_list'];

        if(count($idInsert)>=100){

            return redirect()->action('Journal_incomeController@journal_income')->with('status', 'ทำรายการไม่เกินที่ละ 100 รายการ! กรุณาเลือกใหม่');


        }


        //$time = $data['time'];
        //$number_taxinvoice = $data['number_taxinvoice'];
        //$gettypemoney = $data['gettypemoney'];
        //$detail = $data['detail'];
        //$customerid = $data['customerid'];
        //$acc_code = $data['acc_code'];
        //$branch_id = $data['branch_id'];
        // $grandtotal = $data['grandtotal'];
        // $debit = $data['debit'];
        // $credit = $data['credit'];
        //$timereal = date('Y-m-d H:i:s');

        $emp_code = Session::get('emp_code');
        $dateStartset = '2020-06-05 00:00:00';
        // echo "<pre>";
        // print_r ($idInsert);
        // exit;
        //

		$arrvalue = [];

        // เช็คใน lg ว่ามี insert ไปแล้วหรือยัง
        foreach ($idInsert as $key => $value) {
                //$value  id  ไปหาใน id_type_ref_journal  type 4 คือ รับ
                $subData = explode(",",$value);
                $id = $subData[0];
                $typeRef = $subData[1];

                $sqlLg = 'SELECT '.$db['fsctaccount'].'.ledger.*
                            FROM '.$db['fsctaccount'].'.ledger
                            WHERE '.$db['fsctaccount'].'.ledger.id_type_ref_journal = "'.$id.'"
                            AND '.$db['fsctaccount'].'.ledger.type_journal  = 4
                            AND '.$db['fsctaccount'].'.ledger.type_buy =  "'.$typeRef.'" ';

                $lgResulte = DB::connection('mysql')->select($sqlLg);
                // echo "<pre>";
                // print_r ($lgResulte);
                //

        if(count($lgResulte)==0){

					//echo "Insert";
					//echo "<br>";
					//echo $id;
					//echo "===>";
					//echo $typeRef;

					// ===============================================  START RA (1) ===============================================//
					if($typeRef==1){ /// เช็ค ra ในกระดาษ
						$sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_abb.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_abb
								WHERE '.$db['fsctaccount'].'.taxinvoice_abb.id = "'.$id.'" ';
						$datataxra = DB::connection('mysql')->select($sqlra);

            ///      Update  status_approved
            $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_abb
                      SET status_ap = "1"
                      WHERE '.$db['fsctaccount'].'.taxinvoice_abb.id = "'.$id.'" ';

            $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            ///     Update status msg alert hr
            $brach = $datataxra[0]->branch_id;
            $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                      SET status = "99"
                      WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                      AND '.$db['hr_base'].'.msgalert.type_doc  = "1"
                      AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

            $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);



						// =================================  RA  เงินสด   =================================  / /
						if($datataxra[0]->gettypemoney==1){
							$accCode = Accountcenter::accincome();
              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }

              $company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);


							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount cash
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							}// =================================  สิ้นสุด RA  เงินสด   =================================  / /

						// =================================  RA  เงินโอน   =================================  / /

						if($datataxra[0]->gettypemoney==2){
							$accCode = Accountcenter::accincome();

              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }


							$company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RA  เงินโอน   =================================  / /

						// =================================  RA  เงินสดและโอน   =================================  / /

						if($datataxra[0]->gettypemoney==3){
							$accCode = Accountcenter::accincome();

              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }


							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								$bill_rent = $datataxra[0]->bill_rent;
								$idtax = $datataxra[0]->id;

								$sqlinsertcash = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "1"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
								$drcash = $datainsertcash[0]->money;

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drcash,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  ra  bank
								$sqlinsertbank = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "2"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
								$drbank = $datainsertbank[0]->money;

								$list =  $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drbank,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timereal'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RA  เงินสดและโอน   =================================  / /

						// =================================  RA  เงินเช็ค  =================================  / /
						if($datataxra[0]->gettypemoney==4){
							$accCode = Accountcenter::accincome();

                $time =$datataxra[0]->time;
                  if($time >= $dateStartset){
                      // echo "new";
                      $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                  }else{
                      $branch_id = $datataxra[0]->branch_id;
                      //echo "old";
                  }


							$company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $accnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RA  เงินเช็ค   =================================  / /

							// =================================  RA  etc  =================================  //
							if($datataxra[0]->gettypemoney==5){

							}
							// =================================  RA  etc  =================================  //

					}

					// ===============================================  END RA  ===============================================//


					// ===============================================  START TF (2) ===============================================//


					if($typeRef==2){ /// เช็ค TF ในกระดาษ

						$sqltf = 'SELECT '.$db['fsctaccount'].'.taxinvoice.*
							    FROM '.$db['fsctaccount'].'.taxinvoice
								WHERE '.$db['fsctaccount'].'.taxinvoice.id = "'.$id.'" ';
						$datataxtf = DB::connection('mysql')->select($sqltf);

						$bill_rent = $datataxtf[0]->bill_rent;
						$idtaxra = $datataxtf[0]->taxabb;

						$sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_abb.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_abb
								WHERE '.$db['fsctaccount'].'.taxinvoice_abb.id = "'.$idtaxra.'"
								AND	bill_rent = "'.$bill_rent.'" ';
						$datataxra = DB::connection('mysql')->select($sqlra);

							// ====== update lg ====== //

						$sqlUpdateLg = ' UPDATE '.$db['fsctaccount'].'.ledger
											SET status = "99"
											WHERE '.$db['fsctaccount'].'.ledger.id_type_ref_journal = "'.$idtaxra.'"
											AND '.$db['fsctaccount'].'.ledger.type_journal  = 4
											AND '.$db['fsctaccount'].'.ledger.type_buy =  "'.$typeRef.'" ';

						$lgUpdateResulte = DB::connection('mysql')->select($sqlUpdateLg);

            ///      Update  status_approved
      			$sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice
      					  SET status_ap = "1"
      					  WHERE '.$db['fsctaccount'].'.taxinvoice.id = "'.$id.'" ';

      			$lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            ///     Update status msg alert hr
            $brach =  $datataxra[0]->branch_id;
            $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                      SET status = "99"
                      WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                      AND '.$db['hr_base'].'.msgalert.type_doc  = "2"
                      AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

            $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


            //
					  // echo "Strg";
						//
						// =================================  TF  เงินสด   =================================  / /
						if($datataxra[0]->gettypemoney==1){
							$accCode = Accountcenter::accincome();

							// $branch_id = $datataxtf[0]->branch_id;
              $time =$datataxra[0]->time;
                if($time >= $dateStartset){
                    // echo "new";
                    $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                }else{
                    $branch_id = $datataxra[0]->branch_id;
                    //echo "old";
                }
                // echo $branch_id;
                //
              $company_id = $datataxtf[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);

							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด  TF  cash
								$list = 'รับเงินค่าเช่าจาก'.$datataxtf[0]->customerid;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount cash
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							}// =================================  สิ้นสุด TF  เงินสด   =================================  / /


						// =================================  TF  เงินโอน   =================================  / /

						if($datataxra[0]->gettypemoney==2){
							$accCode = Accountcenter::accincome();
              $time =$datataxra[0]->time;
                if($time >= $dateStartset){
                    // echo "new";
                    $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                }else{
                    $branch_id = $datataxra[0]->branch_id;
                    //echo "old";
                }
							$company_id = $datataxtf[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด TF  เงินโอน   =================================  / /

						// =================================  TF  เงินสดและโอน   =================================  / /

						if($datataxra[0]->gettypemoney==3){
							$accCode = Accountcenter::accincome();
              $time =$datataxra[0]->time;
                if($time >= $dateStartset){
                    // echo "new";
                    $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                }else{
                    $branch_id = $datataxra[0]->branch_id;
                    //echo "old";
                }
							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);



								$sqlinsertcash = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "1"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
								$drcash = $datainsertcash[0]->money;

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drcash,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  ra  bank
								$sqlinsertbank = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "2"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
								$drbank = $datainsertbank[0]->money;

								$list =  $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drbank,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด TF  เงินสดและโอน   =================================  / /

						// =================================  TF  เงินเช็ค  =================================  / /
						if($datataxra[0]->gettypemoney==4){
							$accCode = Accountcenter::accincome();
              $time =$datataxra[0]->time;
                if($time >= $dateStartset){
                    // echo "new";
                    $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                }else{
                    $branch_id = $datataxra[0]->branch_id;
                    //echo "old";
                }
							$company_id = $datataxtf[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด TF  เงินเช็ค   =================================  / /

							// =================================  TF  etc  =================================  //
							if($datataxra[0]->gettypemoney==5){

							}
							// =================================  TF  etc  =================================  //

					}


					// ===============================================  END TF  ===============================================//


					// ===============================================  START TK (3) ===============================================//

					if($typeRef==3){ /// เช็ค TK ในกระดาษ
						$sqltk = 'SELECT '.$db['fsctaccount'].'.taxinvoice_loss.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_loss
								WHERE '.$db['fsctaccount'].'.taxinvoice_loss.id = "'.$id.'" ';
						$datataxtk = DB::connection('mysql')->select($sqltk);

						$bill_rent = $datataxtk[0]->bill_rent;
						$idtaxrl = $datataxtk[0]->taxabb;

						$sqlrl = 'SELECT '.$db['fsctaccount'].'.taxinvoice_loss_abb.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_loss_abb
								WHERE '.$db['fsctaccount'].'.taxinvoice_loss_abb.id = "'.$idtaxrl.'"
								AND	bill_rent = "'.$bill_rent.'" ';
						$datataxrl = DB::connection('mysql')->select($sqlrl);

							// ====== update lg ====== //

						$sqlUpdateLg = ' UPDATE '.$db['fsctaccount'].'.ledger
											SET status = "99"
											WHERE '.$db['fsctaccount'].'.ledger.id_type_ref_journal = "'.$idtaxrl.'"
											AND '.$db['fsctaccount'].'.ledger.type_journal  = 4
											AND '.$db['fsctaccount'].'.ledger.type_buy =  "'.$typeRef.'" ';

						$lgUpdateResulte = DB::connection('mysql')->select($sqlUpdateLg);

            $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_loss
					  SET status_ap = "1"
					  WHERE '.$db['fsctaccount'].'.taxinvoice_loss.id = "'.$id.'" ';

			      $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            $brach =  $datataxrl[0]->branch_id;
            $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                      SET status = "99"
                      WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                      AND '.$db['hr_base'].'.msgalert.type_doc  = "3"
                      AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

            $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);



						// =================================  TK  เงินสด   =================================  / /
						if($datataxrl[0]->gettypemoney==1){
							$accCode = Accountcenter::accincome();

							// $branch_id = $datataxtk[0]->branch_id;
              $time =$datataxtk[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxtk[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxtk[0]->branch_id;
                   //echo "old";
               }


							$company_id = $datataxtk[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);

							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
							$number_bill = $datataxtk[0]->number_taxinvoice;
							$customerid = $datataxtk[0]->customerid;
							$subtotal = $datataxtk[0]->subtotal;
							$discount = 0;
							$discountmoney = 0;
							$vat = $datataxtk[0]->vat;
							$vatmoney = $datataxtk[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxtk[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด  TF  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxtk[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxtk[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>3];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount cash
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney cash
								// if($wht!=0.00){
								// 	$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
								// 	$accwht= $accCode['accwht'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$whtmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accwht,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxtk[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxtk[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>3];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);




              // insert เงินสด vat cash
              $list = 'กำไร(ขาดทุน)';
              $accdrcr= '322102';
                  $arrInert = [ 'id'=>'',
                        'dr'=>'0',
                        'cr'=>$grandtotal-$vatmoney,
                        'acc_code'=>$accdrcr,
                        'branch'=>$branch_id,
                        'status'=> 1,
                        'number_bill'=> $number_bill,
                        'customer_vendor'=>$customerid,
                        'timestamp'=>$datataxtk[0]->time,
                        'code_emp'=> $emp_code,
                        'subtotal'=> $subtotal,
                        'discount'=> $discount,
                        'vat'=> $vat,
                        'vatmoney'=> $vatmoney,
                        'wht'=> $wht,
                        'whtmoney'=> $whtmoney,
                        'grandtotal'=> $grandtotal,
                        'type_income'=>'1' ,
                        'type_journal'=>4 ,
                        'id_type_ref_journal'=>$datataxtk[0]->id,
                        'timereal'=>date('Y-m-d H:i:s'),
                        'list'=> $list,
                        'type_buy'=>3];

                DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);









							}// =================================  สิ้นสุด TK  เงินสด   =================================  / /


						// =================================  TK  เงินโอน   =================================  / /

						if($datataxrl[0]->gettypemoney==2){
							$accCode = Accountcenter::accincome();
							//$branch_id = $datataxtk[0]->branch_id;
              $time =$datataxtk[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxtk[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxtk[0]->branch_id;
                   //echo "old";
               }
							$company_id = $datataxtk[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxtk[0]->number_taxinvoice;
							$customerid = $datataxtk[0]->customerid;
							$subtotal = $datataxtk[0]->subtotal;
							$discount = 0;
							$discountmoney = 0;
							$vat = $datataxtk[0]->vat;
							$vatmoney = $datataxtk[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxtk[0]->grandtotal;


							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxtk[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxtk[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>3];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// // insert เงินสด whtmoney bank
								// if($wht!=0.00){
								// 	$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
								// 	$accwht= $accCode['accwht'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$whtmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accwht,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxtk[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxtk[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>3];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  // insert เงินสด vat cash
                  $list = 'กำไร(ขาดทุน)';
                  $accdrcr= '322102';
                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$grandtotal-$vatmoney,
                            'acc_code'=>$accdrcr,
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$customerid,
                            'timestamp'=>$datataxtk[0]->time,
                            'code_emp'=> $emp_code,
                            'subtotal'=> $subtotal,
                            'discount'=> $discount,
                            'vat'=> $vat,
                            'vatmoney'=> $vatmoney,
                            'wht'=> $wht,
                            'whtmoney'=> $whtmoney,
                            'grandtotal'=> $grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datataxtk[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>3];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							} // =================================  สิ้นสุด TK  เงินโอน   =================================  / /

						// =================================  TK  เงินสดและโอน   =================================  / /

						if($datataxrl[0]->gettypemoney==3){
							$accCode = Accountcenter::accincome();
							//$branch_id = $datataxra[0]->branch_id;
              $time =$datataxtk[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxtk[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxtk[0]->branch_id;
                   //echo "old";
               }
              $company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							$acccash = $accCode['acccash'];
							$number_bill = $datataxtk[0]->number_taxinvoice;
							$customerid = $datataxtk[0]->customerid;
							$subtotal = $datataxtk[0]->subtotal;
							$discount = 0;
							$discountmoney = 0;
							$vat = $datataxtk[0]->vat;
							$vatmoney = $datataxtk[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxtk[0]->grandtotal;


							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);



								$sqlinsertcash = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "1"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
								$drcash = $datainsertcash[0]->money;

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drcash,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxtk[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxtk[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>3];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  ra  bank
								$sqlinsertbank = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "2"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
								$drbank = $datainsertbank[0]->money;

								$list =  $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drbank,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxtk[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxtk[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>3];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney cash
								// if($wht!=0.00){
								// 	$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
								// 	$accwht= $accCode['accwht'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$whtmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accwht,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxtk[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxtk[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>3];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                    // insert เงินสด vat cash
                    $list = 'กำไร(ขาดทุน)';
                    $accdrcr= '322102';
                        $arrInert = [ 'id'=>'',
                              'dr'=>'0',
                              'cr'=>$grandtotal-$vatmoney,
                              'acc_code'=>$accdrcr,
                              'branch'=>$branch_id,
                              'status'=> 1,
                              'number_bill'=> $number_bill,
                              'customer_vendor'=>$customerid,
                              'timestamp'=>$datataxtk[0]->time,
                              'code_emp'=> $emp_code,
                              'subtotal'=> $subtotal,
                              'discount'=> $discount,
                              'vat'=> $vat,
                              'vatmoney'=> $vatmoney,
                              'wht'=> $wht,
                              'whtmoney'=> $whtmoney,
                              'grandtotal'=> $grandtotal,
                              'type_income'=>'1' ,
                              'type_journal'=>4 ,
                              'id_type_ref_journal'=>$datataxtk[0]->id,
                              'timereal'=>date('Y-m-d H:i:s'),
                              'list'=> $list,
                              'type_buy'=>3];

                      DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							} // =================================  สิ้นสุด TK  เงินสดและโอน   =================================  / /

						// =================================  TK  เงินเช็ค  =================================  / /
						if($datataxrl[0]->gettypemoney==4){
							$accCode = Accountcenter::accincome();
							//$branch_id = $datataxtk[0]->branch_id;
              $time =$datataxtk[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxtk[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxtk[0]->branch_id;
                   //echo "old";
               }
							$company_id = $datataxtk[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxtk[0]->number_taxinvoice;
							$customerid = $datataxtk[0]->customerid;
							$subtotal = $datataxtk[0]->subtotal;
							$discount = 0;
							$discountmoney = 0;
							$vat = $datataxtk[0]->vat;
							$vatmoney = $datataxtk[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxtk[0]->grandtotal;


							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxtk[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxtk[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>3];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney bank
								// if($wht!=0.00){
								// 	$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
								// 	$accwht= $accCode['accwht'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$whtmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accwht,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxtk[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxtk[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>3];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxtk[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxtk[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>3];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  // insert เงินสด vat cash
                  $list = 'กำไร(ขาดทุน)';
                  $accdrcr= '322102';
                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$grandtotal-$vatmoney,
                            'acc_code'=>$accdrcr,
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$customerid,
                            'timestamp'=>$datataxtk[0]->time,
                            'code_emp'=> $emp_code,
                            'subtotal'=> $subtotal,
                            'discount'=> $discount,
                            'vat'=> $vat,
                            'vatmoney'=> $vatmoney,
                            'wht'=> $wht,
                            'whtmoney'=> $whtmoney,
                            'grandtotal'=> $grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datataxtk[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>3];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
							} // =================================  สิ้นสุด TK  เงินเช็ค   =================================  / /

							// =================================  TK  etc  =================================  //
							if($datataxtk[0]->gettypemoney==5){

							}
							// =================================  TK  etc  =================================  //

					}


					// ===============================================  END TK  ===============================================//

					// ===============================================  START  (4) ===============================================//


					if($typeRef==4){ /// เช็ค rl ในกระดาษ
						$sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_loss_abb.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_loss_abb
								WHERE '.$db['fsctaccount'].'.taxinvoice_loss_abb.id = "'.$id.'" ';
						$datataxra = DB::connection('mysql')->select($sqlra);
						$bill_rent = $datataxra[0]->bill_rent;
						$type = $datataxra[0]->type;
						$modelmaterial_rl = Maincenter::getdatamaterial_rl($id,$bill_rent,$type);
						$totalpricedepreciation = $modelmaterial_rl[0]->totalpricedepreciation;


            $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_loss_abb
					  SET status_ap = "1"
					  WHERE '.$db['fsctaccount'].'.taxinvoice_loss_abb.id = "'.$id.'" ';

      			$lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            $brach =  $datataxra[0]->branch_id;
            $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                       SET status = "99"
                       WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                       AND '.$db['hr_base'].'.msgalert.type_doc  = "4"
                       AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

             $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


						// =================================    เงินสด   =================================  / /
						if($datataxra[0]->gettypemoney==1){
							$accCode = Accountcenter::accincome();

							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxra[0]->branch_id;
                   //echo "old";
               }

              $company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);

							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = 0;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด rl  cash
								$list = "เงินสด";
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>4];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า

								// $list = 'ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า ';
								// $accaccdepreciation= $accCode['accdepreciation'];
								// 	$arrInert = [ 'id'=>'',
								// 				  'dr'=>$totalpricedepreciation,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdepreciation,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>4];
                //
								// DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //
                //
                //
                //
								// // insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>4];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>4];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  // insert เงินสด vat cash
                  $list = 'กำไร(ขาดทุน)';
                  $accdrcr= '322102';
                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$grandtotal-$vatmoney,
                            'acc_code'=>$accdrcr,
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$customerid,
                            'timestamp'=>$datataxra[0]->time,
                            'code_emp'=> $emp_code,
                            'subtotal'=> $subtotal,
                            'discount'=> $discount,
                            'vat'=> $vat,
                            'vatmoney'=> $vatmoney,
                            'wht'=> $wht,
                            'whtmoney'=> $whtmoney,
                            'grandtotal'=> $grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datataxra[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>3];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							}// =================================  สิ้นสุด   เงินสด   =================================  / /

						// =================================    เงินโอน   =================================  / /

						if($datataxra[0]->gettypemoney==2){
							$accCode = Accountcenter::accincome();

							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxra[0]->branch_id;
                   //echo "old";
               }

							$company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = 0;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>4];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า

								// $list = 'ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า ';
								// $accaccdepreciation= $accCode['accdepreciation'];
								// 	$arrInert = [ 'id'=>'',
								// 				  'dr'=>$totalpricedepreciation,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdepreciation,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>4];
                //
								// DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //
                //
								// // insert  เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>4];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>4];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                // insert เงินสด vat cash
                $list = 'กำไร(ขาดทุน)';
                $accdrcr= '322102';
                    $arrInert = [ 'id'=>'',
                          'dr'=>'0',
                          'cr'=>$grandtotal-$vatmoney,
                          'acc_code'=>$accdrcr,
                          'branch'=>$branch_id,
                          'status'=> 1,
                          'number_bill'=> $number_bill,
                          'customer_vendor'=>$customerid,
                          'timestamp'=>$datataxra[0]->time,
                          'code_emp'=> $emp_code,
                          'subtotal'=> $subtotal,
                          'discount'=> $discount,
                          'vat'=> $vat,
                          'vatmoney'=> $vatmoney,
                          'wht'=> $wht,
                          'whtmoney'=> $whtmoney,
                          'grandtotal'=> $grandtotal,
                          'type_income'=>'1' ,
                          'type_journal'=>4 ,
                          'id_type_ref_journal'=>$datataxra[0]->id,
                          'timereal'=>date('Y-m-d H:i:s'),
                          'list'=> $list,
                          'type_buy'=>3];

                  DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							} // =================================  สิ้นสุด   เงินโอน   =================================  / /

						// =================================    เงินสดและโอน   =================================  / /

						if($datataxra[0]->gettypemoney==3){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxra[0]->branch_id;
                   //echo "old";
               }
							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = 0;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								$bill_rent = $datataxra[0]->bill_rent;
								$idtax = $datataxra[0]->id;

								$sqlinsertcash = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "1"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
								$drcash = $datainsertcash[0]->money;

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drcash,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>4];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  ra  bank
								$sqlinsertbank = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "2"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
								$drbank = $datainsertbank[0]->money;

								$list =  $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drbank,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>4];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							 	// insert เงินสด ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า

								// $list = 'ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า ';
								// $accaccdepreciation= $accCode['accdepreciation'];
								// 	$arrInert = [ 'id'=>'',
								// 				  'dr'=>$totalpricedepreciation,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdepreciation,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>4];
                //
								// DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //
                //
                //
								// // insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>4];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>4];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                $list = 'กำไร(ขาดทุน)';
                $accdrcr= '322102';
                    $arrInert = [ 'id'=>'',
                          'dr'=>'0',
                          'cr'=>$grandtotal-$vatmoney,
                          'acc_code'=>$accdrcr,
                          'branch'=>$branch_id,
                          'status'=> 1,
                          'number_bill'=> $number_bill,
                          'customer_vendor'=>$customerid,
                          'timestamp'=>$datataxra[0]->time,
                          'code_emp'=> $emp_code,
                          'subtotal'=> $subtotal,
                          'discount'=> $discount,
                          'vat'=> $vat,
                          'vatmoney'=> $vatmoney,
                          'wht'=> $wht,
                          'whtmoney'=> $whtmoney,
                          'grandtotal'=> $grandtotal,
                          'type_income'=>'1' ,
                          'type_journal'=>4 ,
                          'id_type_ref_journal'=>$datataxra[0]->id,
                          'timereal'=>date('Y-m-d H:i:s'),
                          'list'=> $list,
                          'type_buy'=>3];

                  DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							} // =================================  สิ้นสุด   เงินสดและโอน   =================================  / /

						// =================================    เงินเช็ค  =================================  / /
						if($datataxra[0]->gettypemoney==4){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxra[0]->branch_id;
                   //echo "old";
               }
							$company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = 0;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $accnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>4];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า

								// $list = 'ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า ';
								// $accaccdepreciation= $accCode['accdepreciation'];
								// 	$arrInert = [ 'id'=>'',
								// 				  'dr'=>$totalpricedepreciation,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdepreciation,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>4];
                //
								// DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //
								// // insert  เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>4];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>4];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  $list = 'กำไร(ขาดทุน)';
                  $accdrcr= '322102';
                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$grandtotal-$vatmoney,
                            'acc_code'=>$accdrcr,
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$customerid,
                            'timestamp'=>$datataxra[0]->time,
                            'code_emp'=> $emp_code,
                            'subtotal'=> $subtotal,
                            'discount'=> $discount,
                            'vat'=> $vat,
                            'vatmoney'=> $vatmoney,
                            'wht'=> $wht,
                            'whtmoney'=> $whtmoney,
                            'grandtotal'=> $grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datataxra[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>3];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							} // =================================  สิ้นสุด   เงินเช็ค   =================================  / /

							// =================================    etc  =================================  //
							if($datataxra[0]->gettypemoney==5){

							}
							// =================================    etc  =================================  //

					}

					// ===============================================  END   ===============================================//

					// ===============================================  START TM (5) ===============================================//
						if($typeRef==5){ /// เช็ค TM ในกระดาษ
						$sqltf = 'SELECT '.$db['fsctaccount'].'.taxinvoice_more.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_more
								WHERE '.$db['fsctaccount'].'.taxinvoice_more.id = "'.$id.'" ';
						$datataxtf = DB::connection('mysql')->select($sqltf);

						$bill_rent = $datataxtf[0]->bill_rent;
						$idtaxra = $datataxtf[0]->taxabb;

						$sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_more_abb.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_more_abb
								WHERE '.$db['fsctaccount'].'.taxinvoice_more_abb.id = "'.$idtaxra.'"
								AND	bill_rent = "'.$bill_rent.'" ';
						$datataxra = DB::connection('mysql')->select($sqlra);

							// ====== update lg ====== //

						$sqlUpdateLg = ' UPDATE '.$db['fsctaccount'].'.ledger
											SET status = "99"
											WHERE '.$db['fsctaccount'].'.ledger.id_type_ref_journal = "'.$idtaxra.'"
											AND '.$db['fsctaccount'].'.ledger.type_journal  = 4
											AND '.$db['fsctaccount'].'.ledger.type_buy =  "'.$typeRef.'" ';

						$lgUpdateResulte = DB::connection('mysql')->select($sqlUpdateLg);

            $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_more
          					  SET status_ap = "1"
          					  WHERE '.$db['fsctaccount'].'.taxinvoice_more.id = "'.$id.'" ';
      			$lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            $brach =  $datataxra[0]->branch_id;
             $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                       SET status = "99"
                       WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                       AND '.$db['hr_base'].'.msgalert.type_doc  = "5"
                       AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

             $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);

						//print_r($datataxra);
						//
						// =================================  TM  เงินสด   =================================  / /
						if($datataxra[0]->gettypemoney==1){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxtf[0]->branch_id;
              $time =$datataxtf[0]->time;
                 if($time >= $dateStartset){
                     // echo "new";
                     $branch_id =  substr($datataxtf[0]->number_taxinvoice,6,4);
                 }else{
                     $branch_id = $datataxtf[0]->branch_id;
                     //echo "old";
                 }


							$company_id = $datataxtf[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);

							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด  TM  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>5];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount cash
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							}// =================================  สิ้นสุด TM  เงินสด   =================================  / /


						// =================================  TM  เงินโอน   =================================  / /

						if($datataxra[0]->gettypemoney==2){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxtf[0]->branch_id;
              $time =$datataxtf[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxtf[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxtf[0]->branch_id;
                   //echo "old";
               }
							$company_id = $datataxtf[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>5];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด TM  เงินโอน   =================================  / /

						// =================================  TM  เงินสดและโอน   =================================  / /

						if($datataxra[0]->gettypemoney==3){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxtf[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxtf[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxtf[0]->branch_id;
                   //echo "old";
               }
							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);



								$sqlinsertcash = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "1"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
								$drcash = $datainsertcash[0]->money;

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drcash,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>5];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  ra  bank
								$sqlinsertbank = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "2"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
								$drbank = $datainsertbank[0]->money;

								$list =  $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drbank,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>5];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด TM  เงินสดและโอน   =================================  / /

						// =================================  TM  เงินเช็ค  =================================  / /
						if($datataxra[0]->gettypemoney==4){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxtf[0]->branch_id;
              $time =$datataxtf[0]->time;
               if($time >= $dateStartset){
                   // echo "new";
                   $branch_id =  substr($datataxtf[0]->number_taxinvoice,6,4);
               }else{
                   $branch_id = $datataxtf[0]->branch_id;
                   //echo "old";
               }
							$company_id = $datataxtf[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>5];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>5];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด TM  เงินเช็ค   =================================  / /

							// =================================  TM  etc  =================================  //
							if($datataxra[0]->gettypemoney==5){

							}
							// =================================  TM  etc  =================================  //

					}


					// ===============================================  END TM  ===============================================//


					// ===============================================  START RN (6) ===============================================//

					if($typeRef==6){ /// เช็ค rn ในกระดาษ
						$sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_more_abb.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_more_abb
								WHERE '.$db['fsctaccount'].'.taxinvoice_more_abb.id = "'.$id.'" ';
						$datataxra = DB::connection('mysql')->select($sqlra);

            $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_more_abb
                  SET status_ap = "1"
                  WHERE '.$db['fsctaccount'].'.taxinvoice_more_abb.id = "'.$id.'" ';
            $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            $brach =  $datataxra[0]->branch_id;
            $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                      SET status = "99"
                      WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                      AND '.$db['hr_base'].'.msgalert.type_doc  = "1"
                      AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';
            $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);




						// =================================  RN  เงินสด   =================================  / /
						if($datataxra[0]->gettypemoney==1){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }
							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);

							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>6];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount cash
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							}// =================================  สิ้นสุด RN  เงินสด   =================================  / /

						// =================================  RN  เงินโอน   =================================  / /

						if($datataxra[0]->gettypemoney==2){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }
							$company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>6];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RN  เงินโอน   =================================  / /

						// =================================  RN  เงินสดและโอน   =================================  / /

						if($datataxra[0]->gettypemoney==3){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }
							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								$bill_rent = $datataxra[0]->bill_rent;
								$idtax = $datataxra[0]->id;

								$sqlinsertcash = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "1"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
								$drcash = $datainsertcash[0]->money;

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drcash,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>6];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  ra  bank
								$sqlinsertbank = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "2"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
								$drbank = $datainsertbank[0]->money;

								$list =  $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drbank,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>6];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RN  เงินสดและโอน   =================================  / /

						// =================================  RN  เงินเช็ค  =================================  / /
						if($datataxra[0]->gettypemoney==4){
							$accCode = Accountcenter::accincome();
							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }
							$company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $accnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>6];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>6];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RN  เงินเช็ค   =================================  / /

							// =================================  RN  etc  =================================  //
							if($datataxra[0]->gettypemoney==5){

							}
							// =================================  RN  etc  =================================  //

					}



					// ===============================================  END RN  ===============================================//

					// ===============================================  START TP (7) ===============================================//

					if($typeRef==7){ /// เช็ค TP ในกระดาษ
						$sqltf = 'SELECT '.$db['fsctaccount'].'.taxinvoice_partial.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_partial
								WHERE '.$db['fsctaccount'].'.taxinvoice_partial.id = "'.$id.'" ';
						$datataxtf = DB::connection('mysql')->select($sqltf);

						$bill_rent = $datataxtf[0]->bill_rent;
						$idtaxra = $datataxtf[0]->taxabb;

						$sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_partial_abb.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_partial_abb
								WHERE '.$db['fsctaccount'].'.taxinvoice_partial_abb.id = "'.$idtaxra.'"
								AND	bill_rent = "'.$bill_rent.'" ';
						$datataxra = DB::connection('mysql')->select($sqlra);

							// ====== update lg ====== //

						$sqlUpdateLg = ' UPDATE '.$db['fsctaccount'].'.ledger
											SET status = "99"
											WHERE '.$db['fsctaccount'].'.ledger.id_type_ref_journal = "'.$idtaxra.'"
											AND '.$db['fsctaccount'].'.ledger.type_journal  = 4
											AND '.$db['fsctaccount'].'.ledger.type_buy =  "'.$typeRef.'" ';

						$lgUpdateResulte = DB::connection('mysql')->select($sqlUpdateLg);


            $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_partial
                  SET status_ap = "1"
                  WHERE '.$db['fsctaccount'].'.taxinvoice_partial.id = "'.$id.'" ';

            $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            $brach =  $datataxra[0]->branch_id;
             $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                       SET status = "99"
                       WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                       AND '.$db['hr_base'].'.msgalert.type_doc  = "7"
                       AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

             $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);

			
						//print_r($datataxra);
						//
						// =================================  TP  เงินสด   =================================  / /
						if($datataxtf[0]->gettypemoney==1){
							$accCode = Accountcenter::accincome();
							$branch_id = $datataxtf[0]->branch_id;
							$company_id = $datataxtf[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);

							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = 0;
							$discountmoney = $subtotal*($discount/100);

							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
              $thisprice = $subtotal - $discountmoney + $vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด  TP  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$thisprice,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount cash
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>2];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'ลูกหนี้การค้า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['accdebtor'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotal,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								// $list = 'ภาษีขาย';
								// $accvat= $accCode['accvat'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$vatmoney,
								// 				  'acc_code'=>$accvat,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>2];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							}// =================================  สิ้นสุด TP  เงินสด   =================================  / /


						// =================================  TP  เงินโอน   =================================  / /

						if($datataxtf[0]->gettypemoney==2){
							 
							$accCode = Accountcenter::accincome();
							$branch_id = $datataxtf[0]->branch_id;
							$company_id = $datataxtf[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = 0;
							$discountmoney = $subtotal*($discount/100);

							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
              $thisprice = $subtotal - $discountmoney + $vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$thisprice,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>2];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'ลูกหนี้การค้า  ';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['accdebtor'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotal,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								// $list = 'ภาษีขาย';
								// $accvat= $accCode['accvat'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$vatmoney,
								// 				  'acc_code'=>$accvat,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>2];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								
							


							} // =================================  สิ้นสุด TP  เงินโอน   =================================  / /

						// =================================  TP  เงินสดและโอน   =================================  / /

						if($datataxtf[0]->gettypemoney==3){
							$accCode = Accountcenter::accincome();
							$branch_id = $datataxra[0]->branch_id;
							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);



								$sqlinsertcash = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "1"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
								$drcash = $datainsertcash[0]->money;

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drcash,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  ra  bank
								$sqlinsertbank = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "2"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
								$drbank = $datainsertbank[0]->money;

								$list =  $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drbank,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>2];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
                $list = 'ลูกหนี้การค้า  ';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['accdebtor'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								// $list = 'ภาษีขาย';
								// $accvat= $accCode['accvat'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$vatmoney,
								// 				  'acc_code'=>$accvat,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>2];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด TP  เงินสดและโอน   =================================  / /

						// =================================  TP  เงินเช็ค  =================================  / /
						if($datataxtf[0]->gettypemoney==4){
							$accCode = Accountcenter::accincome();
							$branch_id = $datataxtf[0]->branch_id;
							$company_id = $datataxtf[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxtf[0]->number_taxinvoice;
							$customerid = $datataxtf[0]->customerid;
							$subtotal = $datataxtf[0]->subtotal;
							$discount = $datataxtf[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxtf[0]->vat;
							$vatmoney = $datataxtf[0]->vatmoney;
							$wht = $datataxtf[0]->withhold;
							$whtmoney = $datataxtf[0]->withholdmoney;
							$grandtotal = $datataxtf[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>2];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>2];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด TP  เงินเช็ค   =================================  / /

							// =================================  TP  etc  =================================  //
							if($datataxra[0]->gettypemoney==5){

							}
							// =================================  TP  etc  =================================  //

					}


					// ===============================================  END TP  ===============================================//



					// ===============================================  START RO (8) ===============================================//

					if($typeRef==8){ /// เช็ค RO ในกระดาษ
						$sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_abb.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_abb
								WHERE '.$db['fsctaccount'].'.taxinvoice_abb.id = "'.$id.'" ';
						$datataxra = DB::connection('mysql')->select($sqlra);

						// =================================  RO  เงินสด   =================================  / /
						if($datataxra[0]->gettypemoney==1){
							$accCode = Accountcenter::accincome();
							$branch_id = $datataxra[0]->branch_id;
							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);

							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
              $thisprice = $subtotal - $discountmoney + $vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$thisprice,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount cash
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>1];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
                $list = 'ลูกหนี้การค้า';
                $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
                $acctool= $accCode['accdebtor'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotal,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// // insert เงินสด vat cash
								// $list = 'ภาษีขาย';
								// $accvat= $accCode['accvat'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$vatmoney,
								// 				  'acc_code'=>$accvat,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>1];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							}// =================================  สิ้นสุด RO  เงินสด   =================================  / /

						// =================================  RO  เงินโอน   =================================  / /

						if($datataxra[0]->gettypemoney==2){
							$accCode = Accountcenter::accincome();
							$branch_id = $datataxra[0]->branch_id;
							$company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
              $thisprice = $subtotal - $discountmoney + $vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>1];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
                $list = 'ลูกหนี้การค้า';
                $grandtotal;
                $acctool= $accCode['accdebtor'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotal,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								// $list = 'ภาษีขาย';
								// $accvat= $accCode['accvat'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$vatmoney,
								// 				  'acc_code'=>$accvat,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>1];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RO  เงินโอน   =================================  / /

						// =================================  RO  เงินสดและโอน   =================================  / /

						if($datataxra[0]->gettypemoney==3){
							$accCode = Accountcenter::accincome();
							$branch_id = $datataxra[0]->branch_id;
							$company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
              $thisprice = $subtotal - $discountmoney + $vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								$bill_rent = $datataxra[0]->bill_rent;
								$idtax = $datataxra[0]->id;

								$sqlinsertcash = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "1"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
								$drcash = $datainsertcash[0]->money;

								// insert เงินสด ra  cash
								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drcash,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  ra  bank
								$sqlinsertbank = 'SELECT *
													FROM '.$db['fsctaccount'].'.insertcashrent
													WHERE status != "99"
													AND typetranfer != "99"
													AND typetranfer = "2"
													AND ref = "'.$bill_rent.'"
													AND typereftax = "'.$idtax.'"
													AND typedoc = "0" ' ;
								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
								$drbank = $datainsertbank[0]->money;

								$list =  $dataaccnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$drbank,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด discount
								// if($discount!=0.00){
								// 	$list = 'ส่วนลดรับ ';
								// 	$accaccdiscount= $accCode['accdiscount'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>$discountmoney,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdiscount,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>1];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								// }


								// insert เงินสด whtmoney cash
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
                $list = 'ลูกหนี้การค้า';
                $grandtotal;
                $acctool= $accCode['accdebtor'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotal,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								// $list = 'ภาษีขาย';
								// $accvat= $accCode['accvat'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$vatmoney,
								// 				  'acc_code'=>$accvat,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datataxra[0]->time,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$datataxra[0]->id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>1];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RO  เงินสดและโอน   =================================  / /

						// =================================  RO  เงินเช็ค  =================================  / /
						if($datataxra[0]->gettypemoney==4){
							$accCode = Accountcenter::accincome();
							$branch_id = $datataxra[0]->branch_id;
							$company_id = $datataxra[0]->company_id;

							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;

							$acccash = $accCode['acccash'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = $datataxra[0]->discount;
							$discountmoney = $subtotal*($discount/100);
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = $datataxra[0]->withhold;
							$whtmoney = $datataxra[0]->withholdmoney;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

								$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert  ra  bank
								$list = $accnumber[0]->accounttypefull;
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$accounttypeno,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>1];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert  discount bank
								if($discount!=0.00){
									$list = 'ส่วนลดรับ ';
									$accaccdiscount= $accCode['accdiscount'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$discountmoney,
												  'cr'=>'0',
												  'acc_code'=>$accaccdiscount,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert เงินสด whtmoney bank
								if($wht!=0.00){
									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
									$accwht= $accCode['accwht'];
										$arrInert = [ 'id'=>'',
												  'dr'=>$whtmoney,
												  'cr'=>'0',
												  'acc_code'=>$accwht,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
								}


								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								$acctool= $accCode['acctool'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$grandtotaltool,
												  'acc_code'=>$acctool,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert  vat bank
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datataxra[0]->time,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$datataxra[0]->id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>1];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


							} // =================================  สิ้นสุด RO  เงินเช็ค   =================================  / /

							// =================================  RO  etc  =================================  //
							if($datataxra[0]->gettypemoney==5){

							}
							// =================================  RO  etc  =================================  //

					}

					// ===============================================  END RO  ===============================================//


					// ===============================================  START CN (9) ===============================================//
					if($typeRef==9){
						$accCode = Accountcenter::accincome();
						$sql = 'SELECT '.$db['fsctaccount'].'.taxinvoice_creditnote.*
							FROM '.$db['fsctaccount'].'.taxinvoice_creditnote
							WHERE '.$db['fsctaccount'].'.taxinvoice_creditnote.id = "'.$id.'" ';
						$datataxcn = DB::connection('mysql')->select($sql);

            $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_creditnote
					       SET status_ap = "1"
					  WHERE '.$db['fsctaccount'].'.taxinvoice_creditnote.id = "'.$id.'" ';
      			$lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

						$number_bill = $datataxcn[0]->number_taxinvoice;

            $brach =  $datataxcn[0]->branch_id;
            $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                       SET status = "99"
                       WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                       AND '.$db['hr_base'].'.msgalert.type_doc  = "9"
                       AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

            $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


						// $branch_id = $datataxcn[0]->branch_id;
            $time =$datataxcn[0]->time;
             if($time >= $dateStartset){
                 // echo "new";
                 $branch_id =  substr($datataxcn[0]->number_taxinvoice,6,4);
             }else{
                 $branch_id = $datataxcn[0]->branch_id;
                 //echo "old";
             }



            $company_id = $datataxcn[0]->company_id;
						$customerid = $datataxcn[0]->customerid;
						$sqlbank = 'SELECT *
									FROM '.$db['fsctaccount'].'.bank
									WHERE status = "1"
									AND branch_id = "'.$branch_id.'"
									AND company_id = "'.$company_id.'"
									AND id_cash = "4" ' ;
						$databank = DB::connection('mysql')->select($sqlbank);
						$accounttypeno = $databank[0]->accounttypeno;

						$sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

						$customerData = DB::connection('mysql')->select($sqlcustomerData);

						// insert  รับคืน เครื่องมือ-อุปกรณ์ให้เช่า
						$list = 'รับคืน เครื่องมือ-อุปกรณ์ให้เช่า'.$customerData[0]->value;;
						$subtotal = $datataxcn[0]->subtotal;
						$vatmoney = $subtotal * ($datataxcn[0]->vat/100);
						$grandtotal = $datataxcn[0]->grandtotal;
						$discount = 0;
						$acctool= $accCode['acctool'];
								$arrInert = [ 'id'=>'',
										  'dr'=>$subtotal,
										  'cr'=>0,
										  'acc_code'=>$acctool,
										  'branch'=>$branch_id,
										  'status'=> 1,
										  'number_bill'=> $number_bill,
										  'customer_vendor'=>$customerid,
										  'timestamp'=>$datataxcn[0]->time,
										  'code_emp'=> $emp_code,
										  'subtotal'=> $subtotal,
										  'discount'=> $discount,
										  'vat'=> $datataxcn[0]->vat,
										  'vatmoney'=> $vatmoney,
										  'wht'=> 0,
										  'whtmoney'=> 0,
										  'grandtotal'=> $grandtotal,
										  'type_income'=>'1' ,
										  'type_journal'=>4 ,
										  'id_type_ref_journal'=>$datataxcn[0]->id,
										  'timereal'=>date('Y-m-d H:i:s'),
										  'list'=> $list,
										  'type_buy'=>9];

							DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


						// insert vat
						$list = 'ภาษีขาย' ;

						$accvat= $accCode['accvat'];
								$arrInert = [ 'id'=>'',
										  'dr'=>$vatmoney,
										  'cr'=>0,
										  'acc_code'=>$acctool,
										  'branch'=>$branch_id,
										  'status'=> 1,
										  'number_bill'=> $number_bill,
										  'customer_vendor'=>$customerid,
										  'timestamp'=>$datataxcn[0]->time,
										  'code_emp'=> $emp_code,
										  'subtotal'=> $subtotal,
										  'discount'=> $discount,
										  'vat'=> $datataxcn[0]->vat,
										  'vatmoney'=> $vatmoney,
										  'wht'=> 0,
										  'whtmoney'=> 0,
										  'grandtotal'=> $grandtotal,
										  'type_income'=>'1' ,
										  'type_journal'=>4 ,
										  'id_type_ref_journal'=>$datataxcn[0]->id,
										  'timereal'=>date('Y-m-d H:i:s'),
										  'list'=> $list,
										  'type_buy'=>9];

							DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

						$brname = Maincenter::databranchbycode($branch_id);
						// insert เงินฝากออมทรัพย์
						$list = 'เงินฝากออมทรัพย์  KBANK '.$databank[0]->number_bank .'('.$brname[0]->name_branch.')';

								$arrInert = [ 'id'=>'',
										  'dr'=>'0',
										  'cr'=>$grandtotal,
										  'acc_code'=>$accounttypeno,
										  'branch'=>$branch_id,
										  'status'=> 1,
										  'number_bill'=> $number_bill,
										  'customer_vendor'=>$customerid,
										  'timestamp'=>$datataxcn[0]->time,
										  'code_emp'=> $emp_code,
										  'subtotal'=> $subtotal,
										  'discount'=> $discount,
										  'vat'=> $datataxcn[0]->vat,
										  'vatmoney'=> $vatmoney,
										  'wht'=> 0,
										  'whtmoney'=> 0,
										  'grandtotal'=> $grandtotal,
										  'type_income'=>'1' ,
										  'type_journal'=>4 ,
										  'id_type_ref_journal'=>$datataxcn[0]->id,
										  'timereal'=>date('Y-m-d H:i:s'),
										  'list'=> $list,
										  'type_buy'=>9];

							DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

					}
					// ===============================================  END CN  ===============================================//


					// ===============================================  START RS (10) ===============================================//
					if($typeRef==10){
              	$accCode = Accountcenter::accincome();

                $sqlra = 'SELECT '.$db['fsctaccount'].'.taxinvoice_special_abb.*
                      FROM '.$db['fsctaccount'].'.taxinvoice_special_abb
                    WHERE '.$db['fsctaccount'].'.taxinvoice_special_abb.id = "'.$id.'" ';
                $datataxra = DB::connection('mysql')->select($sqlra);

                // echo "<pre>";
                // print_r($datataxra);
                //
                                  ///      Update  status_approved
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_special_abb
                            SET status_ap = "1"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_special_abb.id = "'.$id.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

                  ///     Update status msg alert hr
                  $brach = $datataxra[0]->branch_id;
                  $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                            SET status = "99"
                            WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                            AND '.$db['hr_base'].'.msgalert.type_doc  = "1"
                            AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

                  $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);



                  // =================================  RS  เงินสด   =================================  / /
                  if($datataxra[0]->gettypemoney==1){
                    $accCode = Accountcenter::accincome();
                    $time =$datataxra[0]->date_approved;
                    if($time >= $dateStartset){
                        // echo "new";
                        $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                    }else{
                        $branch_id = $datataxra[0]->branch_id;
                        //echo "old";
                    }

                    $company_id = $datataxra[0]->company_id;

                    $sqlbank = 'SELECT *
                          FROM '.$db['fsctaccount'].'.bank
                          WHERE status = "1"
                          AND branch_id = "'.$branch_id.'"
                          AND company_id = "'.$company_id.'"
                          AND id_cash = "1" ' ;
                    $databank = DB::connection('mysql')->select($sqlbank);


                    $accounttypeno = $databank[0]->accounttypeno;
                    $acccash = $accCode['acccash'];
                    $number_bill = $datataxra[0]->number_taxinvoice;
                    $customerid = $datataxra[0]->customer_id;
                    $subtotal = $datataxra[0]->subtotal;
                    $discount = 0;
                    $discountmoney = $subtotal*($discount/100);
                    $vat = $datataxra[0]->vat;
                    $vatmoney = $datataxra[0]->vatmoney;
                    $wht = $datataxra[0]->withhold;
                    $whtmoney = $datataxra[0]->withholdmoney;
                    $grandtotal = $datataxra[0]->grandtotal;

                    //$customerData = Maincenter::getdatacustomeridandname($customerid);
                     $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
                          CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
                          '.$db['fsctmain'].'.customers.customer_terms as customer_terms,
                          '.$db['fsctmain'].'.customers.customerid as id
                          FROM '.$db['fsctmain'].'.customers
                          INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
                          WHERE customerid = "'.$customerid.'" ';

                    $customerData = DB::connection('mysql')->select($sqlcustomerData);

                      // insert เงินสด RS  cash
                      $list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
                      $arrInert = [ 'id'=>'',
                              'dr'=>$grandtotal,
                              'cr'=>'0',
                              'acc_code'=>$acccash,
                              'branch'=>$branch_id,
                              'status'=> 1,
                              'number_bill'=> $number_bill,
                              'customer_vendor'=>$customerid,
                              'timestamp'=>$datataxra[0]->date_approved,
                              'code_emp'=> $emp_code,
                              'subtotal'=> $subtotal,
                              'discount'=> $discount,
                              'vat'=> $vat,
                              'vatmoney'=> $vatmoney,
                              'wht'=> $wht,
                              'whtmoney'=> $whtmoney,
                              'grandtotal'=> $grandtotal,
                              'type_income'=>'1' ,
                              'type_journal'=>4 ,
                              'id_type_ref_journal'=>$datataxra[0]->id,
                              'timereal'=>date('Y-m-d H:i:s'),
                              'list'=> $list,
                              'type_buy'=>1];

                      DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


                      // insert เงินสด discount cash
                      // if($discount!=0.00){
                      //   $list = 'ส่วนลดรับ ';
                      //   $accaccdiscount= $accCode['accdiscount'];
                      //     $arrInert = [ 'id'=>'',
                      //           'dr'=>$discountmoney,
                      //           'cr'=>'0',
                      //           'acc_code'=>$accaccdiscount,
                      //           'branch'=>$branch_id,
                      //           'status'=> 1,
                      //           'number_bill'=> $number_bill,
                      //           'customer_vendor'=>$customerid,
                      //           'timestamp'=>$datataxra[0]->date_approved,
                      //           'code_emp'=> $emp_code,
                      //           'subtotal'=> $subtotal,
                      //           'discount'=> $discount,
                      //           'vat'=> $vat,
                      //           'vatmoney'=> $vatmoney,
                      //           'wht'=> $wht,
                      //           'whtmoney'=> $whtmoney,
                      //           'grandtotal'=> $grandtotal,
                      //           'type_income'=>'1' ,
                      //           'type_journal'=>4 ,
                      //           'id_type_ref_journal'=>$datataxra[0]->id,
                      //           'timereal'=>date('Y-m-d H:i:s'),
                      //           'list'=> $list,
                      //           'type_buy'=>1];
                      //
                      //   DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                      // }
                      //

                      // insert เงินสด whtmoney cash
                      if($wht!=0.00){
                        $list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
                        $accwht= $accCode['accwht'];
                          $arrInert = [ 'id'=>'',
                                'dr'=>$whtmoney,
                                'cr'=>'0',
                                'acc_code'=>$accwht,
                                'branch'=>$branch_id,
                                'status'=> 1,
                                'number_bill'=> $number_bill,
                                'customer_vendor'=>$customerid,
                                'timestamp'=>$datataxra[0]->date_approved,
                                'code_emp'=> $emp_code,
                                'subtotal'=> $subtotal,
                                'discount'=> $discount,
                                'vat'=> $vat,
                                'vatmoney'=> $vatmoney,
                                'wht'=> $wht,
                                'whtmoney'=> $whtmoney,
                                'grandtotal'=> $grandtotal,
                                'type_income'=>'1' ,
                                'type_journal'=>4 ,
                                'id_type_ref_journal'=>$datataxra[0]->id,
                                'timereal'=>date('Y-m-d H:i:s'),
                                'list'=> $list,
                                'type_buy'=>1];

                        DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                      }


                      // insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
                      $list = 'รายได้อื่นๆ';
                      $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
                      $acctool= $accCode['accetc'];
                          $arrInert = [ 'id'=>'',
                                'dr'=>'0',
                                'cr'=>$grandtotaltool,
                                'acc_code'=>$acctool,
                                'branch'=>$branch_id,
                                'status'=> 1,
                                'number_bill'=> $number_bill,
                                'customer_vendor'=>$customerid,
                                'timestamp'=>$datataxra[0]->date_approved,
                                'code_emp'=> $emp_code,
                                'subtotal'=> $subtotal,
                                'discount'=> $discount,
                                'vat'=> $vat,
                                'vatmoney'=> $vatmoney,
                                'wht'=> $wht,
                                'whtmoney'=> $whtmoney,
                                'grandtotal'=> $grandtotal,
                                'type_income'=>'1' ,
                                'type_journal'=>4 ,
                                'id_type_ref_journal'=>$datataxra[0]->id,
                                'timereal'=>date('Y-m-d H:i:s'),
                                'list'=> $list,
                                'type_buy'=>1];

                        DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                      // insert เงินสด vat cash
                      $list = 'ภาษีขาย';
                      $accvat= $accCode['accvat'];
                          $arrInert = [ 'id'=>'',
                                'dr'=>'0',
                                'cr'=>$vatmoney,
                                'acc_code'=>$accvat,
                                'branch'=>$branch_id,
                                'status'=> 1,
                                'number_bill'=> $number_bill,
                                'customer_vendor'=>$customerid,
                                'timestamp'=>$datataxra[0]->date_approved,
                                'code_emp'=> $emp_code,
                                'subtotal'=> $subtotal,
                                'discount'=> $discount,
                                'vat'=> $vat,
                                'vatmoney'=> $vatmoney,
                                'wht'=> $wht,
                                'whtmoney'=> $whtmoney,
                                'grandtotal'=> $grandtotal,
                                'type_income'=>'1' ,
                                'type_journal'=>4 ,
                                'id_type_ref_journal'=>$datataxra[0]->id,
                                'timereal'=>date('Y-m-d H:i:s'),
                                'list'=> $list,
                                'type_buy'=>1];

                        DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


                    }// =================================  สิ้นสุด RS  เงินสด   =================================  / /

                    // =================================  RS  เงินโอน   =================================  / /

                    if($datataxra[0]->gettypemoney==2){
                      $accCode = Accountcenter::accincome();

                      $time =$datataxra[0]->date_approved;
                      if($time >= $dateStartset){
                          // echo "new";
                          $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                      }else{
                          $branch_id = $datataxra[0]->branch_id;
                          //echo "old";
                      }


                      $company_id = $datataxra[0]->company_id;

                      $sqlbank = 'SELECT *
                            FROM '.$db['fsctaccount'].'.bank
                            WHERE status = "1"
                            AND branch_id = "'.$branch_id.'"
                            AND company_id = "'.$company_id.'"
                            AND id_cash = "1" ' ;
                      $databank = DB::connection('mysql')->select($sqlbank);
                      $accounttypeno = $databank[0]->accounttypeno;

                      $sqlaccounttypeno = 'SELECT *
                                  FROM '.$db['fsctaccount'].'.accounttype
                                  WHERE status = "1"
                                  AND accounttypeno = "'.$accounttypeno.'" ' ;
                      $dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

                      $accnumber = $dataaccnumber[0]->id;

                      $acccash = $accCode['acccash'];
                      $number_bill = $datataxra[0]->number_taxinvoice;
                      $customerid = $datataxra[0]->customer_id;
                      $subtotal = $datataxra[0]->subtotal;
                      $discount = 0;
                      $discountmoney = $subtotal*($discount/100);
                      $vat = $datataxra[0]->vat;
                      $vatmoney = $datataxra[0]->vatmoney;
                      $wht = $datataxra[0]->withhold;
                      $whtmoney = $datataxra[0]->withholdmoney;
                      $grandtotal = $datataxra[0]->grandtotal;

                      //$customerData = Maincenter::getdatacustomeridandname($customerid);
                       $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
                            CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
                            '.$db['fsctmain'].'.customers.customer_terms as customer_terms,
                            '.$db['fsctmain'].'.customers.customerid as id
                            FROM '.$db['fsctmain'].'.customers
                            INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
                            WHERE customerid = "'.$customerid.'" ';

                        $customerData = DB::connection('mysql')->select($sqlcustomerData);

                        // insert  RS  bank
                        $list = $dataaccnumber[0]->accounttypefull;
                        $arrInert = [ 'id'=>'',
                                'dr'=>$grandtotal,
                                'cr'=>'0',
                                'acc_code'=>$accounttypeno,
                                'branch'=>$branch_id,
                                'status'=> 1,
                                'number_bill'=> $number_bill,
                                'customer_vendor'=>$customerid,
                                'timestamp'=>$datataxra[0]->date_approved,
                                'code_emp'=> $emp_code,
                                'subtotal'=> $subtotal,
                                'discount'=> $discount,
                                'vat'=> $vat,
                                'vatmoney'=> $vatmoney,
                                'wht'=> $wht,
                                'whtmoney'=> $whtmoney,
                                'grandtotal'=> $grandtotal,
                                'type_income'=>'1' ,
                                'type_journal'=>4 ,
                                'id_type_ref_journal'=>$datataxra[0]->id,
                                'timereal'=>date('Y-m-d H:i:s'),
                                'list'=> $list,
                                'type_buy'=>1];

                        DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


                        // insert  discount bank
                        if($discount!=0.00){
                          $list = 'ส่วนลดรับ ';
                          $accaccdiscount= $accCode['accdiscount'];
                            $arrInert = [ 'id'=>'',
                                  'dr'=>$discountmoney,
                                  'cr'=>'0',
                                  'acc_code'=>$accaccdiscount,
                                  'branch'=>$branch_id,
                                  'status'=> 1,
                                  'number_bill'=> $number_bill,
                                  'customer_vendor'=>$customerid,
                                  'timestamp'=>$datataxra[0]->date_approved,
                                  'code_emp'=> $emp_code,
                                  'subtotal'=> $subtotal,
                                  'discount'=> $discount,
                                  'vat'=> $vat,
                                  'vatmoney'=> $vatmoney,
                                  'wht'=> $wht,
                                  'whtmoney'=> $whtmoney,
                                  'grandtotal'=> $grandtotal,
                                  'type_income'=>'1' ,
                                  'type_journal'=>4 ,
                                  'id_type_ref_journal'=>$datataxra[0]->id,
                                  'timereal'=>date('Y-m-d H:i:s'),
                                  'list'=> $list,
                                  'type_buy'=>1];

                          DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                        }


                        // insert เงินสด whtmoney bank
                        if($wht!=0.00){
                          $list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
                          $accwht= $accCode['accwht'];
                            $arrInert = [ 'id'=>'',
                                  'dr'=>$whtmoney,
                                  'cr'=>'0',
                                  'acc_code'=>$accwht,
                                  'branch'=>$branch_id,
                                  'status'=> 1,
                                  'number_bill'=> $number_bill,
                                  'customer_vendor'=>$customerid,
                                  'timestamp'=>$datataxra[0]->date_approved,
                                  'code_emp'=> $emp_code,
                                  'subtotal'=> $subtotal,
                                  'discount'=> $discount,
                                  'vat'=> $vat,
                                  'vatmoney'=> $vatmoney,
                                  'wht'=> $wht,
                                  'whtmoney'=> $whtmoney,
                                  'grandtotal'=> $grandtotal,
                                  'type_income'=>'1' ,
                                  'type_journal'=>4 ,
                                  'id_type_ref_journal'=>$datataxra[0]->id,
                                  'timereal'=>date('Y-m-d H:i:s'),
                                  'list'=> $list,
                                  'type_buy'=>1];

                          DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                        }


                        // insert  เครื่องมือ-อุปกรณ์ให้เช่า
                        $list = 'รายได้อื่นๆ';
                        $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
                        $acctool= $accCode['accetc'];
                            $arrInert = [ 'id'=>'',
                                  'dr'=>'0',
                                  'cr'=>$grandtotaltool,
                                  'acc_code'=>$acctool,
                                  'branch'=>$branch_id,
                                  'status'=> 1,
                                  'number_bill'=> $number_bill,
                                  'customer_vendor'=>$customerid,
                                  'timestamp'=>$datataxra[0]->date_approved,
                                  'code_emp'=> $emp_code,
                                  'subtotal'=> $subtotal,
                                  'discount'=> $discount,
                                  'vat'=> $vat,
                                  'vatmoney'=> $vatmoney,
                                  'wht'=> $wht,
                                  'whtmoney'=> $whtmoney,
                                  'grandtotal'=> $grandtotal,
                                  'type_income'=>'1' ,
                                  'type_journal'=>4 ,
                                  'id_type_ref_journal'=>$datataxra[0]->id,
                                  'timereal'=>date('Y-m-d H:i:s'),
                                  'list'=> $list,
                                  'type_buy'=>1];

                          DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                        // insert  vat bank
                        $list = 'ภาษีขาย';
                        $accvat= $accCode['accvat'];
                            $arrInert = [ 'id'=>'',
                                  'dr'=>'0',
                                  'cr'=>$vatmoney,
                                  'acc_code'=>$accvat,
                                  'branch'=>$branch_id,
                                  'status'=> 1,
                                  'number_bill'=> $number_bill,
                                  'customer_vendor'=>$customerid,
                                  'timestamp'=>$datataxra[0]->date_approved,
                                  'code_emp'=> $emp_code,
                                  'subtotal'=> $subtotal,
                                  'discount'=> $discount,
                                  'vat'=> $vat,
                                  'vatmoney'=> $vatmoney,
                                  'wht'=> $wht,
                                  'whtmoney'=> $whtmoney,
                                  'grandtotal'=> $grandtotal,
                                  'type_income'=>'1' ,
                                  'type_journal'=>4 ,
                                  'id_type_ref_journal'=>$datataxra[0]->id,
                                  'timereal'=>date('Y-m-d H:i:s'),
                                  'list'=> $list,
                                  'type_buy'=>1];

                          DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


                      } // =================================  สิ้นสุด RS  เงินโอน   =================================  / /


        						   // =================================  RS  เงินสดและโอน   =================================  / /

          						if($datataxra[0]->gettypemoney==3){
          							$accCode = Accountcenter::accincome();

                        $time =$datataxra[0]->date_approved;
                        if($time >= $dateStartset){
                            // echo "new";
                            $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                        }else{
                            $branch_id = $datataxra[0]->branch_id;
                            //echo "old";
                        }


          							$company_id = $datataxra[0]->company_id;
          							$sqlbank = 'SELECT *
          										FROM '.$db['fsctaccount'].'.bank
          										WHERE status = "1"
          										AND branch_id = "'.$branch_id.'"
          										AND company_id = "'.$company_id.'"
          										AND id_cash = "1" ' ;
          							$databank = DB::connection('mysql')->select($sqlbank);
          							$accounttypeno = $databank[0]->accounttypeno;

          							$sqlaccounttypeno = 'SELECT *
          													FROM '.$db['fsctaccount'].'.accounttype
          													WHERE status = "1"
          													AND accounttypeno = "'.$accounttypeno.'" ' ;
          							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

          							$accnumber = $dataaccnumber[0]->id;


          							$acccash = $accCode['acccash'];
          							$number_bill = $datataxra[0]->number_taxinvoice;
          							$customerid = $datataxra[0]->customer_id;
          							$subtotal = $datataxra[0]->subtotal;
          							$discount = 0;
          							$discountmoney = $subtotal*($discount/100);
          							$vat = $datataxra[0]->vat;
          							$vatmoney = $datataxra[0]->vatmoney;
          							$wht = $datataxra[0]->withhold;
          							$whtmoney = $datataxra[0]->withholdmoney;
          							$grandtotal = $datataxra[0]->grandtotal;

          							//$customerData = Maincenter::getdatacustomeridandname($customerid);
          							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
          										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
          										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
          										'.$db['fsctmain'].'.customers.customerid as id
          										FROM '.$db['fsctmain'].'.customers
          										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
          										WHERE customerid = "'.$customerid.'" ';

          								$customerData = DB::connection('mysql')->select($sqlcustomerData);

          								$bill_rent = $datataxra[0]->bill_rent;
          								$idtax = $datataxra[0]->id;

          								$sqlinsertcash = 'SELECT *
          													FROM '.$db['fsctaccount'].'.insertcashrent
          													WHERE status != "99"
          													AND typetranfer != "99"
          													AND typetranfer = "1"
          													AND ref = "'.$bill_rent.'"
          													AND typereftax = "'.$idtax.'"
          													AND typedoc = "0" ' ;
          								$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
          								$drcash = $datainsertcash[0]->money;

          								// insert เงินสด RS  cash
          								$list = 'รับเงินค่าเช่าจาก'.$customerData[0]->value;
          								$arrInert = [ 'id'=>'',
          											  'dr'=>$drcash,
          											  'cr'=>'0',
          											  'acc_code'=>$acccash,
          											  'branch'=>$branch_id,
          											  'status'=> 1,
          											  'number_bill'=> $number_bill,
          											  'customer_vendor'=>$customerid,
          											  'timestamp'=>$datataxra[0]->date_approved,
          											  'code_emp'=> $emp_code,
          											  'subtotal'=> $subtotal,
          											  'discount'=> $discount,
          											  'vat'=> $vat,
          											  'vatmoney'=> $vatmoney,
          											  'wht'=> $wht,
          											  'whtmoney'=> $whtmoney,
          											  'grandtotal'=> $grandtotal,
          											  'type_income'=>'1' ,
          											  'type_journal'=>4 ,
          											  'id_type_ref_journal'=>$datataxra[0]->id,
          											  'timereal'=>date('Y-m-d H:i:s'),
          											  'list'=> $list,
          											  'type_buy'=>1];

          								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


          								// insert  ra  bank
          								$sqlinsertbank = 'SELECT *
          													FROM '.$db['fsctaccount'].'.insertcashrent
          													WHERE status != "99"
          													AND typetranfer != "99"
          													AND typetranfer = "2"
          													AND ref = "'.$bill_rent.'"
          													AND typereftax = "'.$idtax.'"
          													AND typedoc = "0" ' ;
          								$datainsertbank = DB::connection('mysql')->select($sqlinsertbank);
          								$drbank = $datainsertbank[0]->money;

          								$list =  $dataaccnumber[0]->accounttypefull;
          								$arrInert = [ 'id'=>'',
          											  'dr'=>$drbank,
          											  'cr'=>'0',
          											  'acc_code'=>$accounttypeno,
          											  'branch'=>$branch_id,
          											  'status'=> 1,
          											  'number_bill'=> $number_bill,
          											  'customer_vendor'=>$customerid,
          											  'timestamp'=>$datataxra[0]->time,
          											  'code_emp'=> $emp_code,
          											  'subtotal'=> $subtotal,
          											  'discount'=> $discount,
          											  'vat'=> $vat,
          											  'vatmoney'=> $vatmoney,
          											  'wht'=> $wht,
          											  'whtmoney'=> $whtmoney,
          											  'grandtotal'=> $grandtotal,
          											  'type_income'=>'1' ,
          											  'type_journal'=>4 ,
          											  'id_type_ref_journal'=>$datataxra[0]->id,
          											  'timereal'=>date('Y-m-d H:i:s'),
          											  'list'=> $list,
          											  'type_buy'=>1];

          								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


          								// insert เงินสด discount
          								if($discount!=0.00){
          									$list = 'ส่วนลดรับ ';
          									$accaccdiscount= $accCode['accdiscount'];
          										$arrInert = [ 'id'=>'',
          												  'dr'=>$discountmoney,
          												  'cr'=>'0',
          												  'acc_code'=>$accaccdiscount,
          												  'branch'=>$branch_id,
          												  'status'=> 1,
          												  'number_bill'=> $number_bill,
          												  'customer_vendor'=>$customerid,
          												  'timestamp'=>$datataxra[0]->time,
          												  'code_emp'=> $emp_code,
          												  'subtotal'=> $subtotal,
          												  'discount'=> $discount,
          												  'vat'=> $vat,
          												  'vatmoney'=> $vatmoney,
          												  'wht'=> $wht,
          												  'whtmoney'=> $whtmoney,
          												  'grandtotal'=> $grandtotal,
          												  'type_income'=>'1' ,
          												  'type_journal'=>4 ,
          												  'id_type_ref_journal'=>$datataxra[0]->id,
          												  'timereal'=>date('Y-m-d H:i:s'),
          												  'list'=> $list,
          												  'type_buy'=>1];

          									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
          								}


          								// insert เงินสด whtmoney cash
          								if($wht!=0.00){
          									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
          									$accwht= $accCode['accwht'];
          										$arrInert = [ 'id'=>'',
          												  'dr'=>$whtmoney,
          												  'cr'=>'0',
          												  'acc_code'=>$accwht,
          												  'branch'=>$branch_id,
          												  'status'=> 1,
          												  'number_bill'=> $number_bill,
          												  'customer_vendor'=>$customerid,
          												  'timestamp'=>$datataxra[0]->time,
          												  'code_emp'=> $emp_code,
          												  'subtotal'=> $subtotal,
          												  'discount'=> $discount,
          												  'vat'=> $vat,
          												  'vatmoney'=> $vatmoney,
          												  'wht'=> $wht,
          												  'whtmoney'=> $whtmoney,
          												  'grandtotal'=> $grandtotal,
          												  'type_income'=>'1' ,
          												  'type_journal'=>4 ,
          												  'id_type_ref_journal'=>$datataxra[0]->id,
          												  'timereal'=>date('Y-m-d H:i:s'),
          												  'list'=> $list,
          												  'type_buy'=>1];

          									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
          								}


          								// insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
                          $list = 'รายได้อื่นๆ';
                          $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
                          $acctool= $accCode['accetc'];
                              $arrInert = [ 'id'=>'',
                                    'dr'=>'0',
                                    'cr'=>$grandtotaltool,
                                    'acc_code'=>$acctool,
                                    'branch'=>$branch_id,
                                    'status'=> 1,
                                    'number_bill'=> $number_bill,
                                    'customer_vendor'=>$customerid,
                                    'timestamp'=>$datataxra[0]->date_approved,
                                    'code_emp'=> $emp_code,
                                    'subtotal'=> $subtotal,
                                    'discount'=> $discount,
                                    'vat'=> $vat,
                                    'vatmoney'=> $vatmoney,
                                    'wht'=> $wht,
                                    'whtmoney'=> $whtmoney,
                                    'grandtotal'=> $grandtotal,
                                    'type_income'=>'1' ,
                                    'type_journal'=>4 ,
                                    'id_type_ref_journal'=>$datataxra[0]->id,
                                    'timereal'=>date('Y-m-d H:i:s'),
                                    'list'=> $list,
                                    'type_buy'=>1];

                            DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

          								// insert เงินสด vat cash
          								$list = 'ภาษีขาย';
          								$accvat= $accCode['accvat'];
          										$arrInert = [ 'id'=>'',
          												  'dr'=>'0',
          												  'cr'=>$vatmoney,
          												  'acc_code'=>$accvat,
          												  'branch'=>$branch_id,
          												  'status'=> 1,
          												  'number_bill'=> $number_bill,
          												  'customer_vendor'=>$customerid,
          												  'timestamp'=>$datataxra[0]->time,
          												  'code_emp'=> $emp_code,
          												  'subtotal'=> $subtotal,
          												  'discount'=> $discount,
          												  'vat'=> $vat,
          												  'vatmoney'=> $vatmoney,
          												  'wht'=> $wht,
          												  'whtmoney'=> $whtmoney,
          												  'grandtotal'=> $grandtotal,
          												  'type_income'=>'1' ,
          												  'type_journal'=>4 ,
          												  'id_type_ref_journal'=>$datataxra[0]->id,
          												  'timereal'=>date('Y-m-d H:i:s'),
          												  'list'=> $list,
          												  'type_buy'=>1];

          									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


          							} // =================================  สิ้นสุด RS  เงินสดและโอน   =================================  / /


            						// =================================  RS  เงินเช็ค  =================================  / /
            						if($datataxra[0]->gettypemoney==4){
            							$accCode = Accountcenter::accincome();

                            $time =$datataxra[0]->time;
                              if($time >= $dateStartset){
                                  // echo "new";
                                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
                              }else{
                                  $branch_id = $datataxra[0]->branch_id;
                                  //echo "old";
                              }


            							$company_id = $datataxra[0]->company_id;

            							$sqlbank = 'SELECT *
            										FROM '.$db['fsctaccount'].'.bank
            										WHERE status = "1"
            										AND branch_id = "'.$branch_id.'"
            										AND company_id = "'.$company_id.'"
            										AND id_cash = "1" ' ;
            							$databank = DB::connection('mysql')->select($sqlbank);
            							$accounttypeno = $databank[0]->accounttypeno;

            							$sqlaccounttypeno = 'SELECT *
            													FROM '.$db['fsctaccount'].'.accounttype
            													WHERE status = "1"
            													AND accounttypeno = "'.$accounttypeno.'" ' ;
            							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

            							$accnumber = $dataaccnumber[0]->id;

            							$acccash = $accCode['acccash'];
            							$number_bill = $datataxra[0]->number_taxinvoice;
            							$customerid = $datataxra[0]->customer_id;
            							$subtotal = $datataxra[0]->subtotal;
            							$discount = $datataxra[0]->discount;
            							$discountmoney = $subtotal*($discount/100);
            							$vat = $datataxra[0]->vat;
            							$vatmoney = $datataxra[0]->vatmoney;
            							$wht = $datataxra[0]->withhold;
            							$whtmoney = $datataxra[0]->withholdmoney;
            							$grandtotal = $datataxra[0]->grandtotal;

            							//$customerData = Maincenter::getdatacustomeridandname($customerid);
            							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
            										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
            										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
            										'.$db['fsctmain'].'.customers.customerid as id
            										FROM '.$db['fsctmain'].'.customers
            										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
            										WHERE customerid = "'.$customerid.'" ';

            								$customerData = DB::connection('mysql')->select($sqlcustomerData);

            								// insert  ra  bank
            								$list = $accnumber[0]->accounttypefull;
            								$arrInert = [ 'id'=>'',
            											  'dr'=>$grandtotal,
            											  'cr'=>'0',
            											  'acc_code'=>$accounttypeno,
            											  'branch'=>$branch_id,
            											  'status'=> 1,
            											  'number_bill'=> $number_bill,
            											  'customer_vendor'=>$customerid,
            											  'timestamp'=>$datataxra[0]->time,
            											  'code_emp'=> $emp_code,
            											  'subtotal'=> $subtotal,
            											  'discount'=> $discount,
            											  'vat'=> $vat,
            											  'vatmoney'=> $vatmoney,
            											  'wht'=> $wht,
            											  'whtmoney'=> $whtmoney,
            											  'grandtotal'=> $grandtotal,
            											  'type_income'=>'1' ,
            											  'type_journal'=>4 ,
            											  'id_type_ref_journal'=>$datataxra[0]->id,
            											  'timereal'=>date('Y-m-d H:i:s'),
            											  'list'=> $list,
            											  'type_buy'=>1];

            								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


            								// insert  discount bank
            								if($discount!=0.00){
            									$list = 'ส่วนลดรับ ';
            									$accaccdiscount= $accCode['accdiscount'];
            										$arrInert = [ 'id'=>'',
            												  'dr'=>$discountmoney,
            												  'cr'=>'0',
            												  'acc_code'=>$accaccdiscount,
            												  'branch'=>$branch_id,
            												  'status'=> 1,
            												  'number_bill'=> $number_bill,
            												  'customer_vendor'=>$customerid,
            												  'timestamp'=>$datataxra[0]->time,
            												  'code_emp'=> $emp_code,
            												  'subtotal'=> $subtotal,
            												  'discount'=> $discount,
            												  'vat'=> $vat,
            												  'vatmoney'=> $vatmoney,
            												  'wht'=> $wht,
            												  'whtmoney'=> $whtmoney,
            												  'grandtotal'=> $grandtotal,
            												  'type_income'=>'1' ,
            												  'type_journal'=>4 ,
            												  'id_type_ref_journal'=>$datataxra[0]->id,
            												  'timereal'=>date('Y-m-d H:i:s'),
            												  'list'=> $list,
            												  'type_buy'=>1];

            									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
            								}


            								// insert เงินสด whtmoney bank
            								if($wht!=0.00){
            									$list = 'ภาษีเงินได้ถูกหัก ณ ที่จ่าย';
            									$accwht= $accCode['accwht'];
            										$arrInert = [ 'id'=>'',
            												  'dr'=>$whtmoney,
            												  'cr'=>'0',
            												  'acc_code'=>$accwht,
            												  'branch'=>$branch_id,
            												  'status'=> 1,
            												  'number_bill'=> $number_bill,
            												  'customer_vendor'=>$customerid,
            												  'timestamp'=>$datataxra[0]->time,
            												  'code_emp'=> $emp_code,
            												  'subtotal'=> $subtotal,
            												  'discount'=> $discount,
            												  'vat'=> $vat,
            												  'vatmoney'=> $vatmoney,
            												  'wht'=> $wht,
            												  'whtmoney'=> $whtmoney,
            												  'grandtotal'=> $grandtotal,
            												  'type_income'=>'1' ,
            												  'type_journal'=>4 ,
            												  'id_type_ref_journal'=>$datataxra[0]->id,
            												  'timereal'=>date('Y-m-d H:i:s'),
            												  'list'=> $list,
            												  'type_buy'=>1];

            									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
            								}


            								// insert  เครื่องมือ-อุปกรณ์ให้เช่า
            								$list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
            								$grandtotaltool = $subtotal-$discountmoney+$discountmoney;
            								$acctool= $accCode['acctool'];
            										$arrInert = [ 'id'=>'',
            												  'dr'=>'0',
            												  'cr'=>$grandtotaltool,
            												  'acc_code'=>$acctool,
            												  'branch'=>$branch_id,
            												  'status'=> 1,
            												  'number_bill'=> $number_bill,
            												  'customer_vendor'=>$customerid,
            												  'timestamp'=>$datataxra[0]->time,
            												  'code_emp'=> $emp_code,
            												  'subtotal'=> $subtotal,
            												  'discount'=> $discount,
            												  'vat'=> $vat,
            												  'vatmoney'=> $vatmoney,
            												  'wht'=> $wht,
            												  'whtmoney'=> $whtmoney,
            												  'grandtotal'=> $grandtotal,
            												  'type_income'=>'1' ,
            												  'type_journal'=>4 ,
            												  'id_type_ref_journal'=>$datataxra[0]->id,
            												  'timereal'=>date('Y-m-d H:i:s'),
            												  'list'=> $list,
            												  'type_buy'=>1];

            									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

            								// insert  vat bank
            								$list = 'ภาษีขาย';
            								$accvat= $accCode['accvat'];
            										$arrInert = [ 'id'=>'',
            												  'dr'=>'0',
            												  'cr'=>$vatmoney,
            												  'acc_code'=>$accvat,
            												  'branch'=>$branch_id,
            												  'status'=> 1,
            												  'number_bill'=> $number_bill,
            												  'customer_vendor'=>$customerid,
            												  'timestamp'=>$datataxra[0]->time,
            												  'code_emp'=> $emp_code,
            												  'subtotal'=> $subtotal,
            												  'discount'=> $discount,
            												  'vat'=> $vat,
            												  'vatmoney'=> $vatmoney,
            												  'wht'=> $wht,
            												  'whtmoney'=> $whtmoney,
            												  'grandtotal'=> $grandtotal,
            												  'type_income'=>'1' ,
            												  'type_journal'=>4 ,
            												  'id_type_ref_journal'=>$datataxra[0]->id,
            												  'timereal'=>date('Y-m-d H:i:s'),
            												  'list'=> $list,
            												  'type_buy'=>1];

            									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


            							} // =================================  สิ้นสุด RS  เงินเช็ค   =================================  / /

                          // =================================  RS  etc  =================================  //
            							if($datataxra[0]->gettypemoney==5){

            							}
                         // =================================  RS  etc  =================================  //



					}

					// ===============================================  END RS  ===============================================//



					// ===============================================  START SS (11) ===============================================//

					if($typeRef==11){


						$accCode = Accountcenter::accincome();
						$sql = 'SELECT '.$db['fsctmain'].'.stock_sell_head.*
							FROM '.$db['fsctmain'].'.stock_sell_head
							WHERE '.$db['fsctmain'].'.stock_sell_head.id = "'.$id.'"							';
						$datass = DB::connection('mysql')->select($sql);

						$modelmaterial_ss = Maincenter::getdatamaterial_ss($id);

						$totalpricedepreciation = $modelmaterial_ss[0]->totalpricedepreciation;
						$customerid = $datass[0]->customer_id;

						$sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

						$customerData = DB::connection('mysql')->select($sqlcustomerData);
						$sqlinsertcash = 'SELECT *
												FROM '.$db['fsctaccount'].'.insertcashrent
												WHERE status != "99"
												AND typetranfer != "99"
												AND ref = "'.$id.'"
												AND typereftax = "'.$id.'"
												AND typedoc = "13" ' ;
						$datainsertcash = DB::connection('mysql')->select($sqlinsertcash);

						$typetranfer =  $datainsertcash[0]->typetranfer;


						$sqldetail = 'SELECT sum(loss*amount) as sum
							FROM '.$db['fsctmain'].'.stock_sell_detail
							WHERE '.$db['fsctmain'].'.stock_sell_detail.bill_head = "'.$id.'"							';
						$datassdetail = DB::connection('mysql')->select($sqldetail);
						$subtotal= $datassdetail[0]->sum;
						$accCode = Accountcenter::accincome();

						// $branch_id = $datass[0]->branch_id;
            $time =$datass[0]->date_approved;
           if($time >= $dateStartset){
               // echo "new";
               $branch_id =  substr($datass[0]->bill_no,6,4);
           }else{
               $branch_id = $datass[0]->branch_id;
               //echo "old";
           }

            $company_id = $datass[0]->company_id;


						$acccash = $accCode['acccash'];
						$number_bill = $datass[0]->bill_no;

						$discount = $datass[0]->discount;
						$discountmoney = $subtotal*($discount/100);
						$vat = $datass[0]->vat;
						$vatmoney = $datass[0]->vatmoney;
						$wht = 0;
						$whtmoney = 0;
						$grandtotal = $datass[0]->grandtotal;

						if($typetranfer==1){
								// insert เงินสด ss  cash
								$list = "เงินสด";
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datass[0]->date_approved,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>11];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


								// insert เงินสด ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า

								// $list = 'ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า ';
								// $accaccdepreciation= $accCode['accdepreciation'];
								// 	$arrInert = [ 'id'=>'',
								// 				  'dr'=>$totalpricedepreciation,
								// 				  'cr'=>'0',
								// 				  'acc_code'=>$accaccdepreciation,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datass[0]->date_approved,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>11];
                //
								// DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //
                //
                //
                //
								// // insert เงินสด เครื่องมือ-อุปกรณ์ให้เช่า
								// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
								// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
								// $acctool= $accCode['acctool'];
								// 		$arrInert = [ 'id'=>'',
								// 				  'dr'=>'0',
								// 				  'cr'=>$grandtotaltool,
								// 				  'acc_code'=>$acctool,
								// 				  'branch'=>$branch_id,
								// 				  'status'=> 1,
								// 				  'number_bill'=> $number_bill,
								// 				  'customer_vendor'=>$customerid,
								// 				  'timestamp'=>$datass[0]->date_approved,
								// 				  'code_emp'=> $emp_code,
								// 				  'subtotal'=> $subtotal,
								// 				  'discount'=> $discount,
								// 				  'vat'=> $vat,
								// 				  'vatmoney'=> $vatmoney,
								// 				  'wht'=> $wht,
								// 				  'whtmoney'=> $whtmoney,
								// 				  'grandtotal'=> $grandtotal,
								// 				  'type_income'=>'1' ,
								// 				  'type_journal'=>4 ,
								// 				  'id_type_ref_journal'=>$id,
								// 				  'timereal'=>date('Y-m-d H:i:s'),
								// 				  'list'=> $list,
								// 				  'type_buy'=>11];
                //
								// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

								// insert เงินสด vat cash
								$list = 'ภาษีขาย';
								$accvat= $accCode['accvat'];
										$arrInert = [ 'id'=>'',
												  'dr'=>'0',
												  'cr'=>$vatmoney,
												  'acc_code'=>$accvat,
												  'branch'=>$branch_id,
												  'status'=> 1,
												  'number_bill'=> $number_bill,
												  'customer_vendor'=>$customerid,
												  'timestamp'=>$datass[0]->date_approved,
												  'code_emp'=> $emp_code,
												  'subtotal'=> $subtotal,
												  'discount'=> $discount,
												  'vat'=> $vat,
												  'vatmoney'=> $vatmoney,
												  'wht'=> $wht,
												  'whtmoney'=> $whtmoney,
												  'grandtotal'=> $grandtotal,
												  'type_income'=>'1' ,
												  'type_journal'=>4 ,
												  'id_type_ref_journal'=>$id,
												  'timereal'=>date('Y-m-d H:i:s'),
												  'list'=> $list,
												  'type_buy'=>11];

									DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  $list = 'กำไร(ขาดทุน)';
                  $accdrcr= '322102';
                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$grandtotal-$vatmoney,
                            'acc_code'=>$accdrcr,
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$customerid,
                            'timestamp'=>$datass[0]->date_approved,
                            'code_emp'=> $emp_code,
                            'subtotal'=> $subtotal,
                            'discount'=> $discount,
                            'vat'=> $vat,
                            'vatmoney'=> $vatmoney,
                            'wht'=> $wht,
                            'whtmoney'=> $whtmoney,
                            'grandtotal'=> $grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datass[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>3];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


						}

						if($typetranfer==2){
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "1" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);
							$accounttypeno = $databank[0]->accounttypeno;

							$sqlaccounttypeno = 'SELECT *
													FROM '.$db['fsctaccount'].'.accounttype
													WHERE status = "1"
													AND accounttypeno = "'.$accounttypeno.'" ' ;
							$dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

							$accnumber = $dataaccnumber[0]->id;


							// insert  SS  bank
							$list = $dataaccnumber[0]->accounttypefull;
							$arrInert = [ 'id'=>'',
										  'dr'=>$grandtotal,
										  'cr'=>'0',
										  'acc_code'=>$accounttypeno,
										  'branch'=>$branch_id,
										  'status'=> 1,
										  'number_bill'=> $number_bill,
										  'customer_vendor'=>$customerid,
										  'timestamp'=>$datass[0]->date_approved,
										  'code_emp'=> $emp_code,
										  'subtotal'=> $subtotal,
										  'discount'=> $discount,
										  'vat'=> $vat,
										  'vatmoney'=> $vatmoney,
										  'wht'=> $wht,
										  'whtmoney'=> $whtmoney,
										  'grandtotal'=> $grandtotal,
										  'type_income'=>'1' ,
										  'type_journal'=>4 ,
										  'id_type_ref_journal'=>$id,
										  'timereal'=>date('Y-m-d H:i:s'),
										  'list'=> $list,
										  'type_buy'=>11];

							DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							// insert เงินสด ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า

							// $list = 'ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า ';
							// $accaccdepreciation= $accCode['accdepreciation'];
							// 	$arrInert = [ 'id'=>'',
							// 				  'dr'=>$totalpricedepreciation,
							// 				  'cr'=>'0',
							// 				  'acc_code'=>$accaccdepreciation,
							// 				  'branch'=>$branch_id,
							// 				  'status'=> 1,
							// 				  'number_bill'=> $number_bill,
							// 				  'customer_vendor'=>$customerid,
							// 				  'timestamp'=>$datass[0]->date_approved,
							// 				  'code_emp'=> $emp_code,
							// 				  'subtotal'=> $subtotal,
							// 				  'discount'=> $discount,
							// 				  'vat'=> $vat,
							// 				  'vatmoney'=> $vatmoney,
							// 				  'wht'=> $wht,
							// 				  'whtmoney'=> $whtmoney,
							// 				  'grandtotal'=> $grandtotal,
							// 				  'type_income'=>'1' ,
							// 				  'type_journal'=>4 ,
							// 				  'id_type_ref_journal'=>$id,
							// 				  'timereal'=>date('Y-m-d H:i:s'),
							// 				  'list'=> $list,
							// 				  'type_buy'=>11];
              //
							// DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
              //
              //
							// // insert  เครื่องมือ-อุปกรณ์ให้เช่า
							// $list = 'เครื่องมือ-อุปกรณ์ให้เช่า';
							// $grandtotaltool = $subtotal-$discountmoney+$discountmoney;
							// $acctool= $accCode['acctool'];
							// 		$arrInert = [ 'id'=>'',
							// 				  'dr'=>'0',
							// 				  'cr'=>$grandtotaltool,
							// 				  'acc_code'=>$acctool,
							// 				  'branch'=>$branch_id,
							// 				  'status'=> 1,
							// 				  'number_bill'=> $number_bill,
							// 				  'customer_vendor'=>$customerid,
							// 				  'timestamp'=>$datass[0]->date_approved,
							// 				  'code_emp'=> $emp_code,
							// 				  'subtotal'=> $subtotal,
							// 				  'discount'=> $discount,
							// 				  'vat'=> $vat,
							// 				  'vatmoney'=> $vatmoney,
							// 				  'wht'=> $wht,
							// 				  'whtmoney'=> $whtmoney,
							// 				  'grandtotal'=> $grandtotal,
							// 				  'type_income'=>'1' ,
							// 				  'type_journal'=>4 ,
							// 				  'id_type_ref_journal'=>$id,
							// 				  'timereal'=>date('Y-m-d H:i:s'),
							// 				  'list'=> $list,
							// 				  'type_buy'=>11];
              //
							// 	DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

							// insert  vat bank
							$list = 'ภาษีขาย';
							$accvat= $accCode['accvat'];
									$arrInert = [ 'id'=>'',
											  'dr'=>'0',
											  'cr'=>$vatmoney,
											  'acc_code'=>$accvat,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											 'timestamp'=>$datass[0]->date_approved,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>11];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                $list = 'กำไร(ขาดทุน)';
                $accdrcr= '322102';
                    $arrInert = [ 'id'=>'',
                          'dr'=>'0',
                          'cr'=>$grandtotal-$vatmoney,
                          'acc_code'=>$accdrcr,
                          'branch'=>$branch_id,
                          'status'=> 1,
                          'number_bill'=> $number_bill,
                          'customer_vendor'=>$customerid,
                          'timestamp'=>$datass[0]->date_approved,
                          'code_emp'=> $emp_code,
                          'subtotal'=> $subtotal,
                          'discount'=> $discount,
                          'vat'=> $vat,
                          'vatmoney'=> $vatmoney,
                          'wht'=> $wht,
                          'whtmoney'=> $whtmoney,
                          'grandtotal'=> $grandtotal,
                          'type_income'=>'1' ,
                          'type_journal'=>4 ,
                          'id_type_ref_journal'=>$datataxtk[0]->id,
                          'timereal'=>date('Y-m-d H:i:s'),
                          'list'=> $list,
                          'type_buy'=>3];

                  DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


						$sqlUpdatebill = ' UPDATE '.$db['fsctaccount'].'.stock_sell_head SET status_ap = 1 WHERE id = "'.$id.'" ';

						$modelupdate = DB::connection('mysql')->select($sqlUpdatebill);

						}



					}


					// ===============================================  END SS  ===============================================//


					// ===============================================  START TI (12) ===============================================//

					if($typeRef==12){

						$sql = 'SELECT '.$db['fsctaccount'].'.taxinvoice_insurance.*
							    FROM '.$db['fsctaccount'].'.taxinvoice_insurance
								WHERE '.$db['fsctaccount'].'.taxinvoice_insurance.id = "'.$id.'" ';
						$datataxra  = DB::connection('mysql')->select($sql);

						// $bill_rent = $data[0]->bill_rent;
						// $sqlinsertcash = 'SELECT *
						// 					FROM '.$db['fsctaccount'].'.insertcashrent
						// 					WHERE status != "99"
						// 					AND typetranfer != "99"
						// 					AND ref = "'.$bill_rent.'"
						// 					AND typedoc = "4" ' ;
            //
						// $datainsertcash = DB::connection('mysql')->select($sqlinsertcash);
            // print_r($data);
            //
            $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_insurance
                					  SET status_ap = "1"
                					  WHERE '.$db['fsctaccount'].'.taxinvoice_insurance.id = "'.$id.'" ';

			      $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);


            $brach =  $datataxra[0]->branch_id;
            $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                       SET status = "99"
                       WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                       AND '.$db['hr_base'].'.msgalert.type_doc  = "12"
                       AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

            $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);

						$gettypemoney = $datataxra[0]->gettypemoney;


						if($gettypemoney==1){ // TI สด
							//         $sqlcash = 'SELECT money
							// 				FROM '.$db['fsctaccount'].'.insertcashrent
							// 				WHERE status != "99"
							// 				AND typetranfer = "1"
							// 				AND ref = "'.$bill_rent.'"
							// 				AND typedoc = "4" ' ;
              //
							// $money = DB::connection('mysql')->select($sqlcash);

							$accCode = Accountcenter::accincome();
              // print_r($accCode);
              //
							// $branch_id = $datataxra[0]->branch_id;
              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }

              $company_id = $datataxra[0]->company_id;
							$sqlbank = 'SELECT *
										FROM '.$db['fsctaccount'].'.bank
										WHERE status = "1"
										AND branch_id = "'.$branch_id.'"
										AND company_id = "'.$company_id.'"
										AND id_cash = "2" ' ;
							$databank = DB::connection('mysql')->select($sqlbank);

							$accounttypeno = $databank[0]->accounttypeno;
							$acccash = $accCode['acccash'];
              $accinsurance = $accCode['accinsurance'];
              $accvat= $accCode['accvat'];
							$number_bill = $datataxra[0]->number_taxinvoice;
							$customerid = $datataxra[0]->customerid;
							$subtotal = $datataxra[0]->subtotal;
							$discount = 0;
							$discountmoney = 0;
							$vat = $datataxra[0]->vat;
							$vatmoney = $datataxra[0]->vatmoney;
							$wht = 0;
							$whtmoney = 0;
							$grandtotal = $datataxra[0]->grandtotal;

							//$customerData = Maincenter::getdatacustomeridandname($customerid);
							 $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

							$customerData = DB::connection('mysql')->select($sqlcustomerData);

								// insert เงินสด TI  cash
								$list = 'เงินสด	';
								$arrInert = [ 'id'=>'',
											  'dr'=>$grandtotal,
											  'cr'=>'0',
											  'acc_code'=>$acccash,
											  'branch'=>$branch_id,
											  'status'=> 1,
											  'number_bill'=> $number_bill,
											  'customer_vendor'=>$customerid,
											  'timestamp'=>$datataxra[0]->time,
											  'code_emp'=> $emp_code,
											  'subtotal'=> $subtotal,
											  'discount'=> $discount,
											  'vat'=> $vat,
											  'vatmoney'=> $vatmoney,
											  'wht'=> $wht,
											  'whtmoney'=> $whtmoney,
											  'grandtotal'=> $grandtotal,
											  'type_income'=>'1' ,
											  'type_journal'=>4 ,
											  'id_type_ref_journal'=>$datataxra[0]->id,
											  'timereal'=>date('Y-m-d H:i:s'),
											  'list'=> $list,
											  'type_buy'=>12];

								DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  //   เงินประกันการเช่า	TI
                $list = 'เงินประกันการเช่า';
                $arrInert = [ 'id'=>'',
                        'dr'=>'0',
                        'cr'=>$subtotal,
                        'acc_code'=>$accinsurance,
                        'branch'=>$branch_id,
                        'status'=> 1,
                        'number_bill'=> $number_bill,
                        'customer_vendor'=>$customerid,
                        'timestamp'=>$datataxra[0]->time,
                        'code_emp'=> $emp_code,
                        'subtotal'=> $subtotal,
                        'discount'=> $discount,
                        'vat'=> $vat,
                        'vatmoney'=> $vatmoney,
                        'wht'=> $wht,
                        'whtmoney'=> $whtmoney,
                        'grandtotal'=> $grandtotal,
                        'type_income'=>'1' ,
                        'type_journal'=>4 ,
                        'id_type_ref_journal'=>$datataxra[0]->id,
                        'timereal'=>date('Y-m-d H:i:s'),
                        'list'=> $list,
                        'type_buy'=>12];

                DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                // VAT  TI

              $list = 'ภาษีขาย';
              $arrInert = [ 'id'=>'',
                      'dr'=>'0',
                      'cr'=>$vatmoney,
                      'acc_code'=>$accvat,
                      'branch'=>$branch_id,
                      'status'=> 1,
                      'number_bill'=> $number_bill,
                      'customer_vendor'=>$customerid,
                      'timestamp'=>$datataxra[0]->time,
                      'code_emp'=> $emp_code,
                      'subtotal'=> $subtotal,
                      'discount'=> $discount,
                      'vat'=> $vat,
                      'vatmoney'=> $vatmoney,
                      'wht'=> $wht,
                      'whtmoney'=> $whtmoney,
                      'grandtotal'=> $grandtotal,
                      'type_income'=>'1' ,
                      'type_journal'=>4 ,
                      'id_type_ref_journal'=>$datataxra[0]->id,
                      'timereal'=>date('Y-m-d H:i:s'),
                      'list'=> $list,
                      'type_buy'=>12];

              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
						}

            if($gettypemoney==2){ // TI โอน
              $accCode = Accountcenter::accincome();
              $time =$datataxra[0]->time;
              if($time >= $dateStartset){
                  // echo "new";
                  $branch_id =  substr($datataxra[0]->number_taxinvoice,6,4);
              }else{
                  $branch_id = $datataxra[0]->branch_id;
                  //echo "old";
              }


              $company_id = $datataxra[0]->company_id;

              $sqlbank = 'SELECT *
                    FROM '.$db['fsctaccount'].'.bank
                    WHERE status = "1"
                    AND branch_id = "'.$branch_id.'"
                    AND company_id = "'.$company_id.'"
                    AND id_cash = "2" ' ;
              $databank = DB::connection('mysql')->select($sqlbank);
              $accounttypeno = $databank[0]->accounttypeno;
              //
              $sqlaccounttypeno = 'SELECT *
                          FROM '.$db['fsctaccount'].'.accounttype
                          WHERE status = "1"
                          AND accounttypeno = "'.$accounttypeno.'" ' ;
              $dataaccnumber = DB::connection('mysql')->select($sqlaccounttypeno);

              $accnumber = $dataaccnumber[0]->id;

              // $acccash = $accCode['acccash'];
              $accinsurance = $accCode['accinsurance'];
              $accvat= $accCode['accvat'];
              $number_bill = $datataxra[0]->number_taxinvoice;
              $customerid = $datataxra[0]->customerid;
              $subtotal = $datataxra[0]->subtotal;
              $discount = 0;
              $discountmoney = 0;
              $vat = $datataxra[0]->vat;
              $vatmoney = $datataxra[0]->vatmoney;
              $wht = 0;
              $whtmoney = 0;
              $grandtotal = $datataxra[0]->grandtotal;

              //$customerData = Maincenter::getdatacustomeridandname($customerid);
               $sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
                    CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
                    '.$db['fsctmain'].'.customers.customer_terms as customer_terms,
                    '.$db['fsctmain'].'.customers.customerid as id
                    FROM '.$db['fsctmain'].'.customers
                    INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
                    WHERE customerid = "'.$customerid.'" ';

                $customerData = DB::connection('mysql')->select($sqlcustomerData);

                  // insert  TI  bank
    							$list = $dataaccnumber[0]->accounttypefull;
    							$arrInert = [ 'id'=>'',
    										  'dr'=>$grandtotal,
    										  'cr'=>'0',
    										  'acc_code'=>$accounttypeno,
    										  'branch'=>$branch_id,
    										  'status'=> 1,
    										  'number_bill'=> $number_bill,
    										  'customer_vendor'=>$customerid,
    										  'timestamp'=>$datataxra[0]->time,
    										  'code_emp'=> $emp_code,
    										  'subtotal'=> $subtotal,
    										  'discount'=> $discount,
    										  'vat'=> $vat,
    										  'vatmoney'=> $vatmoney,
    										  'wht'=> $wht,
    										  'whtmoney'=> $whtmoney,
    										  'grandtotal'=> $grandtotal,
    										  'type_income'=>'1' ,
    										  'type_journal'=>4 ,
    										  'id_type_ref_journal'=>$datataxra[0]->id,
    										  'timereal'=>date('Y-m-d H:i:s'),
    										  'list'=> $list,
    										  'type_buy'=>12];

    							DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


                    //   เงินประกันการเช่า	TI
                  $list = 'เงินประกันการเช่า';
                  $arrInert = [ 'id'=>'',
                          'dr'=>'0',
                          'cr'=>$subtotal,
                          'acc_code'=>$accinsurance,
                          'branch'=>$branch_id,
                          'status'=> 1,
                          'number_bill'=> $number_bill,
                          'customer_vendor'=>$customerid,
                          'timestamp'=>$datataxra[0]->time,
                          'code_emp'=> $emp_code,
                          'subtotal'=> $subtotal,
                          'discount'=> $discount,
                          'vat'=> $vat,
                          'vatmoney'=> $vatmoney,
                          'wht'=> $wht,
                          'whtmoney'=> $whtmoney,
                          'grandtotal'=> $grandtotal,
                          'type_income'=>'1' ,
                          'type_journal'=>4 ,
                          'id_type_ref_journal'=>$datataxra[0]->id,
                          'timereal'=>date('Y-m-d H:i:s'),
                          'list'=> $list,
                          'type_buy'=>12];

                  DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  // VAT  TI

                $list = 'ภาษีขาย';
                $arrInert = [ 'id'=>'',
                        'dr'=>'0',
                        'cr'=>$vatmoney,
                        'acc_code'=>$accvat,
                        'branch'=>$branch_id,
                        'status'=> 1,
                        'number_bill'=> $number_bill,
                        'customer_vendor'=>$customerid,
                        'timestamp'=>$datataxra[0]->time,
                        'code_emp'=> $emp_code,
                        'subtotal'=> $subtotal,
                        'discount'=> $discount,
                        'vat'=> $vat,
                        'vatmoney'=> $vatmoney,
                        'wht'=> $wht,
                        'whtmoney'=> $whtmoney,
                        'grandtotal'=> $grandtotal,
                        'type_income'=>'1' ,
                        'type_journal'=>4 ,
                        'id_type_ref_journal'=>$datataxra[0]->id,
                        'timereal'=>date('Y-m-d H:i:s'),
                        'list'=> $list,
                        'type_buy'=>12];

                DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

            }




						//



					}

					// ===============================================  END TI  ===============================================//

					// ===============================================  START CI (13) ===============================================//

					if($typeRef==13){

						$accCode = Accountcenter::accincome();
						$sql = 'SELECT '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.*
							FROM '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote
							WHERE '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.id = "'.$id.'" ';
						$datataxcn = DB::connection('mysql')->select($sql);
						$number_bill = $datataxcn[0]->number_taxinvoice;

            ///      Update  status_approved
			      $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote
					                 SET status_ap = "1"
					                 WHERE '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.id = "'.$id.'" ';

			     $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

  ///     Update status msg alert hr
            $brach =  $datataxcn[0]->branch_id;
            $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                      SET status = "99"
                      WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                      AND '.$db['hr_base'].'.msgalert.type_doc  = "13"
                      AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

            $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


						//$branch_id = $datataxcn[0]->branch_id;
            $time =$datataxcn[0]->time;
            if($time >= $dateStartset){
                // echo "new";
                $branch_id =  substr($datataxcn[0]->number_taxinvoice,6,4);
            }else{
                $branch_id = $datataxcn[0]->branch_id;
                //echo "old";
            }


						$company_id = $datataxcn[0]->company_id;
						$customerid = $datataxcn[0]->customerid;
						$sqlbank = 'SELECT *
									FROM '.$db['fsctaccount'].'.bank
									WHERE status = "1"
									AND branch_id = "'.$branch_id.'"
									AND company_id = "'.$company_id.'"
									AND id_cash = "4" ' ;
						$databank = DB::connection('mysql')->select($sqlbank);
						$accounttypeno = $databank[0]->accounttypeno;

						$sqlcustomerData ='SELECT CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname , "   ",'.$db['fsctmain'].'.customers.customerid ) as label,
										CONCAT('.$db['fsctaccount'].'.initial.per , " ",'.$db['fsctmain'].'.customers.name  , "   ", '.$db['fsctmain'].'.customers.lastname )  as value,
										'.$db['fsctmain'].'.customers.customer_terms as customer_terms,
										'.$db['fsctmain'].'.customers.customerid as id
										FROM '.$db['fsctmain'].'.customers
										INNER JOIN '.$db['fsctaccount'].'.initial ON '.$db['fsctmain'].'.customers.initial = '.$db['fsctaccount'].'.initial.id
										WHERE customerid = "'.$customerid.'" ';

						$customerData = DB::connection('mysql')->select($sqlcustomerData);

						// insert คืนประกัน
						$list = 'คืนประกัน   '.$customerData[0]->value;;
						$subtotal = $datataxcn[0]->subtotal;
						$vatmoney = $subtotal * ($datataxcn[0]->vat/100);
						$grandtotal = $datataxcn[0]->grandtotal;
						$discount = 0;
						$acctool= $accCode['acctool'];
								$arrInert = [ 'id'=>'',
										  'dr'=>$subtotal,
										  'cr'=>0,
										  'acc_code'=>$acctool,
										  'branch'=>$branch_id,
										  'status'=> 1,
										  'number_bill'=> $number_bill,
										  'customer_vendor'=>$customerid,
										  'timestamp'=>$datataxcn[0]->time,
										  'code_emp'=> $emp_code,
										  'subtotal'=> $subtotal,
										  'discount'=> $discount,
										  'vat'=> $datataxcn[0]->vat,
										  'vatmoney'=> $vatmoney,
										  'wht'=> 0,
										  'whtmoney'=> 0,
										  'grandtotal'=> $grandtotal,
										  'type_income'=>'1' ,
										  'type_journal'=>4 ,
										  'id_type_ref_journal'=>$datataxcn[0]->id,
										  'timereal'=>date('Y-m-d H:i:s'),
										  'list'=> $list,
										  'type_buy'=>9];

							DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


						// insert vat
						$list = 'ภาษีขาย' ;

						$accvat= $accCode['accvat'];
								$arrInert = [ 'id'=>'',
										  'dr'=>$vatmoney,
										  'cr'=>0,
										  'acc_code'=>$accvat,
										  'branch'=>$branch_id,
										  'status'=> 1,
										  'number_bill'=> $number_bill,
										  'customer_vendor'=>$customerid,
										  'timestamp'=>$datataxcn[0]->time,
										  'code_emp'=> $emp_code,
										  'subtotal'=> $subtotal,
										  'discount'=> $discount,
										  'vat'=> $datataxcn[0]->vat,
										  'vatmoney'=> $vatmoney,
										  'wht'=> 0,
										  'whtmoney'=> 0,
										  'grandtotal'=> $grandtotal,
										  'type_income'=>'1' ,
										  'type_journal'=>4 ,
										  'id_type_ref_journal'=>$datataxcn[0]->id,
										  'timereal'=>date('Y-m-d H:i:s'),
										  'list'=> $list,
										  'type_buy'=>9];

							DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

						$brname = Maincenter::databranchbycode($branch_id);
						// insert เงินฝากออมทรัพย์
						$list = 'เงินฝากออมทรัพย์  KBANK '.$databank[0]->number_bank .'('.$brname[0]->name_branch.')';

								$arrInert = [ 'id'=>'',
										  'dr'=>'0',
										  'cr'=>$grandtotal,
										  'acc_code'=>$accounttypeno,
										  'branch'=>$branch_id,
										  'status'=> 1,
										  'number_bill'=> $number_bill,
										  'customer_vendor'=>$customerid,
										  'timestamp'=>$datataxcn[0]->time,
										  'code_emp'=> $emp_code,
										  'subtotal'=> $subtotal,
										  'discount'=> $discount,
										  'vat'=> $datataxcn[0]->vat,
										  'vatmoney'=> $vatmoney,
										  'wht'=> 0,
										  'whtmoney'=> 0,
										  'grandtotal'=> $grandtotal,
										  'type_income'=>'1' ,
										  'type_journal'=>4 ,
										  'id_type_ref_journal'=>$datataxcn[0]->id,
										  'timereal'=>date('Y-m-d H:i:s'),
										  'list'=> $list,
										  'type_buy'=>9];

							DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


					}

					// ===============================================  END CI  ===============================================//

					// ===============================================  START BANK1 (14) ===============================================//
					if($typeRef==14){
                // echo "bank1";
                $accCode = Accountcenter::accincome();

                $sqlcash = 'SELECT '.$db['fsctaccount'].'.checkbank.*
                            FROM '.$db['fsctaccount'].'.checkbank
                             WHERE  '.$db['fsctaccount'].'.checkbank.id = "'.$id.'" ';
            //   echo $sqlcash;
            //
                 $datacash = DB::connection('mysql')->select($sqlcash);


                ///      Update  status_approved
                $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.checkbank
                               SET status_ap1= "1"
                               WHERE '.$db['fsctaccount'].'.checkbank.id = "'.$id.'" ';

               $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

      ///     Update status msg alert hr
                $brach =  $datacash[0]->branch_id;
                $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                          SET status = "99"
                          WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                          AND '.$db['hr_base'].'.msgalert.type_doc  = "14"
                          AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

                $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


                $branch_id = $datacash[0]->branch_id;

                $sqlhr = 'SELECT *
    									FROM '.$db['hr_base'].'.branch
    									WHERE status = "1"
    									AND code_branch = "'.$branch_id.'"  ' ;

                $ComResulte = DB::connection('mysql')->select($sqlhr);
                $company_id = $ComResulte[0]->company_id;

                $sqlbank = 'SELECT *
                      FROM '.$db['fsctaccount'].'.bank
                      WHERE status = "1"
                      AND branch_id = "'.$branch_id.'"
                      AND company_id = "'.$company_id.'"
                      AND id_cash = "1" ' ;
                $databank = DB::connection('mysql')->select($sqlbank);

                // echo "<pre>";
                // print_r($databank);
                // echo "<br>";
                // //print_r($datacash);
                //
                // insert เงินฝากออมทรัพย์
                $list = 'เงินฝากออมทรัพย์  KBANK '.$databank[0]->number_bank .'('.$databank[0]->name_bank.')';

                  $arrInert = [ 'id'=>'',
                        'dr'=>$datacash[0]->grandtotal,
                        'cr'=>'0',
                        'acc_code'=>$accCode['acccash'],
                        'branch'=>$branch_id,
                        'status'=> 1,
                        'number_bill'=> $datacash[0]->bill_no,
                        'customer_vendor'=>'',
                        'timestamp'=>$datacash[0]->time,
                        'code_emp'=> $datacash[0]->codeemp,
                        'subtotal'=> $datacash[0]->grandtotal,
                        'discount'=> 0,
                        'vat'=> 0,
                        'vatmoney'=> 0,
                        'wht'=> 0,
                        'whtmoney'=> 0,
                        'grandtotal'=> $datacash[0]->grandtotal,
                        'type_income'=>'1' ,
                        'type_journal'=>4 ,
                        'id_type_ref_journal'=>$datacash[0]->id,
                        'timereal'=>date('Y-m-d H:i:s'),
                        'list'=> $list,
                        'type_buy'=>14];


                  DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  // insert เงินสด
                  $list = 'เงินสด  ';

                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$datacash[0]->grandtotal,
                            'acc_code'=>$accCode['acccash'],
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $datacash[0]->bill_no,
                            'customer_vendor'=>'',
                            'timestamp'=>$datacash[0]->time,
                            'code_emp'=> $datacash[0]->codeemp,
                            'subtotal'=> $datacash[0]->grandtotal,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $datacash[0]->grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datacash[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>14];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

					}

					// ===============================================  END BANK1  ===============================================//

					// ===============================================  START BANK2 (15) ===============================================//
					if($typeRef==15){
                // echo "bank2";
                $accCode = Accountcenter::accincome();

                $sqlcash = 'SELECT '.$db['fsctaccount'].'.checkbank.*
                            FROM '.$db['fsctaccount'].'.checkbank
                             WHERE  '.$db['fsctaccount'].'.checkbank.id = "'.$id.'" ';
              //   echo $sqlcash;
              //
                 $datacash = DB::connection('mysql')->select($sqlcash);


                ///      Update  status_approved
                $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.checkbank
                               SET status_ap2= "1"
                               WHERE '.$db['fsctaccount'].'.checkbank.id = "'.$id.'" ';

               $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

              ///     Update status msg alert hr
                $brach =  $datacash[0]->branch_id;
                $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                          SET status = "99"
                          WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                          AND '.$db['hr_base'].'.msgalert.type_doc  = "15"
                          AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

                $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


                $branch_id = $datacash[0]->branch_id;

                $sqlhr = 'SELECT *
                      FROM '.$db['hr_base'].'.branch
                      WHERE status = "1"
                      AND code_branch = "'.$branch_id.'"  ' ;

                $ComResulte = DB::connection('mysql')->select($sqlhr);
                $company_id = $ComResulte[0]->company_id;

                $sqlbank = 'SELECT *
                      FROM '.$db['fsctaccount'].'.bank
                      WHERE status = "1"
                      AND branch_id = "'.$branch_id.'"
                      AND company_id = "'.$company_id.'"
                      AND id_cash = "2" ' ;
                $databank = DB::connection('mysql')->select($sqlbank);

                // echo "<pre>";
                // print_r($databank);
                // echo "<br>";
                // //print_r($datacash);
                //
                // insert เงินฝากออมทรัพย์
                $list = 'เงินฝากออมทรัพย์  KBANK '.$databank[0]->number_bank .'('.$databank[0]->name_bank.')';

                  $arrInert = [ 'id'=>'',
                        'dr'=>$datacash[0]->grandtotal1,
                        'cr'=>'0',
                        'acc_code'=>$accCode['acccash'],
                        'branch'=>$branch_id,
                        'status'=> 1,
                        'number_bill'=> $datacash[0]->bill_no,
                        'customer_vendor'=>'',
                        'timestamp'=>$datacash[0]->time,
                        'code_emp'=> $datacash[0]->codeemp,
                        'subtotal'=> $datacash[0]->grandtotal,
                        'discount'=> 0,
                        'vat'=> 0,
                        'vatmoney'=> 0,
                        'wht'=> 0,
                        'whtmoney'=> 0,
                        'grandtotal'=> $datacash[0]->grandtotal,
                        'type_income'=>'1' ,
                        'type_journal'=>4 ,
                        'id_type_ref_journal'=>$datacash[0]->id,
                        'timereal'=>date('Y-m-d H:i:s'),
                        'list'=> $list,
                        'type_buy'=>15];


                  DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  // insert เงินสด
                  $list = 'เงินสด  ';

                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$datacash[0]->grandtotal1,
                            'acc_code'=>$accCode['acccash'],
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $datacash[0]->bill_no,
                            'customer_vendor'=>'',
                            'timestamp'=>$datacash[0]->time,
                            'code_emp'=> $datacash[0]->codeemp,
                            'subtotal'=> $datacash[0]->grandtotal,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $datacash[0]->grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datacash[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>15];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


					}

					// ===============================================  END BANK2  ===============================================//


					// ===============================================  START BANK3 (16) ===============================================//
					if($typeRef==16){
                  // echo "bank3";
                  $accCode = Accountcenter::accincome();

                  $sqlcash = 'SELECT '.$db['fsctaccount'].'.checkbank.*
                              FROM '.$db['fsctaccount'].'.checkbank
                               WHERE  '.$db['fsctaccount'].'.checkbank.id = "'.$id.'" ';
                //   echo $sqlcash;
                //
                   $datacash = DB::connection('mysql')->select($sqlcash);


                  ///      Update  status_approved
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.checkbank
                                 SET status_ap3= "1"
                                 WHERE '.$db['fsctaccount'].'.checkbank.id = "'.$id.'" ';

                 $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

                ///     Update status msg alert hr
                  $brach =  $datacash[0]->branch_id;
                  $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                            SET status = "99"
                            WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                            AND '.$db['hr_base'].'.msgalert.type_doc  = "16"
                            AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

                  $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


                  $branch_id = $datacash[0]->branch_id;

                  $sqlhr = 'SELECT *
                        FROM '.$db['hr_base'].'.branch
                        WHERE status = "1"
                        AND code_branch = "'.$branch_id.'"  ' ;

                  $ComResulte = DB::connection('mysql')->select($sqlhr);
                  $company_id = $ComResulte[0]->company_id;

                  $sqlbank = 'SELECT *
                        FROM '.$db['fsctaccount'].'.bank
                        WHERE status = "1"
                        AND branch_id = "'.$branch_id.'"
                        AND company_id = "'.$company_id.'"
                        AND id_cash = "3" ' ;
                  $databank = DB::connection('mysql')->select($sqlbank);

                  // echo "<pre>";
                  // print_r($databank);
                  // echo "<br>";
                  // //print_r($datacash);
                  //
                  // insert เงินฝากออมทรัพย์
                  $list = 'เงินฝากออมทรัพย์  KBANK '.$databank[0]->number_bank .'('.$databank[0]->name_bank.')';

                    $arrInert = [ 'id'=>'',
                          'dr'=>$datacash[0]->grandtotal2,
                          'cr'=>'0',
                          'acc_code'=>$accCode['acccash'],
                          'branch'=>$branch_id,
                          'status'=> 1,
                          'number_bill'=> $datacash[0]->bill_no,
                          'customer_vendor'=>'',
                          'timestamp'=>$datacash[0]->time,
                          'code_emp'=> $datacash[0]->codeemp,
                          'subtotal'=> $datacash[0]->grandtotal,
                          'discount'=> 0,
                          'vat'=> 0,
                          'vatmoney'=> 0,
                          'wht'=> 0,
                          'whtmoney'=> 0,
                          'grandtotal'=> $datacash[0]->grandtotal,
                          'type_income'=>'1' ,
                          'type_journal'=>4 ,
                          'id_type_ref_journal'=>$datacash[0]->id,
                          'timereal'=>date('Y-m-d H:i:s'),
                          'list'=> $list,
                          'type_buy'=>16];


                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                    // insert เงินสด
                    $list = 'เงินสด  ';

                        $arrInert = [ 'id'=>'',
                              'dr'=>'0',
                              'cr'=>$datacash[0]->grandtotal2,
                              'acc_code'=>$accCode['acccash'],
                              'branch'=>$branch_id,
                              'status'=> 1,
                              'number_bill'=> $datacash[0]->bill_no,
                              'customer_vendor'=>'',
                              'timestamp'=>$datacash[0]->time,
                              'code_emp'=> $datacash[0]->codeemp,
                              'subtotal'=> $datacash[0]->grandtotal,
                              'discount'=> 0,
                              'vat'=> 0,
                              'vatmoney'=> 0,
                              'wht'=> 0,
                              'whtmoney'=> 0,
                              'grandtotal'=> $datacash[0]->grandtotal,
                              'type_income'=>'1' ,
                              'type_journal'=>4 ,
                              'id_type_ref_journal'=>$datacash[0]->id,
                              'timereal'=>date('Y-m-d H:i:s'),
                              'list'=> $list,
                              'type_buy'=>16];

                      DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);



					}

					// ===============================================  END BANK3  ===============================================//

					// ===============================================  START BANK4 (17) ===============================================//
					if($typeRef==17){
                // echo "bank4";
                $accCode = Accountcenter::accincome();

                $sqlcash = 'SELECT '.$db['fsctaccount'].'.checkbank.*
                            FROM '.$db['fsctaccount'].'.checkbank
                             WHERE  '.$db['fsctaccount'].'.checkbank.id = "'.$id.'" ';
              //   echo $sqlcash;
              //
                 $datacash = DB::connection('mysql')->select($sqlcash);


                ///      Update  status_approved
                $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.checkbank
                               SET status_ap3= "1"
                               WHERE '.$db['fsctaccount'].'.checkbank.id = "'.$id.'" ';

               $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

              ///     Update status msg alert hr
                $brach =  $datacash[0]->branch_id;
                $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                          SET status = "99"
                          WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                          AND '.$db['hr_base'].'.msgalert.type_doc  = "17"
                          AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

                $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


                $branch_id = $datacash[0]->branch_id;

                $sqlhr = 'SELECT *
                      FROM '.$db['hr_base'].'.branch
                      WHERE status = "1"
                      AND code_branch = "'.$branch_id.'"  ' ;

                $ComResulte = DB::connection('mysql')->select($sqlhr);
                $company_id = $ComResulte[0]->company_id;

                $sqlbank = 'SELECT *
                      FROM '.$db['fsctaccount'].'.bank
                      WHERE status = "1"
                      AND branch_id = "'.$branch_id.'"
                      AND company_id = "'.$company_id.'"
                      AND id_cash = "3" ' ;
                $databank = DB::connection('mysql')->select($sqlbank);

                // echo "<pre>";
                // print_r($databank);
                // echo "<br>";
                // //print_r($datacash);
                //
                // insert เงินฝากออมทรัพย์
                $list = 'เงินฝากออมทรัพย์  KBANK '.$databank[0]->number_bank .'('.$databank[0]->name_bank.')';

                  $arrInert = [ 'id'=>'',
                        'dr'=>$datacash[0]->grandtotal3,
                        'cr'=>'0',
                        'acc_code'=>$databank[0]->accounttypeno,
                        'branch'=>$branch_id,
                        'status'=> 1,
                        'number_bill'=> $datacash[0]->bill_no,
                        'customer_vendor'=>'',
                        'timestamp'=>$datacash[0]->time,
                        'code_emp'=> $datacash[0]->codeemp,
                        'subtotal'=> $datacash[0]->grandtotal,
                        'discount'=> 0,
                        'vat'=> 0,
                        'vatmoney'=> 0,
                        'wht'=> 0,
                        'whtmoney'=> 0,
                        'grandtotal'=> $datacash[0]->grandtotal,
                        'type_income'=>'1' ,
                        'type_journal'=>4 ,
                        'id_type_ref_journal'=>$datacash[0]->id,
                        'timereal'=>date('Y-m-d H:i:s'),
                        'list'=> $list,
                        'type_buy'=>17];


                  DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  // insert เงินสด
                  $list = 'เงินสด  ';

                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$datacash[0]->grandtotal3,
                            'acc_code'=>$accCode['acccash'],
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $datacash[0]->bill_no,
                            'customer_vendor'=>'',
                            'timestamp'=>$datacash[0]->time,
                            'code_emp'=> $datacash[0]->codeemp,
                            'subtotal'=> $datacash[0]->grandtotal,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $datacash[0]->grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datacash[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>17];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);




					}

					// ===============================================  END BANK4  ===============================================//


					// ===============================================  START PO (18) ===============================================//
					if($typeRef==18){
                  $accCode = Accountcenter::accincome();
                  //echo $id;
                  $sql = 'SELECT '.$db['fsctaccount'].'.po_head.*
                              FROM '.$db['fsctaccount'].'.po_head
                               WHERE  '.$db['fsctaccount'].'.po_head.id = "'.$id.'" ';
                //   echo $sqlcash;
                //
                   $datapo = DB::connection('mysql')->select($sql);


                  ///      Update  status_approved
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.po_head
                                 SET status_ap= "1"
                                 WHERE '.$db['fsctaccount'].'.po_head.id = "'.$id.'" ';

                 $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

                ///     Update status msg alert hr
                  $branch_id =  $datapo[0]->branch_id;
                  $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                            SET status = "99"
                            WHERE '.$db['hr_base'].'.msgalert.branch = "'.$branch_id.'"
                            AND '.$db['hr_base'].'.msgalert.type_doc  = "18"
                            AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

                  $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);



                  $sqlhr = 'SELECT *
                        FROM '.$db['hr_base'].'.branch
                        WHERE status = "1"
                        AND code_branch = "'.$branch_id.'"  ' ;

                  $ComResulte = DB::connection('mysql')->select($sqlhr);
                  $company_id = $ComResulte[0]->company_id;



                  $sqlbank = 'SELECT *
                        FROM '.$db['fsctaccount'].'.bank
                        WHERE status = "1"
                        AND branch_id = "'.$branch_id.'"
                        AND company_id = "'.$company_id.'"
                        AND id_cash = "3" ' ;
                  $databank = DB::connection('mysql')->select($sqlbank);

                  // insert เงินฝากออมทรัพย์
                  $list = 'เงินฝากออมทรัพย์  KBANK '.$databank[0]->number_bank .'('.$databank[0]->name_bank.')';

                    $arrInert = [ 'id'=>'',
                          'dr'=>$datapo[0]->totolsumall,
                          'cr'=>'0',
                          'acc_code'=>$databank[0]->accounttypeno,
                          'branch'=>$branch_id,
                          'status'=> 1,
                          'number_bill'=> $datacash[0]->bill_no,
                          'customer_vendor'=>'0',
                          'timestamp'=>$datapo[0]->datemdtranfer,
                          'code_emp'=> '1002',
                          'subtotal'=> $datapo[0]->totolsumall,
                          'discount'=> 0,
                          'vat'=> 0,
                          'vatmoney'=> 0,
                          'wht'=> 0,
                          'whtmoney'=> 0,
                          'grandtotal'=> $datapo[0]->totolsumall,
                          'type_income'=>'1' ,
                          'type_journal'=>4 ,
                          'id_type_ref_journal'=>$datapo[0]->id,
                          'timereal'=>date('Y-m-d H:i:s'),
                          'list'=> $list,
                          'type_buy'=>18];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                    $statusbank = $datapo[0]->statusbank;

                    $list = '';
                    if($statusbank == 0){
                          $list = 'เงินกู้ยืมกรรมการ	';
                    }else if($statusbank == 1){
                          $list =  "เงินฝากออมทรัพย์ KBANK 587-2-21903-1 (เชียงใหม่)";
                    }else{
                      $accCodeBank = $datapo->banktranfer;
                      $db = Connectdb::Databaseall();
                      $sqaccshow = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                             FROM '.$db['fsctaccount'].'.accounttype
                             WHERE  '.$db['fsctaccount'].'.accounttype.accounttypeno = "'.$accCodeBank.'" ';

                      $dataacccode = DB::connection('mysql')->select($sqaccshow);
                          $list =  $dataacccode[0]->accounttypefull;
                    }



                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$datapo[0]->totolsumall,
                            'acc_code'=>$accCode['accdeptmd'],
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $datacash[0]->bill_no,
                            'customer_vendor'=>'',
                            'timestamp'=>$datapo[0]->datemdtranfer,
                            'code_emp'=> '1002',
                            'subtotal'=> $datapo[0]->totolsumall,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $datapo[0]->totolsumall,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$datapo[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>18];

                      DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);



					}

					// ===============================================  END PO  ===============================================//

					// ===============================================  START CI สาขา (19) ===============================================//
					if($typeRef==19){
                // echo $id;
                //
                  $accCode = Accountcenter::accincome();
                  $sql = 'SELECT '.$db['fsctaccount'].'.taxinvoice_insurance.*
                          FROM '.$db['fsctaccount'].'.taxinvoice_insurance
                          WHERE  '.$db['fsctaccount'].'.taxinvoice_insurance.id = "'.$id.'" ';

                  $data = DB::connection('mysql')->select($sql);
                  // echo "<pre>";
                  // print_r($data);
                  ///      Update  status_approved
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_insurance
                                 SET status_ap1= "1"
                                 WHERE '.$db['fsctaccount'].'.taxinvoice_insurance.id = "'.$id.'" ';

                 $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

                ///     Update status msg alert hr
                  $branch_id =  $datapo[0]->branch_id;
                  $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                            SET status = "99"
                            WHERE '.$db['hr_base'].'.msgalert.branch = "'.$branch_id.'"
                            AND '.$db['hr_base'].'.msgalert.type_doc  = "19"
                            AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$id.'" ';

                  $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);


                  $sqlhr = 'SELECT *
                        FROM '.$db['hr_base'].'.branch
                        WHERE status = "1"
                        AND code_branch = "'.$branch_id.'"  ' ;

                  $ComResulte = DB::connection('mysql')->select($sqlhr);
                  $company_id = $ComResulte[0]->company_id;

                  $sqlbank = 'SELECT *
                        FROM '.$db['fsctaccount'].'.bank
                        WHERE status = "1"
                        AND branch_id = "'.$branch_id.'"
                        AND company_id = "'.$company_id.'"
                        AND id_cash = "3" ' ;
                  $databank = DB::connection('mysql')->select($sqlbank);

                  // insert เงินฝากออมทรัพย์
                  $list = 'เงินฝากออมทรัพย์  KBANK '.$databank[0]->number_bank .'('.$databank[0]->name_bank.')';

                    $arrInert = [ 'id'=>'',
                          'dr'=>$data[0]->grandtotal,
                          'cr'=>'0',
                          'acc_code'=>$data[0]->accounttypeno,
                          'branch'=>$branch_id,
                          'status'=> 1,
                          'number_bill'=> $data[0]->number_taxinvoice,
                          'customer_vendor'=>'',
                          'timestamp'=>$data[0]->time,
                          'code_emp'=> '1002',
                          'subtotal'=> $data[0]->grandtotal,
                          'discount'=> 0,
                          'vat'=> 0,
                          'vatmoney'=> 0,
                          'wht'=> 0,
                          'whtmoney'=> 0,
                          'grandtotal'=> $data[0]->grandtotal,
                          'type_income'=>'1' ,
                          'type_journal'=>4 ,
                          'id_type_ref_journal'=>$data[0]->id,
                          'timereal'=>date('Y-m-d H:i:s'),
                          'list'=> $list,
                          'type_buy'=>19];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);


                    $list = '';
                    $accSet = $data[0]->banktranfer;
                      $sqaccshow = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                             FROM '.$db['fsctaccount'].'.accounttype
                             WHERE  '.$db['fsctaccount'].'.accounttype.accounttypeno = "'.$accSet.'" ';

                    $dataacccode = DB::connection('mysql')->select($sqaccshow);
                    if(!empty($dataacccode)){
                          $list = $value19->banktranfer;
                    }else{
                          $list = 221100;
                    }


                      $arrInert = [ 'id'=>'',
                            'dr'=>'0',
                            'cr'=>$data[0]->grandtotal,
                            'acc_code'=>$accCode['accdeptmd'],
                            'branch'=>$branch_id,
                            'status'=> 1,
                            'number_bill'=> $datacash[0]->number_taxinvoice,
                            'customer_vendor'=>'',
                            'timestamp'=>$data[0]->time,
                            'code_emp'=> '1002',
                            'subtotal'=> $data[0]->grandtotal,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $data[0]->grandtotal,
                            'type_income'=>'1' ,
                            'type_journal'=>4 ,
                            'id_type_ref_journal'=>$data[0]->id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>19];

                      DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);






					}

					// ===============================================  END CI สาขา  ===============================================//


					// ===============================================  START GL (20) ===============================================//
					if($typeRef==20){

              // echo $id;

              $sqljournal_general = 'SELECT '.$db['fsctaccount'].'.journal_5.*
                                    FROM '.$db['fsctaccount'].'.journal_5
                                     WHERE '.$db['fsctaccount'].'.journal_5.id  = "'.$id.'"  ';

             $datajournal_general = DB::connection('mysql')->select($sqljournal_general);
             // print_r($datajournal_general);
             $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.journal_5
                            SET accept = "1"
                            WHERE '.$db['fsctaccount'].'.journal_5.id = "'.$id.'" ';
            $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            $sqljournal_generaldetail = 'SELECT '.$db['fsctaccount'].'.journalgeneral_detail.*
                                  FROM '.$db['fsctaccount'].'.journalgeneral_detail
                                   WHERE '.$db['fsctaccount'].'.journalgeneral_detail.id_journalgeneral_head  = "'.$id.'"  ';

            $datajournal_generaldetail = DB::connection('mysql')->select($sqljournal_generaldetail);
             // echo "<pre>";
             // print_r($datajournal_generaldetail);

             $list = '';

             foreach ($datajournal_generaldetail as $key => $value) {
                  $accid = $value->accounttype;
                  $list  =

                  $sqlacc = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                        FROM '.$db['fsctaccount'].'.accounttype
                                         WHERE '.$db['fsctaccount'].'.accounttype.id  = "'.$accid.'"  ';

                 $dataaccthis = DB::connection('mysql')->select($sqlacc);

                 // print_r($dataaccthis);
                 $acccode = $dataaccthis[0]->accounttypeno;
                 $list = $dataaccthis[0]->accounttypefull;
                 if($value->debit!=0.00){
                    // dr
                    $arrInert = [ 'id'=>'',
                          'dr'=>$value->debit,
                          'cr'=>'0',
                          'acc_code'=>$acccode,
                          'branch'=>$datajournal_general[0]->code_branch,
                          'status'=> 1,
                          'number_bill'=> $datajournal_general[0]->number_bill_journal,
                          'customer_vendor'=>'',
                          'timestamp'=>$datajournal_general[0]->datebill,
                          'code_emp'=> '',
                          'subtotal'=> $value->debit,
                          'discount'=> 0,
                          'vat'=> 0,
                          'vatmoney'=> 0,
                          'wht'=> 0,
                          'whtmoney'=> 0,
                          'grandtotal'=> $value->debit,
                          'type_income'=>'1' ,
                          'type_journal'=>4 ,
                          'id_type_ref_journal'=>$id,
                          'timereal'=>date('Y-m-d H:i:s'),
                          'list'=> $list,
                          'type_buy'=>20];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                 }else{
                   //cr
              $arrInert = [ 'id'=>'',
                         'dr'=>'0',
                         'cr'=>$value->credit,
                         'acc_code'=>$acccode,
                         'branch'=>$datajournal_general[0]->code_branch,
                         'status'=> 1,
                         'number_bill'=> $datajournal_general[0]->number_bill_journal,
                         'customer_vendor'=>'',
                         'timestamp'=>$datajournal_general[0]->datebill,
                         'code_emp'=> '',
                         'subtotal'=> $value->credit,
                         'discount'=> 0,
                         'vat'=> 0,
                         'vatmoney'=> 0,
                         'wht'=> 0,
                         'whtmoney'=> 0,
                         'grandtotal'=> $value->credit,
                         'type_income'=>'1' ,
                         'type_journal'=>4 ,
                         'id_type_ref_journal'=>$id,
                         'timereal'=>date('Y-m-d H:i:s'),
                         'list'=> $list,
                         'type_buy'=>20];

                   DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);



                 }

             }








					}

					// ===============================================  END GL  ===============================================//


					//
          //
          //           // --------------------- Insert ----------------------------
          //           // if($debit){
          //               $arrvalue = [];
          //               foreach ($data['branch_id'] as $k =>$v){
          //                   $arrvalue[$k]['dr']= $data['dr'][$k];
          //                   $arrvalue[$k]['cr']= $data['cr'][$k];
          //                   $arrvalue[$k]['acc_code']= $data['acc_code'][$k];
          //                   $arrvalue[$k]['branch']= $data['branch_id'][$k];
          //                   $arrvalue[$k]['number_bill']= $data['number_taxinvoice'][$k];
          //                   $arrvalue[$k]['customer_vendor']= $data['customerid'][$k];
          //                   $arrvalue[$k]['timestamp']= $data['time'][$k];
          //                   $arrvalue[$k]['code_emp']=$emp_code;
          //                   $arrvalue[$k]['type_income']= $data['gettypemoney'][$k];
          //                   $arrvalue[$k]['type_journal']=4;
          //                   $arrvalue[$k]['type_buy']=$data['type_buy'][$k];
          //                   $arrvalue[$k]['id_type_ref_journal']=$data['id_type_ref_journal'][$k];
          //                   $arrvalue[$k]['list']= $data['detail'][$k];
          //                   $arrvalue[$k]['timereal']= $timereal;
          //                   $arrvalue[$k]['status']=1;
          //               }
          //
          //           // if($arrvalue || $arrvalue2){
          //       		// $result = array_merge($arrvalue,$arrvalue2);
          //       		// }
          //
					// 		//
          //           echo "<pre>";
          //           print_r($arrvalue);
          //
          //           $model2 = DB::connection('mysql')->table($db['fsctaccount'].'.'.'ledger')->insert($arrvalue);
          //           // --------------------- Insert ---------------------------


                    // --------------------- Update ---------------------------
                    // if($data['type_buy'] || $data['type_buy2'] == 1){ //RA
                    // $model = DB::connection('mysql')
                    //    ->table($db['fsctaccount'].'.taxinvoice_abb')
                    //    ->where('id',$id)
                    //    ->update(['check_list' => 1]);
                    // }
                    //
                    // if($data['type_buy'] || $data['type_buy2'] == 2){ //TF
                    // $model = DB::connection('mysql')
                    //    ->table($db['fsctaccount'].'.taxinvoice')
                    //    ->where('id',$id)
                    //    ->update(['check_list' => 1]);
                    // }


                    // --------------------- Update ---------------------------



                }

                //เมื่อมีข้อมูลแล้ว
                // return view('journal.journal_income',['datamsg'=>true]) ;
        }
        return view('journal.journal_income',['datamsg'=>true]) ;
      }



      // public function index(){
      //
      //     $debts = DB::connection('mysql2')
      //         ->table('in_debt')
      //         ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
      //         ->join('good', 'good.id', '=', 'po_detail.materialid')
      //         ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
      //         ->orderBy('number_debt', 'asc')
      //         ->where('po_detail.statususe',1)
      //         ->get();
      //     $ap = 'default';
      //
      //     $branchs = new Branch;
      //     $branchs = Branch::get();
      //     // dd($debts);
      //
      //     return view('journal.journal_income', compact('debts', 'ap', 'branchs'));
      // }
      //
      // public function journalincome_filter(Request $request){
      //
      //     $branchs = new Branch;
      //     $branchs = Branch::get();
      //
      //     $date = $request->get('daterange');
      //     $branch = $request->get('branch');
      //
      //     $dateset = Datetime::convertStartToEnd($date);
      //     $start = $dateset['start'];
      //     $end = $dateset['end'];
      //
      //     if ($branch != '0') {
      //         $debts = DB::connection('mysql2')
      //             ->table('in_debt')
      //             ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
      //             ->join('good', 'good.id', '=', 'po_detail.materialid')
      //             ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
      //             ->orderBy('number_debt', 'asc')
      //             ->whereBetween('datebill', [$start, $end])
      //             ->where('branch_id', $branch)
      //             ->get();
      //         // dump('have');
      //     } else {
      //         $debts = DB::connection('mysql2')
      //             ->table('in_debt')
      //             ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
      //             ->join('good', 'good.id', '=', 'po_detail.materialid')
      //             ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
      //             ->orderBy('number_debt', 'asc')
      //             ->whereBetween('datebill', [$start, $end])
      //             ->get();
      //         // dump('empty');
      //     }
      //     $ap = 'default';
      //     // dd($debts);
      //     return view('journal.journal_income', compact('debts', 'ap', 'branchs'));
      // }


      // public function confirm_journal_debt(Request $request){
      //
      //     $list_ap = $request->get('check_list');
      //     $debts = Debt::whereIn('number_debt', $list_ap)
      //         ->get();
      //     foreach ($debts as $key => $debt) {
      //         $debt->accept = 1;
      //         $debt->update();
      //     }
      //     return redirect()->route('journal.debt');
      // }

      public function  savemsgedit(){
          $data= Input::all();
          $db = Connectdb::Databaseall();
          DB::beginTransaction();
          try {
                $brach      = $data['brach'];
                $type_doc   = $data['typedoc'];
                $iddoc      = $data['iddoc'];
                $msg        = $data['message'];
                if($msg==''){
                    DB::rollback();
                    return 0;
                }
                $sqlUpdateMsg = ' UPDATE '.$db['hr_base'].'.msgalert
                          SET status = "99"
                          WHERE '.$db['hr_base'].'.msgalert.branch = "'.$brach.'"
                          AND '.$db['hr_base'].'.msgalert.type_doc  = "'.$type_doc.'"
                          AND '.$db['hr_base'].'.msgalert.iddoc =  "'.$iddoc.'" ';

                $UpdateResulte = DB::connection('mysql')->select($sqlUpdateMsg);

                // echo "<pre>";
                $dataInsert = ['id'=>'',
                               'branch'=>$brach,
                               'type_doc'=>$type_doc,
                               'iddoc'=>$iddoc,
                               'msg'=>$msg,
                               'status'=>1];
                // print_r($dataInsert);


                $model2 = DB::connection('mysql')->table($db['hr_base'].'.'.'msgalert')->insert($dataInsert);

                if($type_doc==1){//RA
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_abb
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_abb.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==2){//TF
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==3){//TK
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_loss
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_loss.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==4){//
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_loss_abb
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_loss_abb.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==5){//TM
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_more
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_more.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==6){//RN
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_more_abb
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_more_abb.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==7){//TP
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_partial
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_partial.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==8){//RO
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_partial_abb
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_partial_abb.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==9){//CN
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_creditnote
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_creditnote.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==10){//RS
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_special_abb
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_special_abb.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==11){//SS
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctmain'].'.stock_sell_head
                            SET status_ap = "2"
                            WHERE '.$db['fsctmain'].'.stock_sell_head.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==12){//TI
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_insurance
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_insurance.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==13){//CI
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==14){//เงินนำฝากธนาคารที่ 1
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.checkbank
                            SET status_ap1 = "2"
                            WHERE '.$db['fsctaccount'].'.checkbank.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==15){//เงินนำฝากธนาคารที่ 2
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.checkbank
                            SET status_ap2 = "2"
                            WHERE '.$db['fsctaccount'].'.checkbank.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==16){//เงินนำฝากธนาคารที่ 3
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.checkbank
                            SET status_ap3 = "2"
                            WHERE '.$db['fsctaccount'].'.checkbank.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==17){//เงินนำฝากธนาคารที่ 4
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.checkbank
                            SET status_ap4 = "2"
                            WHERE '.$db['fsctaccount'].'.checkbank.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==18){//PO
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.po_head
                            SET status_ap = "2"
                            WHERE '.$db['fsctaccount'].'.po_head.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }
                if($type_doc==19){//TI โอนมา
                    // echo "string";
                    //
                  $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote
                            SET status_ap1 = "2"
                            WHERE '.$db['fsctaccount'].'.taxinvoice_insurance_creditnote.id = "'.$iddoc.'" ';

                  $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
                }


              DB::commit();
              return 1;
          } catch (\Throwable $e) {
              DB::rollback();
              throw $e;

          }




      }

}
