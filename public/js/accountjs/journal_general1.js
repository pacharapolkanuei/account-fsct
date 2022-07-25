$(document).ready(function() {
  console.log( "ready!" );
});


function getvalue() {
  var get_debit = $('#getvaluedebit1').val();
  console.log(get_debit);
  var get_credit = $('#getvaluecredit1').val();
  console.log(get_credit);
}

function chooserent(){
  var get_type_rent = $('#get_type_rent').val();
  console.log(get_type_rent);
    if (get_type_rent = 1) {
        $("#container10").show();
    }
    else {
        $("#container10").hide();
    }

    if (get_type_rent = 2){
        $(".container11").show();
    }
    else {
        $(".container11").hide();
    }
}

function findTotal(){

}

$(function() {
    $('input[name="daterange"]').daterangepicker();
    // $('select').selectpicker();
});

//-----------------------------------edit modal------------------------------------
function getdataedit(val){
}
