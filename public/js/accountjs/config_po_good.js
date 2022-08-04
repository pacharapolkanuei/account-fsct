$(document).ready(function() {
  console.log( "ready!" );

$(".js-example-basic-multiple-limit").select2({
  maximumSelectionLength: 1
});

    $.get('config_getmaterial', function(res) {
        // console.log(res);
      var option = '<option disabled selected>โปรดเลือกรายการ</option>';
          $.each(res, function(index,value ) { //วนลูป

        option += '<option value="'+value.id+'">'+value.name+'</option>';
      });

    $.get('config_getgood', function(res) {
        // console.log(res);
      var option1 = '<option disabled selected>โปรดเลือกรายการ</option>';
          $.each(res, function(index,value ) { //วนลูป

        option1 += '<option value="'+value.id+'">'+value.name+'</option>';
      });


      var max_fields      = 1000;
      // var wrapper         = $(".container10");
      var wrapper2         = $(".container11");
      var add_button      = $(".add_form_field");
      var no = 1;
      var x = 1;
      $(add_button).click(function(e){
          e.preventDefault();

          if(x < max_fields){
              x++;
              $(wrapper2).append('<tr><td><select name="name_material[]" class="form-control select2" required>'+option+'</select></td><td><select name="name_good[]" class="form-control select2" required>'+option1+'</select></td><td style="text-align: center;"> <input type="hidden" onchange="count(this)" id="eieiza1" value="'+(x-1)+'"> <a href="#" class="btn btn-danger delete"> ลบ</a></td></tr>');
              no = no+1;
          }
          else
          {
          alert('เกิน Limit ที่ตั้งไว้')
          }
      });

      $(wrapper2).on("click",".delete", function(e){
          e.preventDefault(); $(this).parent('').parent('tr').remove(); x--;
      })




    });



});
});
