<script id="uermСonfTmpl" type="text/x-jquery-tmpl">
    <div class="row" style="border: 1px solid grey; margin-top: 15px; padding: 10px 10px 10px 10px !important;">		
		<div class="col-md-12">			
			<div class='row'>
				<div class="col-md-2">
					<label class="control-label red_text">Изделие №<span id="uermItemNumber1"></span></label>
				</div>
				<div class='col-md-3'>
					<label class='control-label red_text' >Высота УЭРМ (от 2000 до 4400), мм:</label>
				</div>
				<div class='col-md-3'>
					<label class='control-label red_text'>Кол-во квартир на этаже (от 1 до 15), шт:</label>
				</div>
				<div class='col-md-3'>
					<label class='control-label red_text'><span>Кол-во УЭРМ (от 1<br />до 200), шт:</span></label>
				</div>
				<div class='col-md-1'>
					<input class='btn consum-del-btn' style='float: right; width: 25px;' type='button' value='&#10008;' onclick="deleteUermItem(this);">
				</div>
			</div>
			<div class='row' style='margin-top: 10px;'>
				<div class='col-md-2'>
				</div>
				<div class='col-md-3'>
					<input value="2000" type="number" id="uermHeight1" min="2000" max="4400" step="100" onchange='uermInputEventProcessor(this)'></input>
				</div>
				<div class='col-md-3'>
					<input value="1" type="number" id="flatCount1" min="1" max="15" onchange='uermInputEventProcessor(this)'>
				</div>				
				<div class='col-md-2'>
					<input value="1" type="number" id="uermCount1" min="1" max="200" onchange='uermInputEventProcessor(this)'>
				</div>
				<div class='col-md-2'>
				</div>
			</div>
			<div class="row" style="margin-top: 10px; margin-bottom: 10px;" >
				<div class='col-md-12'>
					<!--&nbsp;+ Вести доп. параметры-->
					<input type="checkbox" name="uermUseAdditParams" id="uermUseAdditParams" onchange='uermInputEventProcessor(this)'></input>
					<label class="label_text">&nbsp;Указать доп. параметры</label>
				</div>
			</div>
			<div class='collapse out' id="uermAdditParamsContainer1" style="border: 1px dashed #d3d3d3; padding: 5px 5px 5px 5px;">
				<div class='row'>
					<div class='col-md-12'>
						<label class="">Укажите кол-во необходимых комплектующих и их тип из расчета на 1 изделие УЭРМ<br /><br /></label>
					</div>
				</div>
				<div class='row' style="margin-bottom: 3px;">
					<div class='col-md-9'>
						<label class='control-label red_text'>Короб КЭТ силовой (от 0 до 50), шт:</label>
					</div>
					<div class='col-md-3'>
						<input value="1" type="number" id="BoxKETPower1" min="0" max="50" style="width: 75px; float: right;" onchange='uermInputEventProcessor(this)'>						
					</div>
				</div>
				<div class='row' style="margin-bottom: 3px;">
					<div class='col-md-9'>
						<label class='control-label red_text'>Короб КЭТ транзитный (от 0 до 50), шт:</label>						
					</div>				
					<div class='col-md-3'>						
						<input value="0" type="number" id="BoxKETTrans1" min="0" max="50" style="width: 75px; float: right;" onchange='uermInputEventProcessor(this)'></input>
					</div>
				</div>
				<div class='row' style="margin-bottom: 3px;">
					<div class='col-md-9'>
						<label class='control-label red_text'>Короб КСС (от 0 до 50), шт:</label>
					</div>
					<div class='col-md-3'>
						<input value="1" type="number" id="BoxKSS1" min="0" max="50" style="width: 75px; float: right;" onchange='uermInputEventProcessor(this)'>
					</div>
				</div>
				<div class='row' style="margin-bottom: 3px;">
					<div class='col-md-3'>
						<label class='control-label red_text'>Тип ЯУР:</label>
					</div>				
					<div class='col-md-9'>
						<select id="YAURType1" style="font-size: 12px !important; float: right; width: 350px;" >
							<option value="0" selected>ЯУР счетчик на монтажную панель (600х300х150)</option>
							<option value="1" >ЯУР счетчик на DIN-рейку (400х300х150)</option>
						</select>
					</div>
				</div>
			</div>
		</div>
    </div>
</script>

<div class="uerm-conf">
	<div class='row'>		
		<div class="col-md-8">
			<div id="uermItemsContainer"></div>
		</div>
		<div class="col-md-4">
			<br />
			<img id="uerm_img" src="img/uerm.jpg" style="" width="247px" height="568px" usemap="#uerm_map" >
			<map name="uerm_map">
				<area title="ЯУР. Две модификации: 1. с монтажной панелью (600 мм), 2. с дин-рейкой (400 мм)." 
					shape="poly" alt="" coords="40,197,73,177,102,193,102,364,35,385,35,257,40,257" href="#" >
				<area title="ЯУР. Две модификации: 1. с монтажной панелью (600 мм), 2. с дин-рейкой (400 мм)." 
					shape="poly" alt="" coords="42,390,102,370,102,514,98,514,36,535,36,402,40,402" href="#" >
				<area title="ЯУР. Две модификации: 1. с монтажной панелью (600 мм), 2. с дин-рейкой (400 мм)." 
					shape="poly" alt="" coords="164,270,195,252,225,270,225,448,216,444,160,464,160,330,164,330" href="#" >
				<area title="ЯУР. Две модификации: 1. с монтажной панелью (600 мм), 2. с дин-рейкой (400 мм)." 
					shape="poly" alt="" coords="161,474,164,471,164,464,211,447,222,450,225,592,215,589,160,608" href="#" >
				<area title="Короб КЭТ - 1890 мм. Две модификации: 1. силовой (с шинами N и PE), 2. транзитный (без шин). Состоит из центральной секции, короба нижнего и цоколя нижнего." 
					shape="poly" alt="" coords="105,233,160,265,160,609,196,595,196,700,165,717,105,682" href="#" >
				<area title="Цоколь верхний с компенсатором. Высота цоколя: 110, 260, 410, 560 мм. Полезный вылет компенсатора: 0-150 мм."
					shape="poly" alt="" coords="227,97,258,78,259,112,259,112,290,128,319,114,319,178,290,194,227,156" href="#" >
				<area title="Цоколь верхний с компенсатором. Высота цоколя: 110, 260, 410, 560 мм. Полезный вылет компенсатора: 0-150 мм."
					shape="poly" alt="" coords="102,26,133,8,133,32,137,36,137,41,163,57,194,42,194,106,165,122,102,87" href="#" >
				<area title="Короб верхний для КСС и КЭТ (600 мм)."
					shape="poly" alt="" coords="227,155,288,192,319,178,319,322,288,342,228,308" href="#" >
				<area title="Короб верхний для КСС и КЭТ (600 мм)."
					shape="poly" alt="" coords="102,90,165,125,195,108,194,251,164,266,102,233" href="#" >
				<area title="Короб КСС (1890 мм). Состоит из центральной секции, короба нижнего и цоколя нижнего."
					shape="poly" alt="" coords="227,307,288,343,320,325,320,772,288,790,227,755" href="#" >
			</map>
		</div>
	</div><br />
	<div class="row" style="margin-top: 10px; margin-bottom: 10px;" >
		
		<div class="col-md-4"><input style="height: 50px !important; width: 245px !important;" class="btn-default" type="button" id="uermAddItem" value="Добавить изделие" onclick="addUermItem()"></div>
		<div class="col-md-4"><input style="height: 50px !important; width: 245px !important;" class="btn-danger" type="button" id="uermCalc" value="Сделать расчет"></div>
		<div class="col-md-4"><input style="height: 50px !important; width: 245px !important;" class="btn-default" type="button" id="uermClear" value="Сброс"></div>
		
	</div><br />	
	<div id="uermSpecContainer">
	</div><br />	
	<div class="row" style="margin-top: 10px; margin-bottom: 10px;display:none!important;" id="uermXlsBtn1">
		<div class="col-md-12"><input style="height: 50px !important; width: 245px !important;" class="btn-default" type="button" id="uermSaveXls" value="Сохранить в Excel"></div>
	</div>
</div>