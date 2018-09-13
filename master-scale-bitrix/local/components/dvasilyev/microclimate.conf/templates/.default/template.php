<div class="microclimate-conf">
	<div class="row" style="border-bottom: 1px solid #cecece; border-top: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
		<div class="col-md-3">
			<label class="control-label red_text">Параметры шкафа:</label>
		</div>
		<div class="col-md-3">
			<label class="control-label red_text">Высота, мм:</label><br>
			<input value="1000" id="boxHeight1" style="height: 40px !important; width: 160px !important;" type="number" min="200" max="2300"></br>
			<label class="control-label red_text">Ширина, мм:</label><br>
			<input value="1000" id="boxWidth1" style="height: 40px !important; width: 160px !important;" type="number" min="200" max="1500"></br>
			<label class="control-label red_text">Глубина, мм:</label><br>
			<input value="1000" id="boxDeep1" style="height: 40px !important; width: 160px !important;" type="number"  min="200" max="1000">
		</div>
		<div class="col-md-6">
			<label class="control-label red_text">Материал:</label><br>
			<select id="materialType1" onchange="if($(this).val() != '5'){ $('#vM').prop('disabled',true); $('#vM').val($(this).val()); } else { $('#vM').prop('disabled',false); $('#vM').val(5);}">
			  <option value="5.5">Листовая сталь, лакированная</option>
			  <option value="4.5">Листовая сталь, нержавеющая</option>
			  <option value="12.0">Алюминий</option>
			  <option value="4.5">Алюминий, двойной</option>
			  <option value="3.5">Полиэфир</option>
			  <option value="5">Другой материал (k=0.1-20 Вт/(м2°C))</option>
			</select>
			</br>
			<label class="control-label red_text" >Коэффициент тепло-<br />передачи, Вт/(м<sup>2</sup>°C):&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input disabled id="vM" value="5.5" min="0.1" max="20" step="0.1" type="number"> </label>			
		</div>
	</div>	
	<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
		<div class="col-md-3">
			<label class="control-label red_text">Тип установки:</label><br>
			<!--select class="" id="installType1" >
				<option value="0">Шкаф на ножках (вдали от стен)</option>
				<option value="1">Крайний шкаф на ножках (вдали от стен)</option>
				<option value="2">Средний шкаф на ножках (вдали от стен)</option>
				<option value="3">Настенный шкаф</option>
				<option value="4">Крайний настенный шкаф</option>
				<option value="5">Средний настенный шкаф</option>
				<option value="6">Напольный шкаф (вдали от стен)</option>
				<option value="7">Крайний напольный шкаф (вдали от стен)</option>
				<option value="8">Средний напольный шкаф (вдали от стен)</option>
				<option value="9">Напольный шкаф у стены</option>
				<option value="10">Крайний напольный шкаф у стены</option>
				<option value="11">Средний напольный шкаф у стены</option>
			</select-->
		</div>
		<div class="col-md-9">
			<div id="microClimateBoxBlock1">
				<div class="row" style="margin-top: -13px;">
					<div class="col-md-4" data-set=3 data-selected=true><img src="/programs/master-scale/img/microclimate/1-1g.png" width="150px"/><span>Настенный шкаф</span></div>
					<div class="col-md-4" data-set=4><img src="/programs/master-scale/img/microclimate/1-2g.png" width="150px"/><span>Крайний настенный шкаф</span></div>
					<div class="col-md-4" data-set=5><img src="/programs/master-scale/img/microclimate/1-3g.png" width="150px"/><span>Средний настенный шкаф</span></div>
				</div>
				<div class="row" style="">
					<div class="col-md-4" data-set=9><img src="/programs/master-scale/img/microclimate/2-1g.png" width="150px"/><span>Напольный шкаф у стены</span></div>
					<div class="col-md-4" data-set=10><img src="/programs/master-scale/img/microclimate/2-2g.png" width="150px"/><span>Крайний напольный шкаф у стены</span></div>
					<div class="col-md-4" data-set=11><img src="/programs/master-scale/img/microclimate/2-3g.png" width="150px"/><span>Средний напольный шкаф у стены</span></div>
				</div>
				<div class="row" style="">
					<div class="col-md-4" data-set=6><img src="/programs/master-scale/img/microclimate/3-1g.png" width="150px"/><span>Напольный шкаф (вдали от стен)</span></div>
					<div class="col-md-4" data-set=7><img src="/programs/master-scale/img/microclimate/3-2g.png" width="150px"/><span>Крайний напольный шкаф (вдали от стен)</span></div>
					<div class="col-md-4" data-set=8><img src="/programs/master-scale/img/microclimate/3-3g.png" width="150px"/><span>Средний напольный шкаф (вдали от стен)</span></div>
				</div>
				<div class="row" style="padding-bottom: 15px;">
					<div class="col-md-4" data-set=0><img src="/programs/master-scale/img/microclimate/4-1g.png" width="150px"/><span>Шкаф на ножках (вдали от стен)</span></div>
					<div class="col-md-4" data-set=1><img src="/programs/master-scale/img/microclimate/4-2g.png" width="150px"/><span>Крайний шкаф на ножках (вдали от стен)</span></div>
					<div class="col-md-4" data-set=2><img src="/programs/master-scale/img/microclimate/4-3g.png" width="150px"/><span>Средний шкаф на ножках (вдали от стен)</span></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row" style="border-bottom: 1px solid #cecece; border-top: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
		<div class="col-md-3">
			<label class="control-label red_text">Параметры окружающей среды:</label>
		</div>
		<div class="col-md-3">
			<label class="control-label red_text">Tmax, <sup>o</sup>C:</label><br>
			<input value="45" id="tMax1" style="height: 40px !important; width: 160px !important;" type="number" min=-60 max=60></br>
			<label class="control-label red_text">Tmin, <sup>o</sup>C:</label><br>
			<input value="-30" id="tMin1" style="height: 40px !important; width: 160px !important;" type="number" min=-60 max=60></br>
			<label class="control-label red_text">Высота над уровнем моря, м:</label><br>
			<select id="sLevel1">
			  <option value="3.1">0-99</option>
			  <option value="3.2" selected="">100-299</option> 
			  <option value="3.3">300-499</option> 
			  <option value="3.4">500-699</option> 
			  <option value="3.45">700-899</option> 
			  <option value="3.5">900-1249</option> 
			  <option value="3.6">1250-1749</option>
			  <option value="3.7">1750-2000</option> 
			</select>
		</div>
		<div class="col-md-3">
			<label class="control-label red_text">Требуемая температура внутри шкафа:</label>
		</div>
		<div class="col-md-3">
			<label class="control-label red_text">Tmax, <sup>o</sup>C:</label><br>
			<input value="35" id="tMax2" style="height: 40px !important; width: 160px !important;" type="number" min=40 max=60></br>
			<label class="control-label red_text">Tmin, <sup>o</sup>C:</label><br>
			<input value="15" id="tMin2" style="height: 40px !important; width: 160px !important;" type="number" min=10 max=60>
		</div>
	</div>
	<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
		<div class="col-md-3">
			<label class="control-label red_text">Мощность тепловыделения оборудования, Вт:</label>			
		</div>
		<div class="col-md-3">
			<input value="12" id="dissipationPower1" style="height: 40px !important; width: 160px !important;" type="number" min=5 max=1000>
		</div>
		<div class="col-md-2">
			<label class="control-label red_text">Место эксплуатации шкафа:</label>			
		</div>
		<div class="col-md-4">
			<select id="explPlace1">
				<option value="1">Внутри помещения</option>
				<option value="2">На открытом воздухе</option>
			</select>
		</div>
	</div>
	<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
		<div class="col-md-6">
			<button class="btn btn_calc" id="btncalc19" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать</button>
			<button class="btn btn_reset" id="btnclear19" style="margin-left:15px; display: inline-block;">Сброс</button>
		</div>
	</div><br /><br />
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive"> 
				<table class="table table-bordered">
					<tbody>
						<tr>
							<td colspan="9"><label class="control-label red_text">Расчетные значения:</label></td>
						</tr>
						<tr>
							<td><label class="control-label red_text" align="center">Плошадь поверхности, м<sup>2</sup></label></td>									
							<td><label class="control-label red_text" align="center">Эффективная плошадь теплообмена, м<sup>2</sup></label></td>
							<td><label class="control-label red_text" align="center">Расчетная мощность обогрева, Вт</label></td>
							<td><label class="control-label red_text" align="center">Расчетная производитель-<br />ность вентилятора, м<sup>3</sup>/ч</label></td>
							<td><label class="control-label red_text" align="center">Рекомендуемая мощность обогрева, Вт</label></td>
							<td><label class="control-label red_text" align="center">Рекомендуемая производительность вентилятора, м<sup>3</sup>/ч</label></td>
						</tr>
						<tr>
							<td><input disabled="" id="s_rez" style="width:100%;text-align:center;" type="text" value=""></td>									
							<td><input disabled="" id="sT_rez" style="width:100%;text-align:center;" type="text" value="" align="center"></td>
							<td><input disabled="" id="res_rez" style="width:100%;text-align:center;" type="text" value="" align="center"></td>
							<td><input disabled="" id="vent_rez" style="width:100%;text-align:center;" type="text" value="" align="center"></td>
							<td><input disabled="" id="refRes_rez" style="width:100%;text-align:center;" type="text" value="" align="center"></td>
							<td><input disabled="" id="refVent_rez" style="width:100%;text-align:center;" type="text" value="" align="center"></td>
						</tr>						
					</tbody>
				</table>
				<span>*Данный расчет носит рекомендательный характер. Расчетные мощности нагревателя и вентилятора должны быть проверены пользователем в реальных условиях эксплуатации. Компания EKF не несет ответственности за абсолютную точность расчета и возможные издержки.</span>				
			</div>
		</div>
	</div><br /><br />
	<div class="row" style="">
		<div class="col-md-12">
			<label class="control-label red_text">Подобранные комплектующие шкафа:</label>			
		</div>
	</div><br />
	<div id="microclimateEquipContainer1">
	</div><br /><br />
	<div style="display:none;">
	<div class='list-link' onclick='openCloseOtherMicroclimateEquipContainer(this);' href='#otherMicroclimateEquipContainer1' id='otherMicroclimateEquipContainerLink1'>&nbsp;+ Посмотреть все варианты</div>
	<br /><br />
	<div class='collapse out' id='otherMicroclimateEquipContainer1'>
	</div>
	</div>
</div>