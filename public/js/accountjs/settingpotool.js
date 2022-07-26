$(document).ready(function() {
  console.log( "ready!" );

});

 function serchpo(){
      var search = $('#search').val();
      $('#namesupplier').empty();
      $('#address_send').empty();
      $('#phone').empty();
      $('#datatable').empty();
      var tableshow = '';
      var tableend = '';
      var i =1;


       $.get('serchsettingpotool?id='+search, function(res) {
         //console.log(res);
           if(isNaN(res)==true){
            console.log(res);
             var totalamount = 0;
             var totalthis = 0;

              $('#namesupplier').append(res[0].pre+'  '+res[0].name_supplier);
              $('#address_send').append(res[0].address_send);
              $('#phone').append(res[0].phone);
                  $.each(res, function( key, value ) {
                        tableshow += '<tr>';
                        tableshow += '<td>'+i+'</td>';
                        tableshow += '<td>'+value.accounttypeno+'</td>';
                        tableshow += '<td>'+value.list+'</td>';
                        tableshow += '<td>'+value.amount+'  '+value.type_amount+'</td>';
                        tableshow += '<td>'+value.price+'</td>';
                        tableshow += '<td>'+value.total+'</td>';
                        tableshow += '<td>0</td>';
                        tableshow += '<td>'+value.total+'</td>';
                        tableshow += '<td>'+(value.total/value.amount).toFixed(2)+'</td>';
                        tableshow += '</tr>';
                    i++;
                    totalamount=Number(totalamount)+Number(value.amount);
                    totalthis =Number(totalthis)+Number(value.total);
                  });
            $('#datatable').append(tableshow);

                  tableend += '<tr>';
                  tableend += '<td colspan="3" align="center">รวม</td>';
                  tableend += '<td>'+totalamount.toFixed(2)+'</td>';
                  tableend += '<td> </td>';
                  tableend += '<td>'+totalthis.toFixed(2)+'</td>';
                  tableend += '<td>0</td>';
                  tableend += '<td>'+totalthis.toFixed(2)+'</td>';
                  tableend += '</tr>';
                  tableend += '<tr>';
                  tableend += '<td colspan="7" align="center">ภาษีมูลค่าเพิ่ม 7%</td>';
                  tableend += '<td>'+(totalthis*0.07).toFixed(2)+'</td>';
                  tableend += '</tr>';
                  tableend += '<tr>';
                  tableend += '<td colspan="7" align="center">รวมสุทธิ</td>';
                  tableend += '<td>'+(totalthis*1.07).toFixed(2)+'</td>';
                  tableend += '</tr>';
            $('#datatable').append(tableend);



           }else{
               alert('กรอกรหัสบิลไม่ถูกต้อง');
           }
        });
 }

function confirmappove(po){
      $('#poappove').empty();
      $('#idpoappoved').val('');
      var showpo = $('#poshowappoved'+po).val();
      //console.log(showpo);
      $('#idpoappoved').val(po);
      $('#poappove').append(showpo);

}

function saveapprovedpostatus(){
    var idpoassettool = $('#idpoappoved').val();
    //console.log(idpoassettool);
        $.get('approvedpotoolassetstatus?id='+idpoassettool, function(res) {
              console.log(res);
        });
}
