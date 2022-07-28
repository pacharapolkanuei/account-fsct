var goodlist = '';
var id =1;
$(document).ready(function() {
  console.log( "ready!" );
  $(".select2").select2({  width: '100%' });
    $.get('getgoodformaterial', function(res) {
       goodlist = res;
    });

});

function addrow(){
          console.log(goodlist);


    var tb = '<tr>';
        tb += '<td><select  class="form-control select2" name="idgood[]"   required>';
        tb += '<option value="" selected>เลือกวัตถุดิบ</option>';
        $.each(goodlist, function( key, value ) {
            tb += '<option value="'+value.id+'">'+value.name+'</option>';
        });
        tb +='</select></td>';
        tb += '<td><input type="number" class="form-control mb-2 mr-sm-2"   name="amountpermeet[]" id="amountpermeet'+id+'"  onblur="calthis('+id+')" required></input></td>';
        tb += '<td><input type="number" class="form-control mb-2 mr-sm-2"   name="pricepermeet[]"  id="pricepermeet'+id+'" onblur="calthis('+id+')"; required></input></td>';
        tb += '<td><input type="text" class="form-control mb-2 mr-sm-2"   name="totalthis[]" id="totalthis'+id+'" readonly ></input></td>';
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

function calthis(i){
      var m = $('#amountpermeet'+i).val();
      var p = $('#pricepermeet'+i).val();
      var totalthis = Number(m)*Number(p);
      $('#totalthis'+i).val(totalthis);
}
