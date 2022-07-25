$( document ).ready(function() {
    console.log( "ready!" );
    $('.select2').select2();
});

$('.delete-confirm').on('click', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');
    swal({
        title: 'แน่ใจหรือไม่?',
        text: 'คุณต้องการลบรายการนี้!',
        icon: 'warning',
        buttons: ["ยกเลิก", "ตกลง!"],
    }).then(function(value) {
        if (value) {
            window.location.href = url;
        }
    });
});

//------------------------edit--------------------------
function getdata_percent_edit(val){

    var infrom_po_id = val;
    console.log(infrom_po_id);
    $('#get_id_edit').val(infrom_po_id);
    $.get('getdata_percent/'+infrom_po_id, function(res) {
        console.log(res);
        $('#get_num_percent').val(res[0].percent);
    });
  }
//-------------------------------------------------------
