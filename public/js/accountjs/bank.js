$(document).ready(function() {
    $('#example').DataTable();
    // search = '<div id="example_filter" class="dataTables_filter fontslabel"><label>ค้นหาข้อมูล:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="example"></label></div>';
    // $('#example_filter').replaceWith(search);
    // length = '<div class="dataTables_length fontslabel" id="example_length"><label>แสดงข้อมูล <select name="example_length" aria-controls="example" class="form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> แถว</label></div>';
    // $('#example_length').replaceWith(length);
    
});
function confirmdelete(no){
//    console.log(no);
    swal({
        title: 'แน่ใจหรือไม่?',
        text: "คุณต้องการลบรายการนี้!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน ลบรายการ !',
        cancelButtonText: 'ยกเลิก'
      }).then((result) => {
        if (result.value) {
            $.get('/Bank/delete/'+no);        
            swal(
                'สำเร็จ!',
                'ลบรายการของท่านสำเร็จแล้ว',
                'success'
            )
            $.get('/bank_detail'); 
            location.reload();
        }
      })    
}

$(document).ready(function($){
    $('#account_no_insert').mask('000-000-0000');
    $('.account_no_edit').mask('000-000-0000');
});

function validate_account(){
    account_no = $('#account_no_insert').val();    
    account_name = $('#account_name').val();   
    len_name = account_name.length;  
    len_no = account_no.length; 
    branch_id = ($('#branch_id').val()).length; 
    initials = ($('#initials').val()).length;
    accounttype_no = ($('#accounttype_no').val()).length; 
    console.log(branch_id);
    console.log(initials);
    console.log(accounttype_no);


    if (len_no < 12) {
        var class_acc_no = '<font id="text_validate_acc_no" style="color:red"><b> ( *กรุณาระบุให้ครบ )</b></font>';
        $('#text_validate_acc_no').replaceWith(class_acc_no);
    }
    if(len_no == 12){
        var class_acc_no = '<font id="text_validate_acc_no" style="color:red"><b> </b></font>';
        $('#text_validate_acc_no').replaceWith(class_acc_no);
    }

    if(len_name > 0 && len_no == 12 && branch_id > 0 && initials > 0 && accounttype_no > 0 ){         
        btn_submit = '<input type="submit" class="btn btn-success" style="display: inline" id="button-submit" value="บันทึก">';        
        $('#submit-btn').replaceWith(btn_submit);
    }
    if(len_no != 12 || len_name == 0){
        btn_submit = '<button type="button" class="btn" id="submit-btn" onclick="validate_click()">ยืนยัน</button>';        
        $('#submit-btn').replaceWith(btn_submit);
        console.log('tle');
    }

}

function validate_account_edit(){
    account_no = $('.account_no_edit').val();    
    account_name = $('#account_name_edit').val();   
    len_name = account_name.length;  
    len_no = account_no.length; 
    

    if (len_no < 12) {
        var class_acc_no = '<font id="text_validate_acc_no_edit" style="color:red"><b> ( *กรุณาระบุให้ครบ )</b></font>';
        $('#text_validate_acc_no_edit').replaceWith(class_acc_no);
    }
    if(len_no == 12){
        var class_acc_no = '<font id="text_validate_acc_no_edit" style="color:red"><b> </b></font>';
        $('#text_validate_acc_no_edit').replaceWith(class_acc_no);
    }

    if(len_name > 0 && len_no == 12){         
        btn_submit = '<input type="submit" class="btn btn-success" style="display: inline" id="submit-btn-edit" value="บันทึก">';        
        $('#submit-btn-edit').replaceWith(btn_submit);
    }
    if(len_no != 12 || len_name == 0){
        btn_submit = '<button type="button" class="btn" id="submit-btn-edit" onclick="validate_click()">ยืนยัน</button>';        
        $('#submit-btn-edit').replaceWith(btn_submit);
        console.log('tle');
    }

}

function validate_click(){
    //    console.log(no);
        swal({
            title: 'Oop?',
            text: "กรุณากรอกข้อมูลให้ครบถ้วน!",
            type: 'warning',          
            
          })
}

$( document ).ready(function() {
    console.log( "ready!" );
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
    
