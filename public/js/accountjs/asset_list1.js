var typeassetval = '';
var typeassetrefacc = '';
var inset = '';
var selectlot = '';


$( document ).ready(function() {
    //console.log( "ready!" )
    $.get('getlisttypeasset', function(res) {
        //console.log(res);
        typeassetval = res;
     });

     $.get('getlisttypeassetrefaccnumber', function(res) {
         //console.log(res);
         typeassetrefacc = res;
      });

$('.select2').select2({
      dropdownAutoWidth: true
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

});

function cleardata()
{
  document.getElementById("myForm").reset();
    $('#groups_acc_new').empty();
      var optiontypeassetrefacc = '<option value="" selected>เลือกกลุ่มบัญชี</option>';
      $('#groups_acc_new').append(optiontypeassetrefacc);
      $('.material_serch').hide();
      $('#material_id').empty();
      $('#lot').val('');
      $('#price_buyz').val('');
      selectlot = '';
}

$(function() {
    $('input[name="daterange"]').daterangepicker();
});


function get_date() {
  var get_date_buy = $('#get_date_buyz').val();
  console.log(get_date_buy);
  var get_date_calself = $('#get_date_calselfz').val();
  // console.log(get_date_calself);
  var date_cut_string_for_year = get_date_buy.substring(0, 4);
  // console.log(date_cut_string_for_year);
  var decrese_day = date_cut_string_for_year+"-01-01";
  // console.log(decrese_day);

  //วันสุดท้ายของปีที่จำคำนวน
  var lastday_of_year = date_cut_string_for_year+"-12-31";
  console.log(lastday_of_year);


  date1 = get_date_buy.split('-');
  date2 = lastday_of_year.split('-');
  date_decrese = decrese_day.split('-');

  date1 = new Date(date1[0], date1[1], date1[2]);
  date2 = new Date(date2[0], date2[1], date2[2]);
  date_decrese = new Date(date_decrese[0], date_decrese[1], date_decrese[2]);

  date1_unixtime = parseInt(date1.getTime() / 1000);
  date2_unixtime = parseInt(date2.getTime() / 1000);
  date_decrese_unixtime = parseInt(date_decrese.getTime() / 1000);

  var timeDifference = date2_unixtime - date1_unixtime;
  var timenow_decrese = date1_unixtime - date_decrese_unixtime;

  var timeDifferenceInHours = timeDifference / 60 / 60;
  var timeDifferencedecrese = timenow_decrese / 60 / 60;

  // and finaly, in days :)
  var timeDifferenceInDays = (timeDifferenceInHours  / 24) + 3;
  // console.log(timeDifferenceInDays);

  var timeDifferencedecrese_day = (timeDifferencedecrese  / 24);
  // console.log(timeDifferencedecrese_day);
  days_of_a_year(date_cut_string_for_year);

  var date_in_year = days_of_a_year(date_cut_string_for_year);
  // console.log(date_in_year);

  depreciation(timeDifferenceInDays,date_in_year,timeDifferencedecrese_day);
  calculate_depreciation(date_in_year,timeDifferenceInDays);
}


function days_of_a_year(date_cut_string_for_year)
{
  return isLeapYear(date_cut_string_for_year) ? 366 : 365;
}
function isLeapYear(date_cut_string_for_year) {
     return date_cut_string_for_year % 400 === 0 || (date_cut_string_for_year % 100 !== 0 && date_cut_string_for_year % 4 === 0);
}


function calculate_depreciation(date_in_year,timeDifferenceInDays) {
  var price_buy = $('#price_buyz').val();
  // console.log(price_buy);
  var life_for_use = $('#life_for_usez').val();
  // console.log(life_for_use);
  var end_price_sell = $('#end_price_sellz').val();
  // console.log(end_price_sell);

  if (life_for_use >= 0.1) {
    var end_price_sellpercent = 100/life_for_use;
    $('#end_price_sellpercentz').val(end_price_sellpercent);
  }
  else if (life_for_use == 0) {
    $('#end_price_sellpercentz').val("0");
  }
  else if (life_for_use == null){
    $('#end_price_sellpercentz').val("0");
  }

  var date_cal_startz = $('#date_cal_start').val();
  // console.log(date_cal_startz);
  var date_cal_endz = $('#date_cal_end').val();
  // console.log(date_cal_endz);
  date1 = date_cal_startz.split('-');
  date2 = date_cal_endz.split('-');
  const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
  const firstDate = new Date(date1);
  const secondDate = new Date(date2);
  const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)) + 1;
  // console.log(diffDays);

  // if (price_buy && end_price_sell && life_for_use && !diffDays) {
  //   // $('#year_depreciation').empty();
  //     var year_depreciations = (price_buy - end_price_sell)*(100/life_for_use)/100;
  //     var year_depreciations_roundup = Math.round(year_depreciations * 100) / 100
  //     // console.log(year_depreciations);
  //     $('#year_depreciation').val(year_depreciations_roundup);
  // }else if (price_buy && end_price_sell && diffDays) {
  //     var time_for_use = timeDifferenceInDays;
  //     var time_all_use = diffDays;
  //     var year_depreciations = (price_buy - end_price_sell)*(time_for_use/time_all_use);
  //     var year_depreciations_roundup = Math.round(year_depreciations * 100) / 100
  //     // console.log(year_depreciations);
  //     $('#year_depreciation').val(year_depreciations_roundup);
  // }

  //------------------------------------------รายปี---------------------------------------------------
  if (price_buy && end_price_sell && diffDays) {
    var time_for_use = timeDifferenceInDays;
    var time_all_use = diffDays;
    var year_depreciations = (price_buy - end_price_sell)*(time_for_use/time_all_use);
    var year_depreciations_roundup = Math.round(year_depreciations * 100) / 100
    // console.log(year_depreciations);
    $('#year_depreciation').val(year_depreciations_roundup);
  }
  //----------------------------------------------------------------------------------------------------

  //------------------------------------------รายเดือน---------------------------------------------------
  var year_value = $('#year_depreciation').val();
  // console.log(year_value);
  var month_cal = year_value/12;
  var month_depreciations_roundup = Math.round(month_cal * 100) / 100
  $('#month_depreciation').val(month_depreciations_roundup);
  // var day_depreciations_use = $('#day_depreciation').val();
  // var day_depreciations_use = day_depreciations;
  // console.log(day_depreciations_use);
  // var number_range_day = timeDifferenceInDays;
  // console.log(number_range_day);
  // if (end_price_sell && price_buy && number_range_day) {
  //   var range_num_decrese = number_range_day-3;
  //   var fixed_five_year = 1826;
  //   var month_depreciations = ((price_buy - end_price_sell)/fixed_five_year)*range_num_decrese;
  //   var month_depreciations_roundup = Math.round(month_depreciations * 100) / 100
  //   // console.log(month_depreciations_roundup);
  //   $('#month_depreciation').val(month_depreciations_roundup);
  // }
  //----------------------------------------------------------------------------------------------------

  //------------------------------------------รายวัน---------------------------------------------------
  var year_value_for_day = $('#year_depreciation').val();
  var day_cal = year_value_for_day/time_for_use;
  var day_depreciations_roundup = Math.round(day_cal * 100) / 100
  $('#day_depreciation').val(day_depreciations_roundup);
  // var date_in_years = date_in_year;
  // console.log(date_in_years);
  // // var year_depreciation_use = $('#year_depreciation').val();
  // var year_depreciation_use = year_depreciations;
  // console.log(year_depreciation_use);
  // if (year_depreciation_use && date_in_years) {
  //   var day_depreciations = year_depreciation_use/date_in_years;
  //   var day_depreciations_roundup = Math.round(day_depreciations * 100) / 100
  //   console.log(day_depreciations_roundup);
  //   $('#day_depreciation').val(day_depreciations_roundup);
  // }
 //----------------------------------------------------------------------------------------------------


  // else if (price_buy == 0 && end_price_sell && end_price_sellpercent) {
  //   $('#year_depreciation').empty();
  //   var year_depreciations = (0 - end_price_sell)*end_price_sellpercent/100;
  //   // console.log(year_depreciations);
  //   $('#year_depreciation').val(year_depreciations);
  // }
  // else if (price_buy == null && end_price_sell && end_price_sellpercent) {
  //   $('#year_depreciation').empty();
  //   var year_depreciations = (-end_price_sell)*end_price_sellpercent/100;
  //   // console.log(year_depreciations);
  //   $('#year_depreciation').val(year_depreciations);
  // }

  depreciation();
}

function depreciation(timeDifferenceInDays,date_in_year,timeDifferencedecrese_day) {
  var price_buy = $('#price_buyz').val();
  // console.log(price_buy);
  var end_price_sell = $('#end_price_sellz').val();
  // console.log(end_price_sell);
  var life_for_use = $('#life_for_usez').val();
  // console.log(life_for_use);
  var depreciation_buy = $('#depreciation_buyz').val();
  // console.log(depreciation_buy);


  var time_range = timeDifferenceInDays;
  // console.log(time_range);

  var dateinyear = date_in_year;
  // console.log(dateinyear);

  var time_decrese = timeDifferencedecrese_day;
  // console.log(time_decrese);

  if (price_buy && end_price_sell && life_for_use && depreciation_buy ) {
    var cal_depreciation = (price_buy - end_price_sell - depreciation_buy)/life_for_use;
  }

  var wrapper = $(".container10").empty();
  if (cal_depreciation) {
    $(wrapper).append('<th><label class="col-form-label" id="fontslabel"><b><font color="red">ค่าเสื่อมยกมาสุทธิ&nbsp;</b></font></label></th><th><input type="text" class="form-control" name="cal_depreciation_buy" value="'+cal_depreciation+'" id="cal_depreciation_buyz" readonly></th>');
  }
  // else if (cal_depreciation == 0) {
  //   $(wrapper).append('<th><label class="col-form-label" id="fontslabel"><b><font color="red">ค่าเสื่อมยกมาสุทธิ&nbsp;</b></font></label></th><th><input type="text" class="form-control" name="cal_depreciation_buy" value="0" id="cal_depreciation_buyz" readonly></th>');
  // }
  // else {
  // }
  if ($('#cal_depreciation_buyz').val()) {
    var cal_depreciation_buy = $('#cal_depreciation_buyz').val();
    // console.log(cal_depreciation_buy);
  }

  if (price_buy && end_price_sell && cal_depreciation_buy && life_for_use && depreciation_buy && time_range && dateinyear && time_decrese) {
    var cal_self = ((price_buy - end_price_sell - cal_depreciation_buy)/life_for_use)*time_range/(dateinyear-time_decrese);
    $('#cal_selfz').val(cal_self);
  }

}

//-------------------------------------------- getdata edie ---------------------------------------------------------------------

function getdataedit(val){

    var infrom_po_id = val;
    // console.log(infrom_po_id);
    $('#get_id_edit').val(infrom_po_id);
    $.get('getassetlistforedit/'+infrom_po_id, function(res) {
        // console.log(res);
        $('#get_no_asset').val(res[0].no_asset);
        $('#get_name_thai').val(res[0].name_thai);
        $('#get_name_eng').val(res[0].name_eng);
        $('#get_assetlist_dif').val(res[0].asset_different);
        $('#get_groups').val(res[0].group_property_id);
        $('#get_groups_acc').val(res[0].group_acc_id);
        $('#get_no_register').val(res[0].no_register);
        $('#get_department').val(res[0].department);
        // $('#get_branch').val(res[0].branch_id);
        $('#get_price_buy').val(res[0].price_buy);
        $('#get_end_price_sell').val(res[0].end_price_sell);
        $('#get_end_price_sellpercent').val(res[0].end_price_sellpercent);

        $('#get_date_buy').val(res[0].date_buy);
        $('#get_date_startuse').val(res[0].date_startuse);
        $('#get_date_cal').val(res[0].cal_date);

        $('#get_year_depreciation').val(res[0].year_depreciation);
        $('#get_month_depreciation').val(res[0].month_depreciation);
        $('#get_day_depreciation').val(res[0].cal_depreciation_buy);
        $('#get_sum_depreciation').val(res[0].depreciation_buy);
        $('#get_primary_depreciation').val(res[0].primary_depreciation);

    });
  }


  //--------------------------------------------- select type assset -------------------------------//
  function selectassetlist(){

      var typeasset = document.getElementById("assetlist_different").value;
      inset = typeasset;
      //  console.log(typeassetval);

        cleardata();

        $('#assetlist_different').val(inset);
        $('#groups_new').empty();

          // option asset type
        var typeassetypeoption = '<option value="" selected>เลือกหมวด</option>';
        var inputserachpayinid = document.getElementById('serachpayinid');
        var inputmaterial_id = document.getElementById('material_id');





          if(typeasset==1){

            document.getElementById('name_thai').readOnly = false;
            document.getElementById('name_eng').readOnly = false;
            document.getElementById('no_asset').readOnly = false;
            document.getElementById('name_eng').readOnly = false;
            document.getElementById('date_startuses').readOnly = false;
            document.getElementById('date_buy').readOnly = false;
            document.getElementById('depreciation_buyz').readOnly = false;
            document.getElementById('primary_depreciation').readOnly = false;
            document.getElementById('price_buyz').readOnly = false;
            inputserachpayinid.removeAttribute('required');
            inputmaterial_id.removeAttribute('required');



                $.each(typeassetval, function( key, value ) {
                     if(value.typeasset==1){
                        typeassetypeoption += '<option value='+value.id+' >'+value.name_typeasset+'</option>';//console.log(value.name_typeasset);
                     }
                });

              $('#groups_new').append(typeassetypeoption);
              //console.log(typeassetypeoption);

          }else{
            document.getElementById('name_thai').readOnly = true;
            document.getElementById('name_eng').readOnly = true;
            document.getElementById('no_asset').readOnly = true;
            document.getElementById('date_startuses').readOnly = true;
            document.getElementById('date_buy').readOnly = true;
            document.getElementById('depreciation_buyz').readOnly = true;
            document.getElementById('primary_depreciation').readOnly = true;
            document.getElementById('price_buyz').readOnly = true;
            inputserachpayinid.setAttribute('required', '');
            inputmaterial_id.setAttribute('required', '');

                $.each(typeassetval, function( key, value ) {
                     if(value.typeasset==2){
                        typeassetypeoption += '<option value='+value.id+' >'+value.name_typeasset+'</option>';//console.log(value.name_typeasset);
                     }
                });
              $('#groups_new').append(typeassetypeoption);
              $('.material_serch').show();
            //  console.log(typeassetypeoption);
          }

  }



  //////////////////////////// select option groups_new ////////////////////////

  function selectgroup(){
      var groups_new = document.getElementById("groups_new").value;
      //console.log(groups_new);
      /// select accnum
      $('#groups_acc_new').empty();
      var optiontypeassetrefacc = '<option value="" selected>เลือกกลุ่มบัญชี</option>';

       $.each(typeassetrefacc, function( k, v ) {
            if(groups_new==v.typeasset_id){
               optiontypeassetrefacc += '<option value='+v.numberaccount+' >'+v.numberaccount+'-'+v.accounttypefull+'</option>';

             }
          });
       $('#groups_acc_new').append(optiontypeassetrefacc);


      $('#life_for_usez').val('');
      $('#end_price_sellpercentz').val('');
        $.each(typeassetval, function( key, value ) {
             if(value.id==groups_new){
                   ///   cal %
                  $('#life_for_usez').val(value.percent_depreciation_expense);
                    if(value.percent_depreciation_expense!=0){
                        $('#end_price_sellpercentz').val(100/value.percent_depreciation_expense);
                    }else{
                        $('#end_price_sellpercentz').val(0);
                    }
             }
        });
  }

  function serachpayin() {
        var idrecp = $('#serachpayinid').val();
        $('#material_id').empty();
        var material_id = '<option value="" selected>เลือกสินค้า</option>';

          $.get('serchassetrefmaterial?id='+idrecp, function(res) {
                  //console.log(isNaN(res));
              if(isNaN(res)==true){
                  selectlot = res;
                    $.each(res, function( key, value ) {
                        material_id += '<option value="'+value.receiptasset_detail_id+'" >'+value.materialname+'</option>';
                    });
                  $('#material_id').append(material_id);
              }else{
                  alert('กรอกรหัสบิลไม่ถูกต้อง');
              }
           });
  }

  function selectserchlot(){
      var material_id = $('#material_id').val();
      var groups_new = $('#groups_new').val();
      var typenameasset = '';

      console.log(typeassetval);
      $.each(typeassetval, function( k, v ) {
           if(groups_new==v.id){
               typenameasset = v.name_typeasset

            }
         });
      $('#lot').val('');
      $('#price_buyz').val('');
      $('#date_startuses').val('');
      $('#date_buy').val('');
      $('#name_thai').val('');
      $('#name_eng').val('');
      $('#no_asset').val('');
      $('#depreciation_buyz').val('');
      $('#primary_depreciation').val('');

      var timethis = $('#timethis').val();
        //console.log(material_id);
          $.each(selectlot, function( key, value ) {
                if(value.receiptasset_detail_id==material_id){
                    $('#lot').val(value.lot);
                    $('#price_buyz').val(value.cost);
                    $('#date_startuses').val(value.dateuse);
                    $('#date_buy').val(value.datein);
                    $('#name_thai').val(typenameasset+' '+value.materialname+' lot:'+value.lot);
                    $('#name_eng').val(typenameasset+' '+value.materialname+' lot:'+value.lot);
                    $('#no_asset').val(timethis+''+groups_new+''+material_id+''+value.id)
                    $('#depreciation_buyz').val(value.beginningbalance);
                    $('#primary_depreciation').val(value.depreciation_first);

                }
          });


  }
