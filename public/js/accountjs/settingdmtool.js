$(document).ready(function() {
  console.log( "ready!" );

});


 function getdatadmtool(id){
      $('#lotthis').empty();
      $('#datatable').empty();
      $('#id_poasset').empty();
      $('#id_poasset').val(id);
      var tableshow = '';
      var i = 1;

      $.get('getdatedmtool?id='+id, function(res) {
            //  console.log(res);
              $('#lotthis').append(res[0].lotnumber);
              $.each(res, function( key, value ) {
                    tableshow += '<tr>';
                    tableshow += '<td>'+i+'</td>';
                    tableshow += '<td>'+value.list+'<input type="hidden" name="materialid[]" id="materialid'+i+'"   value="'+value.materialid+'" class="form-control" readonly></td>';
                    tableshow += '<td>'+value.amount+'  '+value.type_amount+'</td>';
                    tableshow += '<td>'+value.price+'</td>';
                    tableshow += '<td><input type="text" name="income[]" id="income'+i+'"   value="'+value.amount+'" class="form-control" readonly></td>';
                    tableshow += '<td><input type="number" name="payout[]" id="payout'+i+'" onblur="caldiffshow('+i+')" value="'+value.amount+'" class="form-control" required></td>';
                    tableshow += '<td><b id="showdiff'+i+'">0<b></td>';
                    tableshow += '</tr>';
                i++;
              });
            $('#datatable').append(tableshow);

      });

 }

 function caldiffshow(id){
    $('#showdiff'+id).empty();
    var input = $('#income'+id).val();
    var output = $('#payout'+id).val();
    var resulte =  input - output;


    if(resulte<0){
          alert('กรอกจำนวนผิดพลาด');
            $('#payout'+id).val(input)
            $('#showdiff'+id).append(0);
    }else{
        if(output<0){
          alert('กรอกจำนวนผิดพลา');
            $('#payout'+id).val(input)
            $('#showdiff'+id).empty();
            $('#showdiff'+id).append(0);
        }else{
            $('#showdiff'+id).append(resulte);
        }

    }

 }

 function confirmappove(idpk){
        console.log(idpk);
        var urlref = '<a href="printsettingdmtooldetail?id='+idpk+'" target="_blank"> ใบเบิกพิมพ์ :<img src="images/global/printall.png"> </a>';
        $('#poappove').empty();
        $('#poappove').append(urlref);
        $.get('getdatedmtool?id='+id, function(res) {
                console.log(res);
        });
 }
