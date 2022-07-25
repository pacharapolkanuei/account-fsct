@extends('layout.default')
@section('content')
<div class="row">
         <div class="col-sm-12">
          <div class="card mb-3">
           <div class="card-header">
            <h3><i class="fas fa-edit"></i> <fonts id="fontsheader">การชำระสินค้าและบริการ</fonts></h3>
           </div>

                                <!-- Button to Open the Modal -->
                                <div style="padding: 25px 0px 0px 50px;">
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    <i class="fas fa-arrow-alt-circle-left"> <fonts id="fontscontent">เพิ่มข้อมูล</i>
                                  </button>
                                </div>
                                <br/>
                                <!-- The Modal -->
                                <div class="modal fade" id="myModal">
                                  <div class="modal-dialog modal-xl">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>แบบฟอร์มการชำระสินค้าและบริการ</b></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body">
                                              <label class="col-form-label" for="modal-input-province" id="fontslabel"><b>สาขา :</b></label>
                                              <select class="form-control" id="modal-input-province" name="modal-input-province">
                                                <option value="1">เชียงใหม่</option>
                                                <option value="2">กรุงเทพ</option>
                                              </select>



                                              <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>เลขที่ PO :</b></label>
                                              <select class="form-control" id="modal-input-po" name="modal-input-po">
                                                <option value="1">POXXXXX1</option>
                                                <option value="2">POXXXXX2  </option>
                                              </select>

                                              <label class="col-form-label" for="modal-input-calculate" id="fontslabel"><b>จำนวนเงินที่ขอ :</b></label>
                                              <input type="text" name="modal-input-calculate" class="form-control" id="modal-input-calculate" readonly>

                                              <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>วันที่บิล :</b></label>
                                              <input type="text" id="testdate5" class="form-control" >

                                              <label class="col-form-label" for="modal-input-calculate" id="fontslabel"><b>เลขที่บิล :</b></label>
                                              <input type="text" name="modal-input-calculate" class="form-control" id="modal-input-calculate">
                       <br>

                       <div style="padding: 10px 50px 0px 50px;" id="fontscontent">
                                   <div class="table-responsive">
                                     <table class="table">
                                       <thead class="thead-light">
                                         <tr>
                                           <th>ลำดับ</th>
                                           <th>รายการ</th>
                                           <th>จำนวน</th>
                                           <th>ราคาต่อหน่วย</th>
                            <th>ส่วนลด</th>
                            <th >จำนวนเงิน</th>
                                         </tr>
                                       </thead>
                            <tbody>
                            <td>sfkdsf</td>
                            <td>sfkdsf</td>
                            <td>sfkdsf</td>
                            <td>sfkdsf</td>
                            <td>sfkdsf</td>
                            <td>sfkdsf</td>
                            </tbody>
                            <tfoot class="thead-light">
                            <tr><th></th><th></th><th></th><th></th><th style="text-align: right;">จำนวนเงิน :</th><td>...</td></tr>
                            <tr><th></th><th></th><th></th><th style="text-align: right;">ส่วนลด :</th><th><input type="text" name="" class="form-control"></th><td>...</td></tr>
                            <tr><th></th><th></th><th></th><th></th><th style="text-align: right;">ยอดหลังหักส่วนลด :</th><td>...</td></tr>
                            <tr><th></th><th></th><th></th><th style="text-align: right;">ภาษีมูลค่าเพิ่ม :</th><th><input type="text" name="" class="form-control"></th><td>...</td></tr>
                            <tr><th></th><th></th><th></th><th></th><th style="text-align: right;">จำนวนเงินรวมทั้งสิ้น :</th><td>...</td></tr>
                            </tfoot>
                                     </table>
                                   </div>
                                 </div>

                                              <label class="col-form-label" id="fontslabel"><b>แนบไฟล์ใบกำกับภาษี :</b></label>
                                              <input type="file" name="c" class="form-control">

                       <div style="padding: 50px 50px 0px 50px;" id="fontscontent">
                        <div class="table-responsive">
                                     <table class="table">
                          <thead class="thead-light">
                           <tr>
                            <th>วิธีการจ่ายเงิน</th>
                            <th>ภาษีหัก ณ ที่จ่าย</th>
                            <th>ยอดจ่ายจริง</th>
                            <tbody>
                            <td>
                              <div style="padding: 0px 0px 0px 70px;">
                                <input type="checkbox" class="form-check-input" value="">โอน
                              <br>
                                <input type="checkbox" class="form-check-input" value="">เงินสด
                              <br>
                              <input type="checkbox" class="form-check-input" value="">เช็ค
                             </div>
                            </td>
                            <td></td>
                            <td></td>
                            </tbody>
                           </tr>
                          </thead>
                         </table>
                        </div>
                       </div>

                                              <label class="col-form-label" id="fontslabel"><b>แนบใบหัก ณ ที่จ่าย :</b></label>
                                              <input type="file" name="c" class="form-control">

                                            </div>

                                      <!-- Modal footer -->
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">บันทึก</button> <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                                      </div>

                                    </div>
                                  </div>
                                </div>

                    <div style="padding: 10px 50px 0px 50px;" id="fontscontent">
                      <div class="table-responsive">
                        <table class="table">
                          <thead class="thead-light">
                            <tr>
                              <th>วันที่</th>
                              <th>เลขที่ใบแจ้งหนี้</th>
                              <th>ชื่อรายการ</th>
                              <th>จำนวนซื้อ</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>01/05/2562</td>
                              <td>150000xx2</td>
                              <td>ปากกา</td>
                              <td>50</td>
                            </tr>
                            <tr>
                              <td>02/05/2562</td>
                              <td>150000xx3</td>
                              <td>ดินสอ</td>
                              <td>60</td>
                            </tr>
                            <tr>
                              <td>03/05/2562</td>
                              <td>150000xx4</td>
                              <td>ขนม</td>
                              <td>5</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

          </div><!-- end card-->
         </div>
       </div>
       @endsection