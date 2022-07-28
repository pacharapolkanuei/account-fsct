$(document).ready(function() {
  console.log( "ready!" );

    $.get('getmaterial', function(res) {
        // console.log(res);
      var option = '<option disabled selected>โปรดเลือกรายการ</option>';
          $.each(res, function(index,value ) { //วนลูป

        option += '<option value="'+value.id+'">'+value.name+'</option>';
      });


      var max_fields      = 1000;
      // var wrapper         = $(".container10");
      var wrapper2         = $(".container11");
      var add_button      = $(".add_form_field");
      var no = 1;
      var x = 1;
      $(add_button).click(function(e){
          e.preventDefault();

          if(x < max_fields){
              x++;
              $(wrapper2).append('<tr><td><select name="name_material[]" class="form-control"  required>'+option+'</select></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="produce[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="material_cost[]" onblur="findTotal()"/></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="total_cost[]" onblur="findTotal()" /></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="salary[]" onblur="findTotal()" value="0" readonly /></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="total_produce[]" onblur="findTotal()" /></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="produce_unit[]" onblur="findTotal()" /></td><td style="text-align: center;"> <input type="hidden" onchange="count(this)" id="eieiza1" value="'+(x-1)+'"> <a href="#" class="btn btn-danger delete"> ลบ</a></td></tr>');
              no = no+1;
          }
          else
          {
          alert('เกิน Limit ที่ตั้งไว้')
          }
      });

      $(wrapper2).on("click",".delete", function(e){
          e.preventDefault(); $(this).parent('').parent('tr').remove(); x--;
      })




    });



});

function increase_col(){
  var inc_col2 = $('#inc_col').val();

    // $('#getacc').empty();
    // $('#getacc1').empty();
    // $('#getacc2').empty();
    // $('#getacc3').empty();
    // $('#getacc4').empty();
    // $('#getacc5').empty();
    // $('#getacc6').empty();
    // $('#getacc7').empty();
    // $('#getacc8').empty();
    // $('#getacc9').empty();
    // $('#getacc10').empty();
    // $('#getacc11').empty();
    // $('#getacc12').empty();
    // $('#getacc13').empty();
    // $('#getacc14').empty();
    // $('#getacc15').empty();
    // $('#getacc16').empty();
    // $('#getacc17').empty();
    // $('#getacc18').empty();
    // $('#getacc19').empty();
    // $('#getacc20').empty();
    // $.get('getaccountname', function(res) {
    //     // console.log(res);
    //   var option = '<option disabled selected></option>';
    //       $.each(res, function(index,value ) { //วนลูป
    //
    //     option += '<option value="'+value.id+'">'+value.accounttypeno+' '+value.accounttypefull+'</option>';
    //   });
    //
    // $('#getacc').append(option);//เป็นการเพิ่ม option #modal-input-po
    // $('#getacc1').append(option);
    // $('#getacc2').append(option);
    // $('#getacc3').append(option);
    // $('#getacc4').append(option);
    // $('#getacc5').append(option);
    // $('#getacc6').append(option);
    // $('#getacc7').append(option);
    // $('#getacc8').append(option);
    // $('#getacc9').append(option);
    // $('#getacc10').append(option);
    // $('#getacc11').append(option);
    // $('#getacc12').append(option);
    // $('#getacc13').append(option);
    // $('#getacc14').append(option);
    // $('#getacc15').append(option);
    // $('#getacc16').append(option);
    // $('#getacc17').append(option);
    // $('#getacc18').append(option);
    // $('#getacc19').append(option);
    // $('#getacc20').append(option);
    // });

//   if (inc_col2 == 1) {
//     $(".container11").empty();
//     $(".container11").append('<tr><td><input type="hidden" value="1" name="key"><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()" ></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()" /></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr>');
//   }
//   else if (inc_col2 == 2) {
//     $(".container11").empty();
//     $(".container11").append('<tr><td><input type="hidden" value="2" name="key"><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc1" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc2" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr>');
//   }
//   else if (inc_col2 == 3) {
//     $(".container11").empty();
//     $(".container11").append('<tr><td><input type="hidden" value="3" name="key"><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc3" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc4" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc5" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr>');
//   }
//   else if (inc_col2 == 4) {
//     $(".container11").empty();
//     $(".container11").append('<tr><td><input type="hidden" value="4" name="key"><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc6" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc7" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc8" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc9" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr>');
//   }
//   else if (inc_col2 == 5) {
//     $(".container11").empty();
//     $(".container11").append('<tr><td><input type="hidden" value="5" name="key"><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc10" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc11" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc12" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc13" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"</td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc14" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()" ></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr>');
//   }
//   else if (inc_col2 == 6) {
//     $(".container11").empty();
//     $(".container11").append('<tr><td><input type="hidden" value="6" name="key"><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc15" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc16" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc17" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc18" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"</td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc19" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="credit[]" onblur="findTotal()" ></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr><tr><td><select name="account[]" class="form-control mb-2 mr-sm-2" id="getacc20" required></select></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="debit[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="credit[]" onblur="findTotal()"></td><td><textarea class="form-control mb-2 mr-sm-2" name="memo[]" required></textarea></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="name[]" required/></td></tr>');
//   }
//   else {
//     $(".container11").empty();
//   }
}

function confirmdelete(no){
    // console.log(no);
    swal({
        title: 'แน่ใจหรือไม่?',
        text: "คุณต้องการลบรายการนี้!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน ลบรายการ !',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.value) {
            $.get('/journal_general/deleteUpdate/'+no);
            swal(
                'สำเร็จ!',
                'ลบรายการของท่านสำเร็จแล้ว',
                'success'
            )
            $.get('/journal_general');
            location.reload();
        }
      })
}

function findTotal(){
    var arr = document.getElementsByName('debit[]');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
    document.getElementById('totaldebit').value = tot;

    var arr1 = document.getElementsByName('credit[]');
    var tot1=0;
    for(var i=0;i<arr1.length;i++){
        if(parseFloat(arr1[i].value))
            tot1 += parseFloat(arr1[i].value);
    }
    document.getElementById('totalcredit').value = tot1;
}

$(function() {
    $('input[name="daterange"]').daterangepicker();
    // $('select').selectpicker();
});

//-----------------------------------edit modal------------------------------------
function getdataedit(val){

    var infrom_po_id = val;
    $('#get_id_edit').val(infrom_po_id);
    // console.log($('#get_id_edit').val());
    $.get('getjournalgeneraledit/'+infrom_po_id, function(res) {
        // console.log(res);
        $('#billno').val(res[0].number_bill_journal);
        $('#get_codebranch').val(res[0].code_branch);
        $('#getbranch').val(res[0].name_branch);
        $('#datebill').val(res[0].datebill);
        $('#debit').val(res[0].debit);
        $('#credit').val(res[0].credit);
        $('#list').val(res[0].list);
        $('#name').val(res[0].name_supplier);
        $('#account').val(res[0].accounttypeno);
      });
}
