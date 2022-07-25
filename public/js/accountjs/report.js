/**
 * Created by pacharapol on 1/14/2018 AD.
 */
var index = 1;
var amount = 0;
var price = 0;
var vat = 0;
var availableTags = '';
var objasset = '';
var objohter = '';

$(document).ready(function() {
    $('#example').DataTable();
    $('.select2').select2();

    $('#addrow').on("click", function() {
        // console.log(index);

        CloneTableRow();
        //bindDataWithStep();
    });

    $(".datepicker").datepicker({
        format: 'dd-mm-yyyy',
    });

});
