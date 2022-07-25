$(document).ready(function() {
    $('#example').DataTable();
    
});


function change_fee(id){
    income = $('#income_cheque'+id+'').val();
    fee = $('#fee'+id+'').val();
    sum = income-fee;
    var id_net = '<input type="text" class="form-control" placeholder="รายได้สุทธิ" name="net" id="net'+id+'" value="'+sum+'">';
    $('#net'+id+'').replaceWith(id_net);
    
    


}