setData=[
    {a: '9', b: '9', c: '9', dd: '9', e: '7', f: '7'},
    {a: '9', b: '9', c: '9', dd: '5', e: '7', f: '7'},
    {a: '9', b: '9', c: '5', dd: '5', e: '7', f: '7'},
    {a: '9', b: '5', c: '9', dd: '9', e: '7', f: '7'},
    {a: '9', b: '5', c: '9', dd: '5', e: '7', f: '7'},
    {a: '9', b: '5', c: '5', dd: '5', e: '7', f: '7'}, 
    {a: '9', b: '9', c: '9', dd: '9', e: '7', f: '5'},
    {a: '9', b: '9', c: '9', dd: '5', e: '7', f: '5'},
    {a: '9', b: '9', c: '5', dd: '5', e: '7', f: '5'},
    {a: '9', b: '5', c: '9', dd: '9', e: '7', f: '5'},
    {a: '9', b: '5', c: '9', dd: '5', e: '7', f: '5'}, 
    {a: '9', b: '5', c: '5', dd: '5', e: '7', f: '5'}
  ]
$("#btncalc19").click(microClimateCalc);

function microClimateCalc(){	
	h = $("#boxHeight1").val();
	w = $("#boxWidth1").val();
	d = $("#boxDeep1").val();
	Qv = $("#dissipationPower1").val();
	tMin = $("#tMin2").val();
	tWmin = $("#tMin1").val();
	tMax = $("#tMax2").val();
	tWmax = $("#tMax1").val();
	calcsTe = $("#microClimateBoxBlock1 [data-selected=true]").attr("data-set");
	mat = $("#vM").val();
	outdoor = $('#explPlace1 option:selected').val();
	sLevel = $('#sLevel1 option:selected').val();
	if( isNaN(parseFloat(h)) 		||
		isNaN(parseFloat(d)) 		||
		isNaN(parseFloat(Qv)) 		||
		isNaN(parseFloat(tMin)) 	||
		isNaN(parseFloat(tWmin)) 	||
		isNaN(parseFloat(tMax)) 	||
		isNaN(parseFloat(tWmax)) 	||
		isNaN(parseFloat(mat)) 		||
		isNaN(parseFloat(calcsTe)) 	||
		isNaN(parseFloat(outdoor)) 	||
		isNaN(parseFloat(sLevel)) 	||
		isNaN(parseFloat(w)) )
		return;
	s = ( 2 * ( h * w + h * d + w * d ) / 10000 ) / 100;
	
	sT = ((	 setData[calcsTe].a  * h * w
			+setData[calcsTe].b  * h * w
			+setData[calcsTe].c  * h * d
			+setData[calcsTe].dd * h * d
			+setData[calcsTe].e  * d * w
			+setData[calcsTe].f  * d * w ) / 100000 ) / 100;
	res = ( ( Qv - ( tMin - tWmin ) * sT * mat ) * outdoor * ( -1 ) );
	var deltaT = tWmax - tMax;
	if ( deltaT == 0 ) deltaT = -1;
	vent = sLevel * Qv / ( deltaT ) ;
	if( res < 0 ) res = 0;
	if( vent < 0 ) vent = 0;
	refRes = (res*1.1);
	refVent = (vent*1.1);
	$('#s_rez').val(s.toFixed(2).replace('.',','));
	$('#sT_rez').val(sT.toFixed(2).replace('.',','));	
	$('#res_rez').val(res.toFixed(2).replace('.',','));	
	$('#vent_rez').val(vent.toFixed(2).replace('.',','));	
	$('#refRes_rez').val(refRes.toFixed(2).replace('.',','));	
	$('#refVent_rez').val(refVent.toFixed(2).replace('.',','));	
	res = refRes;	// чтобы не рефакторить код ниже
	vent = refVent;
	request = '/local/components/dvasilyev/microclimate.conf/templates/.default/ajax/index.php?action=get_items';
	$("#microclimateEquipContainer1").empty();
	$("#microClimateOtherEquipTable1").empty();
	$("#microclimateEquipContainer1").append("<img src='/programs/master-scale/img/ajload.gif'></img>");
	$("#otherMicroclimateEquipContainer1").empty();						
	$('#otherMicroclimateEquipContainer1').slideUp();
	$('#otherMicroclimateEquipContainer1').attr('class', 'collapse out');
	$('#otherMicroclimateEquipContainerLink1').html('&nbsp;+ Посмотреть все варианты');
	$.get( request, 
		function(response){
			//alert(vent);
			try{
				
				
				data = JSON.parse(response);				
				console.log(data);
				
				data.heaters = sortByFullPriceDecrease(data.heaters, res);	
				data.fans = sortByFullPriceDecrease(data.fans, vent);				
				data.thermostats = sortByFullPriceDecrease(data.thermostats, 0);
				data.thermostats = getNoNcThermostats(data.thermostats);
				
				console.log(data);
				
				tblIndex = 0;
				otherEquipTblIndex = 0;
				addedQty = 0;
				addedFullPrice = 0;				
				
				$("#microclimateEquipContainer1").empty();
				
				if(res && vent){					
					$("#microclimateEquipContainer1").append("<div class='row'><div class='col-md-12'><label class='control-label red_text'>Вариант 1:</label></div></div>");
					$("#microclimateEquipContainer1").append(getTableTemplate(getTableId(++tblIndex)));
					$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.fans[0]));
					if(data.fans[0]){
						addedQty += data.fans[0].QTY;
						addedFullPrice += data.fans[0].FULLPRICE;
						if(data.fans[0].ADDITIONAL_EQUIP){
							for(i = 0; i < data.fans[0].ADDITIONAL_EQUIP.length; i++){
								$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.fans[0].ADDITIONAL_EQUIP[i]));
								addedQty += data.fans[0].ADDITIONAL_EQUIP[i].QTY;
								addedFullPrice += data.fans[0].ADDITIONAL_EQUIP[i].FULLPRICE;
							}
						}
					}
					$("#otherMicroclimateEquipContainer1").append(getTableTemplate(getOtherEquipTableId(++otherEquipTblIndex)));
					for(i = 1; i < data.fans.length; i++){
						if(i == 1){
							row = "<tr><td colspan=6><label class='control-label'>Вентиляторы:</label></td></tr>";
							$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
						} 
						$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.fans[i]));
					}
					
					$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.heaters[0]));
					for(i = 1; i < data.heaters.length; i++){
						if(i == 1){
							row = "<tr><td colspan=6><label class='control-label'>Обогреватели:</label></td></tr>";
							$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
						}
						$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.heaters[i]));
					}
					if(data.heaters[0]){
						addedQty += data.heaters[0].QTY;
						addedFullPrice += data.heaters[0].FULLPRICE;
					}
					for(i = 0, b = false, fr = true; i < data.thermostats.length; i++){
						if( typeof data.thermostats[i].NO_NC != "undefined" && 
							data.thermostats[i].NO_NC == "NO_NC" && !b ){
							$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
							addedQty += data.thermostats[i].QTY;
							addedFullPrice += data.thermostats[i].FULLPRICE;
							b = true;
							continue;
						} else if( 	typeof data.thermostats[i].NO_NC != "undefined" && 
									data.thermostats[i].NO_NC == "NO_NC" ){
									if(fr){
										row = "<tr><td colspan=6><label class='control-label'>Термостаты NO + NC:</label></td></tr>";
										$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
										fr = false;
									}
									$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
								}
					}							
					row = "<tr><td colspan=4><label class='control-label'>Итого:</label></td><td>" + addedQty + "</td><td>" + addedFullPrice + "</td></tr>";
					$("#" + getTableId(tblIndex) + " tfoot").append(row);
					addedQty = 0;
					addedFullPrice = 0;
					$("#microclimateEquipContainer1").append("<div class='row'><div class='col-md-12'><label class='control-label red_text'>Вариант 2:</label></div></div>");
					$("#microclimateEquipContainer1").append(getTableTemplate(getTableId(++tblIndex)));
					$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.fans[0]));
					if(data.fans[0]){
						addedQty += data.fans[0].QTY;
						addedFullPrice += data.fans[0].FULLPRICE;
						if(data.fans[0].ADDITIONAL_EQUIP){	
							for(i = 0; i < data.fans[0].ADDITIONAL_EQUIP.length; i++){
								$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.fans[0].ADDITIONAL_EQUIP[i]));
								addedQty += data.fans[0].ADDITIONAL_EQUIP[i].QTY;
								addedFullPrice += data.fans[0].ADDITIONAL_EQUIP[i].FULLPRICE;
							}
						}
					}
					$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.heaters[0]));
					if(data.heaters[0]){
						addedQty += data.heaters[0].QTY;
						addedFullPrice += data.heaters[0].FULLPRICE;
					}
					for(i = 0, b = false, fr = true; i < data.thermostats.length; i++){						
						if( typeof data.thermostats[i].NO_NC != "undefined" && 
							data.thermostats[i].NO_NC == "NO" && !b ){
							$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
							addedQty += data.thermostats[i].QTY;
							addedFullPrice += data.thermostats[i].FULLPRICE;
							b = true;
							continue;
						} else if( 	typeof data.thermostats[i].NO_NC != "undefined" && 
									data.thermostats[i].NO_NC == "NO" ){
										if(fr){
											row = "<tr><td colspan=6><label class='control-label'>Термостаты NO:</label></td></tr>";
											$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
											fr = false;
										}
										$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
									}
					}
					for(i = 0, b = false, fr = true; i < data.thermostats.length; i++)
						if( typeof data.thermostats[i].NO_NC != "undefined" && 
							data.thermostats[i].NO_NC == "NC" && !b ){
							$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
							addedQty += data.thermostats[i].QTY;
							addedFullPrice += data.thermostats[i].FULLPRICE;
							b = true;
							continue;
						} else if( 	typeof data.thermostats[i].NO_NC != "undefined" && 
									data.thermostats[i].NO_NC == "NC" ){
										if(fr){
											row = "<tr><td colspan=6><label class='control-label'>Термостаты NC:</label></td></tr>";
											$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
											fr = false;
										}
										$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
									}
					row = "<tr><td colspan=4><label class='control-label'>Итого:</label></td><td>" + addedQty + "</td><td>" + addedFullPrice + "</td></tr>";
					$("#" + getTableId(tblIndex) + " tfoot").append(row);					
				} else if(res){					
					$("#microclimateEquipContainer1").append(getTableTemplate(getTableId(++tblIndex)));
					$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.heaters[0]));
					$("#otherMicroclimateEquipContainer1").append(getTableTemplate(getOtherEquipTableId(++otherEquipTblIndex)));
					for(i = 1; i < data.heaters.length; i++){
						if(i == 1){
							row = "<tr><td colspan=6><label class='control-label'>Обогреватели:</label></td></tr>";
							$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
						} 
						$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.heaters[i]));
					}
					if(data.heaters[0]){
						addedQty += data.heaters[0].QTY;
						addedFullPrice += data.heaters[0].FULLPRICE;
					}
					for(i = 0, b = false, fr = true; i < data.thermostats.length; i++)
						if( typeof data.thermostats[i].NO_NC != "undefined" && 
							data.thermostats[i].NO_NC == "NC" && !b ){
							$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
							addedQty += data.thermostats[i].QTY;
							addedFullPrice += data.thermostats[i].FULLPRICE;
							b = true;
							continue;
						} else if( 	typeof data.thermostats[i].NO_NC != "undefined" && 
									data.thermostats[i].NO_NC == "NC" ){
										if(fr){
											row = "<tr><td colspan=6><label class='control-label'>Термостаты NC:</label></td></tr>";
											$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
											fr = false;
										}
										$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
									}
					row = "<tr><td colspan=4><label class='control-label'>Итого:</label></td><td>" + addedQty + "</td><td>" + addedFullPrice + "</td></tr>";
					$("#" + getTableId(tblIndex) + " tfoot").append(row);
				} else if(vent){
					$("#microclimateEquipContainer1").append(getTableTemplate(getTableId(++tblIndex)));
					$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.fans[0]));
					if(data.fans[0]){
						addedQty += data.fans[0].QTY;
						addedFullPrice += data.fans[0].FULLPRICE;
						if(data.fans[0].ADDITIONAL_EQUIP){	
							for(i = 0; i < data.fans[0].ADDITIONAL_EQUIP.length; i++){
								$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.fans[0].ADDITIONAL_EQUIP[i]));
								addedQty += data.fans[0].ADDITIONAL_EQUIP[i].QTY;
								addedFullPrice += data.fans[0].ADDITIONAL_EQUIP[i].FULLPRICE;
							}
						}
					}
					$("#otherMicroclimateEquipContainer1").append(getTableTemplate(getOtherEquipTableId(++otherEquipTblIndex)));
					for(i = 1; i < data.fans.length; i++){
						if(i == 1){
							row = "<tr><td colspan=6><label class='control-label'>Вентиляторы:</label></td></tr>";
							$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
							fr = false;
						} 
						$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.fans[i]));
					}
					for(i = 0, b = false, fr = true; i < data.thermostats.length; i++)
						if( typeof data.thermostats[i].NO_NC != "undefined" && 
							data.thermostats[i].NO_NC == "NO" && !b ){
							$("#" + getTableId(tblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
							addedQty += data.thermostats[i].QTY;
							addedFullPrice += data.thermostats[i].FULLPRICE;
							b = true;
							continue;
						} else if( 	typeof data.thermostats[i].NO_NC != "undefined" && 
									data.thermostats[i].NO_NC == "NO" ){
										if(fr){
											row = "<tr><td colspan=6><label class='control-label'>Термостаты NO:</label></td></tr>";
											$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(row);
											fr = false;
										}
										$("#" + getOtherEquipTableId(otherEquipTblIndex) + " tbody").append(getMicroclimateRow(data.thermostats[i]));
									}
					row = "<tr><td colspan=4><label class='control-label'>Итого:</label></td><td>" + addedQty + "</td><td>" + addedFullPrice + "</td></tr>";
					$("#" + getTableId(tblIndex) + " tfoot").append(row);
				}
				//$('#otherMicroclimateEquipContainer1').slideDown();
			} catch (e) {
				console.log('Ошибка ' + e.name + ":" + e.message + "\n" + e.stack);
				//console.log(response);
			}
		}
	);	
}
$("#btnclear19").click(
	function(){
		$("#boxHeight1").val('1000');
		$("#boxWidth1").val('1000');
		$("#boxDeep1").val('1000');
		$("#dissipationPower1").val('12');
		$("#tMin2").val('15');
		$("#tMin1").val('-30');
		$("#tMax2").val('35');
		$("#tMax1").val('45');
		$('#installType1').val('0');
		$("#vM").val('5.5');
		$('#explPlace1').val('1');
		$('#sLevel1').val('3.1');
		$('#materialType1').val('5.5');
		$('#s_rez').val('');
		$('#sT_rez').val('');	
		$('#res_rez').val('');	
		$('#vent_rez').val('');	
		$('#refRes_rez').val('');	
		$('#refVent_rez').val('');	
		$('#microclimateEquipContainer1').empty();
		$("#otherMicroclimateEquipContainer1").empty();						
		$('#otherMicroclimateEquipContainer1').slideDown();
		$('#otherMicroclimateEquipContainer1').attr('class', 'collapse out');
		$('#otherMicroclimateEquipContainerLink1').html('&nbsp;+ Посмотреть все варианты');
	});
	
function getMicroclimateRow(item) {
	if(!item) return null;
	pic = item.PICTURE;
	artikul = item.PROPERTY_ARTIKUL_VALUE;
	name = item.NAME;
	price = item.PRICE;
	qty = 0;
	if (typeof item.PROPERTY_OBJEMNYJ_RASKHOD_VOZDUHA_BESKANALNAJA_PO_VALUE != "undefined"){
		qty = Math.ceil( vent / item.PROPERTY_OBJEMNYJ_RASKHOD_VOZDUHA_BESKANALNAJA_PO_VALUE );
	} else if (typeof item.PROPERTY_NOMINALNAJA_MOSHHNOST0_VALUE != "undefined"){
		qty = Math.ceil( res / item.PROPERTY_NOMINALNAJA_MOSHHNOST0_VALUE );
	} else if (typeof item.PROPERTY_TIP_FUNKCIONALNYH_PEREKLUCHATELEJ_VALUE != "undefined"){
		qty = 1;
	} else {
		qty = 1;
	}	
	row = 	"<tr><td align='center'><img src='" + pic + 
			"' /></td><td align='left'>" + artikul + 
			"</td><td align='left'>" + name + 
			"</td><td align='left'>" + price + 
			"</td><td align='center'>" + qty + 
			"</td><td align='center'>" + ( price * qty )  + 
			"</td></tr>";
	return row;
}

function sortByFullPriceDecrease(items, multiplier) { //сортировать товарные позиции по возрастанию цены
	result = [];
	items.forEach(function(item, i, arr) {
						if (typeof item.PROPERTY_OBJEMNYJ_RASKHOD_VOZDUHA_BESKANALNAJA_PO_VALUE != "undefined"){
							item.QTY = Math.ceil( multiplier / item.PROPERTY_OBJEMNYJ_RASKHOD_VOZDUHA_BESKANALNAJA_PO_VALUE );
							if(item.ADDITIONAL_EQUIP)	
								item.ADDITIONAL_EQUIP.forEach(function(aEqp, j, aEqpArr){
										aEqp.QTY = 1;
										aEqp.FULLPRICE = aEqp.PRICE * aEqp.QTY;
								});
						} else if (typeof item.PROPERTY_NOMINALNAJA_MOSHHNOST0_VALUE != "undefined"){
							item.QTY = Math.ceil( multiplier / item.PROPERTY_NOMINALNAJA_MOSHHNOST0_VALUE );
						} else if (typeof item.PROPERTY_TIP_FUNKCIONALNYH_PEREKLUCHATELEJ_VALUE != "undefined"){
							item.QTY = 1;
						}					
						item.FULLPRICE = item.PRICE * item.QTY;
					});		
	while(items.length > 0){	
		minValue = 10000000000.00;
		for(i = 0; i < items.length; i++){
			minValue = items[i].FULLPRICE * 1.0;
			for(j = 0; j < items.length; j++){
				if(j == i) continue;
				if((items[j].FULLPRICE * 1.0) < minValue) 
					minValue = items[j].FULLPRICE * 1.0;
			}
		}
		for(i = 0; i < items.length; i++){
			if((items[i].FULLPRICE * 1.0) == minValue){
				result.push(items[i]);
				items.splice(i,1); 
			}
		}
	}
	
	return result;	
}

function getNoNcThermostats(items) {
	items.forEach(function(item, i, arr) {
						if (typeof item.PROPERTY_TIP_FUNKCIONALNYH_PEREKLUCHATELEJ_VALUE != "undefined"){
							if (	item.PROPERTY_TIP_FUNKCIONALNYH_PEREKLUCHATELEJ_VALUE.match("NO") &&
									item.PROPERTY_TIP_FUNKCIONALNYH_PEREKLUCHATELEJ_VALUE.match("NC") ){
								item.NO_NC = "NO_NC";
							} else if (item.PROPERTY_TIP_FUNKCIONALNYH_PEREKLUCHATELEJ_VALUE.match("NO")){
								item.NO_NC = "NO";
							} else if (item.PROPERTY_TIP_FUNKCIONALNYH_PEREKLUCHATELEJ_VALUE.match("NC")){
								item.NO_NC = "NC";
							}
						}
					});
	return items;
}

function getTableTemplate(tableId){
	return 	"<div class='row'><div class='col-md-12'>" + 
			"<div class='table-responsive'>" +
			"<table class='table table-bordered' id='" + tableId + "'>" +
			"<thead><tr>" +
			"<td align='center'><label class='control-label'>Изображение</label></td>" +															
			"<td align='center'><label class='control-label'>Артикул</label></td>" +
			"<td align='center'><label class='control-label'>Наименование</label></td>" +
			"<td align='center'><label class='control-label'>Цена, ₽</label></td>" +			
			"<td align='center'><label class='control-label'>Кол-во, шт</label></td>" +
			"<td align='center'><label class='control-label'>Сумма, ₽</label></td>" +
			"</tr></thead><tbody></tbody><tfoot></tfoot></table></div></div></div>";
}

function getTableId(index){
	return "microClimateProdTable" + index;
}

function getOtherEquipTableId(index){
	return "microClimateOtherEquipTable" + index;
}

function openCloseOtherMicroclimateEquipContainer(obj){
	if($(obj).html() == '&nbsp;+ Посмотреть все варианты'){
		$('#otherMicroclimateEquipContainer1').slideDown();
		$(obj).html('&nbsp;- Посмотреть все варианты');
	} else {
		$('#otherMicroclimateEquipContainer1').slideUp();
		$(obj).html('&nbsp;+ Посмотреть все варианты');
	}
}

$("#microClimateBoxBlock1 img").click(function(){
		$("#microClimateBoxBlock1 img").each(function(){$(this).parent().attr('data-selected',false)});
		$(this).parent().attr('data-selected',true);
		$("#microClimateBoxBlock1 img").each(function(){
				index = $(this).parent().attr('data-set') * 1.0;
				state = $(this).parent().attr('data-selected') || false;				
				src = getMicroclimateBoxImg(index, state);
				$(this).attr('src', src);
			});/**/
		
	});
//
$("#microClimateBoxBlock1 img").each(function(){ //раскрашиваем выделенный шкаф при загрузке формы
				index = $(this).parent().attr('data-set') * 1.0;
				state = $(this).parent().attr('data-selected') || false;				
				src = getMicroclimateBoxImg(index, state);
				$(this).attr('src', src);
			});

function getMicroclimateBoxImg(index, state){
	if(state == "true"){
		switch(index * 1){
			case 0: return "/programs/master-scale/img/microclimate/4-1r.png";
			case 1: return "/programs/master-scale/img/microclimate/4-2r.png";
			case 2: return "/programs/master-scale/img/microclimate/4-3r.png";
			case 3: return "/programs/master-scale/img/microclimate/1-1r.png";
			case 4: return "/programs/master-scale/img/microclimate/1-2r.png";
			case 5: return "/programs/master-scale/img/microclimate/1-3r.png";
			case 6: return "/programs/master-scale/img/microclimate/3-1r.png";
			case 7: return "/programs/master-scale/img/microclimate/3-2r.png";
			case 8: return "/programs/master-scale/img/microclimate/3-3r.png";
			case 9: return "/programs/master-scale/img/microclimate/2-1r.png";
			case 10: return "/programs/master-scale/img/microclimate/2-2r.png";
			case 11: return "/programs/master-scale/img/microclimate/2-3r.png";
			default: return null;
		}
	} else {
		switch(index * 1){
			case 0: return "/programs/master-scale/img/microclimate/4-1g.png";
			case 1: return "/programs/master-scale/img/microclimate/4-2g.png";
			case 2: return "/programs/master-scale/img/microclimate/4-3g.png";
			case 3: return "/programs/master-scale/img/microclimate/1-1g.png";
			case 4: return "/programs/master-scale/img/microclimate/1-2g.png";
			case 5: return "/programs/master-scale/img/microclimate/1-3g.png";
			case 6: return "/programs/master-scale/img/microclimate/3-1g.png";
			case 7: return "/programs/master-scale/img/microclimate/3-2g.png";
			case 8: return "/programs/master-scale/img/microclimate/3-3g.png";
			case 9: return "/programs/master-scale/img/microclimate/2-1g.png";
			case 10: return "/programs/master-scale/img/microclimate/2-2g.png";
			case 11: return "/programs/master-scale/img/microclimate/2-3g.png";
			default: return null;
		}
	}
}