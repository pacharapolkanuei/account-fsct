<?php
use  App\Api\Accountcenter;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
        }

        .line {
            border: 1px solid black;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }


    </style>
</head>

<body>

    <div class="container">
        <div class="col-sm" style="">
            <center><b>บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด<b></center>
        </div><br>

        <div class="col-sm" style="">
            <center><b>รายงานทะเบียนทรัพย์สิน<b></center>
        </div><br>

        <div class="col-sm" style="">
            <center>ตั้งแต่งวดบัญชี : ถึง </center>
        </div><br>

        <br>
        <br>

        <div class="container">
            <table class="line">
                <thead style="background-color: #D8D8D8;">
                    <tr class="line">
                        <th class="line">ลำดับ</th>
                        <th class="line">รหัสทรัพย์สืน</th>
                        <th class="line">ชื่อทรัพย์สิน</th>
                        <th class="line">วันที่ได้มา</th>
                        <th class="line">ราคาทุน</th>
                        <th class="line">จำนวนปีที่ใช้งาน</th>
                        <th class="line">อัตราค่าเสื่อมต่อปี(%)</th>
                        <th class="line">ค่าเสื่อมสะสมยกมา</th>
                        <th class="line">ค่าเสื่อมเดือนปัจจุบัน</th>
                        <th class="line">ค่าเสื่อมสะสมยกไป</th>
                        <th class="line">มูลค่าทรัพย์สืนสุทธิ</th>
                    </tr>
                </thead>
                @foreach($report_paysers as $key => $report_payser)
                <tr class="line">
                    <td class="line">{{++$key}}</td>
                    <td class="line">{{$report_payser->list}}</td>
                    <td class="line">{{$report_payser->price}}</td>
                    <td class="line">{{$report_payser->amount}}</td>
                    <td class="line">{{$report_payser->total}}</td>
                    <td class="line">{{$report_payser->list}}</td>
                    <td class="line">{{$report_payser->price}}</td>
                    <td class="line">{{$report_payser->amount}}</td>
                    <td class="line">{{$report_payser->total}}</td>
                    <td class="line">{{$report_payser->amount}}</td>
                    <td class="line">{{$report_payser->total}}</td>
                </tr>
                @endforeach
                <tr class="line">
                    <td class="line" rowspan="6" colspan="2" style="float:left">ประเภทการจ่ายเงิน : {{$report_paysers[0]->name_pay}}
                      <br>
                       <?php
                        /*
                        $sumtotalfinal1 = $report_paysers[0]->vat_price + $report_paysers[0]->wht;
                        $resulttext = Accountcenter::converttobath($sumtotalfinal1);
                        echo $resulttext;
                        */
                       ?>
                    </td>
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">รวม
                    <td class="line">
                      @foreach($report_paysers as $i => $report_payser)
                      <input type='hidden' id='sample{{ $i }}' value='{{ $report_payser->total }}'>
                      @endforeach
                      <?php
                        $totalsum = $report_paysers->sum('total');
                        echo $totalsum;
                       ?>
                    </td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">ส่วนลด (บาท)</td>
                    <td class="line">{{$report_paysers[0]->discount}}</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">ภาษีมูลค่าเพิ่ม {{$report_paysers[0]->vat_percent}}% (บาท)</td>
                    <td class="line">
                      @if ($report_paysers[0]->vat_percent == 0)
                          {{$report_paysers[0]->vat_percent/100*$totalsum}}
                      @elseif ($report_paysers[0]->vat_percent == 1)
                          {{$report_paysers[0]->vat_percent/100*$totalsum}}
                      @elseif ($report_paysers[0]->vat_percent == 3)
                          {{$report_paysers[0]->vat_percent/100*$totalsum}}
                      @elseif ($report_paysers[0]->vat_percent == 5)
                          {{$report_paysers[0]->vat_percent/100*$totalsum}}
                      @elseif ($report_paysers[0]->vat_percent == 7)
                          {{$report_paysers[0]->vat_percent/100*$totalsum}}
                      @elseif ($report_paysers[0]->vat_percent == 10)
                          {{$report_paysers[0]->vat_percent/100*$totalsum}}
                      @endif
                    </td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">จำนวนเงินรวม</td>
                    <td class="line">{{$report_paysers[0]->vat_price}}</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">ภาษีหัก ณ ที่จ่าย {{$report_paysers[0]->wht_percent}}%</td>
                    <td class="line">{{$report_paysers[0]->wht}}</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">รวมเงินสุทธิ (บาท)</td>
                    <td class="line">
                      <?php
                        $sumtotalfinal = $report_paysers[0]->vat_price + $report_paysers[0]->wht;
                        echo $sumtotalfinal;
                      ?>
                    </td>
                </tr>
            </table><br><br>

            <table width="100%" border="0">
                <tr>
                    <td width="50%" align="center">
                        ....................................................................................
                    </td>
                    <td width="50%" align="center">
                        ....................................................................................
                    </td>
                </tr>

                <tr>
                    <td width="50%" align="center">
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                    </td>
                    <td width="50%" align="center">
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="center">
                        ผู้จ่ายเงิน
                    </td>
                    <td width="50%" align="center">
                        ผู้รับเงิน
                    </td>
                </tr>
            </table>

            <div style="padding:0px 360px 0px 0px">
            <table width="50%" border="0">
                <tr>
                    <td width="50%" align="center">
                        ....................................................................................
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="center">
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="center">
                        ผู้ตรวจสอบ/อนุมัติ
                    </td>
                </tr>
            </table>
            </div>

        </div>

    </div>

</body>

</html>
