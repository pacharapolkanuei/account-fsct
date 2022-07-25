
$( document ).ready(function() {
    //console.log( "ready!" );
    $("#example").DataTable();
	$('.select2').select2();
});


$(function() {

    $('input[name="daterange"]').daterangepicker();

    // $('select').selectpicker();
});

function reply(br,id,typedoc){
    $('#recipient-name').val();
    $('#typedoc').val();
    $('#iddoc').val();
    $('#message-text').val('');

    $('#recipient-name').val(br);
    $('#typedoc').val(typedoc);
    $('#iddoc').val(id);

}

function savemsg(){
    var token = $('#_token').val();
    var brach = $('#recipient-name').val();
    var typedoc = $('#typedoc').val();
    var iddoc = $('#iddoc').val();
    var message = $('#message-text').val();

    var data = {'_token':token,
                'brach':brach,
                'typedoc':typedoc,
                'iddoc':iddoc,
                'message':message};

    // console.log(data);
      $.post('savemsgedit',data, function(res) {
          //console.log(res);
            if(res==1){
                alert('แจ้งสาขาเรียบร้อยแล้ว');
                $('#exampleModal').modal('hide');
            }else{
                 alert('กรอกข้อความ');
            }
      });
}


//
// $('#exampleModal').on('show.bs.modal', function (event) {
//   var button = $(event.relatedTarget) // Button that triggered the modal
//   var recipient = button.data('whatever') // Extract info from data-* attributes
//   // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//   // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//   console.log(recipient);
//   var modal = $(this)
//   modal.find('.modal-title').text('New message to ' + recipient)
//   modal.find('.modal-body input').val(recipient)
// })

// function get_value_id() {
//   $('#getvalueid').empty();
//   var get_value = $('#getvalueid').val();
//   console.log(get_value);
// }

function get_data_check(sel) {
  $('#check_number_debt').empty();
  var check_number_debtz = sel.value;
  console.log(check_number_debtz);

}
