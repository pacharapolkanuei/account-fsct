$(document).ready(function() {
  console.log( "ready!" );

});

 function serchpo(){
      var search = $('#search').val();
       $.get('serchsettingpotool?id='+search, function(res) {
               console.log(res);
           // if(isNaN(res)==true){
           //     selectlot = res;
           //       $.each(res, function( key, value ) {
           //           material_id += '<option value="'+value.receiptasset_detail_id+'" >'+value.materialname+'</option>';
           //       });
           //     $('#material_id').append(material_id);
           // }else{
           //     alert('กรอกรหัสบิลไม่ถูกต้อง');
           // }
        });
 }
