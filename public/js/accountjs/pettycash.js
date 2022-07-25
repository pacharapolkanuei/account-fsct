$(document).ready(function() {
    $("#example").DataTable();

    $(function() {
        $.datetimepicker.setLocale("th"); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
        // กรณีใช้แบบ inline
        $("#testdate4").datetimepicker({
            timepicker: false,
            format: "d-m-Y", // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
            lang: "th", // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            inline: true
        });
        // กรณีใช้แบบ input
        $("#testdate5").datetimepicker({
            timepicker: false,
            format: "d-m-Y", // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
            lang: "th", // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            onSelectDate: function(dp, $input) {
                var yearT = new Date(dp).getFullYear() - 0;
                var yearTH = yearT + 543;
                var fulldate = $input.val();
                var fulldateTH = fulldate.replace(yearT, yearTH);
                $input.val(fulldateTH);
            }
        });
        // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
        $("#testdate5").on("mouseenter mouseleave", function(e) {
            var dateValue = $(this).val();
            if (dateValue != "") {
                var arr_date = dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0
                if (e.type == "mouseenter") {
                    var yearT = arr_date[2] - 543;
                }
                if (e.type == "mouseleave") {
                    var yearT = parseInt(arr_date[2]) + 543;
                }
                dateValue = dateValue.replace(arr_date[2], yearT);
                $(this).val(dateValue);
            }
        });
    });
});

function change_time() {
    var time = $("#time").val();
    console.log(time);
    $.get("/debt");
    window.location.replace("http://localhost:8000/pettycash/" + time);
}

function validate() {
    branch = $("#branch_id").val().length;
    grandtotal = $("#grandtotal").val().length;
    timeold = $("#timeold").val().length;
    account = $("#account").val().length;
    note = $("#note").val().length;

    if (
        branch != 0 &&
        grandtotal != 0 &&
        timeold != 0 &&
        account != 0 &&
        note != 0
    ) {
        console.log("ok");
        btn_submit =
            '<input type="submit" class="btn btn-success" style="display: inline" id="button-submit" value="บันทึก">';
        $("#submit-btn").replaceWith(btn_submit);
    }
}

function validate_click() {
    //    console.log(no);
    swal({
        title: "Oop?",
        text: "กรุณากรอกข้อมูลให้ครบถ้วน!",
        type: "warning"
    });
}
