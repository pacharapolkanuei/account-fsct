var mlist = '';
var id =1;
$(document).ready(function() {
  console.log( "ready!" );
  $(".select2").select2({  width: '100%' });
    $.get('getmaterialall', function(res) {
       mlist = res;
    });

});

function addrow(){


    var tb = '<tr>';
        tb += '<td><select  class="form-control select2" name="mproduct[]" id="mproduct'+id+'" onchange="calmapping('+id+')"  required>';
        tb += '<option value="" selected>เลือกสินค้า</option>';
        $.each(mlist, function( key, value ) {
            tb += '<option value="'+value.id+'">'+value.name+'</option>';
        });
        tb +='</select></td>';
        tb += '<td><input type="number" class="form-control mb-2 mr-sm-2"   name="produce[]" id="produce'+id+'"  readonly></input></td>';
        tb += '<td><input type="number" class="form-control mb-2 mr-sm-2"   name="cost[]"  id="cost'+id+'"  readonly></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2"   name="total_cost[]" id="total_cost'+id+'" readonly ></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2"   name="saraly[]" id="saraly'+id+'" readonly ></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2"   name="total_cost_produce[]" id="total_cost_produce'+id+'" readonly ></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2"   name="cost_produce_unit[]" id="cost_produce_unit'+id+'" readonly ></input></td>';
        tb += '<td><button type="button" class="btn btn-danger"  onclick="deleteMe(this)" > <fonts id="fontscontent">ลบ</i> </button></td>';
        tb += '</tr>';

    $('#addrowtb').append(tb);
    $(".select2").select2({  width: '100%' });
    id++;
}

function deleteMe(me) {



    var tr = $(me).closest("tr");
    tr.remove();
    // console.log(me);
}

function calmapping(i){
    var mId = $('#mproduct'+i).val();
    var bill_of_lading_head = $('#bill_of_lading_head').val();
        console.log(mId);
    $.get('selectmmappingg?bill='+bill_of_lading_head+'&&mId='+mId, function(res) {
            console.log(res);
            if(res!=0){
                $('#LotShow').val(res['billhead'][0].lot);
                $('#saralyshow').val(res['sumpaythisproduct'][0].sumpaythisproduct);
            }else{
                alert('ไม่พบข้อมูล');
            }
    });
}

function seachbillhead(){
    var bill_of_lading_head = $('#bill_of_lading_head').val();
    $('#LotShow').empty();
    $('#saralyshow').val(0);
    //console.log(bill_of_lading_head);
    $.get('seachbillofladinghead?bill='+bill_of_lading_head, function(res) {
            console.log(res);
            if(res!=0){
                $('#LotShow').val(res['billhead'][0].lot);
                $('#saralyshow').val(res['sumpaythisproduct'][0].sumpaythisproduct);
            }else{
                alert('ไม่พบข้อมูล');
            }
    });
}
