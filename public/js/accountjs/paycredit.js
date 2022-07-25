$( document ).ready(function() {
    console.log( "ready!" );
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


function selectbranch3(val){
	var branch = val.value;
  // console.log(branch);
	$('#modal-input-po').empty();
	// $('#modal-input-po').empty();//เคลียselectจังหวัดก่อนหน้า
		$.get('getpoindebt/'+branch, function(res) {
        // console.log(res);
	  	var option = '<option disabled selected>========เลือกใบเลขที่ AP========</option>';
          $.each(res, function(index,value ) { //วนลูป

			 	option += '<option value="'+value.id+'">'+value.number_debt+'</option>';
		  });

		  $('#modal-input-po').append(option);//เป็นการเพิ่ม option #modal-input-po

    });
    $("#modal-input-po").on('change', function (e) {
        //this returns all the selected item
        var items= $(this).val();
        var indebtpo = $(this).val();
        // console.log(items);
        // console.log(indebtpo);
        calculatetotalreal2(items);
        apdetail(indebtpo);
      });
}

function apdetail(indebtpo){
var _token = $("input[name='_token']").val();
$('#apdata').empty();
// console.log(poid);
// console.log(_token);
  $.post('getindebtpo',{_token:_token , data:indebtpo}, function(res) {
      $('#apdata').empty();
      var table_content = '';
      var no = 1;
      var items2 = [];
      var id_po = [];
      $.each(res, function(index,value) {
        // console.log(res);
        table_content +='<tr>';
          table_content +='<td>'+no+'</td>';
          table_content +='<td>'+'<input type="hidden" name="ap_no" value="'+value.number_debt+'" >'+value.number_debt+'</td>';
          table_content +='<td>'+value.po_number+'</td>';
          table_content +='<td>'+value.price+'</td>';
          table_content +='<td>'+'<input type="hidden" name="po_id" value="'+value.po_headid+'" >'+value.list+'</td>';
        table_content +='</tr>';
        no = no+1;
        items2.push(value.id);
        // id_po.push(value.po_headid)
        // calculatetotalreal(id_po);
        calsumvatindebt(items2)
        // console.log(id_po);
        // console.log(items2);
      });
    $('#apdata').append(table_content);
  })
}


function selecttypepay(val) {
  var type_pay = val.value;
  // console.log(type_pay);
  increasebankfromacc(type_pay);
}

// function increasebank(type_pay) {
//   // console.log(type_pay);
//   var wrapper = $(".container1");
//   // var name = '<label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>';
//       $('.container1').empty();
//       if (type_pay == 2) {
//
//           $.get('getbankdetailz/'+type_pay, function(res) {
//             // console.log(res);
//             var option = '';
//               $.each(res, function(index,value) {
//                 option += '<option value="'+value.id+'">'+value.account_no+' - '+value.account_name+'</option>';
//               });
//
//               $(wrapper).append('<br><div class="form-inline"><label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>'+'<div class="col-sm"><select  style="width: 100%;max-width: 1200px;" class="form-control" name="bank">'+option+'</select></div></div>');
//           });
//       }
// }

function increasebankfromacc(type_pay) {
  var wrapper = $(".container1");
  // var name = '<label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>';
      $('.container1').empty();
      if (type_pay == 2) {

          $.get('getbankfromaccounttype/'+type_pay, function(res) {

            var option = '';
              $.each(res, function(index,value) {
                option += '<option value="'+value.accounttypeno+'|'+value.accounttypefull+'">'+value.accounttypeno+' - '+value.accounttypefull+'</option>';
              });

              $(wrapper).append('<br><div class="form-inline"><label id="fontslabel"><b>ธนาคาร :</b></label>'+'<div class="col-sm"><select style="width: 100%;max-width: 1200px;" class="form-control" name="bank">'+option+'</select></div></div>');
          });
      }
}

function calsumvatindebt(items2) {
  var _token = $("input[name='_token']").val();

  $.post('postcalculatepo1',{_token:_token , data:items2}, function(res) {
        // $('#totoal1').empty();
        // // console.log(res);
        // document.getElementById("totoal1").value = "";
        // var sum_vatprice = Object.values(res[0])
        // $('#totoal1').val(sum_vatprice);
        // // console.log($('#totoal1').val());

        $('#totalallcol').empty();
        // console.log(res);
        document.getElementById("totalallcol").value = "";
        var sumcol = Object.values(res[0])
        $('#totalallcol').val(sumcol);

        calculatelast();
  });
}


function calculatetotalreal2(items) {

  var _token = $("input[name='_token']").val();

  $.post('getpodetailbydebt1',{_token:_token , data:items}, function(res) {
        // console.log(res);
        $('#po_content').empty();
        var table_content = '';
        var no = 1;

        $.each(res, function(index,value) {
          // console.log(value);
          table_content +='<tr>';
            table_content +='<td>'+no+'</td>';
            table_content +='<td>'+'<input type="hidden" name="id_po_indebt[]" value="'+value.id_po+'">'+'<input type="hidden" id="getwhd" value="'+value.whd+'">'+'<input type="hidden" name="id_in_debt" value="'+value.id+'">'+'<input type="hidden" name="bill_no" value="'+value.bill_no+'">'+value.bill_no+'</td>';
            table_content +='<td>'+'<input type="text" name="wht" class="form-control"  id="whd'+no+'" value="'+value.whd+' %" readonly>'+'<input type="hidden" name="vat" value="'+value.vat+'">'+'<input type="hidden" name="discount" value="'+value.discount+'">'+'<input type="hidden" name="vat_price" value="'+value.vat_price+'">'+'</td>';

            if (value.whd == 0.00 || value.whd === null) {
              table_content +='<td>'+'<input class="form-control" type="text" value="'+value.vat_price*value.whd+'" id="sumallwhd" name="wht_name" readonly>'+'</td>';
            }
            else if (value.whd >= 1.00){
              var sumwhd = value.whd/100;
              table_content +='<td>'+'<input class="form-control" type="text" value="'+value.vat_price*sumwhd+'" id="sumallwhd" name="wht_name" readonly>'+'</td>';
            }
            table_content +='<td>'+'<input class="form-control" type="text" value="'+value.vat_price+'" id="price" readonly>'+'</td>';
          table_content +='</tr>';
          no = no+1;
        });
        var id_result = '<tr>\
        <td></td>\
        <td></td>\
        <td></td>\
        <td id="fontslabel" style="text-align:right;"><b>จำนวนรายการ</b></td>\
        <td id="fontslabel"> '+(no-1)+' <b>รายการ<input type="hidden" name="count_list" class="form-control" id="count_list" value="'+(no-1)+'" ></b></td>\
        </tr>';

      $('#po_content').append(table_content);
      $('#po_content').append(id_result);

      $('#price').val();
      $('#sumallwhd').val();
      $('#getwhd').val();
      // change_cal();
      calculatelast();
      showwhd();
  });
}

function showwhd() {
  var showwhd1 = $('#getwhd').val();
  // console.log(showwhd1);

  if (showwhd1 >= 1.00){
    $(".container10").show();
  }
  else{
    $(".container10").hide();
  }
}

////    สำหรับ colum
function calculatelast(){
    var count_list = $('#count_list').val();
    var sumrow =  $('#sumallwhd').val();
    var totalmoney = $('#totalallcol').val();
    $('#sumallwhdcol').val(sumrow);
    console.log(sumrow);
    console.log(totalmoney);
    $('#aftermoney').empty();
    var aftermoneyz = parseFloat(totalmoney) + parseFloat(sumrow);
    var number1 = aftermoneyz.toFixed(2);
    $('#aftermoney').val(number1);

    showmoney();
}

function showmoney(){
  var getmoney1 = $('#aftermoney').val();
  // console.log(getmoney1);
  $('#getmoney').val(getmoney1);
}

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
//             $.get('/paycredit/delete/'+no);
//             swal(
//                 'สำเร็จ!',
//                 'ลบรายการของท่านสำเร็จแล้ว',
//                 'success'
//             )
//             $.get('/paycredit');
//             location.reload();
//         }
//       })
// }

//-------------------------------------editmodal----------------------------------------------
function getdataedit(val){

    var in_debt_id = val;
    $('#get_id_edit').val(in_debt_id);
    // console.log(in_debt_id);
    $.get('getdataeditz/'+in_debt_id, function(res) {
        console.log(res);
        // $('#idvalue').val(res[0].id);
        $('#getbranch').val(res[0].code_branch);
        $('#get_type_po').val(res[0].type_pay);
        $('#bill_no').val(res[0].bill_no);
        $('#datebill').val(res[0].datebill);
        $('#vat_price').val(res[0].vat_price);
        $('#get_type_po_no').val(res[0].type_pay);

        var poid = res[0].po_id;
        getpolis(poid);

        var type_pay_edit = $('#get_type_po_no').val();
        // console.log(type_pay_edit);
        var wrapper = $(".container2").empty();
        if (type_pay_edit == 2) {
          $.get('getbankdetailpaycredit/'+in_debt_id, function(res) {
              var getdetailbank = res[0].account_name
              var getnobank = res[0].account_no
              // console.log(res);
              $(wrapper).append('<div class="form-inline"><label class="col-form-label" id="fontslabel"><b>ธนาคาร :</b></label>'+'<div class="col"><input style="width: 100%;max-width: 1300px;" type="text" class="form-control" value="'+getnobank+' - '+getdetailbank+'" readonly></div></div>');
          });
        }

        });
        // var type_pay_bank = $('#get_type_po').val();
        // // console.log(type_pay_bank);
        // showbank($('#get_type_po_no').val(res[0].type_pay));
    }

function getpolis(poid){
var _token = $("input[name='_token']").val();
$('#poedit').empty();
// console.log(poid);
// console.log(_token);
  $.post('getinfofromidpo',{_token:_token , data:poid}, function(res) {
    // console.log(res);
      //   var option = '';
      //       $.each(res, function(index,value) { //วนลูป
  		// 	 	      option += '<option value="'+value.id+'">'+value.po_number+'</option>';
  		//   });
      //
		  // $('#poedit').append(option);//เป็นการเพิ่ม option #modal-input-po

      var table_content = '';
      var no = 1;
      var items2 = [];
      $.each(res, function(index,value) {
        // console.log(value);
        table_content +='<tr>';
          table_content +='<td>'+no+'</td>';
          table_content +='<td>'+value.payser_number+'</td>';
          table_content +='<td>'+value.po_number+'</td>';
          table_content +='<td>'+value.price+'</td>';
          table_content +='<td>'+value.list+'</td>';
        table_content +='</tr>';
        no = no+1;
        items2.push(value.id);
      });
    $('#poedit').append(table_content);

    // var items2 = $("input[name='po_id']").val();
    // // var items2 = $('#getpoid').val();
    // console.log(items2);
    showdata(items2);
  })
}


// function showbank(type_pay_bank){
//   var type_pay_edit = $('#get_type_po').val();
//   console.log(type_pay_edit);
//   var wrapper = $(".container1").empty();
//
//   if (type_pay_edit == 2) {
//       $.get('getbankdetailpaycredit/'+type_pay_edit, function(res) {
//         console.log(res);
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
      // $.post('postcalculatepo2',{_token:_token , data:items2}, function(res) {
      //     // console.log(res);
      //       document.getElementById("totalsumreal2").value = "";
      //       $('#totalsumreal2').val(res);
      // })

      $.post('postinfofromindebt',{_token:_token , data:items2}, function(res) {
            // console.log(res);
            $('#po_content2').empty();
            var table_content = '';
            var no = 1;

            $.each(res, function(index,value) {
              // console.log(value);
              table_content +='<tr id="fontstable">';
                table_content +='<td>'+no+'</td>';
                table_content +='<td>'+'<input type="hidden" name="in_debt_id" value="'+value.id+'">'+value.bill_no+'</td>';
                table_content +='<td>'+value.whd+'</td>';

                if (value.whd == 0.00) {
                  table_content +='<td>'+'<input class="form-control" type="text" id="sum_whd" value="'+value.vat_price*value.whd+'" readonly>'+'</td>';
                }
                else if (value.whd >= 1.00){
                  var sumwhd = value.whd/100;
                  table_content +='<td>'+'<input class="form-control" type="text" id="sum_whd" value="'+value.vat_price*sumwhd+'" readonly>'+'</td>';
                }

                table_content +='<td>'+'<input type="hidden" id="vat_price_calcol" value="'+value.vat_price+'">'+value.vat_price+'</td>';
              table_content +='</tr>';
              no = no+1;
            });
            var id_result = '<tr>\
      			<td></td>\
            <td></td>\
            <td></td>\
      			<td id="fontstable" style="text-align:right;"><b>จำนวนรายการ</b></td>\
      			<td id="fontstable"> '+(no-1)+' <b>รายการ<input type="hidden" name="count_list" class="form-control" id="count_list" value="'+(no-1)+'" ></b></td>\
      			</tr>';

          $('#po_content2').append(table_content);
          $('#po_content2').append(id_result);

          calculatecol();
      });
}

function calculatecol() {
  var vat_price_calcolz = $('#vat_price_calcol').val();
  var sum_whdz = $('#sum_whd').val();

  $('#vat_price_calcol2').empty();
  $('#vat_price_calcol2').val(vat_price_calcolz);
  $('#sum_whd2').empty();
  $('#sum_whd2').val(sum_whdz);

  $('#aftermoney2').empty();
  var aftermoneyz = parseFloat(vat_price_calcolz) + parseFloat(sum_whdz);
  var number1 = aftermoneyz.toFixed(2);
  $('#aftermoney2').val(number1);

}
