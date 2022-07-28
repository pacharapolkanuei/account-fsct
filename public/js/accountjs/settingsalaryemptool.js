var dataempheadselect = '';
var dataempdetailselect = '';
var i = 1;
var grandsalary = 0;
var grandot = 0;
var grandincomeetc = 0;
var grandtotalincome = 0;
var grandsocial = 0;
var grandleave = 0;
var grandpayetc = 0;
var grandtotalpay = 0;
var grandnet = 0;
var grandproductpay = 0;
$(document).ready(function() {
  console.log( "ready!" );

});

function getdataemptodm(id){
    var lot = $('#lot'+id).val();
    // console.log(lot);
    $('#lotthis1').empty();
    $('#lotthis1').append(lot);

    loaddateemp(id)

}

function loaddateemp(id){
     // console.log(id);
      //////   empdata  ///////

}

function changemonth(){
    var monthselect = $('#month').val();
    $('#empproduct').empty();
    var empproduct = '<option value="" selected>เลือกพนักงานผลิต</option>';
      $.get('getempwageselectmonthproduct?monthselect='+monthselect, function(res) {
          // console.log(res.getdatahead);
          dataempheadselect = res.getdatahead;
          dataempdetailselect = res.getdatadetail;
          $.each(dataempheadselect, function( key, value ) {
              empproduct += '<option value="'+value.WAGE_ID+'">'+value.prefixth+' '+value.nameth+' '+value.surnameth+'  ('+value.WAGE_POSITION_NAME+')'+'</option>';
          });
        $('#empproduct').append(empproduct);
        $("#empproduct").select2({ width: '100%' });

      });
}



function addrowempdate(){
      var selectemppd = $('#empproduct').val();
      // console.log(selectemppd);
      if(selectemppd==''){
        alert('เลือกพนักงาน');
      }else{
          $('.del').empty();
          console.log(dataempdetailselect);
          // $('#datatable').empty();
          var empselectid = '';
          var name = '';
          var position = '';
          var salary = 0;
          var ot = 0;
          var incomeetc = 0;
          var totalincome = 0;
          var social = 0;
          var leave = 0;
          var payetc = 0;
          var totalpay = 0;
          var net = 0;
          var productpay = 0;


          var tb = '';
          // header
          $.each(dataempheadselect, function( key, value ) {
                if(value.WAGE_ID==selectemppd){
                    empselectid = value.WAGE_ID;
                    name = value.prefixth+' '+value.nameth+' '+value.surnameth;
                    position = '('+value.WAGE_POSITION_NAME+')';
                    salary = value.WAGE_SALARY;

                }

          });
          tb +='<tr>';

          tb +='<td>'+name+'<input type="hidden" name="idwage[]" id="idwage'+i+'" value="'+empselectid+'"></td>';
          tb +='<td>'+position+'</td>';
          tb +='<td>'+salary+'</td>';

          // detail
          var addthis = 0;
          $.each(dataempdetailselect, function( key, value ) {
            // ot
              if(value.WAGE_ID==selectemppd && value.ADD_DEDUCT_THIS_MONTH_TMP_ID == 8){

                    ot =  value.ADD_DEDUCT_THIS_MONTH_AMOUNT;

              }

              if(value.WAGE_ID==selectemppd && value.ADD_DEDUCT_THIS_MONTH_TMP_ID != 8 && value.ADD_DEDUCT_THIS_MONTH_TYPE==1){
                    //console.log(value.ADD_DEDUCT_THIS_MONTH_AMOUNT+'-----');
                    addthis =  Number(addthis) + Number(value.ADD_DEDUCT_THIS_MONTH_AMOUNT);
              }

              if(value.WAGE_ID==selectemppd && value.ADD_DEDUCT_THIS_MONTH_TMP_ID == 38 ){
                    //console.log(value.ADD_DEDUCT_THIS_MONTH_AMOUNT+'-----');
                    social =   Number(value.ADD_DEDUCT_THIS_MONTH_AMOUNT);
              }

              if(value.WAGE_ID==selectemppd && value.ADD_DEDUCT_THIS_MONTH_TMP_ID == 21 ){
                    //console.log(value.ADD_DEDUCT_THIS_MONTH_AMOUNT+'-----');
                    leave =   Number(value.ADD_DEDUCT_THIS_MONTH_AMOUNT);
              }

              if(value.WAGE_ID==selectemppd && value.ADD_DEDUCT_THIS_MONTH_TMP_ID != 38 && value.ADD_DEDUCT_THIS_MONTH_TMP_ID != 21 && value.ADD_DEDUCT_THIS_MONTH_TYPE==2){
                    //console.log(value.ADD_DEDUCT_THIS_MONTH_AMOUNT+'-----');
                    payetc =  Number(addthis) + Number(value.ADD_DEDUCT_THIS_MONTH_AMOUNT);
              }



          });
          totalincome = Number(salary) + Number(ot) + Number(incomeetc);
          totalpay =  Number(social) + Number(payetc) + Number(leave);
          var totalthis = Number(totalincome)-Number(totalpay);


           grandsalary = Number(grandsalary) + Number(salary);
           grandot = Number(grandot) + Number(ot);
           grandincomeetc = Number(grandincomeetc) + Number(incomeetc);
           grandtotalincome = Number(grandtotalincome) + Number(totalincome);
           grandsocial = Number(grandsocial) + Number(social);
           grandleave = Number(grandleave) + Number(leave);
           grandpayetc =  Number(grandpayetc) + Number(payetc);
           grandtotalpay =  Number(grandtotalpay) + Number(totalpay);
           grandnet = Number(grandnet) + Number(totalthis);
           grandproductpay =  Number(grandproductpay) + Number(totalincome);


          tb +='<td>'+ot+'</td>';
          tb +='<td>'+incomeetc+'</td>';
          tb +='<td>'+totalincome+'</td>';
          tb +='<td>'+social+'</td>';
          tb +='<td>'+leave+'</td>';
          tb +='<td>'+payetc+'</td>';
          tb +='<td>'+totalpay+'</td>';
          tb +='<td>'+totalthis+'</td>';
          tb +='<td>'+totalincome+'</td>';
          tb +='<td><button type="button" class="btn btn-danger"  onclick="deleteMe(this)" > <fonts id="fontscontent">ลบ</i> </button></td>';
          tb +='</tr>';

          tb +='<tr>';


          $('#datatable').append(tb);
            i++;

      }
      $('#callast').show();
      $('#grandsalary').append(grandsalary);
      $('#grandot').append(grandot);
      $('#grandincomeetc').append(grandincomeetc);
      $('#grandtotalincome').append(grandtotalincome);
      $('#grandsocial').append(grandsocial);
      $('#grandleave').append(grandleave);
      $('#grandpayetc').append(grandpayetc);
      $('#grandtotalpay').append(grandtotalpay);
      $('#grandnet').append(grandnet);
      $('#grandproductpay').append(grandproductpay);

}
function deleteMe(me) {


  
    var tr = $(me).closest("tr");
    tr.remove();
    // console.log(me);
}
