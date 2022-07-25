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
        <div class="col-sm">
            <center><img src="images/logo-fsct/11.jpg" width="90%"></center>
        </div><br>

        <div class="col-sm" style="">
            <center><b>ใบสำคัญจ่าย/Payment Voucher<b></center>
        </div><br>

          <label style=""><b>Date/วันที่ :<b> {{$report_paycredits[0]->datebill}}</label>
          <label style="float:right"><b>AP NO/เลขที่ใบสำคัญจ่าย :<b> {{$report_paycredits[0]->payser_number}}</label>
        <br>
          <label style=""><b>Receiver/ผู้รับเงิน :<b> {{$report_paycredits[0]->pre}} {{$report_paycredits[0]->name_supplier}}</label>
          <label style="float:right"><b>เลขที่ผู้เสียภาษี :<b> {{$report_paycredits[0]->tax_id}}</label>
        <br>
          <label style="float:left"><b>Addeess/ที่อยู่ :<b> {{$report_paycredits[0]->address}} ตำบล {{$report_paycredits[0]->district}} อำเภอ {{$report_paycredits[0]->amphur}} จังหวัด {{$report_paycredits[0]->province}} รหัสไปรษณีย์  {{$report_paycredits[0]->zipcode}} โทรศัพท์  {{$report_paycredits[0]->phone}}</label>
        <br>
        <br>

        <div class="container">
            <table class="line">
                <thead style="background-color: #D8D8D8;">
                    <tr class="line">
                        <th class="line">ลำดับ</th>
                        <th class="line">รายการ</th>
                        <th class="line">ราคาต่อหน่วย</th>
                        <th class="line">จำนวน</th>
                        <th class="line">รวม</th>
                    </tr>
                </thead>
                @foreach($report_paycredits as $key => $report_paycredit)
                <tr class="line">
                    <td class="line">{{++$key}}</td>
                    <td class="line">{{$report_paycredit->list}}</td>
                    <td class="line">{{$report_paycredit->price}}</td>
                    <td class="line">{{$report_paycredit->amount}}</td>
                    <td class="line">{{$report_paycredit->total}}</td>
                </tr>
                @endforeach
                <tr class="line">
                    <td class="line" rowspan="6" colspan="2" align="left">ประเภทการจ่ายเงิน : {{$report_paycredits[0]->name_pay}}
                      <br>
                       <?php
                        $sumtotalfinal1 = $report_paycredits[0]->vat_price + $report_paycredits[0]->wht;
                        $resulttext = Accountcenter::converttobath($sumtotalfinal1);
                        echo $resulttext;
                       ?>
                    </td>
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">รวม
                    <td class="line">
                      @foreach($report_paycredits as $i => $report_paycredit)
                      <input type='hidden' id='sample{{ $i }}' value='{{ $report_paycredit->total }}'>
                      @endforeach
                      <?php
                        $totalsum = $report_paycredits->sum('total');
                        echo $totalsum;
                       ?>
                    </td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">ส่วนลด (บาท)</td>
                    <td class="line">{{$report_paycredits[0]->discount}}</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">ภาษีมูลค่าเพิ่ม {{$report_paycredits[0]->vat_percent}}% (บาท)</td>
                    <td class="line">
                    @if ($report_paycredits[0]->vat_percent == 0)
                        {{$report_paycredits[0]->vat_percent/100*$totalsum}}
                    @elseif ($report_paycredits[0]->vat_percent == 1)
                        {{$report_paycredits[0]->vat_percent/100*$totalsum}}
                    @elseif ($report_paycredits[0]->vat_percent == 3)
                        {{$report_paycredits[0]->vat_percent/100*$totalsum}}
                    @elseif ($report_paycredits[0]->vat_percent == 5)
                        {{$report_paycredits[0]->vat_percent/100*$totalsum}}
                    @elseif ($report_paycredits[0]->vat_percent == 7)
                        {{$report_paycredits[0]->vat_percent/100*$totalsum}}
                    @elseif ($report_paycredits[0]->vat_percent == 10)
                        {{$report_paycredits[0]->vat_percent/100*$totalsum}}
                    @endif
                    </td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">จำนวนเงินรวม</td>
                    <td class="line">{{$report_paycredits[0]->vat_price}}</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">ภาษีหัก ณ ที่จ่าย {{$report_paycredits[0]->wht_percent}}%</td>
                    <td class="line">{{$report_paycredits[0]->wht}}</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">รวมเงินสุทธิ (บาท)</td>
                    <td class="line">
                    <?php
                      $sumtotalfinal = $report_paycredits[0]->vat_price + $report_paycredits[0]->wht;
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
