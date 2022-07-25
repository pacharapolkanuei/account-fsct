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

        #name_label {
          display: inline-block;
          width: 90%;
          text-align: right;
      }
    </style>
</head>

<body>

    <div class="container">
        <div class="col-sm">
            <center><img src="images/logo-fsct/11.jpg" width="90%"></center>
        </div><br>

        <div class="col-sm" style="">
            <center><b>ใบรับวางบิล<b></center>
        </div><br />

        <label style=""><b>รหัสผู้ขาย :<b> {{$report_debtsuppliers[0]->codecreditor}}</label>
      <br />

      <p style="text-align:left;">
          <b>ชื่อผู้ขาย :<b> {{$report_debtsuppliers[0]->pre}} {{$report_debtsuppliers[0]->name_supplier}}
          <span style="float:right;">
            <b>เลขที่เอกสาร :<b> {{$report_debtsuppliers[0]->number_debt}}
          </span>
      </p>

      <br />
        <label style=""><b>ที่อยู่ :<b> {{$report_debtsuppliers[0]->pre}} {{$report_debtsuppliers[0]->name_supplier}}</label>
        <label style="float:right"><b>วันที่เอกสาร :<b> {{$report_debtsuppliers[0]->number_debt}}</label>
      <br />
        <label style="">{{$report_debtsuppliers[0]->pre}} {{$report_debtsuppliers[0]->name_supplier}}</label>
        <label style="float:right"><b>วันที่นัดชำระ :<b> {{$report_debtsuppliers[0]->tax_id}}</label>
      <br />
        <label style="">{{$report_debtsuppliers[0]->address}}</label>
        <label style="float:right"><b>เงื่อนไข :<b> {{$report_debtsuppliers[0]->number_debt}}</label>
      <br />
      <br />

        <label style="">รับบิลไว้ตรวจสอบตามรายการข้างล่างนี้ถูกต้องแล้ว</label>
        <!-- <div class="col-sm" style="float:right">
            <b>เลขที่เอกสาร :<b>{{$report_debtsuppliers[0]->number_debt}}<br>
        </div>
        <div class="col-sm" style="float:right">
            <b>วันที่เอกสาร :<b>{{$report_debtsuppliers[0]->number_debt}}<br>
        </div>
        <div class="col-sm" style="float:right">
            <b>วันที่นัดชำระ :<b>{{$report_debtsuppliers[0]->number_debt}}<br>
        </div>
        <div class="col-sm" style="float:right">
            <b>เงื่อนไข :<b>{{$report_debtsuppliers[0]->number_debt}}<
        </div>

        <div class="col-sm" style="">
            <b>ชื่อผู้ขาย : {{$report_debtsuppliers[0]->pre}} {{$report_debtsuppliers[0]->name_supplier}}<b><br>
        </div>
        <div class="col-sm" style="">
            <b>ที่อยู่ : {{$report_debtsuppliers[0]->address}} {{$report_debtsuppliers[0]->district}}<br>
              {{$report_debtsuppliers[0]->amphur}} {{$report_debtsuppliers[0]->province}} {{$report_debtsuppliers[0]->zipcode}}<b><br>
        </div>
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br /> -->

        <div class="container">
            <table class="line">
                <tr class="line">
                    <th class="line">ลำดับ</th>
                    <th class="line">เลขที่เอกสาร</th>
                    <th class="line">วันที่เอกสาร</th>
                    <th class="line">เลขที่ใบกำกับภาษี</th>
                    <th class="line">วันที่ครบกำหนด</th>
                    <th class="line">จำนวนเงินคงค้าง</th>
                    <th class="line">จำนวนเงินวางบิล</th>
                    <th class="line">หมายเหตุ</th>
                </tr>
                @foreach($report_debtsuppliers as $key => $report_debtsupplier)
                <tr class="line">
                    <td class="line">{{++$key}}</td>
                    <td class="line">{{$report_debtsupplier->number_debt}}</td>
                    <td class="line">{{$report_debtsupplier->datebill}}</td>
                    <td class="line">{{$report_debtsupplier->bill_no}}</td>
                    <td class="line"></td>
                    <td class="line">{{$report_debtsupplier->vat_price}}</td>
                    <td class="line">{{$report_debtsupplier->vat_price}}</td>
                    <td class="line">{{$report_debtsupplier->note}}</td>
                </tr>
                @endforeach
                <tr class="line">
                    <td class="line" colspan="7"><b>
                      @foreach($report_debtsuppliers as $i => $report_debtsupplier)
                      <input type='hidden' id='sample{{ $i }}' value='{{ $report_debtsupplier->vat_price }}'>
                      @endforeach
                      <?php
                        $totalsum = $report_debtsuppliers->sum('vat_price');
                        $resulttext = Accountcenter::converttobath($totalsum);
                        echo $resulttext;
                      ?>
                    </b></td>
                    <td class="line">
                      <?php
                        echo $totalsum;
                       ?>
                    </td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="8" style="text-align: left;"><b>หมายเหตุ :</b> โปรดชำระภายในกำหนดวันเครดิต</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="4" style="text-align:left;">ในนาม<center>บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด</center><br />
                      <center>______________________________________</center>
                      <center>ผู้รับวางบิล</center>
                      <center>วันที่ </center>
                    </td>
                    <td class="line" colspan="4"><br />
                      <center>___________________________</center>
                      <center>ผู้วางบิล</center>
                      <center>วันที่ ...</center>
                    </td>
                </tr>
            </table><br><br>
        </div>

</body>

</html>
