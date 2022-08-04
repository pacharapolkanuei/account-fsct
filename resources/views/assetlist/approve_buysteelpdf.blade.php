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
            <center><b>ใบสั่งซื้อ/Purchase Order<b></center>
        </div><br>

          <label style=""><b>Date/วันที่ :<b> {{$report_receiptassets[0]->datein}}</label>
          <label style="float:right"><b>PO NO./เลขที่ใบขออนุมัติซื้อ :<b> {{$report_receiptassets[0]->po_number}}</label>
        <br>
          <label style=""><b>Seller/ผู้ขาย :<b> {{$report_receiptassets[0]->pre}} {{$report_receiptassets[0]->name_supplier}}</label>
        <br>
          <label style="float:left"><b>Addeess/ที่อยู่ :<b> {{$report_receiptassets[0]->address}} ตำบล {{$report_receiptassets[0]->district}} อำเภอ {{$report_receiptassets[0]->amphur}} จังหวัด {{$report_receiptassets[0]->province}} รหัสไปรษณีย์  {{$report_receiptassets[0]->zipcode}} โทรศัพท์  {{$report_receiptassets[0]->phone}}</label>
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
                @foreach($report_receiptassets as $key => $report_receiptasset)
                <tr class="line">
                    <td class="line">{{++$key}}</td>
                    <td class="line">{{$report_receiptasset->list}}</td>
                    <td class="line">{{$report_receiptasset->price}}</td>
                    <td class="line">{{$report_receiptasset->amount}}</td>
                    <td class="line">{{$report_receiptasset->total}}</td>
                </tr>
                @endforeach
                <tr class="line">
                    <td></td>
                    <td class="line" colspan="2" style="background-color: #D8D8D8;">รวม
                    <td class="line">
                      @foreach($report_receiptassets as $i => $report_receiptasset)
                      <input type='hidden' id='sample{{ $i }}' value='{{ $report_receiptasset->total }}'>
                      @endforeach
                      <?php
                        $totalsum = $report_receiptassets->sum('total');
                        echo $totalsum;
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
