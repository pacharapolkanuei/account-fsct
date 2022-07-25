$(document).ready(function(){
    $(".text-success").hide().html();
    $(".text-danger").hide().html();
    $(".text-info").hide().html();
    $("#submit").click(function(){

        var username=$("#name").val();
        var password=$("#pass").val();
        if(username == 'admin' && password == 123){
            $("#form").html('<h4 style="text-align:center">User Login Successfully</h4><a href="">Back</a>').css('color','green');
        }else if(username == '' || password == ''){
            $(".text-danger").html("Both Field Required.").show().fadeOut(4000);
        }else{
            $(".text-info").html("User Does Not Match.").show().fadeOut(4000);
        }
    });
});