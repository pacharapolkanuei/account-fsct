var mlist = '';
var id =1;
var totolproduce = 0;
var totolcost = 0;
var totoltotal_cost = 0;
var totolsaraly = 0;
var totoltotal_cost_produce = 0;
var totolcost_produce_unit = 0;
var z = 0;
$(document).ready(function() {
  console.log( "ready!" );
  $(".select2").select2({  width: '100%' });
    $.get('getmaterialall', function(res) {
       mlist = res;
    });

});

function addrow(){


    var tb = '<tr>';
        tb += '<td><select  class="form-control select2" name="material_id[]" id="mproduct'+id+'" onchange="calmapping('+id+')"  required>';
        tb += '<option value="" selected>เลือกสินค้า</option>';
        $.each(mlist, function( key, value ) {
            tb += '<option value="'+value.id+'">'+value.name+'</option>';
        });
        tb +='</select></td>';
        tb += '<td><input type="number" class="form-control mb-2 mr-sm-2 pd"   name="produce[]" id="produce'+id+'"  readonly></input></td>';
        tb += '<td><input type="number" class="form-control mb-2 mr-sm-2 ct"   name="cost[]"  id="cost'+id+'"  readonly></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2 tc"   name="total_cost[]" id="total_cost'+id+'" readonly ></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2"   name="saraly[]" id="saraly'+id+'" readonly ></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2 tpc"   name="total_cost_produce[]" id="total_cost_produce'+id+'" readonly ></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2 cpu"   name="cost_produce_unit[]" id="cost_produce_unit'+id+'" readonly ></input></td>';
        // tb += '<td><button type="button" class="btn btn-danger"  onclick="deleteMe(this)" > <fonts id="fontscontent">ลบ</i> </button></td>';
        tb += '</tr>';

    $('#addrowtb').append(tb);
    $(".select2").select2({  width: '100%' });
    id++;
}

function deleteMe(me) {
    resum();
    var tr = $(me).closest("tr");
    tr.remove();

    // console.log(me);
}

function calmapping(i){
    var mId = $('#mproduct'+i).val();
    var bill_of_lading_head = $('#bill_of_lading_head').val();
        // console.log(mId);
    $.get('selectmmapping?bill='+bill_of_lading_head+'&&mId='+mId, function(res) {
            console.log(res);
            if(res!=0){
                 recaladd(i,res[0].amountmain,res[0].sumtotalthis);

            }else{
                alert('ไม่พบข้อมูล กรุณาไปตั้งค่าสินต้าและวัตถุดิบ');
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
                totolsaraly = res['sumpaythisproduct'][0].sumpaythisproduct;
            }else{
                alert('ไม่พบข้อมูล');
            }
    });
}

function recaladd(z,amthis,sumthis){
        // console.log(i);
        // console.log(amthis);
        // console.log(sumthis);
        $('#produce'+z).val(amthis);
        $('#cost'+z).val(sumthis);
        $('#total_cost'+z).val(amthis*sumthis);
        var salarythis = 0 ;

        var list = document.getElementsByClassName("pd");
        var values = [];
        for(var k = 0; k < list.length; ++k) {
               values.push(parseFloat(list[k].value));
           }
           totolproduce = values.reduce(function(previousValue, currentValue, index, array){
               return previousValue + currentValue;
           });
        $('#produceshow').val(totolproduce);


        salarythis = (totolsaraly*amthis)/totolproduce;
        // console.log(z);
      for (var a = z; a >= 0; a--) {
                $('#saraly'+a).val(salarythis);
                $('#total_cost_produce'+a).val(salarythis+(amthis*sumthis));
                $('#cost_produce_unit'+a).val((salarythis+(amthis*sumthis))/amthis);

      }


        var listct = document.getElementsByClassName("ct");
        var valuesct = [];
        for(var d = 0; d < listct.length; ++d) {
               valuesct.push(parseFloat(listct[d].value));
           }
           totolproducect = valuesct.reduce(function(previousValuect, currentValuect, index, array){
               return previousValuect + currentValuect;
           });
        $('#costshow').val(totolproducect);




        var listtc = document.getElementsByClassName("tc");
        var valuestc = [];
        for(var f = 0; f < listtc.length; ++f) {
               valuestc.push(parseFloat(listtc[f].value));
           }
           totolproducetc = valuestc.reduce(function(previousValuetc, currentValuetc, index, array){
               return previousValuetc + currentValuetc;
           });
      $('#total_costshow').val(totolproducetc);




      var listtpc = document.getElementsByClassName("tpc");
      var valuestpc = [];
      for(var b = 0; b < listtpc.length; ++b) {
             valuestpc.push(parseFloat(listtpc[b].value));
         }
         totolproducetpc = valuestpc.reduce(function(previousValuetpc, currentValuetpc, index, array){
             return previousValuetpc + currentValuetpc;
         });
      $('#total_cost_produceshow').val(totolproducetpc);



      var listcpu = document.getElementsByClassName("cpu");
      var valuescpu = [];
      for(var c = 0; c < listcpu.length; ++c) {
             valuescpu.push(parseFloat(listcpu[c].value));
         }
         totolproducecpu = valuescpu.reduce(function(previousValuecpu, currentValuecpu, index, array){
             return previousValuecpu + currentValuecpu;
         });
      $('#cost_produce_unitshow').val(totolproducecpu);
      z++;

}

// function resum(){
//         var list = document.getElementsByClassName("pd");
//         var values = [];
//         for(var k = 0; k < list.length; ++k) {
//                values.push(parseFloat(list[k].value));
//            }
//            totolproduce = values.reduce(function(previousValue, currentValue, index, array){
//                return previousValue + currentValue;
//            });
//         $('#produceshow').val(totolproduce);
//
//
//         for (var a = z; a >= 0; a--) {
//         var amthis = $('#amthis'+a).val();
//         var sumthis = $('#sumthis'+a).val();
//             salarythis = (totolsaraly*amthis)/totolproduce;
//                   $('#saraly'+a).val(salarythis);
//                   $('#total_cost_produce'+a).val(salarythis+(amthis*sumthis));
//                   $('#cost_produce_unit'+a).val((salarythis+(amthis*sumthis))/amthis);
//
//         }
//
//
//           var listct = document.getElementsByClassName("ct");
//           var valuesct = [];
//           for(var d = 0; d < listct.length; ++d) {
//                  valuesct.push(parseFloat(listct[d].value));
//              }
//              totolproducect = valuesct.reduce(function(previousValuect, currentValuect, index, array){
//                  return previousValuect + currentValuect;
//              });
//           $('#costshow').val(totolproducect);
//
//
//
//
//           var listtc = document.getElementsByClassName("tc");
//           var valuestc = [];
//           for(var f = 0; f < listtc.length; ++f) {
//                  valuestc.push(parseFloat(listtc[f].value));
//              }
//              totolproducetc = valuestc.reduce(function(previousValuetc, currentValuetc, index, array){
//                  return previousValuetc + currentValuetc;
//              });
//         $('#total_costshow').val(totolproducetc);
//
//
//
//
//         var listtpc = document.getElementsByClassName("tpc");
//         var valuestpc = [];
//         for(var b = 0; b < listtpc.length; ++b) {
//                valuestpc.push(parseFloat(listtpc[b].value));
//            }
//            totolproducetpc = valuestpc.reduce(function(previousValuetpc, currentValuetpc, index, array){
//                return previousValuetpc + currentValuetpc;
//            });
//         $('#total_cost_produceshow').val(totolproducetpc);
//
//
//
//         var listcpu = document.getElementsByClassName("cpu");
//         var valuescpu = [];
//         for(var c = 0; c < listcpu.length; ++c) {
//                valuescpu.push(parseFloat(listcpu[c].value));
//            }
//            totolproducecpu = valuescpu.reduce(function(previousValuecpu, currentValuecpu, index, array){
//                return previousValuecpu + currentValuecpu;
//            });
//         $('#cost_produce_unitshow').val(totolproducecpu);
//
// }

function saveapprovedtool(id){
      $('#poappove').empty();
      $('#idappoved').val(0);
      var urlapr = '<a href="printasset_product_tool?id='+id+'" target="_blank"><img src="images/global/printall.png"> </a>';
      $('#idappoved').val(id);
      $('#poappove').append(urlapr);
}

function saveapprovedrecstatus(){
    var idappoved = $('#idappoved').val();
    // console.log(idappoved);
      $.get('approveasset_product_tool?id='+idappoved, function(res) {
              if(res==1){
                location.reload();
              }else{
                console.log(res);
              }

      });

}
