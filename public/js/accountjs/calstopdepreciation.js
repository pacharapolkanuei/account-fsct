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
$(function() {

   $('input[name="daterange"]').daterangepicker();

   // $('select').selectpicker();
});

function selecttax(id,type){
        $('#idref').val(id);
        $('#typeref').val(type);
}
