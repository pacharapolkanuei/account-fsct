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
              $(wrapper2).append('<tr><td><select name="name_material[]" class="form-control"  required>'+option+'</select></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="produce[]" onblur="findTotal()"></td><td><input class="form-control mb-2 mr-sm-2" type="text" name="material_cost[]" onblur="findTotal()"/></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="total_cost[]" onblur="findTotal()"/></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="salary[]" onblur="findTotal()" value="0" readonly/></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="total_produce[]" onblur="findTotal()" /></td><td><input class="form-control mb-2 mr-sm-2" type="text"  name="produce_unit[]" onblur="findTotal()" /></td><td style="text-align: center;"> <input type="hidden" onchange="count(this)" id="eieiza1" value="'+(x-1)+'"> <a href="#" class="btn btn-danger delete"> ลบ</a></td></tr>');
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
    var arr = document.getElementsByName('produce[]');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
            tot_final = new Intl.NumberFormat().format(tot);
    }
    document.getElementById('produces').value = tot_final;

    var arr1 = document.getElementsByName('material_cost[]');
    var tot1=0;
    for(var i=0;i<arr1.length;i++){
        if(parseFloat(arr1[i].value))
            tot1 += parseFloat(arr1[i].value);
            tot_final1 = new Intl.NumberFormat().format(tot1);
    }
    document.getElementById('material_costs').value = tot_final1;

    var arr2 = document.getElementsByName('total_cost[]');
    var tot2=0;
    for(var i=0;i<arr2.length;i++){
        if(parseFloat(arr2[i].value))
            tot2 += parseFloat(arr2[i].value);
            tot_final2 = new Intl.NumberFormat().format(tot2);
    }
    document.getElementById('total_costs').value = tot_final2;

    var arr3 = document.getElementsByName('salary[]');
    var tot3=0;
    for(var i=0;i<arr3.length;i++){
        if(parseFloat(arr3[i].value))
            tot3 += parseFloat(arr3[i].value);
            tot_final3 = new Intl.NumberFormat().format(tot3);
    }
    document.getElementById('salarys').value = tot_final3;

    var arr4 = document.getElementsByName('total_produce[]');
    var tot4=0;
    for(var i=0;i<arr4.length;i++){
        if(parseFloat(arr4[i].value))
            tot4 += parseFloat(arr4[i].value);
            tot_final4 = new Intl.NumberFormat().format(tot4);
    }
    document.getElementById('total_produces').value = tot_final4;

    var arr5 = document.getElementsByName('produce_unit[]');
    var tot5=0;
    for(var i=0;i<arr5.length;i++){
        if(parseFloat(arr5[i].value))
            tot5 += parseFloat(arr5[i].value);
            tot_final5 = new Intl.NumberFormat().format(tot5);
    }
    document.getElementById('produce_units').value = tot_final5;


}

function produceUnit(){
    // var arr = document.getElementsByName('debit[]');
    // var tot=0;
    // for(var i=0;i<arr.length;i++){
    //     if(parseFloat(arr[i].value))
    //         tot += parseFloat(arr[i].value);
    // }
    // document.getElementById('totaldebit').value = tot;
    //
    // var arr1 = document.getElementsByName('credit[]');
    // var tot1=0;
    // for(var i=0;i<arr1.length;i++){
    //     if(parseFloat(arr1[i].value))
    //         tot1 += parseFloat(arr1[i].value);
    // }
    // document.getElementById('totalcredit').value = tot1;


    // var produce_cal = document.getElementsByName('produce[]');
    // console.log(produce_cal);
    // var material_cost_cal = document.getElementsByName('material_cost[]');
    // console.log(material_cost_cal);
    // var sum1 = produce_cal * material_cost_cal;
    // console.log(sum1);
    // document.getElementById('total_cost_produce').value = produce_cal;


    // var arr = document.getElementsByName('produce[]');
    // var arr1 = document.getElementsByName('material_cost[]');
    // var tot = 0;
    // for(var i=0;i<arr.length;i++){
    //     if(parseFloat(arr[i].value) && parseFloat(arr1[i].value))
    //         tot = parseFloat(arr[i].value)*parseFloat(arr1[i].value);
    //
    // document.getElementById('total_cost_produce[]').value = tot;
    // }

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
