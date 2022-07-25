$( document ).ready(function() {
    console.log( "ready!" );
});

$(function() {
    $('input[name="daterange"]').daterangepicker();
});

$('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'แน่ใจหรือไม่?',
        text: 'คุณต้องการลบรายการนี้!',
        icon: 'warning',
        buttons: ["ยกเลิก", "ตกลง!"],
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });
});

function selectbranch2(val){
	var branchcode = val.value;
  // console.log(branch);
	$('#modal-input-po').empty();
	// $('#modal-input-po').empty();//เคลียselectจังหวัดก่อนหน้า

		$.get('getbranchtopayser/'+branchcode, function(get_po_num) {
        // console.log(res);
	  	var option = '<option disabled>========เลือกใบเลขที่ PO========</option>';
          $.each(get_po_num, function(index,value ) { //วนลูป

			 	option += '<option value="'+value.id+'">'+value.po_number+'</option>';
		  });

		  $('#modal-input-po').append(option);//เป็นการเพิ่ม option #modal-input-po
    });

      $('.select2').select2();
      $("#modal-input-po").on("select2:select select2:unselect", function (e) {
          //this returns all the selected item
          var items= $(this).val();
          // console.log(items);

          calculatetotalreal(items);

      });
}

function selecttypepay(val) {
  var type_pay = val.value;
  // console.log(type_pay);
  increasebankfromacc(type_pay);
}

// function increasebank(type_pay) {
//   var wrapper = $(".container1");
//   // var name = '<label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>';
//       $('.container1').empty();
//       if (type_pay == 2) {
//
//           $.get('getbankdetail/'+type_pay, function(res) {
//
//             var option = '';
//               $.each(res, function(index,value) {
//                 option += '<option value="'+value.id+'">'+value.account_no+' - '+value.account_name+'</option>';
//               });
//
//               $(wrapper).append('<br><div class="form-inline"><label id="fontslabel"><b>ธนาคาร :</b></label>'+'<div class="col-sm"><select style="width: 100%;max-width: 1200px;" class="form-control" name="bank">'+option+'</select></div></div>');
//           });
//       }
// }

function increasebankfromacc(type_pay) {
  var wrapper = $(".container1");
  // var name = '<label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>';
      $('.container1').empty();
      if (type_pay == 2) {

          $.get('getbankfromacc/'+type_pay, function(res) {

            var option = '';
              $.each(res, function(index,value) {
                option += '<option value="'+value.accounttypeno+'|'+value.accounttypefull+'">'+value.accounttypeno+' - '+value.accounttypefull+'</option>';
              });

              $(wrapper).append('<br><div class="form-inline"><label id="fontslabel"><b>ธนาคาร :</b></label>'+'<div class="col-sm"><select style="width: 100%;max-width: 1200px;" class="form-control" name="bank">'+option+'</select></div></div>');
          });
      }
}


function calculatetotalreal(items){
      var _token = $("input[name='_token']").val();
      // console.log(_token);

      // console.log(items);

      // $.post('postcalculatepo',{_token:_token , data:items}, function(res) {
      //     // console.log(res);
      //       // document.getElementById("totalsumreal").value = "";
      //       // $('#totalsumreal').val(res);
      //
      // });

      $.post('getpodetailbyhead',{_token:_token , data:items}, function(res) {
            // console.log(res);
            $('#po_content').empty();
            var table_content = '';
            var no = 1;
            // var amount = $("#amount").val();
            // var price = $("#price").val();
            // var sum_onelist = (amount*price);
            // var discount = ($("#discount").val()*sum_onelist/100); //ส่วนลดเป็นเปอร์เซ็น
            $.each(res, function(index,value) {
              console.log(value);

              table_content +='<tr>';
                table_content +='<td id="fontstable">'+no+'</td>';
                table_content +='<td id="fontstable">'+'<input type="hidden" name="config_group_supp_id[]" value="'+value.config_group_supp_id+'" >'+'<input type="hidden" name="materialid[]" value="'+value.materialid+'">'+'<input type="hidden" name="wht_percent" value="'+value.whd+'" id="whd">'+'<input type="hidden" name="list[]" value="'+value.list+'" >'+'<input type="hidden" name="type_amount[]" value="'+value.type_amount+'">'+'<input type="hidden" name="withhold[]" value="'+value.withhold+'">'+'<input type="hidden" value="'+value.whd+'" id="getwhd">'+'<input type="hidden" value="'+value.statusbank+'" name="ins_statusbank" id="getdetailprivate">'+'<input type="hidden" value="'+value.ckreservemoney+'" name="ins_pettycash" id="getdetailpettycash">'+'<input type="hidden" value="'+value.vat+'" id="getvat">'+'<input type="hidden" name="quantity_get[]" value="'+value.quantity_get+'">'+'<input type="hidden" name="quantity_loss[]" value="'+value.quantity_loss+'">'+'<input type="hidden" name="status[]" value="'+value.status+'">'+'<input type="hidden" name="check_ins_reserv" value="'+value.po_reservemoney+'">'+'<input type="hidden" name="po_headid[]" value="'+value.po_headid+'">'+value.list+'</td>';
                table_content +='<td>'+'<input class="form-control" type="text" value="'+value.amount+'" id="amount'+no+'"  name="amount[]" readonly>'+'<input type="hidden" name="po_number_ins" value="'+value.po_number+'">'+'</td>';
                table_content +='<td>'+'<input class="form-control" type="text" onchange="change_cal('+no+')" value="'+value.price+'" id="price'+no+'" name="price[]" readonly>'+'</td>';


                table_content +='<td>'+'<input class="form-control" type="text" value="'+value.amount*value.price+'" id="sum_onelist'+no+'" name="sum[]" readonly>'+'</td>';

                if (value.note == null) {
                  table_content +='<td id="fontstable">ไม่มีข้อมูล</td>';
                } else {
                  table_content +='<td id="fontstable">'+value.note+'</td>';
                }

              table_content +='</tr>';
              no = no+1;
            });
            var id_result = '<tr>\
      			<td></td>\
      			<td></td>\
      			<td></td>\
            <td></td>\
      			<td style="text-align:right;" id="fontstable"><b>จำนวนรายการ</b></td>\
      			<td id="fontstable"> '+(no-1)+' <b> รายการ<input type="hidden" name="count_list" class="form-control" id="count_list" value="'+(no-1)+'" ></b></td>\
      			</tr>';

          $('#po_content').append(table_content);
          $('#po_content').append(id_result);
          $('#getwhd').val();
          $('#getvat').val();
          $('#getdetailprivate').val();
            // change_cal(no);
            calculatelast();
            showwhd();
            insert();
            insert_pettycash();
      });


}
// table_content +='<td>'+'a href="del_member.php?id_account=<?php echo $row["id_account"]; ?>" class="btn btn-outline-warning" role="button">ลบ</a>'+'</td>';
// del_member.php?id_account=<?php echo $row["id_account"]; ?>"
function insert() {
  var wrapper = $(".container2");
  var get_statusbank = $('#getdetailprivate').val();
  // console.log(get_statusbank);
  // var name = '<label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>';
      $('.container2').empty();
      if (get_statusbank == 3) {
        $(wrapper).append('<br><div class="form-inline"><div class="col-sm"><center><font id="fontslabel" color="red"><b>** PO นี้ โอนตรงจากบัญชีส่วนตัวไปยังเจ้าหนี้ **</b></font></center></div></div>');
      }
}

function insert_pettycash() {
  var wrapper = $(".container3");
  var get_ckreservemoney = $('#getdetailpettycash').val();
  // console.log(get_ckreservemoney);
  // var name = '<label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>';
      $('.container3').empty();
      if (get_ckreservemoney == 1) {
        $(wrapper).append('<br><div class="form-inline"><div class="col-sm"><center><font id="fontslabel" color="red"><b>** PO นี้ เป็นเงินสดย่อย **</b></font></center></div></div>');
      }
}

function showwhd() {
  var showwhd1 = $('#getwhd').val();
  var showvat1 = $('#getvat').val();
  // console.log(showvat1);
  var showpercentwhd1 = parseFloat(showwhd1);
  $('#showpercentwhd').replaceWith(showpercentwhd1);
  // $('#showpercentwhd').val(showwhd1);

  if (showwhd1 >= 1.00) {
    $(".container10").show();
  }
  else{
    $(".container10").hide();
  }
  if (showvat1 >= 1) {
    $(".container11").show();
  }
  else{
    $(".container11").hide();
  }
}


function change_cal(no){

  ////   สำหรับ rows
   // console.log(no);

   var price =  document.getElementById("price"+no).value;

   var amount  = document.getElementById("amount"+no).value;

   var grantotal = subtotal*amount;

   var sum_whd = document.getElementById("sumallwhd"+no);

   var value = document.getElementById("sum_onelist"+no);
       value.value = grantotal;

       calculatelast();
}

function change_discount() {
  document.getElementById("discountfinal").defaultValue = "0";
  var discount555 = document.getElementById("discountfinal").value;
  $('#discountfinal').empty();
  calculatelast();
}

// function change_company_pay() {
//   document.getElementById("company_paywht").checked = true;
//   var company_paywhtz = document.getElementById("company_paywht").checked = true;
//   // console.log(company_paywhtz);
//   calculatelast();
// }

// function change_company_pay() {
//   var checkBox = document.getElementById("company_paywht");
//     calculatelast();
// }

////    สำหรับ colum
function calculatelast(){
    var count_list = $('#count_list').val();
    var count_whd = $('#count_list').val();
    var discountfinal = $('#discountfinal').val();
    var get_whd = document.getElementById("whd").value;
    console.log(get_whd);
    var get_company_paywht = document.getElementById("company_paywht");
    var get_vat_show = $('#getvat').val();
    // console.log(get_vat_show);

    $('#sum').empty();
    $('#after_wht').empty();
    $('#sumcalvat').empty();
    $('#sumplusvat').empty();
    $('#sum_col').empty();
    $('#sum_discountfinal').empty();
    // $('#company_paywht').empty();


    // console.log(discount555);

    var sum = 0;
    for (var i = 1; i <= count_list; i++){
          // console.log($('#sum_onelist'+i).val());
        sum = parseFloat(sum) + parseFloat($('#sum_onelist'+i).val());
        // console.log(sum);
    }

    // var sum_whd = 0;
    // for (var j = 1;j <= count_whd; j++){
    //   sum_whd = parseFloat(sum_whd) + parseFloat($('#sumallwhd'+j).val());
    // }
    // $('#after_wht').val(sum_whd);
    var sum01 = sum.toFixed(2);
    console.log(sum01);
    $('#sum_col').val(sum01);



    if (discountfinal) {
      sumfinal = parseFloat(sum)*(parseFloat(discountfinal)/100);
      discountpercent = parseFloat(sum) - parseFloat(sumfinal);
      // console.log(discountpercent);
      var sumfinal2 = discountpercent.toFixed(2);
      // console.log(sumfinal2);
      $('#sum').val(sumfinal2);

      sumfinal55 = parseFloat(sum01) - parseFloat(discountpercent);
      var sum_discount1 = sumfinal55.toFixed(2);
      // console.log(sum_discount1);
      $('#sum_discountfinal').val(sum_discount1);

      $('#sumcalvat').val();
      var vats = document.getElementById("vat").value;
      var sumcalvat2 = parseFloat(sumfinal2)*parseFloat(vats)/100;

      console.log(sumcalvat2);
      // var number2 = (Math.round(sumcalvat2*100)/100).toFixed(2)
      var number2 = Number((sumcalvat2).toFixed(2));
      // var number2 = sumcalvat2.toFixed(3);
      // console.log(number2);
      $('#sumcalvat').val(number2);

      $('#sumplusvat').val();
      var sumplusvat = parseFloat(sumfinal2) + parseFloat(number2);
      var sumplusvat2 = sumplusvat.toFixed(2);
      $('#sumplusvat').val(sumplusvat2);
    }
    else {
      var sumtofixed = sum.toFixed(2);
      $('#sum').val(sumtofixed);

      $('#sumcalvat').val();
      var vats = document.getElementById("vat").value;
      // console.log(vats);
      var sumcalvat2 = parseFloat(sum)*parseFloat(vats)/100;
      // console.log(sumcalvat2);
      var number2 = sumcalvat2.toFixed(2);
      // console.log(number2);
      $('#sumcalvat').val(number2);

      $('#sumplusvat').val();
      // console.log(sum);
      var sumplusvat = parseFloat(sum) + parseFloat(number2);
      var sumplusvat2 = sumplusvat.toFixed(2);
      // console.log(sumplusvat2);
      $('#sumplusvat').val(sumplusvat2);
    }

    if (get_whd >= 1.00 && sumfinal2) {
      $('#after_wht').val();
      var get_whd = document.getElementById("whd").value;
      var sumcalwhd = (parseFloat(sumfinal2)*parseFloat(get_whd))/100;
      var numberwhd = sumcalwhd.toFixed(2);
      $('#after_wht').val(numberwhd);
    }
    else{
      $('#after_wht').val();
      var get_whd = document.getElementById("whd").value;
      var sumcalwhd = (parseFloat(sum)*parseFloat(get_whd))/100;
      var numberwhd = sumcalwhd.toFixed(2);
      $('#after_wht').val(numberwhd);
    }

    if (get_whd == 0.00){
      $('#after_vat_wht').val();
      var after_vat_whtz = parseFloat(sumplusvat2);
      // console.log(after_vat_whtz);
      var number3 = after_vat_whtz.toFixed(2);
      $('#after_vat_wht').val(number3);
    }
    else if (get_whd) {
      $('#after_vat_wht').val();
      var after_vat_whtz = parseFloat(sumplusvat2) - parseFloat(numberwhd) ;
      // console.log(after_vat_whtz);
      var number3 = after_vat_whtz.toFixed(2);
      $('#after_vat_wht').val(number3);
    }
    else{
      // $('#after_vat_wht').val();
      // // console.log(sumplusvat2);
      // var after_vat_whtz = parseFloat(sumplusvat2) - parseFloat(numberwhd);
      // // console.log(after_vat_whtz);
      // var number3 = after_vat_whtz.toFixed(2);
      // $('#after_vat_wht').val(number3);
    }


    // if (get_company_paywht.checked == true) {
    //     $('#after_vat_wht').val();
    //     // console.log(get_company_paywht);
    //     var after_vat_whtz = parseFloat(sumplusvat2);
    //     var number3 = after_vat_whtz.toFixed(2);
    //     $('#after_vat_wht').val(number3);
    // }
    // else if (get_company_paywht.checked == true && get_vat_show == 0) {
    //     $('#after_vat_wht').val();
    //     // console.log(get_company_paywht);
    //     var after_vat_whtz = parseFloat(sumtofixed);
    //     var number3 = after_vat_whtz.toFixed(2);
    //     $('#after_vat_wht').val(number3);
    // }
    // else {
    //     $('#after_vat_wht').val();
    //     var after_vat_whtz = parseFloat(sumplusvat2) - parseFloat(numberwhd);
    //     var number3 = after_vat_whtz.toFixed(2);
    //     $('#after_vat_wht').val(number3);
    // }
    showmoney();
}

function showmoney(){
  var showmoneyz = $('#after_vat_wht').val();
  console.log(showmoneyz);
  $('#showmoney').val(showmoneyz)
}

// function new_calculate() {
//   var edit_sum_col =
// }

// function confirmdelete(no){
// //    console.log(no);
//     swal({
//         title: 'แน่ใจหรือไม่?',
//         text: "คุณต้องการลบรายการนี้!",
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'ยืนยัน ลบรายการ !',
//         cancelButtonText: 'ยกเลิก'
//       }).then((result) => {
//         if (result.value) {
//             $.get('/payser/deleteUpdate/'+no);
//             swal(
//                 'สำเร็จ!',
//                 'ลบรายการของท่านสำเร็จแล้ว',
//                 'success'
//             )
//             $.get('/payser');
//             location.reload();
//         }
//       })
// }

function cleardata()
{
  document.getElementById("myForm").reset();
}


function getpicview(val){
    var infrom_po_id = val;
    // console.log(infrom_po_id);
    $('#get_id_payser').val(infrom_po_id);
    $.get('getdataviewpicture/'+infrom_po_id, function(res) {
        // console.log(res);
        $('#getimages').val(res[0].inform_po_picture);
        // var get_src_img = $('#getimages').val(res[0].inform_po_picture);
        // console.log(get_src_img);
        // document.getElementById("imageid").src=get_src_img;
     });
}






function getdataedit(val){
    var infrompoid = val;
    // console.log(infrom_po_id);
    $('#get_id_payser').val(infrompoid);
    $.get('getgetpay/'+infrompoid, function(res) {
        // console.log(res);
        $('#getbranch').val(res[0].name_branch);
        $('#get_type_po').val(res[0].name_pay);
        $('#bill_no').val(res[0].bill_no);
        $('#bill_no_from_vat').val(res[0].bill_from_vat);
        $('#datebill').val(res[0].datebill);
        $('#datebill_from_vat').val(res[0].date_from_vat);
        $('#get_type_po_no').val(res[0].type_pay);
        $('#get_type_po_no').val();
        $('#discountshow').val(res[0].discount);
        $('#wht_percent_show').val(res[0].wht_percent);
        $('#whtshow').val(res[0].wht);
        $('#whtshow').val();
        $('#vat_percent_show').val(res[0].vat_percent);
        $('#vat_percent_show').val();
        // $('#vat_percent_show').val();
        // console.log($('#vat_percent_show').val(res[0].vat_percent));
        $('#company_pay_wht_show').val(res[0].company_pay_wht);
        $('#company_pay_wht_show').val();

        if ($('#company_pay_wht_show').val() == 255) {
            $('#company_pay_wht_show').val('บริษัทออกแทน');
        }
        else {
            $('#company_pay_wht_show').val('บริษัทไม่ได้ออกแทน');
        }

        if ($('#whtshow').val() >= 1.00) {
            $(".container15").show();
        }
        else{
            $(".container15").hide();
        }

          var po_id = [];
          var input = '';
          var no = 1;
            $.each(res, function(index,value) {
              input += '<input type="hidden" name="" value="'+no+'">';
              input += '<input type="hidden" name="" value="'+value.po_id+'">';
              no = no+1;

          po_id.push(value.po_id);
        });
        // var poid = res[0].po_head;
        // console.log(po_id);
        getpolis(po_id);

        if (infrom_po_id) {
            var type_pay_edit = $('#get_type_po_no').val();
            // console.log(type_pay_edit);
            var wrapper = $(".container1").empty();
            if (type_pay_edit == 2) {
              $.get('getbankdetail1/'+infrom_po_id, function(res) {
                  var getdetailbank = res[0].account_name
                  var getnobank = res[0].account_no
                  // console.log(getdetailbank);
                  $(wrapper).append('<div class="form-inline"><label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>'+'<div class="col"><input style="width: 100%;max-width: 1200px;" type="text" class="form-control" value="'+getnobank+' - '+getdetailbank+'" readonly ></div></div>');
              });
          }
        }

     });
}

function getpolis(po_id){
var _token = $("input[name='_token']").val();
$('#cccccc').empty();
  $.post('getinfofromidpo1',{_token:_token , data:po_id}, function(res) {

      var table_content = '';
      var no = 1;
      var items2 = [];
      $.each(res, function(index,value) {
        items2.push(value.id);
        table_content +='<tr>';
          table_content +='<td>'+no+'</td>';
          table_content +='<td>'+value.payser_number+'</td>';
          table_content +='<td>'+'<input type="hidden" name="po_id" value="'+value.id+'" >'+value.po_number+'</td>';
          table_content +='<td>'+value.price+'</td>';
          table_content +='<td>'+value.list+'</td>';

        table_content +='</tr>';
        no = no+1;
      });
      // console.log(res);
      document.getElementById("cccccc").innerHTML = table_content;
    // $('#poedit').append(table_content);
    showdata(items2);
  })


}

//
// function showbank(){
//   var type_pay_edit = $('#get_type_po_no').val();
//   // console.log(type_pay_edit);
//   var wrapper = $(".container1").empty();
//
//   if (type_pay_edit == 2) {
//       $.get('getbankdetail1/'+type_pay_edit, function(res) {
//         // console.log(res);
//         // var option = '';
//         //   $.each(res, function(index,value) {
//         //     option += '<option value="'+value.id+'">'+value.account_name+'</option>';
//         //   });
//           $(wrapper).append('<label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>'+'<input type="text" class="form-control" id="id_bank" readonly >');
//       });
//   }
// }

function showdata(items2){
      var _token = $("input[name='_token']").val();
      // console.log(items2);
      $.post('postcalculatepo',{_token:_token , data:items2}, function(res) {
          // console.log(res);
            document.getElementById("totalsumreal2").value = "";
            $('#totalsumreal2').val(res);
      });

      $.post('getpodetailbyhead',{_token:_token , data:items2}, function(res) {
            // console.log(res);
            $('#po_content2').empty();
            var table_content = '';
            var no = 1;
            // var amount = $("#amount").val();
            // var price = $("#price").val();
            // var sum_onelist = (amount*price);
            // var discount = ($("#discount").val()*sum_onelist/100); //ส่วนลดเป็นเปอร์เซ็น
            $.each(res, function(index,value) {
              // console.log(value);

              table_content +='<tr>';
                table_content +='<td>'+no+'</td>';
                table_content +='<td>'+value.list+'</td>';
                table_content +='<td>'+'<input class="form-control" type="text" value="'+value.amount+'" id="amount'+no+'" readonly>'+'</td>';
                table_content +='<td>'+'<input class="form-control" type="text" value="'+value.price+'" id="price'+no+'" readonly>'+'</td>';

                if (value.whd == 0.00) {
                  table_content +='<td>'+'<input class="form-control" type="text" value="'+value.price*value.whd+'" id="sumallwhd'+no+'" name="wht_name[]" readonly>'+'</td>';
                }
                else if (value.whd >= 1.00){
                  var sumwhd = value.whd/100;
                  table_content +='<td>'+'<input class="form-control" type="text" value="'+value.price*sumwhd+'" id="sumallwhd'+no+'" name="wht_name[]" readonly>'+'</td>';
                }

                table_content +='<td>'+'<input class="form-control" type="text" value="'+value.amount*value.price+'" id="sum_onelist1'+no+'" name="sum[]" readonly>'+'</td>';

                if (value.note == null) {
                  table_content +='<td>ไม่มีข้อมูล</td>';
                } else {
                  table_content +='<td>'+value.note+'</td>';
                }

              table_content +='</tr>';
              no = no+1;
            });
            var id_result = '<tr>\
            <td></td>\
            <td></td>\
            <td></td>\
            <td></td>\
            <td></td>\
            <td style="text-align:right;"><b>จำนวนรายการ</b></td>\
            <td> '+(no-1)+' <b>รายการ<input type="hidden" name="count_list" class="form-control" id="count_list1" value="'+(no-1)+'" ></b></td>\
            </tr>';

          $('#po_content2').append(table_content);
          $('#po_content2').append(id_result);

            calculatelast1();

      });
}

////    สำหรับ colum
function change_cal1(no){

  ////   สำหรับ rows
   // console.log(no);

   var price =  document.getElementById("price"+no).value;

   var discount = document.getElementById("discount"+no).value;

   var subtotal = parseFloat(price) - parseFloat(discount);

   var amount  = document.getElementById("amount"+no).value;

   var grantotal = subtotal*amount;

   var value = document.getElementById("sum_onelist1"+no);
       value.value = grantotal;

       calculatelast1();

}

function calculatelast1(){
  var count_list = $('#count_list1').val();
  var count_whd = $('#count_list1').val();
  var discountfinal = $('#discountfinal').val();
  // var get_whd = document.getElementById("whd").value;
  var get_company_paywht = document.getElementById("company_paywht");

  $('#sum1').empty();
  $('#after_wht').empty();
  $('#sumcalvat').empty();

  var sum = 0;
  for (var i = 1; i <= count_list; i++){
        // console.log($('#sum_onelist'+i).val());
      sum = parseFloat(sum) + parseFloat($('#sum_onelist1'+i).val());
      // console.log(sum);
  }


  if (discountfinal) {
    sumfinal = parseFloat(sum) - parseFloat(discountfinal);
    var sumfinal2 = sumfinal.toFixed(2);
    // console.log(sumfinal2);
    $('#sum1').val(sumfinal2);

    // $('#sumcalvat1').val();
    // var vats = document.getElementById("vat").value;
    // var sumcalvat2 = parseFloat(sumfinal2) + (parseFloat(sumfinal2)*parseFloat(vats))/100;
    // var number2 = sumcalvat2.toFixed(2);
    // $('#sumcalvat1').val(number2);

  }
  else {
    var sumtofixed = sum.toFixed(2);
    $('#sum1').val(sumtofixed);

    // $('#sumcalvat1').val();
    // var vats = document.getElementById("vat").value;
    // var sumcalvat2 = parseFloat(sum) + (parseFloat(sum)*parseFloat(vats))/100;
    // var number2 = sumcalvat2.toFixed(2);
    // $('#sumcalvat1').val(number2);

  }

  // if (get_whd >= 1.00 && sumfinal2) {
  //   $('#after_wht').val();
  //   var get_whd = document.getElementById("whd").value;
  //   var sumcalwhd = (parseFloat(sumfinal2)*parseFloat(get_whd))/100;
  //   var numberwhd = sumcalwhd.toFixed(2);
  //   $('#after_wht').val(numberwhd);
  // }
  // else{
  //   $('#after_wht').val();
  //   var get_whd = document.getElementById("whd").value;
  //   var sumcalwhd = (parseFloat(sum)*parseFloat(get_whd))/100;
  //   var numberwhd = sumcalwhd.toFixed(2);
  //   $('#after_wht').val(numberwhd);
  // }

  // if (get_company_paywht.checked == true) {
  //     $('#after_vat_wht').val();
  //     // console.log(get_company_paywht);
  //     var after_vat_whtz = parseFloat(number2);
  //     var number3 = after_vat_whtz.toFixed(2);
  //     $('#after_vat_wht').val(number3);
  // }
  // else {
  //     $('#after_vat_wht').val();
  //     var after_vat_whtz = parseFloat(number2) - parseFloat(numberwhd);
  //     var number3 = after_vat_whtz.toFixed(2);
  //     $('#after_vat_wht').val(number3);
  // }

}
