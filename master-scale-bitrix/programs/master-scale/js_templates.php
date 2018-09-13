<script id="buildLoadCalcTmpl" type="text/x-jquery-tmpl">
	<div class="row" style="margin-top: 10px; width: 109%;" id="${id}">
		<div class='col-sm-12 col-sm-border'>
			<div class='row'>				
				<div class='col-sm-6 consum-child-elem-margins' style='margin-left: -5px;'>
					<label class='control-label red_text'>Тип потребителя:</label><br>
					<select class='selectpicker' style='height: 40px; width: 310px;' id='consumersType' onchange='JQTmplEventProcessor(this);'>
						<option value='0'  id='option0'>Вентиляц. обор. (двиг.>30кВт)</option>
						<option value='1'  id='option1'>Вентиляц. обор.</option>
						<option value='2'  id='option2'>Дымоудаление</option>
						<option value='3'  id='option3'>Кондиционер</option>
						<option value='4'  id='option4'>Кондиционер > 30кВт</option>
						<option value='5'  id='option5'>Лифт</option>
						<option value='6'  id='option6'>Мед. кабинет</option>
						<option value='7'  id='option7'>Мед.обор.тепловое</option>
						<option value='8'  id='option8'>Мед.обор.стационарное</option>
						<option value='9'  id='option9'>Нагревательное сантех. обор.</option>
						<option value='10' id='option10'>Насосное обор. (двиг.>30кВт)</option>
						<option value='11' id='option11'>Насосное обор.</option>
						<option value='12' id='option12'>Оборудование уборочное</option>
						<option value='13' id='option13'>ОЗДС</option>
						<option value='14' id='option14'>Освещение аварийное</option>
						<option value='15' id='option15'>Освещение</option>
						<option value='16' id='option16'>Пищеблок (двиг. обор.)</option>
						<option value='17' id='option17'>Пищеблок (теп. обор.)</option>
						<option value='18' id='option18'>Пожарный клапан</option>
						<option value='19' id='option19'>Пожарный насос</option>
						<option value='20' id='option20'>Посудомоеч. маш. (гор.вода)</option>
						<option value='21' id='option21'>Посудомоеч. маш. (хол.вода)</option>
						<option value='22' id='option22'>Прачечная (двиг. обор.)</option>
						<option value='23' id='option23'>Прачечная (теп. обор.)</option>
						<option value='24' id='option24'>Рентген</option>
						<option value='25' id='option25'>Розетки бытовые</option>
						<option value='26' id='option26'>Розетки компьютерные</option>
						<option value='27' id='option27'>Рукосушитель</option>
						<option value='28' id='option28'>Слаботоч. сист.</option>
						<option value='29' id='option29'>Станок</option>
						<option value='30' id='option30'>Станок (теп. обор.)</option>
						<option value='31' id='option31'>Сценич. звук</option>
						<option value='32' id='option32'>Сценич. мех.</option>
						<option value='33' id='option33'>Сценич. свет</option>
						<option value='34' id='option34'>Учеб. мастерская</option>
						<option value='35' id='option35'>Учеб.мастерская (теп. обор.)</option>
						<option value='36' id='option36'>Учебное обор.</option>
						<option value='37' id='option37'>Учебное обор.(теп. обор.)</option>
						<option value='38' id='option38'>Флюорограф</option>
						<option value='39' id='option39'>Холодильное обор.</option>
						<option value='40' id='option40'>Холодильное обор.>30кВт</option>
						<option value='41' id='option41'>Квартира (прир. газ)</option>
						<option value='42' id='option42'>Квартира (сжиж. газ)</option>
						<option value='43' id='option43'>Квартира (эл. плита)</option>
						<option value='44' id='option44'>Дачный домик</option>
						<option value='45' id='option45'>ИТП</option>
					</select>
				</div>
				<div class='col-sm-4 consum-child-elem-margins'>
					<div class='row'><br>
						<div class='col-sm-2'>
							<input type="checkbox" id="fireInvolved1" name="fireInvolved1" onchange="JQTmplEventProcessor(this);" checked>
						</div>
						<div class='col-sm-10'>
							<label for="fireInvolved1" class='control-label red_text'>Участвует при пожаре</label>
						</div>
					</div>	
					<div class='row'>
						<div class='col-sm-2'>
							<input type="checkbox" id="KCEditing1" name="KCEditing1" onchange="JQTmplEventProcessor(this);">
						</div>
						<div class='col-sm-10'>
							<label for="KCEditing1" class='control-label red_text'>Указать Кс вручную</label>
						</div>
					</div>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<div class='col-sm-1 consum-child-elem-margins'>
						<input class='btn consum-del-btn' type='button' value='Удалить' onclick="deleteConsumer(this);">
					</div>
				</div>			
				<div class='row'>
					<div class='col-sm-11' style="margin-left: 10px;">
						<div class="table-responsive"> 
							<table class="table table-bordered">
								<tr>
									<td class='red_text'>Np</td>
									<td class='red_text'>Ру, кВт</td>									
									<td class='red_text'>Qу, квар</td>
									<td class='red_text'>Кс</td>
									<td class='red_text'>Pр, кВт</td>
									<td class='red_text'>Qр, квар</td>
									<td class='red_text'>cosϕ</td>
									<td class='red_text'>Tgϕ</td>
									<td class='red_text'>Sp, кВА</td>
									<td class='red_text'>Ip, A</td>									
								</tr>
								<tr>
									<td><input value='1' type='text' id='Np' onchange='JQTmplEventProcessor(this);' style="width: 55px;"></td>
									<td><input value='5' type='text' id='Py' onchange='JQTmplEventProcessor(this);' style="width: 60px;"></td>									
									<td><input value='' type='text' id='Qy' onchange='JQTmplEventProcessor(this);' style="width: 63px;" disabled></td>
									<td><input value='' type='text' id='Kc' onchange='JQTmplEventProcessor(this);' style="width: 60px;" disabled></td>
									<td><input value='' type='text' id='Pp' onchange='JQTmplEventProcessor(this);' style="width: 60px;" disabled></td>
									<td><input value='' type='text' id='Qp' onchange='JQTmplEventProcessor(this);' style="width: 63px;" disabled></td>
									<td><input value='0,98' type='text' id='cosf' onchange='JQTmplEventProcessor(this);' style="width: 60px;"></td>
									<td><input value='' type='text' id='tgf' onchange='JQTmplEventProcessor(this);' style="width: 60px;" disabled></td>
									<td><input value='' type='text' id='Sp' onchange='JQTmplEventProcessor(this);' style="width: 60px;" disabled></td>
									<td><input value='' type='text' id='Ip' onchange='JQTmplEventProcessor(this);' style="width: 60px;" disabled></td>
									
								</tr>
							</table>
						</div> 
					</div>
				</div>
		</div>
	</div>
</script>
<script id="lightningHeightTmpl" type="text/x-jquery-tmpl">
    <div class="row">
        <div class="col-sm-5 input-left-sign">
            <label class="control-label red_text">Высота молниеотвода ${j} h<sub>${j}</sub>, м:</label>
        </div>
        <div class="col-sm-6 radio-block-div">
            <input type="text" id="lightningheight${j}" value="">
        </div>
    </div>
</script>
<script id="lightningDistanceTmpl" type="text/x-jquery-tmpl">
    <div class="row">
        <div class="col-sm-5 input-left-sign">
            <label class="control-label red_text">Расстояние между молниеотводами ${j} и ${k} L<sub>${j}${k}</sub>, м:</label>
        </div>
        <div class="col-sm-6 radio-block-div">
            <input type="text" id="lightningdist${j}${k}" value="">
        </div>
    </div>
</script>
<script id="multipleLightningPropsTmpl" type="text/x-jquery-tmpl">
    <div class='row' id='lightning${i}${neighbor}props'>
        <div class="row">
            <div class="col-sm-12"><label class="control-label red_text lbrez-top-margin">Характеристики молниеотвода ${i}${neighbor} :</label></div>
        </div>
        <div class="row" id="divrez57" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez57title">h<sub>0</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez57"></label></div>
        </div>
        <div class="row" id="divrez58" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez58title">r<sub>0</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez58"></label></div>
        </div>
        <div class="row" id="divrez59" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez59title">r<sub>x</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez59"></label></div>
        </div>
        <div class="row" id="divrez60" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez60title">α:</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez60"></label></div>
        </div>
        <div class="row" id="divrez61" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez61title">h<sub>c</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez61"></label></div>
        </div>
        <div class="row" id="divrez62" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez62title">r<sub>c</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez62"></label></div>
        </div>
        <div class="row" id="divrez63" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez63title">r<sub>cx</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez63"></label></div>
        </div>
        <div class="row" id="divrez64" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez64title">h<sub>01</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez64"></label></div>
        </div>
        <div class="row" id="divrez65" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez65title">r<sub>01</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez65"></label></div>
        </div>
        <div class="row" id="divrez66" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez66title">r<sub>x1</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez66"></label></div>
        </div>
        <div class="row" id="divrez67" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez67title">h<sub>02</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez67"></label></div>
        </div>
        <div class="row" id="divrez68" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez68title">r<sub>02</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez68"></label></div>
        </div>
        <div class="row" id="divrez69" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez69title">r<sub>x2</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez69"></label></div>
        </div>
        <div class="row" id="divrez70" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez70title">h<sub>c1</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez70"></label></div>
        </div>
        <div class="row" id="divrez71" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez71title">h<sub>c2</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez71"></label></div>
        </div>
        <div class="row" id="divrez72" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez72title">α<sub>1</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez72"></label></div>
        </div>
        <div class="row" id="divrez73" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez73title">α<sub>2</sub> :</label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez73"></label></div>
        </div>
        <div class="row" id="divrez56" style='display: none'>
            <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez56title"></label></div>
            <div class="col-md-6"><label class="control-label rez_text" id="lbrez56"></label></div>
        </div>
    </div>
</script>
<script id="crossSectionOfTrayAndFireTmpl" type="text/x-jquery-tmpl">
	<div class="row" style="margin-top: 10px;" id="${id}">
		<div class='col-sm-12 col-sm-border'>
			<div class='row'>
				<div class='col-sm-5 consum-child-elem-margins'>
					<label class='control-label red_text'>Тип кабеля:</label><br />
					<select class='selectpicker' style='height: 40px !important; width: 260px !important;' id='cableType1' onchange='updateHtmlContent1(this);'>
						<?
						$iblockId = 134;
						$ct_Section = CIBlockSection::GetList(array('ID' => 'asc'), array('IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'));
						//echo $ct_Section->SelectedRowsCount();
						//$ct_Section->SelectedRowsCount()
						$section = $ct_Section->Fetch();
						$curr_ct_val = $section['ID'];
						do{ ?>
							<option value=<?=$section['ID']?>><?=$section['NAME'] ?></option>
						<? }while($section = $ct_Section->Fetch()); ?>
					</select>
				</div>
				<div class='col-sm-2 consum-child-elem-margins' style="margin-left: -40px !important;">
					<label class='control-label red_text'>Сечение:</label><br />
					<select class='selectpicker' style='height: 40px !important; width: 110px !important;' id='cableCrossSection1' onchange='updateHtmlContent1(this);'>
						<?
						$ct_Sections = CIBlockElement::GetList(	array(	'ID' => 'asc'), 
																array(	'IBLOCK_ID' => $iblockId, 
																		'ACTIVE' => 'Y', 
																		'SECTION_ID' => $curr_ct_val),
																false,
																false,
																array(	"ID",
																		"NAME",
																		"PROPERTY_outer_diameter",
																		"PROPERTY_cable_mass",
																		"PROPERTY_volume_combustible_mass"
																	));
						//echo $ct_Section->SelectedRowsCount();
						//$ct_Section->SelectedRowsCount()
						$sections = $ct_Sections->Fetch();
						$curr_ct_val = $sections['ID'];
						$curr_outer_diam_val = $sections['PROPERTY_OUTER_DIAMETER_VALUE'];
						$curr_cable_mass_val = $sections['PROPERTY_CABLE_MASS_VALUE'];
						$curr_volume_combustible_mass_val = $sections['PROPERTY_VOLUME_COMBUSTIBLE_MASS_VALUE'];
						do{ ?>
							<option value=<?=$sections['ID']?>><?=$sections['NAME'] ?></option>
						<? }while($sections = $ct_Sections->Fetch()); ?>
					</select>
				</div>	
				<div class='col-sm-3 consum-child-elem-margins'>
					<label class='control-label red_text'>Кол-во линий, шт:</label><br />
					<input value="1" type="text" id="lineCount1" style='height: 40px !important; width: 160px !important;' onchange='updateHtmlContent1(this);'></input>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<input class='btn consum-del-btn' style='height: 40px !important; margin-left: 30px;' type='button' value='Удалить' onclick="parent = this.parentNode.parentNode.parentNode.parentNode;parent.remove();">
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-2 consum-child-elem-margins'>
					<label class='control-label red_text'>Внешний диаметр D, мм:</label>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<label class='control-label red_text'>Масса кабеля, кг/м:</label>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<label class='control-label red_text'>Объем горючей массы, л/м:</label>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<label class='control-label red_text'>Площадь сечения кабелей, мм<sup>2</sup>:</label>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<label class='control-label red_text'>Масса кабелей, кг/м:</label>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<label class='control-label red_text'>Суммарный объем горючей массы, л/м:</label>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-2 consum-child-elem-margins'>
					<input value="<?=$curr_outer_diam_val ?>" type="text" id="outdiam1" disabled=""></input>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<input value="<?=$curr_cable_mass_val ?>" type="text" id="cablemass1" disabled="">
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<input value="<?=$curr_volume_combustible_mass_val ?>" type="text" id="volumecombustiblemass1" disabled="">
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<input value="<?=($curr_outer_diam_val / 2.0) * ($curr_outer_diam_val / 2.0) * 3.14 ?>" type="text" id="cablescrosssection1" disabled=""></input>
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<input value="<?=$curr_cable_mass_val ?>" type="text" id="cablesmass1" disabled="">
				</div>
				<div class='col-sm-2 consum-child-elem-margins'>
					<input value="<?=$curr_volume_combustible_mass_val ?>" type="text" id="volumecombustiblemass2" disabled="">
				</div>
			</div>
			</div>			
		</div>		
	</div>
</script>