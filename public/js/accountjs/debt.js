function selectbranch(val){
	var branchcode = val.value;
	$('#modal-input-po').empty();
	$('#po_content').empty();
	$('#sum').empty();
	$('#discount').empty();
	$('#after_discount').empty();
	$('#vat').empty();
	$('#after_vat.form_control').empty();

	// $('#modal-input-po').empty();//เคลียselectจังหวัดก่อนหน้า
		$.get('getbranchtouse/'+branchcode, function(get_po_num) {
		console.log(get_po_num);

	  	var option = '<option value="">Select PO</option>';
          $.each(get_po_num, function(index,value) { //วนลูป

			 	option += '<option value="'+value.id+'">'+value.po_number+'</option>';
		  });

		  $('#modal-input-po').append(option);//เป็นการเพิ่ม option #modal-input-po

	});

	var totalsumall ='<input type="text" style="width: 100%;max-width: 1200px;" name="modal-input-calculate" class="form-control" id="totalsumall" readonly>';
	$('#totalsumall').replaceWith(totalsumall);

	var after_vat ='<input type="text" name="modal-input-calculate" class="form-control" id="after_vat" readonly>';
	$('#after_vat').replaceWith(after_vat);
}

function terms(val){

	var po = val.value;
	// console.log(po);
	$('#totalallsum').empty();
	$('#modal-input-credit').empty();

	$.get('getterm/'+po, function(res) {
		console.log(res);

			// console.log(res);

			// แสดงค่า เครดิตครบกำหนด หลังการเลือก PO
			var term = '<input type="text" name="credit" class="form-control" id="modal-input-credit" value="'+res.terms+'" >\
						<input type="hidden" name="id_po" class="form-control" id="modal-input-credit" value="'+res.id+'" >'; //ส่ง id ของ po เพื่อนำไปอัปเดตค่า เครดิตครบกำหนด
			// แสดงจำนวนเงินหลังจากการเลือก PO
			var totalsumall = '<input type="text" style="width: 100%; max-width: 1200px;" name="modal-input-calculate" class="form-control" value="'+res.totolsumall+'" id="totalsumall" readonly>';
			var suppliers = '<input type="hidden" name="supplie_id" value="'+res.supplier_id+'">'

			$('#modal-input-credit').replaceWith(term);
			$('#totalsumall').replaceWith(totalsumall);
			$('#suppliers').replaceWith(suppliers);

		$.get('getpodetail/'+po, function(po_detail){


			$('#po_content').empty();
			var table_content = ''; //ตารางแสดงรายการ
			var no = 1; //ลำดับรายการ
			var sum = 0; //ยอดเงินรวมจากรายการ PO_detail
			var discount = 0; //ส่วนลด
			var after_discount = 0; //ยอดเงินหลังจากการหักส่วนลด
			var vat = res.vat; //ภาษาีที่นำไปคำนวน
			var after_vat = 0; //ยอดเงินหลังหักภาษี



			$.each(po_detail, function(index,value) {
				// console.log(no);
				table_content += '\
				<tr>\
				<td>'+no+'<input type="hidden" name="id'+no+'" class="form-control" id="modal-input-credit" value="'+value.id+'" ></td>\
				<td>'+value.list+'</td>\
				<td><input type="text" name="amount'+no+'" class="form-control center_text" id="amount'+no+'" value="'+value.amount+'" onchange="change_table('+no+')"></td>\
				<td><input type="text" name="price'+no+'" class="form-control center_text" id="price'+no+'" value="'+value.price+'" onchange="change_table('+no+')" ></td>\
				<td><input type="text" name="discount'+no+'" class="form-control center_text" id="discount'+no+'" value="0" onchange="change_table('+no+')"></td>\
				<td id="sum_onelist'+no+'">'+(value.amount*value.price-discount)+' บาท</td>\
				<td>'+value.note+'</td>\
				</tr>';
				no = no+1;
				sum += +value.total;

				// sumtotalright += value.amount*value.price;
				// $('#sum_totalright').val(sumtotalright);

			});
			//แสดงจำนวนรวมรายการ
			var id_result = '<tr>\
			<td></td>\
			<td></td>\
			<td></td>\
			<td></td>\
			<td></td>\
			<td>จำนวนรายการ</td>\
			<td> '+(no-1)+' รายการ<input type="hidden" name="count_list" class="form-control" id="count_list" value="'+(no-1)+'" ></td>\
			</tr>';

			$('#po_content').append(table_content); //แสดงรายการ
			$('#po_content').append(id_result); //รวมจำนวนรายการ
			// -----------------------------------
			var sendnotochangetable = '<input type="hidden" name="no_send" class="form-control" id="send_to_changetable" value="'+(no-1)+'"></input>';
			$('#po_content').append(sendnotochangetable);
			// -----------------------------------
			var id_sum = '<td id="sum"> '+sum+' บาท</td><input type="hidden" id="sum_send" value="'+sum+'"></input>'; //แสดงsum และ เพื่อส่งไป Changetable();
			$('#sum').replaceWith(id_sum);
			// -----------------------------------
			var id_discount = '<td id="discount">'+discount.toFixed(2)+' บาท<input type="hidden" name="discount" value="'+discount.toFixed(2)+'"></input></td>'; //แสดงส่วนลด
			$('#discount').replaceWith(id_discount);
			// -----------------------------------
			after_discount = sum;	//แสดงยอดเงินหลังหักส่วนลด
			var id_after_discount = '<td id="after_discount">'+after_discount.toFixed(2)+' บาท</td><input type="hidden" id="after_discount_send" value="'+after_discount+'"></input>';
			$('#after_discount').replaceWith(id_after_discount);

			show_realtotal = sum;	//ยอดเงินที่แสดง
			var id_show_realtotal = '<td id="show_realtotal">'+show_realtotal.toFixed(2)+' บาท</td>';
			$('#show_realtotal').replaceWith(id_show_realtotal);

			show_vattotal = 0;	//คำนวน vat
			// after_dis1 =
			var id_show_realtotal = '<td id="show_realtotal">'+show_realtotal.toFixed(2)+' บาท</td>';
			$('#show_realtotal').replaceWith(id_show_realtotal);

			// -----------------------------------
			var id_vat = '<td id="vat"><input type="text" name="vat" class="form-control center_text" id="vat_send" value="'+res.vat+'" onchange="change_vat()" readonly></input></td>'; //แสดงภาษี
			$('#vat').replaceWith(id_vat);

			// -----------------------------------
			var id_cal_vat = '<td id="cal_vat"><input type="text" name="cal_vat" class="form-control center_text" value="'+(parseInt(res.vat)/100*after_discount).toFixed(2)+'" readonly></input></td>'; //แสดงภาษี
			$('#cal_vat').replaceWith(id_cal_vat);

			// -----------------------------------
			after_vat = '<td id="sum-all" ><input type="text" name="net_amount" class="form-control center_text" value="'+((((100+(parseInt(res.vat)))/100))*after_discount).toFixed(2)+' บาท" id="after_vat" readonly></input></td>';
			$('#sum-all').replaceWith(after_vat); //แสดงยอดเงินหลังหักภาษี
			// -----------------------------------
			// var supplie_id = '<input type="text" name="supplie_id" value="'+po_detail[0].supplier_id+'"></input>';
			// $('#modal-input-po').append(supplie_id);
			//------------------------------------
			after_vat1 = '<td id="sumshow" ><input style="width: 100%;max-width: 1200px;" type="text" class="form-control" value="'+((((100+(parseInt(res.vat)))/100))*after_discount).toFixed(2)+' บาท" id="after_vat1" readonly></input></td>';
			$('#sumshow').replaceWith(after_vat1); //แสดงยอดเงินหลังหักภาษี


		});
	});



}

function change_table(no){

	//! change_table() จะทำงานเมื่อมีการแก้ไข จำนวนรายการ และ ราคารายการ
	var count_list = $("#count_list").val();
	var sum_discount = 0;
	var sum = 0;
	var vat = $('#vat_send').val();
	// console.log(count_list);
	for (let i = 1; i <= count_list; i++) {

		var amount = $("#amount"+i+"").val();
		var price = $("#price"+i+"").val();
		var sum_onelist = (amount*price);
		var discount = ($("#discount"+i+"").val()*sum_onelist/100); //ส่วนลดเป็นเปอร์เซ็น

		var amount_id = '<input type="text" name="amount'+i+'" class="form-control center_text" id="amount'+i+'" value="'+amount+'" onchange="change_table('+i+')">';
		$('#amount'+i+'').replaceWith(amount_id); //จำนวน

		var price_id = '<input type="text" name="price'+i+'" class="form-control center_text" id="price'+i+'" value="'+price+'" onchange="change_table('+i+')">';
		$('#price'+i+'').replaceWith(price_id); //ราคา

		var colum_sum = '<td id="sum_onelist'+i+'">'+((parseInt(sum_onelist))-discount)+' บาท</td>';
		$('#sum_onelist'+i+'').replaceWith(colum_sum); //จำนวน*ราคา

		sum += (price*amount)-discount;
		sum_discount += +discount;
	}


	var id_sum = '<td id="sum"> '+sum+' บาท</td><input type="hidden" id="sum_send" value="'+sum+'"></input>'; //แสดงsum และ เพื่อส่งไป Changetable();
	$('#sum').replaceWith(id_sum);

	var id_discount = '<td id="discount" >'+sum_discount.toFixed(2)+' บาท<input type="hidden" name="discount" value="'+sum_discount.toFixed(2)+'"></input></td>'; //แสดงส่วนลด
	$('#discount').replaceWith(id_discount);



	after_discount = sum;	//แสดงยอดเงินหลังหักส่วนลด
	var id_after_discount = '<td id="after_discount">'+sum+' บาท</td><input type="hidden" id="after_discount_send" value="'+sum+'"></input>';
	$('#after_discount').replaceWith(id_after_discount);

	value_after_vat = (((100+parseInt(vat))/100)*after_discount).toFixed(2);

	var id_vat = '<td id="vat"><input type="text" name="vat" class="form-control" id="vat_send" value="'+vat+'" onchange="change_vat()"></input></td>';
	$('#vat').replaceWith(id_vat);	//แสดงภาษี

	after_vat = '<td id="sum-all" ><input type="text" name="net_amount" class="form-control" value="'+value_after_vat+' บาท" id="after_vat" readonly></input></td>';
	$('#sum-all').replaceWith(after_vat); //แสดงยอดเงินหลังหักภาษี

	value_after_vat1 = (((100+parseInt(vat))/100)*after_discount).toFixed(2);
	after_vat1 = '<td id="sumshow" ><input style="width: 100%;max-width: 1200px;" type="text" class="form-control" value="'+value_after_vat1+' บาท" id="after_vat1" readonly></input></td>';
	$('#sumshow').replaceWith(after_vat1); //แสดงยอดเงินหลังหักภาษี
}

function change_vat(){
	//! change_vat() จำทงานเมื่อมีการแก้ไข field vat ในหน้า debt.blade
	var vat = $('#vat_send').val();
	var after_discount = $('#after_discount_send').val();
	value_after_vat = (((100+(parseInt(vat)))/100)*after_discount).toFixed(2);
	value_after_vat1 = (((100+(parseInt(vat)))/100)*after_discount).toFixed(2);
	// console.log(value_after_vat);

	var id_vat = '<td id="vat"><input type="text" name="vat" class="form-control" id="vat_send" value="'+vat+'" onchange="change_vat()"></input></td>'; //แสดงภาษี
	$('#vat').replaceWith(id_vat);

	// var id_vat = '<td id="cal_vat"><input type="text" name="cal_vat" class="form-control" value="'+cal_vat+'" onchange="change_cal_vat()"></input></td>'; //แสดงภาษี
	// $('#cal_vat').replaceWith(id_vat);

	after_vat = '<td id="sum-all" ><input type="text" name="net_amount" class="form-control" value="'+value_after_vat+' บาท" id="after_vat" readonly></input></td>';
	$('#sum-all').replaceWith(after_vat); //แสดงยอดเงินหลังหักภาษี
	// showmoney();
	after_vat1 = '<td id="sumshow" ><input type="text" style="width: 100%;max-width: 1200px;" class="form-control" value="'+value_after_vat1+' บาท" id="after_vat1" readonly></input></td>';
	$('#sumshow').replaceWith(after_vat1); //แสดงยอดเงินหลังหักภาษี
}

function showmoney() {
	var showmoneyz = value_after_vat;
	// console.log(showmoneyz);
	$('#showmoney').val(showmoneyz);
}

$( document ).ready(function() {
    console.log( "ready!" );
});
$(document).ready(function() {
	$('#example').DataTable();
	$('#example1').DataTable();
	$('#example2').DataTable();
	$('#example3').DataTable();

});
