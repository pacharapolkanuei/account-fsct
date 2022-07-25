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
function getdataedit(val){

    var infrom_po_id = val;
    console.log(infrom_po_id);
    $('#get_id_edit').val(infrom_po_id);
    $.get('getdefineproperty/'+infrom_po_id, function(res) {
        console.log(res);
        $('#get_no_group').val(res[0].number_property);
        $('#get_des_thai').val(res[0].descritption_thai);
        $('#get_des_eng').val(res[0].descritption_eng);
        $('#get_acc_code').val(res[0].accounttype_no);
        $('#get_debit').val(res[0].debit);
        $('#get_credit').val(res[0].credit);
    });
  }
//-------------------------------------------------------
// function confirmdelete(no){
//    console.log(no);
//     swal({
//         title: 'แน่ใจหรือไม่?',
//         text: "คุณต้องการลบรายการนี้!",
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'ยืนยัน ลบรายการ !',
//         cancelButtonText: 'ยกเลิก'
//       }).then((result) => {
//         if (result.value) {
//             $.get('/define_property/delete/'+no);
//             swal(
//                 'สำเร็จ!',
//                 'ลบรายการของท่านสำเร็จแล้ว',
//                 'success'
//             )
//             $.get('/define_property');
//             location.reload();
//         }
//       })
// }
