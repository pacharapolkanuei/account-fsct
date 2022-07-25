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
            <center><b>ใบเจ้าหนี้การค้า<b></center>
        </div><br>
        <div class="col-sm" style="float:right">
            <b>AP NO/เลขที่ใบตั้งหนี้ :<b>{{$report_debts[0]->number_debt}}<br>
        </div>
        <div class="col-sm" style="">
            <b>Date/วันที่ : {{$report_debts[0]->datebill}}
        </div>
        <div class="col-sm" style="">
            <b>Seller/ผู้ขาย : {{$report_debts[0]->name_supplier}}<b><br>
        </div>
        <div class="col-sm" style="">
            <b>Addeess/ที่อยู่ : {{$report_debts[0]->address}} {{$report_debts[0]->district}} {{$report_debts[0]->amphur}} {{$report_debts[0]->province}} {{$report_debts[0]->zipcode}}<b>
        </div><br><br>

        <div class="container">
            <table class="line">
                <tr class="line">
                    <th class="line">#</th>
                    <th class="line">รายการ</th>
                    <th class="line">ราคาต่อหน่วย</th>
                    <th class="line">จำนวน</th>
                    <th class="line">รวม</th>
                </tr>
                @foreach($report_debts as $key => $report_debt)
                <tr class="line">
                    <td class="line">{{++$key}}</td>
                    <td class="line">{{$report_debt->list}}</td>
                    <td class="line">{{$report_debt->price}}</td>
                    <td class="line">{{$report_debt->amount}}</td>
                    <td class="line">{{$report_debt->total}}</td>
                </tr>
                @endforeach
                <tr class="line">
                    <td class="line" rowspan="3" colspan="2">.......</td>
                    <td class="line" colspan="2">รวมส่วนลด
                    <td class="line">{{$report_debts[0]->discount}}</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2">ภาษี</td>
                    <td class="line">{{$report_debts[0]->vat}} %</td>
                </tr>
                <tr class="line">
                    <td class="line" colspan="2">รวมสุทธิ</td>
                    <td class="line">{{$report_debts[0]->vat_price}}</td>
                </tr>
            </table><br><br>

            <div class="col-sm" style="">
                <b>หมายเหตุ<b>&nbsp;&nbsp;&nbsp;&nbsp; Price are iclude VAT / ราคาที่สั่งซื้อ เป็นราคาที่ได้รวมภาษีมูลค่าเพิ่มไว้แล้ว<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Please refer the Purchase order No.at each Delivery Note/invoide. กรุณาระบุหมายเลขใบตั้งหนี้ทุกครั้ง<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Please issue the receipt in the name of <b>FASAI CONSTRUCTION TOOLS CO.,LTD.<b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                กรุณาออกใบเสร็จรับเงินในนาม <b>บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด<b><br><br><br><br>
            </div>


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
                        ......
                    </td>
                    <td width="50%" align="center">
                        ......
                    </td>
                </tr>
                <tr>
                    <td width="50%" align="center">
                        ผู้สั่งซื้อ
                    </td>
                    <td width="50%" align="center">
                        ผู้อนุมัติการสั่งซื้อ
                    </td>
                </tr>
            </table>

        </div>

    </div>

</body>

</html>