
$(document).ready(function() {
  console.log( "ready!" );

});

function getdataemptodm(id){
    var lot = $('#lot'+id).val();
    console.log(lot);
    $('#lotthis1').empty();
    $('#lotthis1').append(lot);

    loaddateemp(id)

}

function loaddateemp(id){
     console.log(id);
      //////   empdata  ///////

}

function changemonth(){
    var monthselect = $('#month').val();
    console.log(monthselect);
    loaddateempinput(monthselect);
}

function loaddateempinput(monthselect){

}
