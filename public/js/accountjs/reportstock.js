var datacus = '';

$(document).ready(function() {

    $('#example').DataTable({
      "order": [[ 3, "asc" ]],
      dom: 'Bfrtip',
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    });

    // alert('222222');
    // $('#reservation').daterangepicker();

    $("#reservation").datepicker( {  //รายปี
      format: " yyyy",
      viewMode: "years",
      minViewMode: "years"

    });


    // $('#datePicker').datepicker('setDate', new Date());

    // $(".datepicker").datepicker({
    //   format: 'dd/mm/yyyy',
    //   language: 'th'
    // });

        // $("#month").datepicker( {  //รายเดือน
        //   format: " yyyy",
        //   viewMode: "years",
        //   minViewMode: "years"
        //   });
        //
        //   $("#allmonth").datepicker( {  //ทุกเดือน
        //     format: " mm/yyyy",
        //     viewMode: "months",
        //     minViewMode: "months"
        //   });

        // $("#toyear").datepicker( {  //รายปี
        //   format: " yyyy",
        //   viewMode: "years",
        //   minViewMode: "years"
        //
        // });
        //
        // $("#monthbr").datepicker( {  //ทุกเดือน
        //   format: " mm-yyyy",
        //   viewMode: "months",
        //   minViewMode: "months"
        // });

        // console.log('2222222');
        // var datepicker = $('#datepicker').val();
        // console.log(datepicker);

});


function autocompletecusdata() {


    $.get("getdatacustomeridandname", function(res) {
        datacus =  res;
        //console.log(datacus);

    });

    $('#namecus').autocomplete({
        source: datacus,
        select: function (event, ui) {
            var cusid = ui.item.id;
            $('#cusid').val(cusid);


        }
    });

}

function loadstock(){
  console.log(11111);

	var id=$('#groupmaterial_id').val();

	if(id!=0)
	{
		 $('#typematerial_id').attr('readonly', false);
	}
	else
	{
		$('#typematerial_id').attr('readonly', true);
	}

	$('#typematerial_id').html('');
	var _option = "<option value='0' select=select>เลือกชนิดของสินค้า</option>";


	$.get("getdatatypematerial?id="+id, function(data) {
    // console.log(data);
	        $.each(data, function(key, value) {
	           _option+='<option value="'+data[key].id+'">'+data[key].name_type+'</option>';
        });

	$('#typematerial_id').append(_option);
	});
}
