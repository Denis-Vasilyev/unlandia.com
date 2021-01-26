initUermForm();
uermClear();
$('#uerm_img').mapster({
        fillOpacity: 0.4,
        stroke: true,
        strokeOpacity: 0.8,
        strokeWidth: 4,
        multySelect: true,      
		onClick: function (e) {/*alert();*/}
    });
function initUermForm(){
		addUermItem();
		addUermItem();
		addUermItem();
		//$('input:checkbox[name=uermUseAdditParams]').iCheck('destroy');
}

function addUermItem(){
	/*uermHeight 	= items[i].uermHeight;
	flatCount	= items[i].flatCount;
	uermCount	= items[i].uermCount;*/
	if($('#uermItemsContainer').children().length < 5){
		$('#uermСonfTmpl').tmpl().appendTo('#uermItemsContainer');
		chCount = $('#uermItemsContainer').children().length;
		firstItem = $('#uermItemsContainer').children()[0];
		uermUseAdditParams = $(firstItem).find('#uermUseAdditParams').prop('checked');
		if(chCount > 1 && uermUseAdditParams == true){			
			boxKETPower	= $(firstItem).find('#BoxKETPower1').val();
			boxKETTrans	= $(firstItem).find('#BoxKETTrans1').val();
			boxKSS		= $(firstItem).find('#BoxKSS1').val();
			YAURType	= $(firstItem).find('#YAURType1 option:selected').val();
			lastItem 	= $('#uermItemsContainer').children()[chCount-1];
			$(lastItem).find('#uermUseAdditParams').prop('checked',true);
			$(lastItem).find('#uermAdditParamsContainer1').slideDown();
			$(lastItem).find('#BoxKETPower1').val(boxKETPower);
			$(lastItem).find('#BoxKETTrans1').val(boxKETTrans);
			$(lastItem).find('#BoxKSS1').val(boxKSS);
			$(lastItem).find("#YAURType1").val(YAURType);
		}
	}
	else 
		$('#uermAddItem').prop('disabled',true);
	$.each($('#uermItemsContainer').children(),function(key,value){
		$(this).find('#uermItemNumber1').html(key + 1);
	});
}

function deleteUermItem(obj){
	parent = obj.parentNode.parentNode.parentNode.parentNode;
	parent.remove();
	$.each($('#uermItemsContainer').children(),function(key,value){
		$(this).find('#uermItemNumber1').html(key + 1);
	});
	$('#uermAddItem').prop('disabled',false);
}

$("#uermClear").click(uermClear);

function uermClear(){
		$("#uermItemsContainer").empty();
		$("#uermSpecContainer").empty();
		$("#uermXlsBtn1").hide();
		addUermItem();
		addUermItem();
		addUermItem();
		
} 

$("#uermCalc").click(uermCalc);

function uermCalc(){
	//alert();
	$("#uermSpecContainer").empty();
	uermData = [];
	request = '/local/components/dvasilyev/uerm.conf/templates/.default/ajax/index.php?action=get_items';
	$.get( 	request,
			function(response){
				try {
					uermData = JSON.parse(response)['items'];					
					items = [];
					$.each($('#uermItemsContainer').children(),function(key,value){
						uermHeight 	= parseFloat($(this).find('#uermHeight1').val());
						flatCount  	= parseFloat($(this).find('#flatCount1').val());
						uermCount  	= parseFloat($(this).find('#uermCount1').val());
						additParams = $(this).find('#uermUseAdditParams').prop('checked');
						if(additParams){
							boxKETPower	= parseFloat($(this).find('#BoxKETPower1').val());
							boxKETTrans	= parseFloat($(this).find('#BoxKETTrans1').val());
							boxKSS		= parseFloat($(this).find('#BoxKSS1').val());
							YAURType	= parseFloat($(this).find('#YAURType1 option:selected').val());
							items.push({	uermHeight: 	uermHeight, 
											flatCount: 		flatCount, 
											uermCount: 		uermCount,
											additParams:	additParams,
											boxKETPower: 	boxKETPower,
											boxKETTrans:	boxKETTrans,
											boxKSS:			boxKSS,
											YAURType:		YAURType });
							return true;
						}
						items.push({	uermHeight: uermHeight, 
										flatCount: flatCount, 
										uermCount: uermCount, 
										additParams: additParams });
					});
					//console.log(items); return;
					for(i=0; i<items.length; i++){
						if(	isNaN(items[i].uermHeight) ||
							isNaN(items[i].flatCount)  ||
							isNaN(items[i].uermCount)
						) return false;
						if( items[i].additParams ){
							if(	isNaN(items[i].boxKETPower)  ||
								isNaN(items[i].boxKETTrans)  ||
								isNaN(items[i].boxKSS)		 ||
								isNaN(items[i].YAURType)
							) return false;
						}
					}/**/
					//console.log(items);
					itemsSpec = [];
					
					for(i=0; i<items.length; i++){
						uermHeight 	= items[i].uermHeight;
						flatCount	= items[i].flatCount;
						uermCount	= items[i].uermCount;
						boxKETPower	= items[i].boxKETPower;
						boxKETTrans	= items[i].boxKETTrans;
						boxKSS		= items[i].boxKSS;
						YAURType	= items[i].YAURType;
						if(items[i].additParams){ // если указаны доп параметры
							if(items[i].uermHeight >= 2000 && items[i].uermHeight < 2150) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-slide-110', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 2150 && items[i].uermHeight < 2300) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-slide-260', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 2300 && items[i].uermHeight < 2450) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-slide-410', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);							
							} else if(items[i].uermHeight >= 2450 && items[i].uermHeight < 2600) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-slide-560', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 2600 && items[i].uermHeight < 2750) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											},
										 {	article: 'uerm-slide-110', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 2750 && items[i].uermHeight < 2900) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											},
										 {	article: 'uerm-slide-260', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);								
							} else if(items[i].uermHeight >= 2900 && items[i].uermHeight < 3050) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											},
										 {	article: 'uerm-slide-410', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);								
							} else if(items[i].uermHeight >= 3050 && items[i].uermHeight < 3200) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											},
										 {	article: 'uerm-slide-560', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3200 && items[i].uermHeight < 3350) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * 2 * uermCount
											},
										 {	article: 'uerm-slide-110', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);								
							} else if(items[i].uermHeight >= 3350 && items[i].uermHeight < 3500) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * 2 * uermCount
											},
										 {	article: 'uerm-slide-260', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3500 && items[i].uermHeight < 3650) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * 2 * uermCount
											},
										 {	article: 'uerm-slide-410', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3650 && items[i].uermHeight < 3800) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * 2 * uermCount
											},
										 {	article: 'uerm-slide-560', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3800 && items[i].uermHeight < 3950) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * 3 * uermCount
											},
										 {	article: 'uerm-slide-110', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								//console.log(item);
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3950 && items[i].uermHeight < 4100) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * 3 * uermCount
											},
										 {	article: 'uerm-slide-260', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 4100 && items[i].uermHeight < 4250) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * 3 * uermCount
											},
										 {	article: 'uerm-slide-410', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 4250 && items[i].uermHeight <= 4400) {
								item = [ {	article: 'uerm-ket-t-1890',											
											qty:  (boxKETTrans * 1) ? ( boxKETTrans * uermCount ) : 0
											},
										 {	article: 'uerm-ket-s-1890',											
											qty:  (boxKETPower * 1) ? ( boxKETPower * uermCount ) : 0
											},
										 {	article: 'uerm-kss-1890', 
											qty:  (boxKSS * 1) ? ( boxKSS * uermCount ) : 0
											},
										 {	article: (YAURType * 1) ? 'uerm-din-400' : 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * 3 * uermCount
											},
										 {	article: 'uerm-slide-560', 
											qty: (boxKETTrans + boxKETPower + boxKSS) * uermCount
											}
										];
								itemsSpec.push(item);
							}
						} else {			//без доп параметров
							if(items[i].uermHeight >= 2000 && items[i].uermHeight < 2150) {
								item = [ {	article: 'uerm-ket-s-1890',											
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-slide-110', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 2150 && items[i].uermHeight < 2300) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-slide-260', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 2300 && items[i].uermHeight < 2450) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-slide-410', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);							
							} else if(items[i].uermHeight >= 2450 && items[i].uermHeight < 2600) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-slide-560', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 2600 && items[i].uermHeight < 2750) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 2 * uermCount
											},
										 {	article: 'uerm-slide-110', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 2750 && items[i].uermHeight < 2900) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 2 * uermCount
											},
										 {	article: 'uerm-slide-260', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);								
							} else if(items[i].uermHeight >= 2900 && items[i].uermHeight < 3050) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 2 * uermCount
											},
										 {	article: 'uerm-slide-410', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);								
							} else if(items[i].uermHeight >= 3050 && items[i].uermHeight < 3200) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 2 * uermCount
											},
										 {	article: 'uerm-slide-560', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3200 && items[i].uermHeight < 3350) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 4 * uermCount
											},
										 {	article: 'uerm-slide-110', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);								
							} else if(items[i].uermHeight >= 3350 && items[i].uermHeight < 3500) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 4 * uermCount
											},
										 {	article: 'uerm-slide-260', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3500 && items[i].uermHeight < 3650) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 4 * uermCount
											},
										 {	article: 'uerm-slide-410', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3650 && items[i].uermHeight < 3800) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 4 * uermCount
											},
										 {	article: 'uerm-slide-560', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3800 && items[i].uermHeight < 3950) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 6 * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 2 * uermCount
											},
										 {	article: 'uerm-slide-110', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 3950 && items[i].uermHeight < 4100) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 6 * uermCount
											},
										 {	article: 'uerm-slide-260', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 4100 && items[i].uermHeight < 4250) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 6 * uermCount
											},
										 {	article: 'uerm-slide-410', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							} else if(items[i].uermHeight >= 4250 && items[i].uermHeight <= 4400) {
								item = [ {	article: 'uerm-ket-s-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-kss-1890', 
											qty: 1 * uermCount
											},
										 {	article: 'uerm-mp-600', 
											qty: flatCount * uermCount
											},
										 {	article: 'uerm-kor-600', 
											qty: 6 * uermCount
											},
										 {	article: 'uerm-slide-560', 
											qty: 2 * uermCount
											}
										];
								itemsSpec.push(item);
							}
						}
					}					
					console.log(itemsSpec);
					$("#uermSpecContainer").append(getUermSpecTable(itemsSpec, items, uermData));
					$("#uermXlsBtn1").show();
				} catch (e) {
					console.log(response);
					console.log('Ошибка ' + e.name + ":" + e.message + "\n" + e.stack);				
				}
			}
		);
}

function getUermSpecTable(	itemsSpec,	// комплектующие с расчитанным количеством на одно изделие 
							items, 		// данные по изделиям введенные пользователем
							uermData	// список номенклатур и наименований изделий
							){
	//console.log(items);
	subcells = "";
	for(i=1;i<=itemsSpec.length;i++)
		subcells += "<td align='center'>Изделие №" + i + "</td>";
	tHead = "<div class='row'><div class='col-md-12'>" + 
			"<div class='table-responsive'>" +
			"<table class='table table-bordered'>" +
			"<thead><tr>" +
			"<td align='center' rowspan=2><label>Изображение</label></td>" +
			"<td align='center' rowspan=2><label>Артикул ЭКФ</label></td>" +															
			"<td align='center' rowspan=2><label>Наименование</label></td>" +
			"<td align='center' colspan=" + itemsSpec.length + "><label>Количество, шт</label></td>" +
			"<td align='center' rowspan=2><label>Итого, шт</label></td>" + 
			"<td align='center' rowspan=2><label>Базовая цена, ₽</label></td>" + 
			"<td align='center' rowspan=2><label>Сумма, ₽</label></td></tr>" + 
			"<tr>" + subcells + "</tr></thead><tbody>";
	tBody = "";
	totalPrice = 0;
	console.log(uermData);
	for(var uermDataKey in uermData){
		tBodyRow = "<tr><td><img src='" + uermData[uermDataKey].PICTURE + "' /></td><td>" + uermDataKey + "</td><td>" + uermData[uermDataKey].NAME + "</td>";
		totalQty = 0;
		for(i=0;i<itemsSpec.length;i++){
			catchFlag = false;
			for(j=0;j<itemsSpec[i].length;j++)
				if(itemsSpec[i][j].article == uermDataKey){
					catchFlag = true;
					totalQty += itemsSpec[i][j].qty /* * items[i].uermCount*/;
					tBodyRow += "<td align='center' >" + ( itemsSpec[i][j].qty /* * items[i].uermCount */) +"</td>";
					break;
				}
			if(!catchFlag)
				tBodyRow += "<td align='center' > 0 </td>";
		}
		if(totalQty * 1){
			tPrice = ( uermData[uermDataKey].PRICE * totalQty );
			price = ( uermData[uermDataKey].PRICE * 1 );
			totalPrice += tPrice;
			tBodyRow += "<td align='center'> " + totalQty + 
						"</td><td>" + priceFormat(price) + 
						//"</td><td>" + tPrice.toFixed(2) + "</td></tr>";
						"</td><td style='white-space: nowrap;'>" + priceFormat(tPrice) + "</td></tr>";			
			tBody += tBodyRow;
		}		
	}
	tFoot = "</tbody><tfoot><tr><td align='right' colspan=" + ( itemsSpec.length + 5 ) + "><b>Итого:</b></td><td id='uermSpecTPrice'>" + priceFormat(totalPrice) + "</td></tr></tfoot></table></div></div></div>";
	return tHead + tBody + tFoot;
}
	
function uermInputEventProcessor(obj){	
	//alert($(obj).attr('id'));
	switch($(obj).attr('id')){
		case 'uermHeight1':		
			minVal = 2000;
			maxVal = 4400;
			msg = "Укажите целое значение от " + minVal + " до " + maxVal;
			val = $(obj).val();
			val = uermAlertFail(minVal,maxVal,val,msg);
			if(val || val == "0") $(obj).val(val);
		break;
		case 'flatCount1':	
			minVal = 1;
			maxVal = 15;
			msg = "Укажите целое значение от " + minVal + " до " + maxVal;
			val = $(obj).val();
			val = uermAlertFail(minVal,maxVal,val,msg);
			if(val || val == "0") $(obj).val(val);
		break;
		case 'uermCount1':
			minVal = 1;
			maxVal = 200;
			msg = "Укажите целое значение от " + minVal + " до " + maxVal;
			val = $(obj).val();
			val = uermAlertFail(minVal,maxVal,val,msg);
			if(val || val == "0") $(obj).val(val);
		break;
		case 'uermUseAdditParams':			
			if($(obj).prop("checked") == true)
				$(obj).parent().parent().parent().find('#uermAdditParamsContainer1').slideDown();
			else
				$(obj).parent().parent().parent().find('#uermAdditParamsContainer1').slideUp();
		break;
		case 'BoxKETPower1':
			minVal = 0;
			maxVal = 50;
			msg = "Укажите целое значение от " + minVal + " до " + maxVal;
			val = $(obj).val();
			val = uermAlertFail(minVal,maxVal,val,msg);
			if(val || val == "0") $(obj).val(val);
		break;
		case 'BoxKETTrans1':
			minVal = 0;
			maxVal = 50;
			msg = "Укажите целое значение от " + minVal + " до " + maxVal;
			val = $(obj).val();
			val = uermAlertFail(minVal,maxVal,val,msg);
			if(val || val == "0") $(obj).val(val);
		break;
		case 'BoxKSS1':
			minVal = 0;
			maxVal = 50;
			msg = "Укажите целое значение от " + minVal + " до " + maxVal;
			val = $(obj).val();
			val = uermAlertFail(minVal,maxVal,val,msg);
			if(val || val == "0") $(obj).val(val);
		break;
	}
}

function uermAlertFail(min,max,val,msg){
	if( val == "" ) return min;
	if( parseInt(val) != val ) { alert(msg); return min; }
	if(val * 1 < min ) { alert(msg); return min; }
	if(val * 1 > max ) { alert(msg); return max; }
	return null;
}

$('input:checkbox[name=uermUseAdditParams]').on('ifChecked',function(){
				$('input:checkbox[name=uermUseAdditParams]').iCheck('destroy');
			});

$('#uermSaveXls').click(uermSpecGenerateXls);

function uermSpecGenerateXls(){
	//alert(.length);
	xlsData = {};
	$("#uermSpecContainer tbody")
		.children().each(
				function(i,value){
					xlsData[i] = [];
					$(value).children().each(
						function(j,cell){
							if(j != 0)
								xlsData[i].push($(cell).html().trim());
						}
					);
				});
	request = '/local/components/dvasilyev/uerm.conf/templates/.default/ajax/index.php?action=get_report';
	data = {};
	data[0] = xlsData;
	data[1] = $("#uermSpecContainer #uermSpecTPrice").html();
	console.log(data);
	$.post(	request, 
			{xlsData: data},
            function(response) {
				try{
					//console.log(response);
					window.location = "/../" + response;
				} catch (e) {
					console.log(response);
					console.log('Ошибка ' + e.name + ":" + e.message + "\n" + e.stack);
					return false;
				}
				
            });
}

function priceFormat(price){
	price = price.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1 ').replace('.', ',').trim();
	price = price.replace(" ", "&#8239;");//заменяем пробел на короткий пробел
	while(price[0] == "0")
		price = price.splice(1);	
	return price;
}