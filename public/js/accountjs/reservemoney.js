function selecttypeprice(val) {
    var list = val.value;
    var id_company = $('#id_compay').val();
    var branch_id = $('#brid').val();

    // console.log(list);

    $.get("getmainmaterialbyquotation?idtype="+list+"&&idcompany="+id_company+"&&branch_id="+branch_id, function(res) {
      if(list!=0){
          $('#amount').val(res[0].amount);
          $('#list0').val(res[0].list);
          $('#id_list').val(res[0].id);
          // $('#hideselecthead').hide();
      }else{
          $('#amount').val(res);
          $('#list0').val(res);
          $('#id_list').val(res);
          // $('#hideselecthead').show();
      }
        availableTags =  res;
    });

}


function deleteMe(val){
    var id = val;
    var branch = $('#branch').val();
    bootbox.confirm({
          title: "แจ้งเตือน!!!",
          message: "ยืนยันการลบรายการ",
          buttons: {
              cancel: {
                  label: '<i class="fa fa-times"></i> Cancel'
              },
              confirm: {
                  label: '<i class="fa fa-check"></i> Confirm'
              }
          },
          callback: function(result) {
              if (result) {
                   // console.log('deleteMe');
                   $.post('deletedetail', { id: id , branch:branch }, function(res) {
                        console.log(res);
                          location.reload();
                    });

              }

          }
      });


}


function fncSubmit()
{
    if(document.getElementById('image').value == "")
    {
        alert('กรุณาแนบหลักฐานการจ่ายเงิน');
        return false;
    }
}


$(document).ready(function() {
    // $('#example').DataTable();

    // $('#example').DataTable();
    
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons:[
            $.extend( true, {}, fixNewLine, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, fixNewLine, {
                extend: 'excelHtml5'
            } )

        ]

    });

    $('.dataTables_length').addClass('bs-select')

    $('#reservation').daterangepicker();

    $(".datepicker").datepicker({
    format: 'dd/mm/yyyy',
    language: 'th'
    });

    var fixNewLine = {
        exportOptions: {
            format: {
                body: function ( data, column, row ) {
                    return column === 0 ?
                        data.replace( /<br\s*\/?>/gmi, '\n' ) :
                        data;
                }
            }
        }
    };

    // $('#example').DataTable({
    //     dom: 'Bfrtip',
    //     buttons:[
    //         $.extend( true, {}, fixNewLine, {
    //             extend: 'copyHtml5'
    //         } ),
    //         $.extend( true, {}, fixNewLine, {
    //             extend: 'excelHtml5'
    //         } )
    //
    //     ]
    //
    // });

    $("#year").datepicker( {  //รายปี
          format: " yyyy",
          viewMode: "years",
          minViewMode: "years"

        });

});

function saveporef(val){
      $('#reservemoneyid').val('');
      $('#reservemoneyid').val(val);

}

function getponumbersubmit(){
  var valid = $('#configPo').validator('validate').has('.has-error').length;
      if (valid == 0) {

          bootbox.confirm({
              title: "ยืนยันการทำรายการ",
              message: "ยืนยันการตรวจสอบ",
              buttons: {
                  cancel: {
                      label: '<i class="fa fa-times"></i> Cancel'
                  },
                  confirm: {
                      label: '<i class="fa fa-check"></i> Confirm'
                  }
              },
              callback: function(result) {
                  if (result) {
                        var formData = new FormData();
                        var files   = $('#fileref')[0].files[0];
                        formData.append('fileref', files);
                        formData.append('id', $('#reservemoneyid').val());
                        formData.append('ponumber', $('#ponumber').val());
                        formData.append('bill_no', $('#bill_no').val());



                        // console.log(formData);

                            $.ajax({
                                  url: 'insertporef',
                                  type: "POST",
                                  data: formData,
                                  async:false,
                                  processData: false,
                                  contentType: false,
                                  success: function (res) {

                                    console.log(res);
                                  }
                              });



                  }

              }
          });
      }
      return false;


}
