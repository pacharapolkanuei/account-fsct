<?php
use  App\Api\Connectdb;
$db = Connectdb::Databaseall();
?>
@extends('index')
@section('content')
<!-- js data table -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/journal_debt.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_debt.css') }}" rel="stylesheet" type="text/css" media="all">

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-holder" id="fontscontent">
                        <h1 class="float-left">Account - FSCT</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">สมุดรายวัน</li>
                            <li class="breadcrumb-item active">สมุดรายวันขาย</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3><i class="fas fa-edit"></i>
                                <fonts id="fontsheader">สมุดรายวันขาย</fonts>
                            </h3><br><br>
                            <!-- date range -->
                            {!! Form::open(['route' => 'journalsale_filter', 'method' => 'post']) !!}
                            <div class="row" class="fontslabel">
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                        </div>
                                        <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <label id="fontslabel"><b>สาขา :</b></label>
                                        <select  name="branch[]" class="form-control select2"  multiple="multiple"   data-placeholder="เลือกสาขา" required>
                                            <option value="0">เลือกสาขา</option>
                                            @foreach ($branchs as $key => $branch)
                                            <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                            @endforeach
                                        </select>
                                        <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;

                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <!-- date range -->
                        </div>

                        <?php
                            // print_r($journals);
                            // exit;
                        ?>
                        <!-- table cotent -->
                        <div class="col" id="fontsjournal">
                            <table class="table table-bordered" >
                                <thead>
                                    <tr style="background-color:#aab6c2;color:white;">
                                        <th scope="col" style="text-align:left;">เลือก</th>
                                        <th scope="col">วัน/เดือน/ปี</th>
                                        <th scope="col">เลขที่ใบวางบิล</th>

                                        <th scope="col">รายละเอียด</th>
                                        <th scope="col">เลขที่บัญชี</th>
                                        <th scope="col">ชื่อเลขที่บัญชี</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">เดบิต</th>
                                        <th scope="col">เครดิต</th>
                                    </tr>
                                </thead>
                                {!! Form::open(['route' => 'confirm_journal_sale', 'method' => 'post']) !!}
                                <tbody>
                                    <!-- นั่งร้าน -->
                                <?php  $totaldebit1 = 0; $totalcredit = 0;?>

                                    @foreach ($journals as $key => $journal)
                                    @if($journal->type == 0)
                                    <tr>
                                        <td>
                                          @if($journal->accept == 0)
                                          <label class="con">
                                          <input type="checkbox" name="check_list[]" value="{{ $journal->invoice_id }}">
                                              <span class="checkmark"></span>
                                          </label>
                                          @else
                                          <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                          @endif
                                        </td>
                                        <td>{{$journal->datetime_out}}</td>
                                        <td>{{$journal->id_run}}</td>

                                        <td>แจ้งหนี้ลูกหนี้การค้า {{$journal->name_customer}}</td>
                                        <td>{{$journal->accounttypeno}}</td>
                                        <td>{{$journal->accounttypefull}}</td>
                                        <td>{{$journal->branch_id}}</td>
                                        <td>{{number_format($journal->grandtotal,2)}}<?php $totalcredit =$journal->grandtotal; ?></td>
                                        <td>0.00</td>
                                    </tr>
                                    @endif

                                    @if($journal->type == 2)
                                    <tr>
                                        <td>

                                        </td>
                                        <td></td>
                                        <td></td>

                                        <td></td>
                                        <td>{{$journal->accounttypeno}}</td>
                                        <td>{{$journal->accounttypefull}}</td>
                                        <td>{{$journal->branch_id}}</td>
                                        <td>0.00</td>
                                        <td>{{number_format($journal->grandtotal,2)}}<?php $totaldebit1 =  $totaldebit1 + $journal->grandtotal; ?></td>
                                    </tr>
                                    <tr>
                                        <td>

                                        </td>
                                        <td> </td>
                                        <td> </td>

                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td>   <b><?php echo number_format($totaldebit1,2) ; ?></b></td>
                                        <td>   <b><?php echo number_format($totalcredit,2);?></b></td>
                                    </tr>
                                    @endif
                                    @if($journal->type == 1)
                                    <tr>
                                        <td>

                                        </td>
                                        <td></td>
                                        <td></td>

                                        <td></td>
                                        <td>{{$journal->accounttypeno}}</td>
                                        <td>{{$journal->accounttypefull}}</td>
                                        <td>{{$journal->branch_id}}</td>
                                        <td>0.00</td>
                                        <td>{{number_format($journal->grandtotal,2)}}<?php $totaldebit1 = $totaldebit1 + $journal->grandtotal; ?></td>
                                    </tr>

                                    @endif




                                    @endforeach
                                    <!-- จบ  -->
                                    <?php $totaldebit = 0; $totalcredit = 0;
                                    // print_r($datajournal_general);
                                    foreach ($datajournal_general as $key => $value) {
                                      $journal5_id = $value->id;
                                      $sqljournalgeneral_detail = 'SELECT '.$db['fsctaccount'].'.journalgeneral_detail.*
                                                           FROM '.$db['fsctaccount'].'.journalgeneral_detail
                                                            WHERE '.$db['fsctaccount'].'.journalgeneral_detail.id_journalgeneral_head = "'.$journal5_id.'"
                                                            AND  ('.$db['fsctaccount'].'.journalgeneral_detail.debit != "0.00"
                                                            OR '.$db['fsctaccount'].'.journalgeneral_detail.debit IS NOT NULL) ';

                                       $datajournalgeneral_detail = DB::connection('mysql')->select($sqljournalgeneral_detail);

                                      // print_r($datajournalgeneral_detail);

                                      ?>


                                      <tr>
                                          <td>
                                              @if($value->accept == 0)
                                              <label class="con">
                                              <input type="checkbox" name="check_list_gl[]" value="{{ $value->id }}">
                                                  <span class="checkmark"></span>
                                              </label>
                                              @else
                                              <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                              @endif
                                          </td>
                                          <td>{{$value->datebill}}</td>
                                          <td>{{$value->number_bill_journal}}</td>

                                          <td>
                                            <?php

                                                    echo $datajournalgeneral_detail[0]->list;
                                            ?>
                                          </td>
                                          <td>
                                              <?php

                                                      $ac_id = $datajournalgeneral_detail[0]->accounttype;
                                                      $sqlaccounttype = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                                                           FROM '.$db['fsctaccount'].'.accounttype
                                                                            WHERE '.$db['fsctaccount'].'.accounttype.id = "'.$ac_id.'" ';

                                                       $dataaccounttype = DB::connection('mysql')->select($sqlaccounttype);
                                                       echo $dataaccounttype[0]->accounttypeno;


                                              ?>
                                          </td>
                                          <td>
                                              <?php
                                                       echo $dataaccounttype[0]->accounttypefull;
                                              ?>
                                          </td>
                                          <td>   <?php echo $value->code_branch;?> </td>
                                          <td>
                                                <?php    $totaldebit = $totaldebit +  $datajournalgeneral_detail[0]->debit;
                                                      echo number_format($datajournalgeneral_detail[0]->debit,2);
                                                ?>
                                          </td>
                                          <td>
                                            0.00
                                          </td>
                                      </tr>
                                        <?php
                                               $journal5_id = $value->id;
                                               $sqljournalgeneral_detail = 'SELECT '.$db['fsctaccount'].'.journalgeneral_detail.*
                                                                    FROM '.$db['fsctaccount'].'.journalgeneral_detail
                                                                     WHERE '.$db['fsctaccount'].'.journalgeneral_detail.id_journalgeneral_head = "'.$journal5_id.'"
                                                                     AND  ('.$db['fsctaccount'].'.journalgeneral_detail.credit != "0.00"
                                                                     OR '.$db['fsctaccount'].'.journalgeneral_detail.credit IS NOT NULL) ';

                                                $datajournalgeneral_detail = DB::connection('mysql')->select($sqljournalgeneral_detail);
                                                // print_r($datajournalgeneral_detail);
                                                // exit;
                                                // echo $datajournalgeneral_detail[0]->list;
                                        ?>
                                      <tr>
                                          <td>

                                          </td>
                                          <td></td>
                                          <td></td>

                                          <td>
                                            <?php

                                                     echo $datajournalgeneral_detail[0]->list;
                                            ?>
                                          </td>
                                          <td>
                                              <?php

                                                      $ac_id = $datajournalgeneral_detail[0]->accounttype;
                                                      $sqlaccounttype = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                                                           FROM '.$db['fsctaccount'].'.accounttype
                                                                            WHERE '.$db['fsctaccount'].'.accounttype.id = "'.$ac_id.'" ';

                                                       $dataaccounttype = DB::connection('mysql')->select($sqlaccounttype);
                                                       echo $dataaccounttype[0]->accounttypeno;


                                              ?>
                                          </td>
                                          <td>
                                              <?php
                                                       echo $dataaccounttype[0]->accounttypefull;
                                              ?>
                                          </td>
                                          <td>   <?php echo $value->code_branch;?> </td>
                                          <td>
                                                0.00
                                          </td>
                                          <td>
                                            <?php    $totalcredit = $totalcredit +  $datajournalgeneral_detail[0]->credit;
                                                  echo number_format($datajournalgeneral_detail[0]->credit,2);
                                            ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>

                                          </td>
                                          <td></td>
                                          <td></td>

                                          <td>
                                            <?php
                                                   // $journal5_id = $value->id;
                                                   // $sqljournalgeneral_detail = 'SELECT '.$db['fsctaccount'].'.journalgeneral_detail.*
                                                   //                      FROM '.$db['fsctaccount'].'.journalgeneral_detail
                                                   //                       WHERE '.$db['fsctaccount'].'.journalgeneral_detail.id_journalgeneral_head = "'.$journal5_id.'"
                                                   //                       AND  ('.$db['fsctaccount'].'.journalgeneral_detail.credit != "0.00"
                                                   //                       OR '.$db['fsctaccount'].'.journalgeneral_detail.credit IS NOT NULL) ';
                                                   //
                                                   //  $datajournalgeneral_detail = DB::connection('mysql')->select($sqljournalgeneral_detail);
                                                    echo $datajournalgeneral_detail[1]->list;
                                            ?>
                                          </td>
                                          <td>
                                              <?php

                                                      $ac_id = $datajournalgeneral_detail[1]->accounttype;
                                                      $sqlaccounttype = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                                                           FROM '.$db['fsctaccount'].'.accounttype
                                                                            WHERE '.$db['fsctaccount'].'.accounttype.id = "'.$ac_id.'" ';

                                                       $dataaccounttype = DB::connection('mysql')->select($sqlaccounttype);
                                                       echo $dataaccounttype[0]->accounttypeno;


                                              ?>
                                          </td>
                                          <td>
                                              <?php
                                                       echo $dataaccounttype[0]->accounttypefull;
                                              ?>
                                          </td>
                                          <td>  <?php echo $value->code_branch;?> </td>
                                          <td>
                                               0.00
                                          </td>
                                          <td>
                                            <?php    $totalcredit = $totalcredit +  $datajournalgeneral_detail[1]->credit;
                                                  echo number_format($datajournalgeneral_detail[1]->credit,2);
                                            ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>

                                          </td>
                                          <td> </td>
                                          <td> </td>

                                          <td> </td>
                                          <td> </td>
                                          <td> </td>
                                          <td> </td>
                                          <td>   <b><?php echo number_format($totaldebit,2) ; ?></b></td>
                                          <td>   <b><?php echo number_format($totalcredit,2);?></b></td>
                                      </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </div>
                        <div style="padding-bottom:50px;">
                            <center><button type="submit" class="btn btn-success">Okay ยืนยันการตรวจ</button></center>
                        </div>
                        <!--END table cotent -->
                        {!! Form::close() !!}
                    </div><!-- end card-->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- END container-fluid -->
    </div>
    <!-- END content -->
</div>
<!-- END content-page -->

@endsection
