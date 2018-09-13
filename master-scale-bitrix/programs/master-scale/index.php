<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Master Tool');
?>

<link href="css/style.css" rel="stylesheet">
<link href="icheck/skins/flat/red.css" rel="stylesheet">
<script src="js/html2canvas.js"></script>
<script src="icheck/icheck.js"></script>
<script src="js/scripts.js"></script>

<? require('js_templates.php'); ?>
	
	<img src="img/Master-TOOL.png" style="width: 250px;">
	<div class="container-fluid" style="margin-left: -30px !important;">		
		<div class="row">
			<div class="col-md-12">
				<div class="tabbable tabs-left" id="tabs-336590">
					<ul class="program-select-tabs nav-tabs" style="border-bottom: none !important;">
						<?
						$tabs = [
							['id' => 926477, 'title' => 'Определение сечения провода по его диаметру'],
							['id' => 359125, 'title' => 'Определение сечения провода по заданой потере напряжения, мощности нагрузки и длины линии'],
							['id' => 359128, 'title' => 'Расчет тока в цепи'],
							['id' => 359127, 'title' => 'Расчет сопротивления системы заземления'],
							['id' => 359126, 'title' => 'Расчет емкости конденсаторов для трехфазных электродвигателей'],
							['id' => 359129, 'title' => 'Расчет падения напряжения в линии'],
							['id' => 359130, 'title' => 'Расчет заполняемости кабельных каналов'],
							['id' => 359131, 'title' => 'Расчёт нагрузок жилых и общественных зданий'],
							['id' => 359136, 'title' => 'Расчет экономической эффективности от применения преобразователя частоты VECTOR EKF PROXima'],
							['id' => 359132, 'title' => 'Расчёт тока утечки'],
							['id' => 359133, 'title' => 'Расчёт токов короткого замыкания'],
							['id' => 359134, 'title' => 'Термическая стойкость кабеля'],
							['id' => 359135, 'title' => 'Молниезащита'],
							['id' => 359137, 'title' => 'Подбор догрузочного сопротивления'],
							['id' => 359138, 'title' => 'Проверка чувствительности'],
							['id' => 359139, 'title' => 'Подбор сечения лотка и необходимости пожаротушения'],
							['id' => 359140, 'title' => 'Онлайн конфигуратор по микроклимату'],
							['id' => 3591369, 'title' => 'Калькулятор селективности'],
							['id' => 359141, 'title' => 'Онлайн конфигуратор для подбора УЭРМ']
						];
						
						?>

						<? foreach ($tabs as $index => $tab) { ?>
							<? $num = str_pad($index+1, 2, 0, STR_PAD_LEFT); ?>
							<li href="#panel-<?=$tab['id']?>" 
								id="<?=$tab['id']?>"
								data-toggle="tab" <? 	if ($index == 0 && !$_GET['a']) { ?>class="active"<? } 
														else if ($index == 18 && $_GET['a']) { ?>class="active"<? } ?>>
	                            <div class="tab_middle">
	                            	<span class="tabnum"><?=$num?></span>
									<p><?=$tab['title']?></p>
								</div>
	                        </li>
						<? } ?>						
                                        
					</ul>									
					<div class="tab-content">
						<div class="tab-pane <? if (!$_GET['d'] && !$_GET['a']) { ?>active<? } ?>" id="panel-926477">
							<form class="topdf-form" action="to_pdf.php?form=wire_section_by_diameter" method="post">
							<input type="hidden" name="pageTitle" value="Определение сечения провода по его диаметру">
							<br>
							<div id="wire_cross_section">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<ol>
													<li class="red_text"><span class="black_text">Намотайте витком к витку оголенную жилу провода на предмет цилиндрической формы (например отвертку). Старайтесь наматывать как можно плотнее, без зазоров.<br></span></li>
													<li class="red_text"><span class="black_text">Измерьте штангель-циркулем длину намотанной жилы<br></span></li>
													<li class="red_text"><span class="black_text">Внесите показания в соответствующие поля и нажмите клавишу enter</span></li>
												</ol>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="row" style="margin-top: 20px">
													<div class="col-md-8"><p class="red_text">Введите количество витков</p></div>
													<div class="col-md-4"><input type="text" id="kolvovit" name="kolvovit" value=""></div>
												</div>
												<div class="row" style="margin-top: 15px">
													<div class="col-md-8"><p class="red_text">Введите длину намотки (мм)</p></div>
													<div class="col-md-4"><input type="text" id="dlinavit" name="dlinavit" value=""></div>
												</div>
												<div class="row" style="margin-top: 20px">
													<div class="col-md-1"><p><b>&nbsp;</b></p></div>
													<div class="col-md-11">														
														<label class="control-label red_text" style="margin-top:8px;">РЕЗУЛЬТАТ:</label>
														<label class="control-label rez_text" id="rezult" style="margin-left: 20px;">
													</label></div>
													<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-md-5">
										<img alt="caliper.gif" src="img/caliper.gif" style="margin-left: 10px; width: 450px;">
									</div>
									
								</div>									
							</div>
							</form>
							<script>
								$('#kolvovit').change(function(){
									MakeRez();
								});
								$('#dlinavit').change(function(){
									MakeRez();
								});
								
								function MakeRez() {									
									var s = 3.14 * ( Math.pow( parseFloat($("#dlinavit").val()) / parseFloat($("#kolvovit").val()), 2) ) / 4;
									if(!isNaN(s)){
										var val = s.toFixed(2) + " мм<sup>2</sup>";
										$('#rezult').html(val);
										$('#rezult').append('<input type="hidden" name="result" value="' + val + '">');
										sendCntAjax('masterscale','calc','calc',null);
										$('.tab-pane.active .topdf-button').show();
									} else {
										$('#rezult').html("");
										$('.tab-pane.active .topdf-button').hide();
									}
								}
							</script>
						</div>
						<div class="tab-pane" id="panel-359125">	
							<form class="topdf-form" action="to_pdf.php?form=wire_section_by_voltage" method="post">
							<input type="hidden" name="pageTitle" value="Определение сечения провода по заданой потере напряжения, мощности нагрузки и длины линии">
							<br>
							<div class="control-group">
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Определение сечения для:</label>
									</div>
									<div class="col-md-8">
										<input type="radio" name="phase" id="rad0">
										<label for="rad0" class="label_text" style="margin-left: 10px;">Однофазных потребителей переменного тока</label><br>
										<input type="radio" name="phase" id="rad1">
										<label for="rad1" class="label_text" style="margin-left: 10px;">Трехфазных потребителей переменного тока</label>
									</div>
								</div>
							</div>
							<div class="control-group">
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Тип проводов:</label>
									</div>
									<div class="col-md-8">
										<input type="radio" name="whire" id="rad2">
										<label for="rad2" class="label_text">Медные</label><br>
										<input type="radio" name="whire" id="rad3">
										<label for="rad3" class="label_text">Алюминивые</label>
									</div>
								</div>
							</div>
							<div class="control-group">
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Допустимые потери напряжения, %:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="vollos" id="rad4" value="1"><br>
													<label for="rad4" class="black_text" style="padding-left: 5px; margin-top: 10px">1</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad5" value="2"><br>
													<label for="rad5" class="black_text" style="padding-left: 5px; margin-top: 10px">2</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad6" value="3"><br>
													<label for="rad6" class="black_text" style="padding-left: 5px; margin-top: 10px">3</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad7" value="4"><br>
													<label for="rad7" class="black_text" style="padding-left: 5px; margin-top: 10px">4</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad8" value="5"><br>
													<label for="rad8" class="black_text" style="padding-left: 5px; margin-top: 10px">5</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad9" value="6"><br>
													<label for="rad9" class="black_text" style="padding-left: 5px; margin-top: 10px">6</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad10" value="7"><br>
													<label for="rad10" class="black_text" style="padding-left: 5px; margin-top: 10px">7</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad11" value="8"><br>
													<label for="rad11" class="black_text" style="padding-left: 5px; margin-top: 10px">8</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad12" value="9"><br>
													<label for="rad12" class="black_text" style="padding-left: 5px; margin-top: 10px">9</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="vollos" id="rad13" value="10"><br>
													<label for="rad13" class="black_text" style="padding-left: 5px; margin-top: 10px">10</label>
												</div>
										</div>										
									</div>
								</div>
							</div>
							<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
								<div class="col-md-4"><label class="control-label red_text">Мощность нагрузки, Вт:</label></div>
								<div class="col-md-8"><input type="text" id="lbpower" name="lbpower" value=""></div>
							</div>		
							<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
								<div class="col-md-4"><label class="control-label red_text">Длина линии, м:</label></div>
								<div class="col-md-8"><input type="text" id="lblenght" name="lblenght" value=""></div>
							</div>
							<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
								<div class="col-md-6">
									<button class="btn btn_calc" id="btncalc1" style="margin-right:15px; display: inline-block;"onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать </button>
									<button class="btn btn_reset" id="btnclear1" style="margin-left:15px; display: inline-block;">Сброс</button>
								</div>								
							</div>
							<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
								<div class="col-md-6">
									<label class="control-label red_text" style="margin-top:8px;">РЕЗУЛЬТАТ:</label>
									<label class="control-label rez_text" id="lbrez2" style="margin-left: 20px;"></label>
									<br><input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
								</div>
								
							</div>		
							</form>
							<script>
								$('#btncalc1').click(function(){
									WireCrossSectionCalc();
									return false;
								});
								$('#btnclear1').click(function(){
									WireCrossSectionClear();
									return false;
								});
								function WireCrossSectionCalc() {
									var typeСonsumer = null;
									var wireType = null;
									var voltageDrop = null;
									
									if($('#rad0').prop('checked')) typeСonsumer = 1;
									if($('#rad1').prop('checked')) typeСonsumer = 2;
									
									if($('#rad2').prop('checked')) wireType = 1;
									if($('#rad3').prop('checked')) wireType = 2;

									if($('#rad4').prop('checked')) voltageDrop = 1;
									if($('#rad5').prop('checked')) voltageDrop = 2;
									if($('#rad6').prop('checked')) voltageDrop = 3;
									if($('#rad7').prop('checked')) voltageDrop = 4;
									if($('#rad8').prop('checked')) voltageDrop = 5;
									if($('#rad9').prop('checked')) voltageDrop = 6;
									if($('#rad10').prop('checked')) voltageDrop = 7;
									if($('#rad11').prop('checked')) voltageDrop = 8;
									if($('#rad12').prop('checked')) voltageDrop = 9;
									if($('#rad13').prop('checked')) voltageDrop = 10;
									//alert(voltageDrop);
									var power = $('#lbpower').val().replace(',','.');
									var len = $('#lblenght').val().replace(',','.');
									
									if( !parseFloat(typeСonsumer) ||
										!parseFloat(wireType) ||
										!parseFloat(voltageDrop) ||
										!parseFloat(power) ||
										!parseFloat(len)
									){
										$('#lbrez2').html('');
										alert('Заполните все поля.');
										return;
									}
									var s;
									var y;
									if(wireType == 1) y = 57;
									if(wireType == 2) y = 35;
									if(typeСonsumer == 1){
										s = (200 * power * len)/(220 * 220 * y * voltageDrop);
									}
									if(typeСonsumer == 2){
										s = (100 * power * len)/(380 * 380 * y * voltageDrop);
									}
									$('#lbrez2').html(s.toFixed(1) + " мм<sup>2</sup>");
									$('#lbrez2').append('<input type="hidden" name="result" value="' + s.toFixed(1) + '">');

								}
								function WireCrossSectionClear() {
									$('#select01').val("");
									$('#select02').val("");
									$('#select03').val("");
									$('#lbpower').val("");
									$('#lblenght').val("");
									$('#lbrez2').html("");
									$('input:radio[name=phase]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=whire]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=vollos]').each(function(){$(this).iCheck('uncheck');});
								}
							</script>
						</div>
						<div class="tab-pane" id="panel-359126">
							<form class="topdf-form" action="to_pdf.php?form=capacitance" method="post">
								<input type="hidden" name="pageTitle" value="Расчет емкости конденсаторов для трехфазных электродвигателей">
								<div class="control-group">
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 30px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Соединение обмоток двигателя:</label>
										</div>
										<div class="col-md-7">
											<input type="radio" name="motor_winding" id="rad14">
											<label for="rad14" class="label_text" style="margin-left: 10px;">Звезда</label><br>
											<input type="radio" name="motor_winding" id="rad15">
											<label for="rad15" class="label_text" style="margin-left: 10px;">Треугольник</label>
										</div>
									</div>
									<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
										<div class="col-md-5"><label class="control-label red_text">Мощность двигателя, Вт:</label></div>
										<div class="col-md-7"><input type="text" id="lbpower1" name="power1" value=""></div>
									</div>	
									<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
										<div class="col-md-5"><label class="control-label red_text">Напряжене в сети, В:</label></div>
										<div class="col-md-7"><input type="text" id="lbvoltage1" name="voltage1" value=""></div>
									</div>	
									<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
										<div class="col-md-5"><label class="control-label red_text">Коэффициент мощности, cosϕ:</label></div>
										<div class="col-md-7"><input type="text" id="lbcosf1" name="cosf1" value=""></div>
									</div>	
									<div class="row" style="padding-top: 15px; padding-bottom: 15px; ">
										<div class="col-md-5"><label class="control-label red_text">КПД двигателя (указывать от 0 до 1):</label></div>
										<div class="col-md-7"><input type="text" id="effengine1" name="effengine1" value=""></div>
									</div>
									<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-6">
											<button class="btn btn_calc" id="btncalc2" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать</button>
											<button class="btn btn_reset" id="btnclear2" style="margin-left:15px; display: inline-block;">Сброс</button>
										</div>								
									</div>
									<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-6">
											<label class="control-label red_text" style="margin-top:8px;">Ёмкость рабочего конденсатора, мкФ:</label>
											<label class="control-label rez_text" id="lbrez3" style="margin-left: 20px;">
										</label></div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
										<div class="col-md-6">
											<label class="control-label red_text" style="margin-top:8px;">Ёмкость пускового конденсатора, мкФ:</label>
											<label class="control-label rez_text" id="lbrez4" style="margin-left: 20px;">
										</label></div>
									</div>
								</div>
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
							<script>
								$('#btncalc2').click(function(){
									CapacitanceCalc();
								});
								
								$('#btnclear2').click(function(){
									CapacitanceClear();
									return false;
								});
								
								function CapacitanceCalc() {		
									var power = $('#lbpower1').val().replace(',','.');
									var voltage = $('#lbvoltage1').val().replace(',','.');
									var cosf = $('#lbcosf1').val().replace(',','.');
									var kpd = $('#effengine1').val().replace(',','.');
									
									if( !parseFloat(power)		||
										!parseFloat(voltage)	||
										!parseFloat(cosf)		||
										!parseFloat(kpd)		||
										!( $('#rad14').prop('checked') || $('#rad15').prop('checked'))
									){
										$('#lbrez3').html('');
										$('#lbrez4').html('');
										alert('Заполните все поля.');
										return false;
									}
									if( kpd < 0 || kpd > 1 ){
										$('#lbrez3').html('');
										$('#lbrez4').html('');
										alert('Укажите значение КПД двигателя в пределах от 0 до 1.');
										return false;
									}
									var workCapacitance;
									if($('#rad14').prop('checked'))
										workCapacitance = 2800 * ( power / ( 1.73 * voltage * kpd * cosf ) ) / voltage;
									if($('#rad15').prop('checked'))
										workCapacitance = 4800 * ( power / ( 1.73 * voltage * kpd * cosf ) ) / voltage;
									var launchCapacitance = 2.5 * workCapacitance;
									
									$('#lbrez3').html(workCapacitance.toFixed(4));
									$('#lbrez3').append('<input type="hidden" name="rez3" value="' + workCapacitance.toFixed(4) + '">');
									$('#lbrez4').html(launchCapacitance.toFixed(4));
									$('#lbrez4').append('<input type="hidden" name="rez4" value="' + launchCapacitance.toFixed(4) + '">');
									return false;
								}
								
								function CapacitanceClear() {
									$('#lbpower1').val("");
									$('#lbvoltage1').val("");
									$('#lbcosf1').val("");
									$('#effengine1').val("");
									$('#lbrez3').html("");
									$('#lbrez4').html("");
									$('input:radio[name=motor_winding]#rad14').iCheck('uncheck');
									$('input:radio[name=motor_winding]#rad15').iCheck('uncheck');		
									return false;
								}
							</script>
						</div>
						<div class="tab-pane" id="panel-359127">
							<form id="earthingform" class="topdf-form" action="to_pdf.php?form=earthing" method="post" >
								<input type="hidden" name="pageTitle" value="Расчет сопротивления системы заземления">
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 30px; padding-bottom: 15px;">
									<div class="col-md-12">
										<img alt="zaz.png" src="img/zaz.png" style="border: 1px solid #cecece; width: 1000px; /*margin-left: -10px;*/">
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-5">
										<label class="control-label red_text">Верхний слой грунта:</label>
									</div>
									<div class="col-md-7">
										<select class="selectpicker" id="selpuplay" name="selpuplay" style="width: 450px !important;  height: 40px !important;">
											<option value="novalue" selected="">Выберите...</option>
											<option value="60">Песок сильно увлажненый (60)</option>
											<option value="130">Песок умеренно увлажненный (130)</option>
											<option value="400">Песок влажный (400)</option>
											<option value="1500">Песок слегка влажный (1500)</option>
											<option value="4200">Песок сухой (4200)</option>
											<option value="1000">Песчанник (1000)</option>
											<option value="300">Супесок (300)</option>
											<option value="1500">Супесь влажная (1500)</option>
											<option value="60">Сугланик сильно увлажненный (60)</option>
											<option value="100">Суглинок полутвердый лессовидный (100)</option>
											<option value="190">Суглинок промерзший слой (190)</option>
											<option value="60">Глина (при t&gt;0) (60)</option>
											<option value="50">Торф (при t=0) (50)</option>
											<option value="40">Торф (при t&gt;0) (40)</option>
											<option value="25">Солончаковые почвы (t&gt;0) (25)</option>
											<option value="5000">Щебень сухой (5000)</option>
											<option value="3000">Щебень мокрый (3000)</option>
											<option value="5500">Дресва (t&gt;0) (5500)</option>
											<option value="40">Садовая земля (40)</option>
											<option value="50">Чернозем (50)</option>
											<option value="1000">Речная вода (1000)</option>
											<option value="22500">Гранитное основание (t&gt;0) (22500)</option>
										  </select>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-5">
										<label class="control-label red_text">Нижний слой грунта:</label>
									</div>
									<div class="col-md-7">
										<select class="selectpicker" id="selpdownlay" name="selpdownlay" style="width: 450px !important; height: 40px !important;">
											<option value="novalue" selected="">Выберите...</option>
											<option value="60">Песок сильно увлажненый (60)</option>
											<option value="130">Песок умеренно увлажненный (130)</option>
											<option value="400">Песок влажный (400)</option>
											<option value="1500">Песок слегка влажный (1500)</option>
											<option value="4200">Песок сухой (4200)</option>
											<option value="1000">Песчанник (1000)</option>
											<option value="300">Супесок (300)</option>
											<option value="1500">Супесь влажная (1500)</option>
											<option value="60">Сугланик сильно увлажненный (60)</option>
											<option value="100">Суглинок полутвердый лессовидный (100)</option>
											<option value="190">Суглинок промерзший слой (190)</option>
											<option value="60">Глина (при t&gt;0) (60)</option>
											<option value="50">Торф (при t=0) (50)</option>
											<option value="40">Торф (при t&gt;0) (40)</option>
											<option value="25">Солончаковые почвы (t&gt;0) (25)</option>
											<option value="5000">Щебень сухой (5000)</option>
											<option value="3000">Щебень мокрый (3000)</option>
											<option value="5500">Дресва (t&gt;0) (5500)</option>
											<option value="40">Садовая земля (40)</option>
											<option value="50">Чернозем (50)</option>
											<option value="1000">Речная вода (1000)</option>
											<option value="22500">Гранитное основание (t&gt;0) (22500)</option>
										  </select>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-5">
										<label class="control-label red_text">Количество вертикальных<br> заземлителей, шт:</label>
									</div>
									<div class="col-md-7">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="earthing" id="rad16" value="1"><br>
													<label for="rad16" class="black_text" style="padding-left: 5px; margin-top: 10px">1</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad17" value="2"><br>
													<label for="rad17" class="black_text" style="padding-left: 5px; margin-top: 10px">2</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad18" value="3"><br>
													<label for="rad18" class="black_text" style="padding-left: 5px; margin-top: 10px">3</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad19" value="4"><br>
													<label for="rad19" class="black_text" style="padding-left: 5px; margin-top: 10px">4</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad20" value="5"><br>
													<label for="rad20" class="black_text" style="padding-left: 5px; margin-top: 10px">5</label>
												</div>
											
										
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="earthing" id="rad21" value="6"><br>
													<label for="rad21" class="black_text" style="padding-left: 5px; margin-top: 10px">6</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad22" value="7"><br>
													<label for="rad22" class="black_text" style="padding-left: 5px; margin-top: 10px">7</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad23" value="8"><br>
													<label for="rad23" class="black_text" style="padding-left: 5px; margin-top: 10px">8</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="earthing" id="rad24" value="9"><br>
													<label for="rad24" class="black_text" style="padding-left: 5px; margin-top: 10px">9</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad25" value="10"><br>
													<label for="rad25" class="black_text" style="padding-left: 3px; margin-top: 10px">10</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad26" value="11"><br>
													<label for="rad26" class="black_text" style="padding-left: 3px; margin-top: 10px">11</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad27" value="12"><br>
													<label for="rad27" class="black_text" style="padding-left: 3px; margin-top: 10px">12</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad28" value="13"><br>
													<label for="rad28" class="black_text" style="padding-left: 3px; margin-top: 10px">13</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad29" value="14"><br>
													<label for="rad29" class="black_text" style="padding-left: 3px; margin-top: 10px">14</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="earthing" id="rad30" value="15"><br>
													<label for="rad30" class="black_text" style="padding-left: 3px; margin-top: 10px">15</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Климатический коэффициент:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;" title="Архангельская, Мурманская, Вологодская, Кировская, Пермская, Свердловская, Сахалинская, Камчатская и Магаданская области, северная половина Западной и Восточной Сибири и Республика Коми, северная часть Хабаровского края и восточная часть Приморского края">
													<input type="radio" name="climzone" id="rad31" value="1">
													<label for="rad31" class="black_text" style="padding-left: 30px; margin-top: 10px">Климатическая зона 1 (вертикальный: 1,9; горизонтальный: 5,75)</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;" title="Республика Карелия, Ленинградская, Новгородская, Псковская области, южная часть Хабаровского и западная часть Приморского краев">
													<input type="radio" name="climzone" id="rad32" value="2">
													<label for="rad32" class="black_text" style="padding-left: 30px; margin-top: 10px">Климатическая зона 2 (вертикальный: 1,65; горизонтальный: 4)</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;" title="Смоленская, Калининградская, Московская, Калининская, Орловская, Тульская, Рязанская, Ивановская, Ярославская, Горьковская, Брянская, Челябинская, Владимирская, Калужская, Костромская, Амурская области, южная часть Западной и Восточной Сибири, Республика Чувашия, Республика Мордовия, Республика Марий Эл, Республика Татарстан, Республика Башкирия и Республика Удмуртия">
													<input type="radio" name="climzone" id="rad33" value="3">
													<label for="rad33" class="black_text" style="padding-left: 30px; margin-top: 10px">Климатическая зона 3 (вертикальный: 1,5; горизонтальный: 2,25)</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;" title="Курская, Астраханская, Куйбышевская, Саратовская, Волгоградская, Оренбургская, Воронежская, Тамбовская, Пензенская, Ростовская, Ульяновская области, Краснодарский край, Северный Кавказ и Закавказье">
													<input type="radio" name="climzone" id="rad34" value="4">
													<label for="rad34" class="black_text" style="padding-left: 30px; margin-top: 10px">Климатическая зона 4 (вертикальный: 1,3; горизонтальный: 1,75)</label>
												</div><br>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-5"><label class="control-label red_text">Глубина верхнего слоя грунта (H), м:</label></div>
									<div class="col-md-7"><input type="text" id="lbtoplayerdeep" name="toplayerdeep" value=""></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-5"><label class="control-label red_text">Длина вертикального заземлителя (L1), м:</label></div>
									<div class="col-md-7"><input type="text" id="lbvertearthinglen" name="vertearthinglen" value=""></div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-5"><label class="control-label red_text">Диаметр вертикального заземлителя (D), м:</label></div>
									<div class="col-md-7"><input type="text" id="lbvertearthingdiam" name="vertearthingdiam" value=""></div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-5"><label class="control-label red_text">Глубина горизонтального заземлителя (h2), м:</label></div>
									<div class="col-md-7"><input type="text" id="lbhorearthinghalfheight" name="horearthinghalfheight" value=""></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-5"><label class="control-label red_text">Ширина полки горизонтального заземлителя (b), м:</label></div>
									<div class="col-md-7"><input type="text" id="lbhorearthingshelfwidth"  name="horearthingshelfwidth" value=""></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-5"><label class="control-label red_text">Длина соединительной полосы до ввода в здание (L3), м:</label></div>
									<div class="col-md-7"><input type="text" id="lbconnectstriplen" name="connectstriplen" value=""></div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-12">
										<button class="btn btn_calc" id="btncalc3" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать</button>
										<button class="btn btn_reset" id="btnclear3" style="margin-left:15px; display: inline-block;">Сброс</button>
									</div>								
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-12">
										<label class="control-label red_text" style="margin-top:8px;">Удельное электрическое сопротивление грунта, Ом*м<sup>2</sup>:</label>
										<label class="control-label rez_text" id="lbrez5" style="margin-left: 20px;">
									</label></div>
								</div>
								<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
									<div class="col-md-12">
										<label class="control-label red_text" style="margin-top:8px;">Сопротивление одиночного вертикального  заземлителя, Ом:</label>
										<label class="control-label rez_text" id="lbrez6" style="margin-left: 20px;">
									</label></div>
								</div>
								<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
									<div class="col-md-12">
										<label class="control-label red_text" style="margin-top:8px;">Сопротивление горизонтального заземлителя, Ом:</label>
										<label class="control-label rez_text" id="lbrez7" style="margin-left: 20px;">
									</label></div>
								</div>
								<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
									<div class="col-md-12">
										<label class="control-label red_text" style="margin-top:8px;">Длина горизонтального заземлителя, м:</label>
										<label class="control-label rez_text" id="lbrez8" style="margin-left: 20px;">
									</div>
								</div>
								<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
									<div class="col-md-12">
										<label class="control-label red_text" style="margin-top:8px;">Общее сопротивление растекания электрического тока, Ом:</label>
										<label class="control-label rez_text" id="lbrez9" style="margin-left: 20px;"></label>
									</div>
								</div>
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
							<script>
								$('#earthingform').submit(function(event) {
								    // Предотвращаем обычную отправку формы
								    event.preventDefault();
								
									var formData = $('#earthingform').serializeArray();
									formData.push({name: 'ajax',value: true});
									formData.push({name: 'selpuplay_html',value: $('#selpuplay option:selected').html()});
									formData.push({name: 'selpdownlay_html',value: $('#selpdownlay option:selected').html()});
									formData.push({name: 'rez5',value: $('#lbrez5').html()});
									formData.push({name: 'rez6',value: $('#lbrez6').html()});
									formData.push({name: 'rez7',value: $('#lbrez7').html()});
									formData.push({name: 'rez8',value: $('#lbrez8').html()});
									formData.push({name: 'rez9',value: $('#lbrez9').html()});
								    $.post(	'to_pdf.php?form=earthing', 
											formData,
								            function(data) {
												window.location = '/../' + data;
								            });/**/
							    });
								
								$('#btncalc3').click(function(){
									EarthingCalc();
									return false;
								});
								
								$('#btnclear3').click(function(){
									EarthingClear();
									return false;
								});
								
								function EarthingCalc() {
									var p1 = $('#selpuplay').val().replace(',','.');
									var p2 = $('#selpdownlay').val().replace(',','.');
									//var k1 = $('input:radio[name=climzone] > option:checked').val();
									var n = $('.checked > input:radio[name=earthing]').val();
									var klimZone = $('.checked > input:radio[name=climzone]').val();
									var H  = $('#lbtoplayerdeep').val().replace(',','.');
									var L1 = $('#lbvertearthinglen').val().replace(',','.');
									var D = $('#lbvertearthingdiam').val().replace(',','.');
									//var h1 = $('#lbvertearthinghalfheight').val().replace(',','.');
									var h2 = $('#lbhorearthinghalfheight').val().replace(',','.');		
									var b = $('#lbhorearthingshelfwidth').val().replace(',','.');
									//var L2 = $('#lbhorearthinglen').val().replace(',','.');
									var L3 = $('#lbconnectstriplen').val().replace(',','.');		
									//var electrinst = $('.checked > input:radio[name=electrinst]').val();
									//alert(p1 + " " + p2 + " " + k1 + " " + L1 + " " + H + " " + h2);
									
									if( !parseFloat(p1) 	||
										!parseFloat(p2) 	||
										!parseFloat(n) 		||
										!parseFloat(klimZone) 	||
										!parseFloat(H) 		||
										!parseFloat(L1) 	||
										!parseFloat(D) 		||
										//!parseFloat(h1) 	||
										!parseFloat(h2) 	||			
										!parseFloat(b) 		||
										//!parseFloat(L2)		||
										!parseFloat(L3)		/*||
										['row', 'contour'].indexOf(electrinst) === -1)*/
									){
										$('#lbrez5').html("");
										$('#lbrez6').html("");
										$('#lbrez7').html("");
										//$('#lbrez8').html("");
										$('#lbrez9').html("");
										alert('Заполните все поля.');
										return;
									}
									
									var errString = "";		
									
									if( H <= 0 ){ errString += 'Глубина верхнего слоя грунта (H)\n';}
									if( L1 <= 0 ){ errString += 'Длина вертикального заземлителя (L1)\n';}
									if( D <= 0 ){ errString += 'Диаметр вертикального заземлителя (D)\n';}
									//if( h1 <= 0 ){ errString += 'Расстояние от середины вертикального заземлителя до поверхности земли (h1)\n';}
									if( h2 <= 0 ){ errString += 'Глубина горизонтального заземлителя (h2)\n';}
									if( b <= 0 ){ errString += 'Ширина полки горизонтального заземлителя (b)\n';}
									//if( L2 <= 0 ){ errString += 'Длина горизонтального заземлителя (L2)\n';}
									if( L3 <= 0 ){ errString += 'Длина соединительной полосы до ввода в здание (L3)\n';}
									
									if( errString != "" ){
										errString = 'Следующие значения должны быть больше 0:\n' + errString;
										alert(errString);
										$('#lbrez5').html("");
										$('#lbrez6').html("");
										$('#lbrez7').html("");
										//$('#lbrez8').html("");
										$('#lbrez9').html("");
										return;
									}
									
									var k1, k2;
									switch(klimZone){
										case '1':
											k1 = 1.9; k2 = 5.75;
											break;
										case '2':
											k1 = 1.65; k2 = 4;
											break;
										case '3':
											k1 = 1.5; k2 = 2.25;
											break;
										case '4':
											k1 = 1.3; k2 = 1.75;
											break;
									}
									
									e1 = n;
									var vertunitsvalue = "";
									{
										if (e1 == 1) vertunitsvalue = 1;
										if (e1 == 2) vertunitsvalue = 1.68;  
										if (e1 == 3) vertunitsvalue = 2.28;
										if (e1 == 4) vertunitsvalue = 2.84;
										if (e1 == 5) vertunitsvalue = 3.35;
										if (e1 == 6) vertunitsvalue = 3.9;  
										if (e1 == 7) vertunitsvalue = 4.41;
										if (e1 == 8) vertunitsvalue = 4.88;
										if (e1 == 9) vertunitsvalue = 5.31;
										if (e1 == 10) vertunitsvalue = 5.7;  
										if (e1 == 11) vertunitsvalue = 6.16;
										if (e1 == 12) vertunitsvalue = 6.6;
										if (e1 == 13) vertunitsvalue = 7.02;
										if (e1 == 14) vertunitsvalue = 7.42;  
										if (e1 == 15) vertunitsvalue = 7.8;
										if (e1 == 16) vertunitsvalue = 8.16;
										if (e1 == 17) vertunitsvalue = 8.5;
										if (e1 == 18) vertunitsvalue = 8.82;  
										if (e1 == 19) vertunitsvalue = 9.12;
										if (e1 == 20) vertunitsvalue = 9.4;
									}
									var L2 = (L1 * (e1 - 1)) - (-L3); // длина горизонт. заземлителя
									//var p = ( p1 * k1 * p2 * L1 ) / ( p1 * k1 * ( L1 - H + h2 ) + p2 * ( H - h2 ) );
									var p = (p1 * k1 * p2 * L1) / (((p1 * k1) * (L1 - H - (-h2))) + (p2 * (H - h2))); //удельное электрическое сопротивление грунта
									var m = p / (2 * Math.PI * L1);
									var m1 = p * k2 / (Math.PI * L2);
									var r = Math.log((2 * L1) / D);
									var n = Math.log(((4 * ((L1 / 2) - (-h2))) - (-L1)) / ((4 * ((L1 / 2) - (-h2))) - L1));
									var s = Math.log(L2 / Math.sqrt(b * h2));
									
									var resist_ud = p;						// удельное электрическое сопротивление грунта
									var resist_vert = m * (r + (n / 2));	// сопротивление одного верт. заземлителя
									var dlina_gor = L2;						// длина горизонт. заземлителя
									var resist_gor = m1 * s;				// сопротивление горизонт. заземлителя
									var resist = ((resist_vert / vertunitsvalue) * resist_gor) / ((resist_vert / vertunitsvalue) + resist_gor);//Общее сопроитивление растекания электрического тока
									
									$('#lbrez5').html(resist_ud.toFixed(2)); //Удельное электрическое сопротивление грунта
									$('#lbrez6').html(resist_vert.toFixed(2)); //Сопротивление одиночного вертикального заземлителя
									$('#lbrez8').html(dlina_gor.toFixed(2));// длина горизонт. заземлителя
									$('#lbrez7').html(resist_gor.toFixed(2)); //Сопротивление горизонтального заземлителя
									$('#lbrez9').html(resist.toFixed(2)); //Общее сопроитивление растекания электрического тока
								}
								
								function EarthingClear() {
									$("#selpuplay :first").prop('selected',true);
									$("#selpdownlay :first").prop('selected',true);
									$('input:radio[name=earthing]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=climzone]').each(function(){$(this).iCheck('uncheck');});
									$('#lbtoplayerdeep').val("");
									$('#lbvertearthinglen').val("");
									$('#lbvertearthingdiam').val("");
									$('#lbhorearthinglen').val("");
									$('#lbhorearthingshelfwidth').val("");
									$('#lbconnectstriplen').val("");
									$('#lbhorearthinghalfheight').val("");
									$('#lbvertearthinghalfheight').val("");
									$('input:radio[name=electrinst]').each(function(){$(this).iCheck('uncheck');});
									$('#lbrez5').html("");
									$('#lbrez6').html("");
									$('#lbrez7').html("");
									$('#lbrez8').html("");
									$('#lbrez9').html("");
								}
							</script>
						</div>
						<div class="tab-pane" id="panel-359128">
							<form class="topdf-form" action="to_pdf.php?form=current_in_circuit" method="post">
								<input type="hidden" name="pageTitle" value="Расчет тока в цепи">
								<br>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Выбор питающей сети:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="chaintype" id="rad37" value="1">
													<label for="rad37" class="black_text" style="padding-left: 30px; margin-top: 10px">1-фазная</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="chaintype" id="rad38" value="3">
													<label for="rad38" class="black_text" style="padding-left: 30px; margin-top: 10px">3х-фазная</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Характеристика нагрузки:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="loadfeature" id="rad39" value="1">
													<label for="rad39" class="black_text" style="padding-left: 30px; margin-top: 10px">Активная</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="loadfeature" id="rad40" value="2">
													<label for="rad40" class="black_text" style="padding-left: 30px; margin-top: 10px">Реактивная</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-4"><label class="control-label red_text">Мощность нагрузки, Вт:</label></div>
									<div class="col-md-8"><input type="text" id="lbloadpower" name="loadpower" value=""></div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-4"><label class="control-label red_text">Фактическое напряжение в сети, В:</label></div>
									<div class="col-md-8"><input type="text" id="factvoltage" name="factvoltage" value=""></div>
								</div>							
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-4"><label class="control-label red_text">Коэффициент мощности, cosϕ:</label></div>
									<div class="col-md-8"><input type="text" id="lbcosf2" name="cosf2" value=""></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-6">
										<button class="btn btn_calc" id="btncalc4" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать</button>
										<button class="btn btn_reset" id="btnclear4" style="margin-left:15px; display: inline-block;">Сброс</button>
									</div>								
								</div>
								<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
									<div class="col-md-6">
										<label class="control-label red_text" style="margin-top:8px;">Сила тока в цепи, А:</label>
										<label class="control-label rez_text" id="lbrez10" name="rez10" style="margin-left: 20px;"></label>
									</div>
								</div>
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
							<script>
								$('input:radio[name=loadfeature]').on('ifChecked',function(){
															switch($(this).attr('id')){
																case 'rad39':
																	$('#lbcosf2').val('0,95');
																	break;
																case 'rad40':
																	$('#lbcosf2').val('0,8');
																	break;
															}															
														});
								$('#btnclear4').click(function(){CurrentInCircuitClear();});
								$('#btncalc4').click(function(){CurrentInCircuitCalc();});
								
								function CurrentInCircuitClear(){
									$('input:radio[name=chaintype]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=loadfeature]').each(function(){$(this).iCheck('uncheck');});
									$('#lbloadpower').val("");
									$('#factvoltage').val("");
									$('#lbcosf2').val("");
									$('#lbrez10').html("");
									return false;
								}
								
								function CurrentInCircuitCalc(){
									var chainType = $('.checked > input:radio[name=chaintype]').val();
									var loadFeatureType = $('.checked > input:radio[name=loadfeature]').val();
									var loadPower = $('#lbloadpower').val().replace(',','.');
									var factVoltage = $('#factvoltage').val().replace(',','.');
									var cosf = $('#lbcosf2').val().replace(',','.');
									
									if( !parseFloat(chainType) ||
										!parseFloat(loadFeatureType) ||
										!parseFloat(loadPower) ||
										!parseFloat(factVoltage) ||
										!parseFloat(cosf)
									){
										$('#lbrez2').html('');
										alert('Заполните все поля.');
										return;
									}
									var I;
									switch(chainType){
										case '1':
											I = loadPower / (factVoltage * cosf);
											$('#lbrez10').html(I.toFixed(2));
											$('#lbrez10').append('<input type="hidden" name="rez10" value="' + I.toFixed(2) + '">');
											break;
										case '3':
											I = loadPower / (1.73 * factVoltage * cosf);
											$('#lbrez10').html(I.toFixed(2));
											$('#lbrez10').append('<input type="hidden" name="rez10" value="' + I.toFixed(2) + '">');
											break;
									}
									return false;
								}
							</script>
						</div>
						<div class="tab-pane" id="panel-359129">
							<br>
							<form class="topdf-form" action="to_pdf.php?form=voltage_drop" method="post">
								<input type="hidden" name="pageTitle" value="Расчет падения напряжения в линии">
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Выбор питающей сети:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="voltagetype" id="rad41" value="1">
													<label for="rad41" class="black_text" style="padding-left: 30px; margin-top: 10px">Фазного напряжения (фаза-ноль)</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="voltagetype" id="rad42" value="2">
													<label for="rad42" class="black_text" style="padding-left: 30px; margin-top: 10px">Линейного напряжения (фаза-фаза)</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-4"><label class="control-label red_text">Напряжение в линии, В:</label></div>
									<div class="col-md-8"><input type="text" id="voltage" name="voltage" value=""></div>
								</div>	
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Тип линии:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="linetype" id="rad43" value="1">
													<label for="rad43" class="black_text" style="padding-left: 30px; margin-top: 10px">Кабельная линия</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="linetype" id="rad44" value="2">
													<label for="rad44" class="black_text" style="padding-left: 30px; margin-top: 10px">Воздушная линия</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Провод:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="whire1" id="rad45" value="1">
													<label for="rad45" class="black_text" style="padding-left: 30px; margin-top: 10px">Медный</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="whire1" id="rad46" value="1.58">
													<label for="rad46" class="black_text" style="padding-left: 30px; margin-top: 10px">Алюминиевый</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Сечение жил провода, мм<sup>2</sup>:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="wirecross" id="rad47" value="0.034400"><br>
													<label for="rad47" class="black_text" style="margin-top: 10px">0.5</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad48" value="0.025800"><br>
													<label for="rad78" class="black_text" style="padding-left: 5px; margin-top: 10px">0.75</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad48" value="0.017200"><br>
													<label for="rad48" class="black_text" style="padding-left: 5px; margin-top: 10px">1</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad49" value="0.011467"><br>
													<label for="rad49" class="black_text" style="margin-top: 10px">1.5</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad50" value="0.006880"><br>
													<label for="rad50" class="black_text" style="margin-top: 10px">2.5</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad51" value="0.004300"><br>
													<label for="rad51" class="black_text" style="padding-left: 5px; margin-top: 10px">4</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad52" value="0.002867"><br>
													<label for="rad52" class="black_text" style="padding-left: 5px; margin-top: 10px">6</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad53" value="0.001720"><br>
													<label for="rad22" class="black_text" style="margin-top: 10px">10</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="wirecross" id="rad23" value="0.001075"><br>
													<label for="rad53" class="black_text" style="margin-top: 10px">16</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad54" value="0.000688"><br>
													<label for="rad54" class="black_text" style="margin-top: 10px">25</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad55" value="0.000491"><br>
													<label for="rad55" class="black_text" style="margin-top: 10px">35</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad56" value="0.000344"><br>
													<label for="rad56" class="black_text" style="margin-top: 10px">50</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad57" value="0.000246"><br>
													<label for="rad57" class="black_text" style="margin-top: 10px">70</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad58" value="0.000181"><br>
													<label for="rad58" class="black_text" style="margin-top: 10px">95</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="wirecross" id="rad59" value="0.000143"><br>
													<label for="rad59" class="black_text" style="margin-top: 10px">120</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-4"><label class="control-label red_text">Мощность нагрузки, Вт:</label></div>
									<div class="col-md-8"><input type="text" id="lbloadpower1" name="loadpower1" value=""></div>
								</div>							
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-4"><label class="control-label red_text">Коэффициент мощности, cosϕ:</label></div>
									<div class="col-md-8"><input type="text" id="lbcosf3" name="cosf3" value="0,95"></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-4"><label class="control-label red_text">Длина линии, м:</label></div>
									<div class="col-md-8"><input type="text" id="lblinelen" name="linelen"></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;">
									<div class="col-md-4"><label class="control-label red_text">Температура линии, С<sup>O</sup>:</label></div>
									<div class="col-md-8"><input type="text" id="lblinetemp" name="linetemp" value="20"></div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-6">
										<button class="btn btn_calc" id="btncalc5" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать</button>
										<button class="btn btn_reset" id="btnclear5" style="margin-left:15px; display: inline-block;">Сброс</button>
									</div>								
								</div>
								<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
									<div class="col-md-6">
										<label class="control-label red_text" style="margin-top:8px;">Падение напряжения в линиии, В:</label>
										<label class="control-label rez_text" id="lbrez11" style="margin-left: 20px;">
									</label></div>
								</div>
								<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
									<div class="col-md-6">
										<label class="control-label red_text" style="margin-top:8px;">Падение напряжения в линиии, %:</label>
										<label class="control-label rez_text" id="lbrez12" style="margin-left: 20px;">
									</label></div>
								</div>
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
							<script>
								$('input:radio[name=linetype]#rad43').iCheck('check');
								$('input:radio[name=linetype]#rad43').iCheck('disable');
								$('input:radio[name=linetype]#rad44').iCheck('disable');
								$('input:radio[name=voltagetype]').on('ifChecked',function(){
																					var vtype = $(this).val();
																					if(vtype == '1')	
																						$('#voltage').val(380);
																					if(vtype == '2')															
																						$('#voltage').val(220);
																				});
								function VoltageDropCalc(){
									var voltageType = $('.checked > input:radio[name=voltagetype]').val();
									var voltage = $('#voltage').val().replace(',','.');
									var lineType = $('.checked > input:radio[name=linetype]').val();
									var wireType = $('.checked > input:radio[name=whire1]').val();		
									var wireCross = $('.checked > input:radio[name=wirecross]').val();
									var loadPower = $('#lbloadpower1').val().replace(',','.');
									var cosf = $('#lbcosf3').val().replace(',','.');	
									var lineLen = $('#lblinelen').val().replace(',','.');
									var lineTemp = $('#lblinetemp').val().replace(',','.');	
									
									if( !parseFloat(voltageType) ||
										!parseFloat(voltage) 	 ||
										!parseFloat(lineType) 	 ||
										!parseFloat(wireType) 	 ||
										!parseFloat(wireCross) 	 ||
										!parseFloat(loadPower) 	 ||
										!parseFloat(cosf) 		 ||
										!parseFloat(lineLen) 	 ||
										!parseFloat(lineTemp) 
									){
										$('#lbrez11').html("");
										$('#lbrez12').html("");
										alert('Заполните все поля.');
										return;
									}
									if ((cosf > 1) || (cosf < -1) || (isNaN(cosf))){
										$('#lbrez11').html("");
										$('#lbrez12').html("");
										alert('Коэффициент мощности должен находиться в пределе от -1 до 1.');
										return;
									}
									//
									var q = (loadPower * Math.pow((1 - Math.pow(cosf, 2)), 0.5)) / cosf; //реактивная мощность
									var x = "";
									var sm = "";
									var sa = "";
									{
										if (wireCross == 0.034400) x = 0.000133, sm = 11, sa = 6; //акт. сопр., реакт. сопр., макс. ток медь/алюминий
										if (wireCross == 0.025800) x = 0.000123, sm = 15, sa = 9;
										if (wireCross == 0.017200) x = 0.000114, sm = 18, sa = 11;
										if (wireCross == 0.011467) x = 0.000107, sm = 23, sa = 14;
										if (wireCross == 0.006880) x = 0.000099, sm = 40, sa = 24;
										if (wireCross == 0.004300) x = 0.000098, sm = 50, sa = 32;
										if (wireCross == 0.002867) x = 0.000093, sm = 65, sa = 39;
										if (wireCross == 0.001720) x = 0.000087, sm = 90, sa = 60;
										if (wireCross == 0.001075) x = 0.000082, sm = 120, sa = 75;
										if (wireCross == 0.000688) x = 0.000081, sm = 160, sa = 105;
										if (wireCross == 0.000491) x = 0.000078, sm = 190, sa = 130;
										if (wireCross == 0.000344) x = 0.000077, sm = 235, sa = 165;
										if (wireCross == 0.000246) x = 0.000075, sm = 290, sa = 210;
										if (wireCross == 0.000181) x = 0.000074, sm = 330, sa = 255;
										if (wireCross == 0.000143) x = 0.000072, sm = 385, sa = 295;
									}
									var tks = "";
									{
										if (wireType == 1) tks = 0.00428;
										if (wireType == 1.58) tks = 0.0038;
									}
									var rl = wireCross * lineLen * wireType * (1 + (tks * (lineTemp - 20))); //акт. сопр. провода
									var rq = x * lineLen; //реакт. сопр. провода
									
									if ((Math.pow(voltage, 2) / (2 * rl)) < loadPower){
										alert('Максимальная мощность в данном случае, с учётом сопротивления кабеля не может превышать ' + (Math.round(Math.pow(voltage, 2) / (2 * rl))) + ' Вт.');
										$('#lbrez11').html("");
										$('#lbrez12').html("");
										return;
									}
									
									var result = voltageType*(((loadPower * rl) + (q * rq)) / voltage);
									var result_1 = result / (voltage / 100);


									$('#lbrez11').html(result.toFixed(2));
									$('#lbrez11').append('<input type="hidden" name="rez11" value="' + result.toFixed(2) + '">');
									$('#lbrez12').html(result_1.toFixed(2));
									$('#lbrez12').append('<input type="hidden" name="rez12" value="' + result_1.toFixed(2) + '">');
								}
								
								function VoltageDropClear(){
									$('input:radio[name=voltagetype]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=linetype]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=whire1]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=wirecross]').each(function(){$(this).iCheck('uncheck');});
									$('#lbloadpower1').val("");
									$('#lbcosf3').val("0,95");
									$('#lblinelen').val("");
									$('#lblinetemp').val("20");
									$('#lbrez11').html("");
									$('#lbrez12').html("");
								}
								$('#btnclear5').click(function(){VoltageDropClear();return false;});
								$('#btncalc5').click(function(){VoltageDropCalc();return false;});
							</script>
						</div>
						<div class="tab-pane" id="panel-359130">
							<br>
							<form class="topdf-form" action="to_pdf.php?form=box_occupancy" method="post">
								<input type="hidden" name="pageTitle" value="Определение сечения провода по его диаметру">
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Тип короба:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="boxtype" id="rad60" value="1">
													<label for="rad60" class="black_text" style="padding-left: 30px; margin-top: 10px">Короб с открываемой крышкой</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="boxtype" id="rad61" value="2">
													<label for="rad61" class="black_text" style="padding-left: 30px; margin-top: 10px">Короб глухой</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Размеры кабельного канала:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="boxsize" id="rad62" value="1"><br>
													<label for="rad62" class="black_text" style="margin-top: 10px">12*15</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad63" value="2"><br>
													<label for="rad63" class="black_text" style="margin-top: 10px">15*10</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad64" value="3"><br>
													<label for="rad64" class="black_text" style="margin-top: 10px">16*16</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad65" value="4"><br>
													<label for="rad65" class="black_text" style="margin-top: 10px">20*10</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad66" value="5"><br>
													<label for="rad66" class="black_text" style="margin-top: 10px">25*16</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad67" value="6"><br>
													<label for="rad67" class="black_text" style="margin-top: 10px">25*25</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad68" value="7"><br>
													<label for="rad68" class="black_text" style="margin-top: 10px">40*16</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="boxsize" id="rad69" value="8"><br>
													<label for="rad69" class="black_text" style="margin-top: 10px">40*40</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad70" value="9"><br>
													<label for="rad70" class="black_text" style="margin-top: 10px">60*40</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad71" value="10"><br>
													<label for="rad71" class="black_text" style="margin-top: 10px">60*60</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad72" value="11"><br>
													<label for="rad72" class="black_text" style="margin-top: 10px">80*40</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad73" value="12"><br>
													<label for="rad73" class="black_text" style="margin-top: 10px">80*60</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad74" value="13"><br>
													<label for="rad74" class="black_text" style="margin-top: 10px">100*40</label>
												</div><!--
											 --><div style="display: inline-block; margin-left: 30px;">
													<input type="radio" name="boxsize" id="rad75" value="14"><br>
													<label for="rad75" class="black_text" style="margin-top: 10px">100*60</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-4">
										<label class="control-label red_text">Тип кабеля:</label>
									</div>
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="cabletype" id="rad76" value="flat">
													<label for="rad76" class="black_text" style="padding-left: 30px; margin-top: 10px">Плоский</label>
												</div><br>
												<div style="display: inline-block; margin-left: 10px;">
													<input type="radio" name="cabletype" id="rad77" value="round">
													<label for="rad77" class="black_text" style="padding-left: 30px; margin-top: 10px">Круглый</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;" id="flatcable1">
									<div class="col-md-4"><label class="control-label red_text">Ширина внешней изоляции, мм:</label></div>
									<div class="col-md-8"><input type="text" id="lbinsulationwidth" name="insulationwidth"></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;" id="flatcable2">
									<div class="col-md-4"><label class="control-label red_text">Высота внешней изоляции, мм:</label></div>
									<div class="col-md-8"><input type="text" id="lbinsulationheight" name="insulationheight"></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px; border-bottom: 1px solid #cecece;" id="roundcable">
									<div class="col-md-4"><label class="control-label red_text">Диаметр внешней изоляции, мм:</label></div>
									<div class="col-md-8"><input type="text" id="lbinsulationdiam" name="insulationdiam"></div>
								</div>	
								<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-6">
										<button class="btn btn_calc" id="btncalc6" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать</button>
										<button class="btn btn_reset" id="btnclear6" style="margin-left:15px; display: inline-block;">Сброс</button>
									</div>								
								</div>
								<div class="row" style="padding-top: 5px; padding-bottom: 15px;">
									<div class="col-md-12">
										<label class="control-label red_text" style="margin-top:8px;">Заполняемость канала:</label>
										<label class="control-label rez_text" id="lbrez13" style="margin-left: 20px;"></label>
									</div>
								</div>
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
							<script>
								$('#roundcable').hide();
								$('#flatcable1').hide();
								$('#flatcable2').hide();
								$('input:radio[name=cabletype]').on('ifChecked',function(){
														var ctype = $(this).val();
														if(ctype == 'flat'){
															$('#flatcable1').show();
															$('#flatcable2').show();
															$('#roundcable').hide();
														}
														if(ctype == 'round'){															
															$('#flatcable1').hide();
															$('#flatcable2').hide();
															$('#roundcable').show();
														}	
													});
								function BoxOccupancyCalc(){
									var boxType = $('.checked > input:radio[name=boxtype]').val();
									var boxSize = $('.checked > input:radio[name=boxsize]').val();
									var cableType = $('.checked > input:radio[name=cabletype]').val();
									var insulationDiam = $('#lbinsulationdiam').val().replace(',','.');
									var insulationWidth = $('#lbinsulationwidth').val().replace(',','.');
									var insulationHeight = $('#lbinsulationheight').val().replace(',','.');
									if( !parseFloat(boxType) ||
										!parseFloat(boxSize) ||
										(['flat', 'round'].indexOf(cableType) === -1)
									){
										$('#lbrez13').html('');
										$('#lbrez14').html('');
										alert('Заполните все поля.');
										return;
									}
									
									switch(cableType){
										case 'flat':
											if( !parseFloat(insulationWidth) ||
												!parseFloat(insulationHeight) ){
													$('#lbrez13').html('');
													$('#lbrez14').html('');
													alert('Заполните все поля.');
													return;
												}
											break;
										case 'round':
											if( !parseFloat(insulationDiam) ){
													$('#lbrez13').html('');
													$('#lbrez14').html('');
													alert('Заполните все поля.');
													return;
												}
											break;
									}
									var s;
									var rez;
									if( boxType == 1 ){
										switch(boxSize){
											case '1':
												s = ( 12 * 15 ) - ( 12 * 15 )  * 0.4;  
											break;
											case '2': 
												s = ( 15 * 10 ) - ( 15 * 10 ) * 0.4;
											break;
											case '3':
												s = ( 16 * 16 ) - ( 16 * 16 ) * 0.4;
											break;
											case '4':
												s = ( 20 * 10 ) - ( 20 * 10 ) * 0.4;
											break;
											case '5':
												s = ( 25 * 16 ) - ( 25 * 16 ) * 0.4;
											break;
											case '6':
												s = ( 25 * 25 ) - ( 25 * 25 ) * 0.4;
											break;
											case '7':
												s = ( 40 * 16 ) - ( 40 * 16 ) * 0.4;
											break;
											case '8':
												s = ( 40 * 40 ) - ( 40 * 40 ) * 0.4;
											break;
											case '9':
												s = ( 60 * 40 ) - ( 60 * 40 ) * 0.4;
											break;
											case '10':
												s = ( 60 * 60 ) - ( 60 * 60 ) * 0.4;
											break;
											case '11':
												s = ( 80 * 40 ) - ( 80 * 40 ) * 0.4;
											break;
											case '12':
												s = ( 80 * 60 ) - ( 80 * 60 ) * 0.4;
											break;
											case '13':
												s = ( 100 * 40 ) - ( 100 * 40 ) * 0.4;
											break;
											case '14':
												s = ( 100 * 60 ) - ( 100 * 60 ) * 0.4;
											break;
										}
										if( cableType == 'round'){
											rez = s / (insulationDiam * insulationDiam);
										}
										if( cableType == 'flat'){
											rez = s / (insulationWidth * insulationHeight);
										}	
									}
									if( boxType == 2 ){
										switch(boxSize){
											case '1':
												s = ( 12 * 15 ) - ( 12 * 15 )  * 0.35;  
											break;
											case '2': 
												s = ( 15 * 10 ) - ( 15 * 10 ) * 0.35;
											break;
											case '3':
												s = ( 16 * 16 ) - ( 16 * 16 ) * 0.35;
											break;
											case '4':
												s = ( 20 * 10 ) - ( 20 * 10 ) * 0.35;
											break;
											case '5':
												s = ( 25 * 16 ) - ( 25 * 16 ) * 0.35;
											break;
											case '6':
												s = ( 25 * 25 ) - ( 25 * 25 ) * 0.35;
											break;
											case '7':
												s = ( 40 * 16 ) - ( 40 * 16 ) * 0.35;
											break;
											case '8':
												s = ( 40 * 40 ) - ( 40 * 40 ) * 0.35;
											break;
											case '9':
												s = ( 60 * 40 ) - ( 60 * 40 ) * 0.35;
											break;
											case '10':
												s = ( 60 * 60 ) - ( 60 * 60 ) * 0.35;
											break;
											case '11':
												s = ( 80 * 40 ) - ( 80 * 40 ) * 0.35;
											break;
											case '12':
												s = ( 80 * 60 ) - ( 80 * 60 ) * 0.35;
											break;
											case '13':
												s = ( 100 * 40 ) - ( 100 * 40 ) * 0.35;
											break;
											case '14':
												s = ( 100 * 60 ) - ( 100 * 60 ) * 0.35;
											break;
										}
										if( cableType == 'round'){
											rez = s / (insulationDiam * insulationDiam);
										}
										if( cableType == 'flat'){
											rez = s / (insulationWidth * insulationHeight);
										}
									}
									$('#lbrez13').html(rez.toFixed(2));
									$('#lbrez13').append('<input type="hidden" name="rez13" value="' + rez.toFixed(2) + '">');
									$('#lbrez14').html("");		
								}
								function BoxOccupancyClear(){		
									$('input:radio[name=boxtype]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=boxsize]').each(function(){$(this).iCheck('uncheck');});
									$('input:radio[name=cabletype]').each(function(){$(this).iCheck('uncheck');});
									$('#lbinsulationdiam').val("");
									$('#lbinsulationwidth').val("");
									$('#lbinsulationheight').val("");
									$('#flatcable1').hide();
									$('#flatcable2').hide();
									$('#roundcable').hide();
									$('#lbrez13').html("");
									$('#lbrez14').html("");		
								}
								$('#btnclear6').click(function(){BoxOccupancyClear();return false;});
								$('#btncalc6').click(function(){BoxOccupancyCalc();return false;});
							</script>
						</div>
						<div class="tab-pane" id="panel-359131">
                            <style>
                                .col-sm-border{
                                    border: 1px solid #cecece;
                                    padding: 10px 0 5px 15px;
                                }
                                .consum-child-elem-margins{
                                    margin: 0 0 10px 0;
                                }
                                .consum-del-btn{
                                    font-size: 12px;
                                    background: transparent url('img/reset_btn.gif') no-repeat center top;
                                    font-family: "Tahoma";
                                    color: rgb( 89, 90, 90 );
                                    font-weight: bold;
                                    width: 79px;
                                    height: auto !important;/**/
									content: 'Удалить' !important;
                                }
                                .load-type-block-margin{
                                    margin-left: 15px;
                                }
                            </style>
													
							<div class="row" style="border-bottom: 1px solid #cecece; border-top: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;margin-top: 9px;">
								<div class="col-xs-4">
									<label class="control-label red_text">Этажность учреждения:</label>
								</div>
								<div class="col-xs-2">
									<select class="selectpicker" id="floorcountlist_" style="display: inline-block; height: 40px;">       
										<option value="1" selected>1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option> 
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option> 
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option> 
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option> 
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
									</select>										
								</div>
							</div>
							<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
								<div class="col-xs-12">
									<div class="row">
										<div class="col-xs-12">
											<label class="control-label red_text">Тип учреждения по таблице 6.11 СП31-110-2003 для определения К1 для расчета нагрузки питающих линий:</label>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12">
											<div class="row">
												<div class="col-xs-1">
													<input type="radio" name="buildtypekk1" id="rad89" value="1">
												</div>
												<div class="col-xs-11">
														<label for="rad89" class="black_text" style="">Предприятия торговли и общественного питания, гостиницы</label>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-1">
													<input type="radio" name="buildtypekk1" id="rad90" value="2">
												</div>
												<div class="col-xs-11">
														<label for="rad90" class="black_text" style="">Общеобразовательные школы, специальные учебные заведения, профтехучилища</label>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-1">
													<input type="radio" name="buildtypekk1" id="rad91" value="3">
												</div>
												<div class="col-xs-11">
														<label for="rad91" class="black_text" style="">Детские ясли-сады</label>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-1">
													<input type="radio" name="buildtypekk1" id="rad92" value="4">
												</div>
												<div class="col-xs-11">
														<label for="rad92" class="black_text" style="">Ателье, комбинаты бытового обслуживания, химчистки с прачечными самообслуживания, парикмахерские</label>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-1">
													<input type="radio" name="buildtypekk1" id="rad93" value="5">
												</div>
												<div class="col-xs-11">
													<label for="rad93" class="black_text" style="">Организации и учреждения управления, финансирования и кредитования, проектные и конструкторские организации</label>
												</div>
											</div>
										</div>
									</div>	
								</div>
							</div>
							<div class='row' style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
								<div class='col-sm-12'>
									<div class='row'>
										<div class='col-sm-12'>
											<label class='control-label red_text'>Тип учреждения по таблице 6.5 СП31-110-2003 для определения К_с.о для расччета Рр освещения:</label>
										</div>
									</div>
									<div class='row'>
										<div class='col-sm-12'>
											<div class='row'>
												<div class='col-xs-1'>
													<input type='radio' name='buildtypekc' id='rad80' value='1' checked='checked'>
												</div>
												<div class='col-xs-11'>
													<label for='rad80' class='black_text'>Гостиницы, спальные корпуса и административные помещения санаториев, домов отдыха, пансионатов, турбаз, оздоровительных лагерей</label>
												</div>
											</div>
											<div class='row'>
												<div class='col-xs-1'>
													<input type='radio' name='buildtypekc' id='rad81' value='2'>
												</div>
												<div class='col-xs-11'>
													<label for='rad81' class='black_text'>Предприятия общественного питания, детские ясли-сады, учебно-производственные мастерские профтехучилищ</label>
												</div>
											</div>
											<div class='row'>
												<div class='col-xs-1'>
													<input type='radio' name='buildtypekc' id='rad82' value='3'>
												</div>
												<div class='col-xs-11'>
													<label for='rad82' class='black_text'>Организации и учреждения управления, учреждения финансирования, кредитования и государственного страхования, общеобразовательные школы, специальные учебные заведения, учебные здания профтехучилищ, предприятия бытового обслуживания, торговли, парикмахерские</label>
												</div>
											</div>
											<div class='row'>
												<div class='col-xs-1'>
													<input type='radio' name='buildtypekc' id='rad83' value='4'>
												</div>
												<div class='col-xs-11'>
													<label for='rad83' class='black_text'>Проектные, конструкторские организации, научно-исследовательские институты</label>
												</div>
											</div>
											<div class='row'>
												<div class='col-xs-1'>
													<input type='radio' name='buildtypekc' id='rad84' value='5'>
												</div>
												<div class='col-xs-11'>
													<label for='rad84' class='black_text'>Актовые залы, конференц-залы (освещение зала и президиума), спортзалы</label>
												</div>
											</div>
											<div class='row'>
												<div class='col-xs-1'>
													<input type='radio' name='buildtypekc' id='rad85' value='6'>
												</div>
												<div class='col-xs-11'>
													<label for='rad85' class='black_text'>Клубы и дома культуры</label>
												</div>
											</div>
											<div class='row'>
												<div class='col-xs-1'>
													<input type='radio' name='buildtypekc' id='rad86' value='7'>
												</div>
												<div class='col-xs-11'>
													<label for='rad86' class='black_text'>Кинотеатры</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="padding-top: 30px; padding-bottom: 5px;" id="buildtype7">
								<div class="col-xs-12">
									<label class="control-label red_text"><h4 style="font-weight: bold;">Данные для определения нагрузок по типу потребителя:</h4></label>
								</div>							
							</div>

							<div id="loadTypeArrData" class="load-type-block-margin"></div>

							<div style="border-bottom: 1px solid #cecece;">
								<div class="row" style="margin-top: 10px; margin-bottom: 10px;" id="loadTypeArrAddButton">
									<div class="col-md-1"><input style="height: 50px !important; width: 245px !important;" class="btn btn_reset" type="button" id="loadTypeAddElement" value="Добавить потребитель" onclick="addConsumer()"></div>
								</div>
							</div>
							
							<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
								<div class="col-md-6">
									<button class="btn btn_calc" id="btncalc7" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);">Рассчитать</button>
									<button class="btn btn_reset" id="btnclear7" style="margin-left:15px; display: inline-block;">Сброс</button>
								</div>								
							</div>
							
							<div class="row">
								<div class="col-md-2">									
								</div>	
								<div class="col-md-8">
									<label class="control-label red_text">
										<h4 style="font-weight: bold;">СУММАРНАЯ НАГРУЗКА ПРОЕКТИРУЕМОГО ОБЪЕКТА</h4>
									</label>
								</div>
								<div class="col-md-2">									
								</div>	
							</div>
							<div class="row">
								<div class="col-md-6">	
									<div class="row">
										<div class="col-md-6">
											<label class="control-label red_text">Рр.осв/ Рр.сил, %:</label>
										</div>
										<div class="col-md-6">											
											<input value='' type='text' id='Pp_osv_sil_rez' style="width: 68px; margin-bottom: 4px;" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label class="control-label red_text">Рр.осв/ Рр.хол, %:</label>
										</div>
										<div class="col-md-6">
											<input value='' type='text' id='Pp_osv_hol_rez' style="width: 68px;" disabled>
										</div>
									</div>
								</div>	
								<div class="col-md-6">	
									<div class="row">
										<div class="col-md-6">
											<label class="control-label red_text">К (Рр.осв/ Рр.сил):</label>
										</div>
										<div class="col-md-6">											
											<input value='' type='text' id='K_rez' style="width: 68px; margin-bottom: 4px;" disabled>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label class="control-label red_text">К1 (Рр.осв/ Рр.хол):</label>
										</div>
										<div class="col-md-6">											
											<input value='' type='text' id='K1_rez' style="width: 68px;" disabled>
										</div>
									</div>								
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive"> 
										<table class="table table-bordered">
											<tr>
												<td colspan=9><label class="control-label red_text">АВАРИЙНЫЙ РЕЖИМ</label></td>
											</tr>
											<tr>
												<td><input value='' type='text' id='Py_crash_rez' style="width: 68px;" disabled></td>									
												<td><input value='' type='text' id='Qy_crash_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='K_crash_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='Pp_crash_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='Qp_crash_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='cosf_crash_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='tgf_crash_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='Sp_crash_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='Ip_crash_rez' style="width: 68px;" disabled></td>
											</tr>
											<tr>
												<td colspan=9><label class="control-label red_text">АВАРИЙНЫЙ РЕЖИМ (ПРИ ПОЖАРЕ)</label></td>
											</tr>
											<tr>
												<td><input value='' type='text' id='Py_fire_rez' style="width: 68px;" disabled></td>									
												<td><input value='' type='text' id='Qy_fire_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='K_fire_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='Pp_fire_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='Qp_fire_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='cosf_fire_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='tgf_fire_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='Sp_fire_rez' style="width: 68px;" disabled></td>
												<td><input value='' type='text' id='Ip_fire_rez' style="width: 68px;" disabled></td>
											</tr>
											<tr>
												<td><label class="control-label red_text">Ру, кВт</label></td>									
												<td><label class="control-label red_text">Qу, квар</label></td>
												<td><label class="control-label red_text">Кс</label></td>
												<td><label class="control-label red_text">Pр, кВт</label></td>
												<td><label class="control-label red_text">Qр, квар</label></td>
												<td><label class="control-label red_text">cosϕ</label></td>
												<td><label class="control-label red_text">Tgϕ</label></td>
												<td><label class="control-label red_text">Sp, кВА</label></td>
												<td><label class="control-label red_text">Ip, A</label></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
                            
							<form id="buildloadcalculationform"class="topdf-form" action="to_pdf.php?form=buildloadcalculation" method="post" style="display: none;">
								<input type="hidden" name="pageTitle" value="Расчёт нагрузок жилых и общественных зданий">
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
							<script>
								$('input:radio[name=buildtypekc]#rad80').iCheck('check');//*
								$('input:radio[name=calctype]#rad79').iCheck('check');//*
								$('input:radio[name=buildtypekk1]#rad89').iCheck('check');//*
								$('input:radio[name=buildtype]#rad94').iCheck('check');//*
								
								var blockAddCount = 0;
                                var addedConsumersArr = [];
                                var consumersOldValues = [];
								
								$('#buildloadcalculationform').submit(function(event) {
								    // Предотвращаем обычную отправку формы
									event.preventDefault();
									var formData = $('#loadcalculationform').serializeArray();
									
									formData.push({name: 'ajax',value: true});
									
									calcForId = $('.checked input:radio[name=calctype]').attr('id');
									calcForVal = $('.checked input:radio[name=calctype]').val();
									calcForLabel = $('label[for='+calcForId+']').html();
									if(calcForId){
										formData.push({name: 'calctypeval', value: calcForVal});
										formData.push({name: 'calctypelabel', value: calcForLabel});
									}
									
									loadTypeChildren = $('#loadTypeArrData').children();
									
									formData.push({name: 'consumersCount', value: loadTypeChildren.length});
									$.each(loadTypeChildren,function(key,value){
										id = $(value).attr('id');
										formData.push({name: 'consumersType' + key, value: $('#'+id+" #consumersType option:selected").html()});
										formData.push({name: 'consumersCount' + key, value: $('#'+id+" #consumersCount").val()});
										formData.push({name: 'py1' + key, value: $('#'+id+" #py1").val()});
										formData.push({name: 'kc' + key, value: $('#'+id+" #kc").val()});
										formData.push({name: 'cosf4' + key, value: $('#'+id+" #lbcosf4").val()});
										formData.push({name: 'pp' + key, value: $('#'+id+" #pp").val()});
										formData.push({name: 'qp' + key, value: $('#'+id+" #qp").val()});
									});
									
									buildTypeId = $('.checked input:radio[name=buildtype]').attr('id');
									buildTypeVal = $('.checked input:radio[name=buildtype]').val();
									buildTypeLabel = $('label[for='+buildTypeId+']').html();
									if(calcForVal == 'build'){
										formData.push({name: 'buildtypelabel', value: buildTypeLabel});
										formData.push({name: 'buildtypeval', value: buildTypeVal});
									}
									
									buildTypeKKId = $('.checked input:radio[name=buildtypekk1]').attr('id');
									buildTypeKKVal = $('.checked input:radio[name=buildtypekk1]').val();
									buildTypeKKLabel = $('label[for='+buildTypeKKId+']').html();
									if(buildTypeVal == '2'){
										formData.push({name: 'buildtypekk1', value: buildTypeKKLabel});								
									}
									
									formData.push({name: 'rez15_1', value: $('#lbrez15_1').html()});
									
									if(calcForVal == 'switchboard'){
										
										formData.push({name: 'rez15', value: $('#lbrez15').html()});
										formData.push({name: 'rez16', value: $('#lbrez16').html()});
										formData.push({name: 'rez35', value: $('#lbrez35').html()});
										formData.push({name: 'rez17', value: $('#lbrez17').html()});
										formData.push({name: 'rez18', value: $('#lbrez18').html()});
										formData.push({name: 'rez19', value: $('#lbrez19').html()});
										formData.push({name: 'rez20', value: $('#lbrez20').html()});
										
									}
									
									if(calcForVal == 'build'){
										formData.push({name: 'rez21', value: $('#lbrez21').html()});
										formData.push({name: 'rez22', value: $('#lbrez22').html()});
										formData.push({name: 'rez23', value: $('#lbrez23').html()});
										formData.push({name: 'rez24', value: $('#lbrez24').html()});
										formData.push({name: 'rez25', value: $('#lbrez25').html()});
										formData.push({name: 'rez26', value: $('#lbrez26').html()});
										formData.push({name: 'rez27', value: $('#lbrez27').html()});
										formData.push({name: 'rez28', value: $('#lbrez28').html()});
										formData.push({name: 'rez29', value: $('#lbrez29').html()});
										formData.push({name: 'rez30', value: $('#lbrez30').html()});
										formData.push({name: 'rez31', value: $('#lbrez31').html()});
										formData.push({name: 'rez32', value: $('#lbrez32').html()});
										formData.push({name: 'rez33', value: $('#lbrez33').html()});
										formData.push({name: 'rez34', value: $('#lbrez34').html()});
									}
										
									
									if(buildTypeVal == '2'){
										formData.push({name: 'rez15_2', value: $('#lbrez15_2').html()});
										formData.push({name: 'rez15_3', value: $('#lbrez15_3').html()});
									}
										
										
									    
									$.post(	'to_pdf.php?form=buildloadcalculation', 
											formData,
								            function(data) {
												window.location = '/../' + data;								
								            });/**/
							    });

                                
                                function flatHideFunction(){
                                    for(i = 0; i < addedConsumersArr.length; i++)
                                        if($.inArray(addedConsumersArr[i],['34','35','36','37']) !== -1)
                                            addedConsumersArr.splice(i--, 1);

                                    consumersOldValues_= [];
                                    for(key in consumersOldValues) {
                                        if ($.inArray(consumersOldValues[key], ['34','35','36','37']) !== -1)
                                            consumersOldValues_.push(key);
                                        else {
                                            $('#' + key).find('#option34').hide();
                                            $('#' + key).find('#option35').hide();
                                            $('#' + key).find('#option36').hide();
                                            $('#' + key).find('#option37').hide();
                                        }
                                    }

                                    for(i = 0; i < consumersOldValues_.length; i++) {
                                        delete consumersOldValues[consumersOldValues_[i]];
                                        $('#' + consumersOldValues_[i]).remove();
                                        loadTypeCount--;
                                    }

                                    console.log('consumersOldValues');
                                    console.log(consumersOldValues);
                                    console.log('addedConsumersArr');
                                    console.log(addedConsumersArr);
                                }

                                function flatShowFunction(){
                                    for(key in consumersOldValues) {
                                        $('#' + key).find('#option34').show();
                                        $('#' + key).find('#option35').show();
                                        $('#' + key).find('#option36').show();
                                        $('#' + key).find('#option37').show();
                                    }
                                }

                               

                                function addConsumer(){
                                    id = "loadtypeblock_" + blockAddCount;
                                    selected_option = null;
									for(i=0; i <= 45; i++) { //ищем индекс не указанного раньше потребителя
										if ($.inArray(i.toString(), addedConsumersArr) == -1) {
                                            selected_option = i.toString();
                                            break;
                                        }
                                    }
                                    if(selected_option == null){
                                        $('#loadTypeAddElement').attr("disabled", "disabled");
                                        return;
									}
                                    $('#buildLoadCalcTmpl').tmpl(id).appendTo('#loadTypeArrData');
                                    if(selected_option != null) //делаем не указанного ранее потребителя выбранным
                                        $('#' + id).find('#option' + selected_option).attr("selected", "selected");									
                                    for(el in addedConsumersArr) //прячем уже выбранных потребителей
										$('#' + id).find('#option' + addedConsumersArr[el]).hide();
									newConsVal = $('#' + id).find('#consumersType :selected').val();
									if($.inArray(newConsVal, ['0','1','3','4','18']) != -1){
										$('#' + id).find('#fireInvolved1').attr("disabled", "disabled");
										$('#' + id).find('#fireInvolved1').removeAttr("checked");
									}
									addedConsumersArr.push(newConsVal);
                                    consumersOldValues[id] = newConsVal;
                                    for(key in consumersOldValues){
                                        if(key != id) {
                                            $('#' + key).find('#option' + newConsVal).hide();
                                        }
                                    }
                                    if(addedConsumersArr.length == 46)
                                        $('#loadTypeAddElement').attr("disabled", "disabled");
									blockAddCount++;
									loadTypeBlockChange($("#" + id));
                                }

                                function consumersTypeChange(obj){
                                    id = $(obj.parentNode.parentNode.parentNode.parentNode).attr('id');
                                    consumerType = $('#' + id).find('#consumersType :selected').val();                                    
                                    oldVal = consumersOldValues[id];
                                    for(key in consumersOldValues){
                                        if(key != id) {
                                            $('#' + key).find('#option' + oldVal).show();
                                            $('#' + key).find('#option' + consumerType).hide();
                                        }
                                    }
									if($.inArray(consumerType, ['0','1','3','4','18']) != -1){
										$('#' + id).find('#fireInvolved1').attr("disabled", "disabled");
										$('#' + id).find('#fireInvolved1').removeAttr("checked");
									} else {
										$('#' + id).find('#fireInvolved1').removeAttr('disabled');
										$('#' + id).find('#fireInvolved1').prop("checked", "checked");
									}
                                    index = addedConsumersArr.indexOf(oldVal);
                                    addedConsumersArr.splice(index,1);
                                    addedConsumersArr.push(consumerType);
                                    consumersOldValues[id] = consumerType; 
                                }

                                function deleteConsumer(obj){
									parent = obj.parentNode.parentNode.parentNode.parentNode.parentNode;
                                    val = $(parent).find('#consumersType :selected').val();
									index = addedConsumersArr.indexOf(val);
                                    addedConsumersArr.splice(index,1);
                                    delete consumersOldValues[$(parent).attr('id')];
									parent.remove();
                                    for(key in consumersOldValues){
                                        $('#' + key).find('#option' + val).show();
									}
                                    $('#loadTypeAddElement').removeAttr('disabled');
								}
																
								$('input:radio[name=buildtypekk1]').on('ifChecked',function(){
								        $.each($("#loadTypeArrData").children(),function(key,value){
											currConsNum = $(value).find('#consumersType').val();
											if($.inArray(currConsNum,['25']) != -1) loadTypeBlockChange($(value));									
										});
								    }
								);
								$('input:radio[name=buildtypekc]').on('ifChecked',function(){
										$.each($("#loadTypeArrData").children(),function(key,value){
											currConsNum = $(value).find('#consumersType').val();
											if($.inArray(currConsNum,['15']) != -1) loadTypeBlockChange($(value));									
										});
								    }
								);
								$('#floorcountlist_').change(	//подобный обработчик не работает для элементов из шаблона
								    function(){
										$.each($("#loadTypeArrData").children(),function(key,value){
											currConsNum = $(value).find('#consumersType').val();
											if($.inArray(currConsNum,['5']) != -1) {loadTypeBlockChange($(value));}									
										});
								    }
								);

                                function loadTypeBlockChange(obj){
								   consumersType = $(obj).find('#consumersType :selected').val();
								   fireInvolved1 = $(obj).find('#fireInvolved1').prop('checked');
								   KCEditing1 = $(obj).find('#KCEditing1').prop('checked');
								   Py = parseFloat($(obj).find('#Py').val().replace(',','.'));
								   Np = parseInt($(obj).find('#Np').val().replace(',','.'),10);
								   cosf = parseFloat($(obj).find('#cosf').val().replace(',','.'));
								   if(isNaN(Py) || isNaN(Np) || isNaN(cosf)) return false;
								   if(Py < 0 || Np < 1 || cosf < -1.0 || cosf > 1.0) return false;
								   if(KCEditing1){
									   Kc = parseFloat($(obj).find('#Kc').val().replace(',','.'));
									   if(isNaN(Kc)) return false;
								   } else {
									   switch(consumersType){										   
										    case '0':
												if(Py <= 30.0){ Py = 30.1; $(obj).find('#Py').val((Py+'').replace('.',',')); }
												Kc = loadCalcResPubBuildingsTab6_9(Np, Py, null);
												break;
											case '1':
												if(Py > 30.0){ Py = 30; $(obj).find('#Py').val(Py); }
												Kc = loadCalcResPubBuildingsTab6_9(Np, null, null);
												break;
											case '2':
												Kc = 1.0;
												break;
											case '3':
												if(Py > 30.0){ Py = 30; $(obj).find('#Py').val(Py); }
												weight = calcWeghtTab6_9(3);
												Kc = loadCalcResPubBuildingsTab6_9(Np, null, weight);
												break;
											case '4':
												if(Py <= 30.0){ Py = 30.1; $(obj).find('#Py').val((Py+'').replace('.',',')); }
												Kc = loadCalcResPubBuildingsTab6_9(Np, Py, null);
												break;
											case '5':
												floorCount = $('#floorcountlist_ :selected').val() * 1.0;
												Kc = loadCalcResPubBuildingsTab6_4(Np, parseInt(floorCount,10));
												break;
											case '6':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 15);
												break;
											case '7':
												Kc = loadCalcResPubBuildingsTab2_1(Np);
												break;
											case '8':
												Kc = loadCalcResPubBuildingsTab2_2(Np);
												break;
											case '9':
												Kc = loadCalcResPubBuildingsTab6_9(Np,null,null);
												break;
											case '10':
												if(Py > 30.0){ Py = 30; $(obj).find('#Py').val(Py); }
												Kc = loadCalcResPubBuildingsTab6_9(Np, null, null);
												break;
											case '11':
												if(Py <= 30.0){ Py = 30.1; $(obj).find('#Py').val((Py+'').replace('.',',')); }
												Kc = loadCalcResPubBuildingsTab6_9(Np, Py, null);
												break;
											case '12':
												Kc = 0.0;
												break;
											case '13':
												Kc = 1.0;
												break;
											case '14':
												Kc = 1.0;
												break;
											case '15':
												rowNum = $('[name = buildtypekc]:checked').val();												
												Kc = loadCalcResPubBuildingsTab6_5(Py * Np, parseInt(rowNum,10));
												break;
											case '16':
												Kc = loadCalcResPubBuildingsTab6_8(Np);
												break;
											case '17':
												Kc = loadCalcResPubBuildingsTab6_8(Np);
												break;
											case '18':
												Kc = 1.0;
												break;
											case '19':
												Kc = 0.5;
												break;
											case '20':
												Kc = loadCalcResPubBuildingsTab6_10_hot(Np);
												break;
											case '21':
												Kc = loadCalcResPubBuildingsTab6_10_cold(Np);
												break;
											case '22':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 16);
												break;
											case '23':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 16);
												break;
											case '24':
												Kc = 1.0;
												break;
											case '25':
												rowNum = $('[name = buildtypekk1]:checked').val() * 1.0;
												if($.inArray(parseInt(rowNum,10),[1,4]) != -1) Kc = 0.2;
												else Kc = 0.1;
												break;
											case '26':
												if(Np <= 8) Kc = 0.9;
												else if(Np >= 20) Kc = 0.8;
												else Kc = interpolation(8,0.9,Np,20,0.8);
												break;
											case '27':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 17);
												break;
											case '28':
												Kc = 1.0;
												break;
											case '29':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 11);
												break;
											case '30':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 11);
												break;
											case '31':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 8);
												break;
											case '32':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 8);
												break;
											case '33':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 8);
												break;
											case '34':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 14);
												break;
											case '35':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 14);
												break;
											case '36':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 13);
												break;
											case '37':
												Kc = loadCalcResPubBuildingsTab6_7(Np, 13);
												break;
											case '38':
												Kc = 1.0;
												break;
											case '39':
												if(Py > 30.0){ Py = 30; $(obj).find('#Py').val(Py); }
												weight = calcWeghtTab6_9(3);
												Kc = loadCalcResPubBuildingsTab6_9(Np, null, weight);
												break;
											case '40':
												if(Py <= 30.0){ Py = 30.1; $(obj).find('#Py').val((Py+'').replace('.',',')); }
												Kc = loadCalcResPubBuildingsTab6_9(Np, Py, null);
												break;
											case '41':
												Pp = loadCalcResPubBuildingsTab6_1(Np, 1);
												Kc = Pp / Py;
												break;
											case '42':
												Pp = loadCalcResPubBuildingsTab6_1(Np, 2);
												Kc = Pp / Py;
												break;
											case '43':
												Pp = loadCalcResPubBuildingsTab6_1(Np, 3);
												Kc = Pp / Py;
												break;
											case '44':
												Pp = loadCalcResPubBuildingsTab6_1(Np, 4);
												Kc = Pp / Py;
												break;
											case '45':
												Kc = 1.0;
												break;
											default:
												break;
									   }
								   }
								   tgf = Math.tan(Math.acos(cosf));
								   Qy = Py * tgf;
								   Pp = Py * Kc;
								   Qp = Qy * Kc;
								   Sp = Math.sqrt(Py*Py + Qy*Qy) * Kc;
								   Ip = Sp / (Math.sqrt(3.0)*0.38);
								   $(obj).find('#Qy').val(Qy.toFixed(2).replace('.',','));
								   $(obj).find('#Kc').val(Kc.toFixed(2).replace('.',','));
								   $(obj).find('#Pp').val(Pp.toFixed(2).replace('.',','));
								   $(obj).find('#Qp').val(Qp.toFixed(2).replace('.',','));
								   $(obj).find('#tgf').val(tgf.toFixed(2).replace('.',','));
								   $(obj).find('#Sp').val(Sp.toFixed(2).replace('.',','));	
								   $(obj).find('#Ip').val(Ip.toFixed(2).replace('.',','));	
                                }

                                function JQTmplEventProcessor(obj){
                                    switch($(obj).get(0).tagName){
                                        case 'SELECT':
                                            switch($(obj).attr('id')){                                                
                                                case 'consumersType': //тип потребителя
                                                    parent = obj.parentNode.parentNode.parentNode.parentNode;
													consumersTypeChange(obj);
                                                    loadTypeBlockChange(parent);
													break;
                                                default: break;
                                            }
                                            break;
                                        case 'INPUT':
                                            switch($(obj).attr('id')){
                                                case 'fireInvolved1':
                                                    parent = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                                                    loadTypeBlockChange(parent);
                                                    break;
												case 'KCEditing1':
                                                    parent = obj.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
													if($(obj).prop('checked'))
														$(parent).find('#Kc').removeAttr('disabled');
													else														
														$(parent).find('#Кс').attr('disabled','disabled');
													loadTypeBlockChange(parent);
                                                	break;
												case 'Py':
                                                    parent = obj.parentNode.parentNode.parentNode.parentNode.
																	parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
													loadTypeBlockChange(parent);
                                                	break;
												case 'Np':
                                                    parent = obj.parentNode.parentNode.parentNode.parentNode.
																	parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
													loadTypeBlockChange(parent);
                                                	break;
                                                case 'cosf':
                                                    parent = obj.parentNode.parentNode.parentNode.parentNode.
																	parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
													loadTypeBlockChange(parent);
                                                	break;
												case 'Kc':
                                                    parent = obj.parentNode.parentNode.parentNode.parentNode.
																	parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
													loadTypeBlockChange(parent);
                                                	break;
                                                default: break;
                                            }
                                            break;
                                        case 'OPTION': break;
                                        default: break;
                                    }
                                }
								function interpolation(a1,b1,a,a2,b2){
                                    if(isNaN(a1) || isNaN(b1) || isNaN(a) || isNaN(a2) || isNaN(b2))
                                        return 'error';
                                    else
                                        return b1-((b1-b2)/(a2-a1))*(a-a1);
                                }
								
								function calcWeghtTab6_9(consNum){
									Py_summ = 0.0;
									Py = 0.0;
									$.each($("#loadTypeArrData").children(),function(key,value){
										currConsNum = $(value).find('#consumersType').val();
										if($.inArray(currConsNum,['14','15','41','42','43','44','45']) == -1){
											if(!isNaN(Py_curr = parseFloat($(value).find('#Py').val().replace(',','.')))) Py_summ += Py_curr;
											else return null;
											if(currConsNum == consNum) Py = Py_curr;
										}	/**/									
									});
									return weight = 100.0 * Py / (Py_summ - Py);									
								}
                                function loadCalcResPubBuildingsTab6_9(Np, Py, weight){
                                    if(Py == null && weight == null){
                                        if(Np >= 0 && Np <= 2)
                                            return 1;
                                        if(Np > 2 && Np <= 3)
                                            return interpolation(2,1,Np,3,0.9);
                                        if(Np > 3 && Np <= 5)
                                            return interpolation(3,0.9,Np,5,0.8);
                                        if(Np > 5 && Np <= 8)
                                            return interpolation(5,0.8,Np,8,0.75);
                                        if(Np > 8 && Np <= 10)
                                            return interpolation(8,0.75,Np,10,0.7);
                                        if(Np > 10 && Np <= 15)
                                            return interpolation(10,0.7,Np,15,0.65);
                                        if(Np > 15 && Np <= 20)
                                            return interpolation(15,0.65,Np,20,0.65);
                                        if(Np > 20 && Np <= 30)
                                            return interpolation(20,0.65,Np,30,0.6);
                                        if(Np > 30 && Np <= 50)
                                            return interpolation(30,0.6,Np,50,0.55);
                                        if(Np > 50 && Np <= 100)
                                            return interpolation(50,0.55,Np,100,0.55);
                                        if(Np > 100 && Np <= 200)
                                            return interpolation(100,0.55,Np,200,0.5);
                                        if(Np > 200)
                                            return 0.5;
                                    }else if(Py != null && weight == null){
                                        if(Np >= 0 && Np <= 2)
                                            return 0.8;
                                        if(Np > 2 && Np <= 3)
                                            return interpolation(2,0.8,Np,3,0.75);
                                        if(Np > 3 && Np <= 5)
                                            return interpolation(3,0.75,Np,5,0.7);
                                        if(Np > 5 && Np <= 8)
                                            return interpolation(5,0.7,Np,8,0.7);
                                        if(Np > 8 && Np <= 10)
                                            return interpolation(8,0.7,Np,10,0.7);
                                        if(Np > 10 && Np <= 15)
                                            return interpolation(10,0.7,Np,15,0.7);
                                        if(Np > 15 && Np <= 20)
                                            return interpolation(15,0.7,Np,20,0.7);
                                        if(Np > 20 && Np <= 30)
                                            return interpolation(20,0.7,Np,30,0.7);
                                        if(Np > 30 && Np <= 50)
                                            return interpolation(30,0.7,Np,50,0.7);
                                        if(Np > 50 && Np <= 100)
                                            return interpolation(50,0.7,Np,100,0.7);
                                        if(Np > 100 && Np <= 200)
                                            return interpolation(100,0.7,Np,200,0.7);
                                        if(Np > 200)
                                            return 0.7;
                                    }else if(Py == null && weight != null){
										if(Np >= 0 && Np <= 2){
											if(weight >= 100.0)
												return 1.0;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,1.0,weight,84.0,0.75);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.75,weight,74.0,0.7);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.7,weight,49.0,0.65);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.65,weight,24.0,0.6);
											if(weight < 24.0)
												return 0.6;
										}
                                        if(Np > 2 && Np <= 3){
											if(weight >= 100.0)
												return 0.9;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.9,weight,84.0,0.75);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.75,weight,74.0,0.7);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.7,weight,49.0,0.65);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.65,weight,24.0,0.6);
											if(weight < 24.0)
												return 0.6;
										}
                                        if(Np > 3 && Np <= 5){
											if(weight >= 100.0)
												return 0.8;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.8,weight,84.0,0.75);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.75,weight,74.0,0.7);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.7,weight,49.0,0.65);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.65,weight,24.0,0.6);
											if(weight < 24.0)
												return 0.6;
										}
                                        if(Np > 5 && Np <= 8){
											if(weight >= 100.0)
												return 0.75;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.75,weight,84.0,0.7);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.7,weight,74.0,0.65);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.65,weight,49.0,0.6);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.6,weight,24.0,0.6);
											if(weight < 24.0)
												return 0.6;
										}
                                        if(Np > 8 && Np <= 10){
											if(weight >= 100.0)
												return 0.7;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.7,weight,84.0,0.65);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.65,weight,74.0,0.65);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.65,weight,49.0,0.6);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.6,weight,24.0,0.55);
											if(weight < 24.0)
												return 0.55;
										}
                                        if(Np > 10 && Np <= 15){
											if(weight >= 100.0)
												return 0.65;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.65,weight,84.0,0.6);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.6,weight,74.0,0.6);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.6,weight,49.0,0.55);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.55,weight,24.0,0.5);
											if(weight < 24.0)
												return 0.5;
										}
                                        if(Np > 15 && Np <= 20){
											if(weight >= 100.0)
												return 0.65;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.65,weight,84.0,0.6);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.6,weight,74.0,0.6);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.6,weight,49.0,0.5);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.5,weight,24.0,0.5);
											if(weight < 24.0)
												return 0.5;
										}
                                        if(Np > 20 && Np <= 30){
											if(weight >= 100.0)
												return 0.6;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.6,weight,84.0,0.6);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.6,weight,74.0,0.55);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.55,weight,49.0,0.5);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.5,weight,24.0,0.5);
											if(weight < 24.0)
												return 0.5;
										}
                                        if(Np > 30 && Np <= 50){
											if(weight >= 100.0)
												return 0.55;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.55,weight,84.0,0.55);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.55,weight,74.0,0.5);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.5,weight,49.0,0.5);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.5,weight,24.0,0.5);
											if(weight < 24.0)
												return 0.5;
										}
                                        if(Np > 50 && Np <= 100){
											if(weight >= 100.0)
												return 0.55;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.55,weight,84.0,0.55);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.55,weight,74.0,0.5);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.5,weight,49.0,0.45);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.45,weight,24.0,0.45);
											if(weight < 24.0)
												return 0.45;
										}
                                        if(Np > 100 && Np <= 200){
											if(weight >= 100.0)
												return 0.5;
											if(weight < 100.0 && weight >= 84.0)
												return interpolation(100.0,0.5,weight,84.0,0.5);
											if(weight < 84.0 && weight >= 74.0)
												return interpolation(84.0,0.5,weight,74.0,0.45);
											if(weight < 74.0 && weight >= 49.0)
												return interpolation(74.0,0.45,weight,49.0,0.45);
											if(weight < 49.0 && weight >= 24.0)
												return interpolation(49.0,0.45,weight,24.0,0.4);
											if(weight < 24.0)
												return 0.4;
										}
                                        if(Np > 200){
											if(weight >= 100.0)
												return 0.5;
											if(weight < 100.0 && weight >= 84.0)
												return 0.5;
											if(weight < 84.0 && weight >= 74.0)
												return 0.45;
											if(weight < 74.0 && weight >= 49.0)
												return 0.45;
											if(weight < 49.0 && weight >= 24.0)
												return 0.4;
											if(weight < 24.0)
												return 0.4;
										}																		
									}else if(Py != null && weight != null){
										
									}
                                }
                                
								function loadCalcResPubBuildingsTab6_4(Np, floorCount){
									if(	isNaN(Np) || (!isNaN(Np) && Np < 0) ||
										isNaN(floorCount) || (!isNaN(floorCount) && floorCount < 0))
                                        return null;
                                    else if(floorCount <= 12){
										if(Np >= 0 && Np <= 2) return 0.8;
                                        if(Np > 2 && Np <= 3) return interpolation(2,0.8,Np,3,0.8);
                                        if(Np > 3 && Np <= 4) return interpolation(3,0.8,Np,4,0.7);
                                        if(Np > 4 && Np <= 5) return interpolation(5,0.7,Np,8,0.7);
                                        if(Np > 5 && Np <= 6) return interpolation(8,0.7,Np,10,0.65);
                                        if(Np > 6 && Np <= 10) return interpolation(10,0.65,Np,15,0.5);
                                        if(Np > 10 && Np <= 20) return interpolation(10,0.5,Np,20,0.4);
                                        if(Np > 20 && Np <= 25) return interpolation(20,0.4,Np,30,0.35);
                                        if(Np > 25) return 0.35;
                                    }
                                    else if(floorCount > 12){
                                        if(Np >= 0 && Np <= 2) return 0.9;
                                        if(Np > 2 && Np <= 3) return interpolation(2,0.9,Np,3,0.9);
                                        if(Np > 3 && Np <= 4) return interpolation(3,0.9,Np,4,0.8);
                                        if(Np > 4 && Np <= 5) return interpolation(5,0.8,Np,8,0.8);
                                        if(Np > 5 && Np <= 6) return interpolation(8,0.8,Np,10,0.75);
                                        if(Np > 6 && Np <= 10) return interpolation(10,0.75,Np,15,0.6);
                                        if(Np > 10 && Np <= 20) return interpolation(10,0.6,Np,20,0.5);
                                        if(Np > 20 && Np <= 25) return interpolation(20,0.5,Np,30,0.4);
                                        if(Np > 25) return 0.4;
                                    }
                                }
                                
								function loadCalcResPubBuildingsTab6_10_cold(Np){
                                    if(	isNaN(Np) || (!isNaN(Np) && Np < 0))
                                        return null;
                                    else {
                                        if(Np >= 0 && Np <= 1)
                                            return 1;
                                        if(Np > 1 && Np <= 2)
                                            return interpolation(1,1,Np,2,0.9);
                                        if(Np > 2 && Np <= 3)
                                            return interpolation(2,0.9,Np,3,0.85);
                                        if(Np > 3)
                                            return 0.85;
                                    }
                                }
                                
								function loadCalcResPubBuildingsTab6_10_hot(Np){
                                    if(	isNaN(Np) || (!isNaN(Np) && Np < 0))
                                        return null;
                                    else {
                                        if(Np >= 0 && Np <= 1)
                                            return 0.65;
                                        if(Np > 1 && Np <= 2)
                                            return interpolation(1,0.65,Np,2,0.6);
                                        if(Np > 2 && Np <= 3)
                                            return interpolation(2,0.6,Np,3,0.55);
                                        if(Np > 3)
                                            return 0.55;
                                    }
                                }                                
                                
								function loadCalcResPubBuildingsTab6_1(Np, rowNum){
                                    if(	isNaN(Np) || (!isNaN(Np) && Np < 0) ||
										isNaN(rowNum) || (!isNaN(rowNum) && 
											($.inArray(rowNum,[1,2,3,4]) == -1)))
                                        return null;
                                    else {
                                        if(rowNum == 1){
                                            if(Np >= 0 && Np <= 5)
                                                return 4.5;
                                            if(Np > 5 && Np <= 6)
                                                return interpolation(5,4.5,Np,6,2.8);
                                            if(Np > 6 && Np <= 9)
                                                return interpolation(6,2.8,Np,9,2.3);
                                            if(Np > 9 && Np <= 12)
                                                return interpolation(9,2.3,Np,12,2);
                                            if(Np > 12 && Np <= 15)
                                                return interpolation(12,2,Np,15,1.8);
                                            if(Np > 15 && Np <= 18)
                                                return interpolation(15,1.8,Np,18,1.65);
                                            if(Np > 18 && Np <= 24)
                                                return interpolation(18,1.65,Np,24,1.4);
                                            if(Np > 24 && Np <= 40)
                                                return interpolation(24,1.4,Np,40,1.2);
                                            if(Np > 40 && Np <= 60)
                                                return interpolation(40,1.2,Np,60,1.05);
                                            if(Np > 60 && Np <= 100)
                                                return interpolation(60,1.05,Np,100,0.85);
                                            if(Np > 100 && Np <= 200)
                                                return interpolation(100,0.85,Np,200,0.77);
                                            if(Np > 200 && Np <= 400)
                                                return interpolation(200,0.77,Np,400,0.71);
                                            if(Np > 400 && Np <= 600)
                                                return interpolation(400,0.71,Np,600,0.69);
                                            if(Np > 600 && Np <= 1000)
                                                return interpolation(600,0.69,Np,1000,0.67);
                                            if(Np > 1000)
                                                return 0.67;
                                        }
                                        if(rowNum == 2){
                                            if(Np >= 0 && Np <= 5)
                                                return 6;
                                            if(Np > 5 && Np <= 6)
                                                return interpolation(5,6,Np,6,3.4);
                                            if(Np > 6 && Np <= 9)
                                                return interpolation(6,3.4,Np,9,2.9);
                                            if(Np > 9 && Np <= 12)
                                                return interpolation(9,2.9,Np,12,2.5);
                                            if(Np > 12 && Np <= 15)
                                                return interpolation(12,2.5,Np,15,2.2);
                                            if(Np > 15 && Np <= 18)
                                                return interpolation(15,2.2,Np,18,2);
                                            if(Np > 18 && Np <= 24)
                                                return interpolation(18,2,Np,24,1.8);
                                            if(Np > 24 && Np <= 40)
                                                return interpolation(24,1.8,Np,40,1.4);
                                            if(Np > 40 && Np <= 60)
                                                return interpolation(40,1.4,Np,60,1.3);
                                            if(Np > 60 && Np <= 100)
                                                return interpolation(60,1.3,Np,100,1.08);
                                            if(Np > 100 && Np <= 200)
                                                return interpolation(100,1.08,Np,200,1);
                                            if(Np > 200 && Np <= 400)
                                                return interpolation(200,1,Np,400,0.92);
                                            if(Np > 400 && Np <= 600)
                                                return interpolation(400,0.92,Np,600,0.84);
                                            if(Np > 600 && Np <= 1000)
                                                return interpolation(600,0.84,Np,1000,0.76);
                                            if(Np > 1000)
                                                return 0.76;
                                        }
                                        if(rowNum == 3){
                                            if(Np >= 0 && Np <= 5)
                                                return 10;
                                            if(Np > 5 && Np <= 6)
                                                return interpolation(5,10,Np,6,5.1);
                                            if(Np > 6 && Np <= 9)
                                                return interpolation(6,5.1,Np,9,3.8);
                                            if(Np > 9 && Np <= 12)
                                                return interpolation(9,3.8,Np,12,3.2);
                                            if(Np > 12 && Np <= 15)
                                                return interpolation(12,3.2,Np,15,2.8);
                                            if(Np > 15 && Np <= 18)
                                                return interpolation(15,2.8,Np,18,2.6);
                                            if(Np > 18 && Np <= 24)
                                                return interpolation(18,2.6,Np,24,2.2);
                                            if(Np > 24 && Np <= 40)
                                                return interpolation(24,2.2,Np,40,1.95);
                                            if(Np > 40 && Np <= 60)
                                                return interpolation(40,1.95,Np,60,1.7);
                                            if(Np > 60 && Np <= 100)
                                                return interpolation(60,1.7,Np,100,1.5);
                                            if(Np > 100 && Np <= 200)
                                                return interpolation(100,1.5,Np,200,1.36);
                                            if(Np > 200 && Np <= 400)
                                                return interpolation(200,1.36,Np,400,1.27);
                                            if(Np > 400 && Np <= 600)
                                                return interpolation(400,1.27,Np,600,1.23);
                                            if(Np > 600 && Np <= 1000)
                                                return interpolation(600,1.23,Np,1000,1.19);
                                            if(Np > 1000)
                                                return 1.19;
                                        }
                                        if(rowNum == 4){
                                            if(Np >= 0 && Np <= 5)
                                                return 4;
                                            if(Np > 5 && Np <= 6)
                                                return interpolation(5,4,Np,6,2.3);
                                            if(Np > 6 && Np <= 9)
                                                return interpolation(6,2.3,Np,9,1.7);
                                            if(Np > 9 && Np <= 12)
                                                return interpolation(9,1.7,Np,12,1.4);
                                            if(Np > 12 && Np <= 15)
                                                return interpolation(12,1.4,Np,15,1.2);
                                            if(Np > 15 && Np <= 18)
                                                return interpolation(15,1.2,Np,18,1.1);
                                            if(Np > 18 && Np <= 24)
                                                return interpolation(18,1.1,Np,24,0.9);
                                            if(Np > 24 && Np <= 40)
                                                return interpolation(24,0.9,Np,40,0.76);
                                            if(Np > 40 && Np <= 60)
                                                return interpolation(40,0.76,Np,60,0.69);
                                            if(Np > 60 && Np <= 100)
                                                return interpolation(60,0.69,Np,100,0.61);
                                            if(Np > 100 && Np <= 200)
                                                return interpolation(100,0.61,Np,200,0.58);
                                            if(Np > 200 && Np <= 400)
                                                return interpolation(200,0.58,Np,400,0.54);
                                            if(Np > 400 && Np <= 600)
                                                return interpolation(400,0.54,Np,600,0.51);
                                            if(Np > 600 && Np <= 1000)
                                                return interpolation(600,0.51,Np,1000,0.46);
                                            if(Np > 1000)
                                                return 0.46;
                                        }
                                    }
                                }
                                
								function loadCalcResPubBuildingsTab6_5(Py, rowNum){
                                    if(	isNaN(Py) || (!isNaN(Py) && Py < 0) ||
										isNaN(rowNum) || (!isNaN(rowNum) && 
											($.inArray(rowNum,[1,2,3,4,5,6,7]) == -1)))
                                        return null;
                                    else {
                                        if(rowNum == 1){
                                            if(Py >= 0 && Py <= 5)
                                                return 1;
                                            if(Py > 5 && Py <= 10)
                                                return interpolation(5,1,Py,10,0.8);
                                            if(Py > 10 && Py <= 15)
                                                return interpolation(10,0.8,Py,15,0.7);
                                            if(Py > 15 && Py <= 25)
                                                return interpolation(15,0.7,Py,25,0.6);
                                            if(Py > 25 && Py <= 50)
                                                return interpolation(25,0.6,Py,50,0.5);
                                            if(Py > 50 && Py <= 100)
                                                return interpolation(50,0.5,Py,100,0.4);
                                            if(Py > 100 && Py <= 200)
                                                return interpolation(100,0.4,Py,200,0.35);
                                            if(Py > 200 && Py <= 400)
                                                return interpolation(200,0.35,Py,400,0.3);
                                            if(Py > 400 && Py <= 500)
                                                return interpolation(400,0.3,Py,500,0.3);
                                            if(Py > 500)
                                                return 0.3;
                                        }
                                        if(rowNum == 2){
                                            if(Py >= 0 && Py <= 5)
                                                return 1;
                                            if(Py > 5 && Py <= 10)
                                                return interpolation(5,1,Py,10,0.9);
                                            if(Py > 10 && Py <= 15)
                                                return interpolation(10,0.9,Py,15,0.85);
                                            if(Py > 15 && Py <= 25)
                                                return interpolation(15,0.85,Py,25,0.8);
                                            if(Py > 25 && Py <= 50)
                                                return interpolation(25,0.8,Py,50,0.75);
                                            if(Py > 50 && Py <= 100)
                                                return interpolation(50,0.75,Py,100,0.7);
                                            if(Py > 100 && Py <= 200)
                                                return interpolation(100,0.7,Py,200,0.65);
                                            if(Py > 200 && Py <= 400)
                                                return interpolation(200,0.65,Py,400,0.6);
                                            if(Py > 400 && Py <= 500)
                                                return interpolation(400,0.6,Py,500,0.5);
                                            if(Py > 500)
                                                return 0.5;
                                        }
                                        if(rowNum == 3){
                                            if(Py >= 0 && Py <= 5)
                                                return 1;
                                            if(Py > 5 && Py <= 10)
                                                return interpolation(5,1,Py,10,0.95);
                                            if(Py > 10 && Py <= 15)
                                                return interpolation(10,0.95,Py,15,0.9);
                                            if(Py > 15 && Py <= 25)
                                                return interpolation(15,0.9,Py,25,0.85);
                                            if(Py > 25 && Py <= 50)
                                                return interpolation(25,0.85,Py,50,0.8);
                                            if(Py > 50 && Py <= 100)
                                                return interpolation(50,0.8,Py,100,0.75);
                                            if(Py > 100 && Py <= 200)
                                                return interpolation(100,0.75,Py,200,0.7);
                                            if(Py > 200 && Py <= 400)
                                                return interpolation(200,0.7,Py,400,0.65);
                                            if(Py > 400 && Py <= 500)
                                                return interpolation(400,0.65,Py,500,0.6);
                                            if(Py > 500)
                                                return 0.6;
                                        }
                                        if(rowNum == 4){
                                            if(Py >= 0 && Py <= 5)
                                                return 1;
                                            if(Py > 5 && Py <= 10)
                                                return interpolation(5,1,Py,10,1);
                                            if(Py > 10 && Py <= 15)
                                                return interpolation(10,1,Py,15,0.95);
                                            if(Py > 15 && Py <= 25)
                                                return interpolation(15,0.95,Py,25,0.9);
                                            if(Py > 25 && Py <= 50)
                                                return interpolation(25,0.9,Py,50,0.85);
                                            if(Py > 50 && Py <= 100)
                                                return interpolation(50,0.85,Py,100,0.8);
                                            if(Py > 100 && Py <= 200)
                                                return interpolation(100,0.8,Py,200,0.75);
                                            if(Py > 200 && Py <= 400)
                                                return interpolation(200,0.75,Py,400,0.7);
                                            if(Py > 400 && Py <= 500)
                                                return interpolation(400,0.7,Py,500,0.65);
                                            if(Py > 500)
                                                return 0.65;
                                        }
                                        if(rowNum == 5){
                                            if(Py >= 0 && Py <= 5)
                                                return 1;
                                            if(Py > 5 && Py <= 10)
                                                return interpolation(5,1,Py,10,1);
                                            if(Py > 10 && Py <= 15)
                                                return interpolation(10,1,Py,15,1);
                                            if(Py > 15 && Py <= 25)
                                                return interpolation(15,1,Py,25,1);
                                            if(Py > 25 && Py <= 50)
                                                return interpolation(25,1,Py,50,1);
                                            if(Py > 50 && Py <= 100)
                                                return interpolation(50,1,Py,100,1);
                                            if(Py > 100 && Py <= 200)
                                                return interpolation(100,1,Py,200,1);
                                            if(Py > 200 && Py <= 400)
                                                return interpolation(200,1,Py,400,1);
                                            if(Py > 400 && Py <= 500)
                                                return interpolation(400,1,Py,500,1);
                                            if(Py > 500)
                                                return 1;
                                        }
                                        if(rowNum == 6){
                                            if(Py >= 0 && Py <= 5)
                                                return 1;
                                            if(Py > 5 && Py <= 10)
                                                return interpolation(5,1,Py,10,0.9);
                                            if(Py > 10 && Py <= 15)
                                                return interpolation(10,0.9,Py,15,0.8);
                                            if(Py > 15 && Py <= 25)
                                                return interpolation(15,0.8,Py,25,0.75);
                                            if(Py > 25 && Py <= 50)
                                                return interpolation(25,0.75,Py,50,0.7);
                                            if(Py > 50 && Py <= 100)
                                                return interpolation(50,0.7,Py,100,0.65);
                                            if(Py > 100 && Py <= 200)
                                                return interpolation(100,0.65,Py,200,0.55);
                                            if(Py > 200 && Py <= 400)
                                                return interpolation(200,0.55,Py,400,0.6);
                                            if(Py > 400 && Py <= 500)
                                                return interpolation(400,0.6,Py,500,0.6);
                                            if(Py > 500)
                                                return 0.6;
                                        }
                                        if(rowNum == 7){
                                            if(Py >= 0 && Py <= 5)
                                                return 1;
                                            if(Py > 5 && Py <= 10)
                                                return interpolation(5,1,Py,10,0.9);
                                            if(Py > 10 && Py <= 15)
                                                return interpolation(10,0.9,Py,15,0.8);
                                            if(Py > 15 && Py <= 25)
                                                return interpolation(15,0.8,Py,25,0.7);
                                            if(Py > 25 && Py <= 50)
                                                return interpolation(25,0.7,Py,50,0.65);
                                            if(Py > 50 && Py <= 100)
                                                return interpolation(50,0.65,Py,100,0.6);
                                            if(Py > 100 && Py <= 200)
                                                return interpolation(100,0.6,Py,200,0.5);
                                            if(Py > 200 && Py <= 400)
                                                return interpolation(200,0.5,Py,400,0.5);
                                            if(Py > 400 && Py <= 500)
                                                return interpolation(400,0.5,Py,500,0.5);
                                            if(Py > 500)
                                                return 0.5;
                                        }
                                    }
                                }
                                
								function loadCalcResPubBuildingsTab6_8(Np){
                                    if(	isNaN(Np) || (!isNaN(Np) && Np < 0))
                                        return null;
                                    else {
                                        if(Np >= 0 && Np <= 2)
                                            return 0.9;
                                        if(Np > 2 && Np <= 3)
                                            return interpolation(2,0.9,Np,3,0.85);
                                        if(Np > 3 && Np <= 5)
                                            return interpolation(3,0.85,Np,5,0.75);
                                        if(Np > 5 && Np <= 8)
                                            return interpolation(5,0.75,Np,8,0.65);
                                        if(Np > 8 && Np <= 10)
                                            return interpolation(8,0.65,Np,10,0.6);
                                        if(Np > 10 && Np <= 15)
                                            return interpolation(10,0.6,Np,15,0.5);
                                        if(Np > 15 && Np <= 20)
                                            return interpolation(15,0.5,Np,20,0.45);
                                        if(Np > 20 && Np <= 30)
                                            return interpolation(20,0.45,Np,30,0.4);
                                        if(Np > 30 && Np <= 60)
                                            return interpolation(30,0.4,Np,60,0.3);
                                        if(Np > 60 && Np <= 100)
                                            return interpolation(60,0.3,Np,100,0.3);
                                        if(Np > 100 && Np <= 120)
                                            return interpolation(100,0.3,Np,120,0.25);
                                        if(Np > 120)
                                            return 0.25;
                                    }
                                }
                                
								function loadCalcResPubBuildingsTab6_6(buildType, networkType){
                                    if(	isNaN(buildType) ||
                                        buildType < 0 ||
                                        isNaN(networkType) ||
                                        networkType < 0 )
                                        return 'error';
                                    else {
                                        if(buildType == '1'){
                                            if(networkType == '1') return 1;
                                            if(networkType == '2') return 0.2;
                                            if(networkType == '3') return 0.1;
                                        }
                                        if(buildType == '2'){
                                            if(networkType == '1') return 1;
                                            if(networkType == '2') return 0.4;
                                            if(networkType == '3') return 0.2;
                                        }
                                        return null;
                                    }
                                }
                                
								function loadCalcResPubBuildingsTab6_11_k(Pp_osv_sil, Pp_hol, rowNum){
                                    if(	isNaN(Pp_osv_sil) || (!isNaN(Pp_osv_sil) && Pp_osv_sil < 0) ||
										isNaN(rowNum) || (!isNaN(rowNum) && rowNum < 0))
                                        return null;
                                    else {
                                        if( Pp_hol == null ){
                                            if( rowNum == 1 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return interpolation(20,0.9,Pp_osv_sil,75,0.85);
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return interpolation(75,0.85,Pp_osv_sil,140,0.9);
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil <= 250 )
                                                    return 0.9;
												if( Pp_osv_sil > 250 )
                                                    return 1.0;
                                            }
                                            if( rowNum == 2 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return interpolation(20,0.95,Pp_osv_sil,75,0.9);
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return interpolation(75,0.9,Pp_osv_sil,140,0.95);
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil <= 250 )
                                                    return 0.95;
												if( Pp_osv_sil > 250 )
                                                    return 1.0;
                                            }
                                            if( rowNum == 3 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return interpolation(20,0.85,Pp_osv_sil,75,0.8);
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return interpolation(75,0.8,Pp_osv_sil,140,0.85);
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil <= 250 )
                                                    return 0.85;
												if( Pp_osv_sil > 250 )
                                                    return 1.0;
                                            }
                                            if( rowNum == 4 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return interpolation(20,0.85,Pp_osv_sil,75,0.75);
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return interpolation(75,0.75,Pp_osv_sil,140,0.85);
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil <= 250 )
                                                    return 0.85;
												if( Pp_osv_sil > 250 )
                                                    return 1.0;
                                            }
                                            if( rowNum == 5 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return interpolation(20,0.95,Pp_osv_sil,75,0.9);
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return interpolation(75,0.9,Pp_osv_sil,140,0.95);
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil <= 250 )
                                                    return 0.95;
												if( Pp_osv_sil > 250 )
                                                    return 1.0;
                                            }
                                        } else {
                                            if( rowNum == 1 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return 0.85;
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return 0.75;
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil < 250 )
                                                    return 0.85;
                                                if( Pp_osv_sil >= 250 )
                                                    return 1;
                                            }
                                            if( rowNum == 2 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return 0.95;
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return 0.9;
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil < 250 )
                                                    return 0.95;
                                                if( Pp_osv_sil >= 250 )
                                                    return 1;
                                            }
                                            if( rowNum == 3 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return 0.85;
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return 0.8;
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil < 250 )
                                                    return 0.85;
                                                if( Pp_osv_sil >= 250 )
                                                    return 1;
                                            }
                                            if( rowNum == 4 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return 0.85;
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return 0.75;
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil < 250 )
                                                    return 0.85;
                                                if( Pp_osv_sil >= 250 )
                                                    return 1;
                                            }
                                            if( rowNum == 5 ){
                                                if( Pp_osv_sil >= 0 && Pp_osv_sil < 20 )
                                                    return 1;
                                                if( Pp_osv_sil >= 20 && Pp_osv_sil < 75 )
                                                    return 0.85;
                                                if( Pp_osv_sil >= 75 && Pp_osv_sil < 140 )
                                                    return 0.75;
                                                if( Pp_osv_sil >= 140 && Pp_osv_sil < 250 )
                                                    return 0.85;
                                                if( Pp_osv_sil >= 250 )
                                                    return 1;
                                            }
                                        }
                                    }
                                }
                                
								function loadCalcResPubBuildingsTab6_11_k1(Pp_osv_hol){
                                    if(	isNaN(Pp_osv_hol) || (!isNaN(Pp_osv_hol) && Pp_osv_hol < 0) )
                                        return null;
                                    else {
                                        if( Pp_osv_hol >= 0 && Pp_osv_hol < 15 )
                                            return 1;
                                        if( Pp_osv_hol >= 15 && Pp_osv_hol < 20 )
                                            return interpolation(15,1,Pp_osv_hol,20,0.8);
                                        if( Pp_osv_hol >= 20 && Pp_osv_hol < 50 )
                                            return interpolation(75,0.8,Pp_osv_hol,140,0.6);
                                        if( Pp_osv_hol >= 50 && Pp_osv_hol < 100 )
                                            return interpolation(75,0.6,Pp_osv_hol,140,0.4);
                                        if( Pp_osv_hol >= 100 && Pp_osv_hol < 150 )
                                            return interpolation(75,0.4,Pp_osv_hol,140,0.2);
                                        if( Pp_osv_hol >= 150 )
                                            return 0.2;
                                    }
                                }
								
								function loadCalcResPubBuildingsTab6_7(Np, rowNum){
                                    if(	isNaN(Np) || (!isNaN(Np) && Np < 0) ||
										isNaN(rowNum) || (!isNaN(rowNum) && 
											($.inArray(rowNum,[8,9,11,12,13,14,15,16,17]) == -1)))
                                        return null;
                                    else {
                                        if(Np >= 0 && Np <= 3)
											switch(rowNum){
												case 8: return 0.5;
												case 11: return 0.5;
												case 13: return 0.4;
												case 14: return 0.5;
												case 15: return 0.6;
												case 16: return 0.7;
												case 17: return 0.4;
												default: return null;
											}
                                        if(Np > 3 && Np <= 5)
                                            switch(rowNum){
												case 8: return interpolation(3,0.5,Np,5,0.2);
												case 11: return interpolation(3,0.5,Np,5,0.2);
												case 13: return interpolation(3,0.4,Np,5,0.15);
												case 14: return interpolation(3,0.5,Np,5,0.2);
												case 15: return interpolation(3,0.6,Np,5,0.3);
												case 16: return interpolation(3,0.7,Np,5,0.5);
												case 17: return interpolation(3,0.4,Np,5,0.15);
												default: return null;
											}
                                        if(Np > 5)
                                            switch(rowNum){
												case 8: return 0.2;
												case 11: return 0.2;
												case 13: return 0.15;
												case 14: return 0.2;
												case 15: return 0.3;
												case 16: return 0.5;
												case 17: return 0.15;
												default: return null;
											}
                                    }
									return null;
                                }
								
								function loadCalcResPubBuildingsTab2_1(Np){
                                    if(	isNaN(Np) || (!isNaN(Np) && Np < 0))
                                        return null;
                                    else {
                                        if(Np >= 0 && Np <= 3) return 0.95;
                                        if(Np > 3 && Np <= 5) return interpolation(3,0.95,Np,5,0.9);
                                        if(Np > 5 && Np <= 8) return interpolation(5,0.9,Np,8,0.8);
										if(Np > 8 && Np <= 10) return interpolation(8,0.8,Np,10,0.7);
										if(Np > 10 && Np <= 20) return interpolation(10,0.7,Np,20,0.65);
										if(Np > 20 && Np <= 30) return interpolation(20,0.65,Np,30,0.6);
										if(Np > 30 && Np <= 40) return interpolation(30,0.6,Np,40,0.55);
										if(Np > 40) return 0.55;
                                    }
									return null;
                                }
								
								function loadCalcResPubBuildingsTab2_2(Np){
                                    if(	isNaN(Np) || (!isNaN(Np) && Np < 0))
                                        return null;
                                    else {
                                        if(Np >= 0 && Np <= 3) return 0.6;
                                        if(Np > 3 && Np <= 5) return interpolation(3,0.6,Np,5,0.5);
                                        if(Np > 5 && Np <= 8) return interpolation(5,0.5,Np,8,0.45);
										if(Np > 8 && Np <= 10) return interpolation(8,0.45,Np,10,0.4);
										if(Np > 10 && Np <= 20) return interpolation(10,0.4,Np,20,0.35);
										if(Np > 20 && Np <= 30) return interpolation(20,0.35,Np,30,0.3);
										if(Np > 30 && Np <= 40) return interpolation(30,0.3,Np,40,0.25);
										if(Np > 40) return 0.25;
                                    }
									return null;
                                }

                                function loadCalcResPubBuildingsCalc(){
									Pp_osv_sil = null;			Pp_osv_hol = null;			Pp_osv = null;
									Pp_hol = null;				Pp = null;					K = null;
									K1 = null;					K_crash = null;				K_fire = null;
									Py_crash = null;			Py_fire = null;				Qy_crash = null;
									Qy_fire = null;				Pp_crash = null;			Pp_fire = null;
									Pp_smoke_fire_equip = null;	Pp_fire_involv = null;		Qp = null;
									Qp_hol = null;				Qp_smoke_fire_equip = null;	Qp_fire_involv = null;
									tgf_crash = null;			tgf_fire = null;			cosf_crash = null;
									cosf_fire = null;			Sp_crash = null;			Sp_fire = null;
									Ip_crash = null;			Ip_fire = null;				/**/
									$.each($("#loadTypeArrData").children(),function(key,value){
										currConsNum = $(value).find('#consumersType').val();
										if($.inArray(currConsNum,['14','15']) != -1) 
											Pp_osv += $(value).find('#Pp').val().replace(',','.') * 1.0;
										if($.inArray(currConsNum,['3','4']) != -1){ 
											Pp_hol += $(value).find('#Pp').val().replace(',','.') * 1.0;
											Qp_hol += $(value).find('#Qp').val().replace(',','.') * 1.0;
										}
										if($.inArray(currConsNum,['2','18','19']) != -1){ 
											Pp_smoke_fire_equip += $(value).find('#Pp').val().replace(',','.') * 1.0;
											Qp_smoke_fire_equip += $(value).find('#Qp').val().replace(',','.') * 1.0
										}
										if($(value).find('#fireInvolved1').prop("checked")){
											Pp_fire_involv += $(value).find('#Pp').val().replace(',','.') * 1.0;
											Qp_fire_involv += $(value).find('#Qp').val().replace(',','.') * 1.0;
										}
										Pp += $(value).find('#Pp').val().replace(',','.') * 1.0;
										Qp += $(value).find('#Qp').val().replace(',','.') * 1.0;
										Py_crash += $(value).find('#Py').val().replace(',','.') * 1.0;
										Qy_crash += $(value).find('#Qy').val().replace(',','.') * 1.0;
									});									
									Pp_osv_sil = (Pp_osv / (Pp - Pp_osv)) * 100.0;
									Pp_osv_hol = (Pp_osv / Pp_hol) * 100.0;
									if(isNaN(Pp_osv_sil)) return false;
									rowNum = $('[name = buildtypekc]:checked').val() * 1.0;
									K = loadCalcResPubBuildingsTab6_11_k(Pp_osv_sil, Pp_hol, rowNum);
									K1 = loadCalcResPubBuildingsTab6_11_k1(Pp_osv_hol);
									Py_fire = Py_crash;
									Qy_fire = Qy_crash;
									Pp_crash = K * Pp - Pp_smoke_fire_equip + K1 * Pp_hol;
									Pp_fire = K * Pp_fire_involv;
									K_crash = Pp_crash / Py_crash;
									K_fire = Pp_fire / Py_fire;
									Qp_crash = K * Qp - Qp_smoke_fire_equip + K1 * Qp_hol;
									Qp_fire = K * Qp_fire_involv;
									tgf_crash = Qp_crash / Pp_crash;
									tgf_fire = Qp_fire / Pp_fire;
									cosf_crash = Math.cos(Math.atan(tgf_crash));
									cosf_fire = Math.cos(Math.atan(tgf_fire));
									Sp_crash = Math.sqrt(Pp_crash * Pp_crash + Qp_crash * Qp_crash);
									Sp_fire = Math.sqrt(Pp_fire * Pp_fire + Qp_fire * Qp_fire);
									Ip_crash = Sp_crash / (Math.sqrt(3) * 0.38);
									Ip_fire = Sp_fire / (Math.sqrt(3) * 0.38);
									//
									$('#Pp_osv_sil_rez').val(Pp_osv_sil.toFixed(2).replace('.',','));
									$('#Pp_osv_hol_rez').val(Pp_osv_hol.toFixed(2).replace('.',','));
									$('#K_rez').val(K.toFixed(2).replace('.',','));
									$('#K1_rez').val(K1.toFixed(2).replace('.',','));
									//
									$('#Py_crash_rez').val(Py_crash.toFixed(2).replace('.',','));
									$('#Qy_crash_rez').val(Qy_crash.toFixed(2).replace('.',','));
									$('#K_crash_rez').val(K_crash.toFixed(2).replace('.',','));
									$('#Pp_crash_rez').val(Pp_crash.toFixed(2).replace('.',','));
									$('#Qp_crash_rez').val(Qp_crash.toFixed(2).replace('.',','));
									$('#cosf_crash_rez').val(cosf_crash.toFixed(2).replace('.',','));
									$('#tgf_crash_rez').val(tgf_crash.toFixed(2).replace('.',','));
									$('#Sp_crash_rez').val(Sp_crash.toFixed(2).replace('.',','));
									$('#Ip_crash_rez').val(Ip_crash.toFixed(2).replace('.',','));
									//
									$('#Py_fire_rez').val(Py_fire.toFixed(2).replace('.',','));
									$('#Qy_fire_rez').val(Qy_fire.toFixed(2).replace('.',','));
									$('#K_fire_rez').val(K_fire.toFixed(2).replace('.',','));
									$('#Pp_fire_rez').val(Pp_fire.toFixed(2).replace('.',','));
									$('#Qp_fire_rez').val(Qp_fire.toFixed(2).replace('.',','));
									$('#cosf_fire_rez').val(cosf_fire.toFixed(2).replace('.',','));
									$('#tgf_fire_rez').val(tgf_fire.toFixed(2).replace('.',','));
									$('#Sp_fire_rez').val(Sp_fire.toFixed(2).replace('.',','));
									$('#Ip_fire_rez').val(Ip_fire.toFixed(2).replace('.',','));
									
								}
								//кнопка "рассчитать"
                                $('#btncalc7').click(function(){ loadCalcResPubBuildingsCalc(); })
								//кнопка "сброс"
                                $('#btnclear7').click(function() {
                                    $('#loadTypeArrData').empty();
									$('#floorcountlist_').val('1');
									$('#rad89').iCheck('check');
									$('#rad80').iCheck('check');
                                    blockAddCount = 0;
                                    consumersArr = [];
                                    addedConsumersArr = [];
                                    consumersOldValues = [];
									//
                                    $('#Pp_osv_sil_rez').html('');
									$('#Pp_osv_hol_rez').html('');
									$('#K_rez').html('');
									$('#K1_rez').html('');
									$('#Py_crash_rez').val('');
									$('#Qy_crash_rez').val('');
									$('#K_crash_rez').val('');
									$('#Pp_crash_rez').val('');
									$('#Qp_crash_rez').val('');
									$('#cosf_crash_rez').val('');
									$('#tgf_crash_rez').val('');
									$('#Sp_crash_rez').val('');
									$('#Ip_crash_rez').val('');
									//
									$('#Py_fire_rez').val('');
									$('#Qy_fire_rez').val('');
									$('#K_fire_rez').val('');
									$('#Pp_fire_rez').val('');
									$('#Qp_fire_rez').val('');
									$('#cosf_fire_rez').val('');
									$('#tgf_fire_rez').val('');
									$('#Sp_fire_rez').val('');
									$('#Ip_fire_rez').val('');
									//
									$('#loadTypeAddElement').prop('disabled', false);
                                });
							</script>
						</div>
						<div class="tab-pane" id="panel-359132">
                            <br>
							<form class="topdf-form" action="to_pdf.php?form=load_curent" method="post">
								<input type="hidden" name="pageTitle" value="Расчет тока утечки">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="row" style="margin-top: 20px">
													<div class="col-md-5"><p class="red_text">Длина линии, м</p></div>
													<div class="col-md-4"><input type="text" id="linelength1"  name="linelength1" value=""></div>
													<div class="col-md-3"></div>
												</div>
												<div class="row" style="margin-top: 15px">
													<div class="col-md-5"><p class="red_text">Ток нагрузки, А</p></div>
													<div class="col-md-4"><input type="text" id="loadcurrent1"  name="loadcurrent1" value=""></div>
													<div class="col-md-3"></div>
												</div>
												<div class="row" style="margin-top: 20px">
													<div class="col-md-5"><label class="control-label red_text" style="margin-top:8px;">Ток утечки, мА:</label></div>
													<div class="col-md-4"><label class="control-label rez_text" id="lbrez36"></label></div>
													<div class="col-md-3"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
							<script>
								$('#linelength1').change(function(){
									loadCurentCalc();
									return false;
								});
								$('#loadcurrent1').change(function(){
									loadCurentCalc();
									return false;
								});
								function loadCurentCalc() {
									
									var L = parseFloat($("#linelength1").val());
									var In = parseFloat($("#loadcurrent1").val());
									var delta_i = 0.4 * In + 0.01 * L;
									if(!isNaN(delta_i)){
										$('#lbrez36').html(delta_i.toFixed(2)/* + " мА"*/);
										$('#lbrez36').append('<input type="hidden" name="rez36" value="' + delta_i.toFixed(2) + '">');
										sendCntAjax('masterscale','calc','calc',null);
									} else {
										$('#lbrez36').html("");
									}
								}
							</script>
						</div>
						<div class="tab-pane" id="panel-359133">
                            <form id="kzform" class="topdf-form" action="to_pdf.php?form=kz" method="post" >
								<input type="hidden" name="pageTitle" value="Расчёт токов короткого замыкания">
								<div class="row" style="border-bottom: 1px solid #cecece;/* */padding-top: 15px; padding-bottom: 15px;">
									<div class="col-sm-2">
										<label class="control-label red_text">Тип кабеля:</label>
									</div>
									<div class="col-sm-10">
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad101" value="0">
											<label for="rad101" class="label_text" style="margin-left: 10px;">3-x жильный кабель с алюминиевыми жилами в алюминиевой оболочке</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad102" value="1">
											<label for="rad102" class="label_text" style="margin-left: 10px;">3-x жильный кабель с алюминиевыми жилами в свинцовой оболочке</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad103" value="2">
											<label for="rad103" class="label_text" style="margin-left: 10px;">3-x жильный кабель с алюминиевыми жилами в непроводящей оболочке</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad104" value="3">
											<label for="rad104" class="label_text" style="margin-left: 10px;">4-x жильный кабель (3 + 1) с алюминиевыми жилами в алюминиевой оболочке</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad105" value="4">
											<label for="rad105" class="label_text" style="margin-left: 10px;">4-x жильный кабель(3 + 1) с алюминиевыми жилами в свинцовой оболочке</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad106" value="5">
											<label for="rad106" class="label_text" style="margin-left: 10px;">4-x жильный кабель (3 + 1) с алюминиевыми жилами в непроводящей оболочке</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad107" value="6">
											<label for="rad107" class="label_text" style="margin-left: 10px;">3-x жильный кабель с медными жилами в стальной оболочке</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad108" value="7">
											<label for="rad108" class="label_text" style="margin-left: 10px;">4-x жильный кабель (3 + 1) с медными жилами в стальной оболочке</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="cabletype1" id="rad109" value="8">
											<label for="rad109" class="label_text" style="margin-left: 10px;">4-x жильный кабель с медными жилами в стальной оболочке</label>
										</div><br>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece;/* */padding-top: 15px; padding-bottom: 15px;">
									<div class="col-sm-2">
										<label class="control-label red_text">Количество жил и сечение, (шт., мм<sup>2</sup>):</label>
									</div>
									<div class="col-sm-10">
										<select class="selectpicker" id="cabletypesp1" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">3x4</option>
											<option value="1">3x6</option>
											<option value="2">3x10</option>
											<option value="3">3x16</option>
											<option value="4">3x25</option>
											<option value="5">3x35</option>
											<option value="6">3x50</option>
											<option value="7">3x70</option>
											<option value="8">3x95</option>
											<option value="9">3x120</option>
											<option value="10">3x150</option>
											<option value="11">3x185</option>
											<option value="12">3x240</option>
										</select>
										<select class="selectpicker" id="cabletypesp2" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">3x4</option>
											<option value="1">3x6</option>
											<option value="2">3x10</option>
											<option value="3">3x16</option>
											<option value="4">3x25</option>
											<option value="5">3x35</option>
											<option value="6">3x50</option>
											<option value="7">3x70</option>
											<option value="8">3x95</option>
											<option value="9">3x120</option>
											<option value="10">3x150</option>
											<option value="11">3x185</option>
											<option value="12">3x240</option>
										</select>
										<select class="selectpicker" id="cabletypesp3" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">3x4</option>
											<option value="1">3x6</option>
											<option value="2">3x10</option>
											<option value="3">3x16</option>
											<option value="4">3x25</option>
											<option value="5">3x35</option>
											<option value="6">3x50</option>
											<option value="7">3x70</option>
											<option value="8">3x95</option>
											<option value="9">3x120</option>
											<option value="10">3x150</option>
										</select>
										<select class="selectpicker" id="cabletypesp4" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">3x4 + 1x2,5</option>
											<option value="1">3x6 + 1x4</option>
											<option value="2">3x10 + 1x6</option>
											<option value="3">3x16 + 1x10</option>
											<option value="4">3x25 + 1x16</option>
											<option value="5">3x35 + 1x16</option>
											<option value="6">3x50 + 1x25</option>
											<option value="7">3x70 + 1x35</option>
											<option value="8">3x95 + 1x50</option>
										</select>
										<select class="selectpicker" id="cabletypesp5" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">3x4 + 1x2,5</option>
											<option value="1">3x6 + 1x4</option>
											<option value="2">3x10 + 1x6</option>
											<option value="3">3x16 + 1x10</option>
											<option value="4">3x25 + 1x16</option>
											<option value="5">3x35 + 1x16</option>
											<option value="6">3x50 + 1x25</option>
											<option value="7">3x70 + 1x35</option>
											<option value="8">3x95 + 1x50</option>
											<option value="9">3x120 + 1x50</option>
											<option value="10">3x150 + 1x70</option>
											<option value="11">3x185 + 1x70</option>
										</select>
										<select class="selectpicker" id="cabletypesp6" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">3x4 + 1x2,5</option>
											<option value="1">3x6 + 1x4</option>
											<option value="2">3x10 + 1x6</option>
											<option value="3">3x16 + 1x10</option>
											<option value="4">3x25 + 1x16</option>
											<option value="5">3x35 + 1x16</option>
											<option value="6">3x50 + 1x25</option>
											<option value="7">3x70 + 1x35</option>
											<option value="8">3x95 + 1x50</option>
											<option value="9">3x120 + 1x50</option>
											<option value="10">3x150 + 1x70</option>
										</select>
										<select class="selectpicker" id="cabletypesp7" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">3x6</option>
											<option value="1">3x10</option>
											<option value="2">3x16</option>
											<option value="3">3x25</option>
											<option value="4">3x35</option>
											<option value="5">3x50</option>
											<option value="6">3x70</option>
											<option value="7">3x95</option>
											<option value="8">3x120</option>
											<option value="9">3x150</option>
											<option value="10">3x185</option>
											<option value="11">3x240</option>
										</select>
										<select class="selectpicker" id="cabletypesp8" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">3x6 + 1x4</option>
											<option value="1">3x10 + 1x6</option>
											<option value="2">3x16 + 1x10</option>
											<option value="3">3x25 + 1x16</option>
											<option value="4">3x35 + 1x16</option>
											<option value="5">3x50 + 1x25</option>
											<option value="6">3x70 + 1x25</option>
											<option value="7">3x70 + 1x35</option>
											<option value="8">3x95 + 1x35</option>
											<option value="9">3x95 + 1x50</option>
											<option value="10">3x120 + 1x35</option>
											<option value="11">3x120 + 1x70</option>
											<option value="12">3x150 + 1x50</option>
											<option value="13">3x150 + 1x70</option>
											<option value="14">3x185 + 1x50</option>
											<option value="15">3x185 + 1x95</option>
										</select>
										<select class="selectpicker" id="cabletypesp9" style="width: 170px">
											<!--option value="" selected="">Выберите...</option-->
											<option value="0">4x6</option>
											<option value="1">4x10</option>
											<option value="2">4x16</option>
											<option value="3">4x25</option>
											<option value="4">4x35</option>
											<option value="5">4x50</option>
											<option value="6">4x70</option>
											<option value="7">4x95</option>
											<option value="8">4x120</option>
											<option value="9">4x150</option>
											<option value="10">4x185</option>
										</select>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; margin-top: 20px; padding-bottom: 15px;">
									<div class="col-md-2"><p class="red_text">Длина кабеля (м)</p></div>
									<div class="col-md-10"><input type="text" id="cablelength1" value="" style="width: 170px"></div>
								</div>
								<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-6">
										<button class="btn btn_calc" id="btncalc8" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);calcKZ();return false;">Рассчитать</button>
										<button class="btn btn_reset" id="btnclear8" style="margin-left:15px; display: inline-block;">Сброс</button>
									</div>
								</div>
								<div class="row" style="margin-top: 20px">
									<div class="col-sm-4"><label class="control-label red_text" style="margin-top:8px;">Однофазное КЗ:</label></div>
									<div class="col-sm-4"><label class="control-label red_text" style="margin-top:8px;">Двухфазное КЗ:</label></div>
									<div class="col-sm-4"><label class="control-label red_text" style="margin-top:8px;">Трехфазное КЗ:</label></div>
								</div>
								<div class="row" style="margin-top: 20px">
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">R1 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez37"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">R1 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez41"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">R1 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez45"></label></div>
								</div>
								<div class="row" style="margin-top: 20px">
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">X1 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez38"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">X1 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez42"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">X1 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez46"></label></div>
								</div>
								<div class="row" style="margin-top: 20px">
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">R0 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez39"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">R0 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez43"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">R0 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez47"></label></div>
								</div>
								<div class="row" style="margin-top: 20px">
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">X0 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez40"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">X0 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez44"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">X0 ,(Ом):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez48"></label></div>
								</div>

								<div class="row" style="">
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">Iкз ,(А):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez49"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">Iкз ,(А):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez50"></label></div>
									<div class="col-md-2"><label class="control-label red_text" style="margin-top:8px;">Iкз ,(А):</label></div>
									<div class="col-md-2"><label class="control-label rez_text" id="lbrez51"></label></div>
								</div>
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
                            <script>
                                $('#cabletypesp1').show();
                                $('#cabletypesp2').hide();
                                $('#cabletypesp3').hide();
                                $('#cabletypesp4').hide();
                                $('#cabletypesp5').hide();
                                $('#cabletypesp6').hide();
                                $('#cabletypesp7').hide();
                                $('#cabletypesp8').hide();
                                $('#cabletypesp9').hide();/**/
                                $('input:radio[name=cabletype1]#rad101').iCheck('check');
                                $('input:radio[name=cabletype1]').on('ifChecked',function(){
                                    //alert($(this).val());
                                    switch($(this).attr('id')){
                                        case 'rad101':
                                            $('#cabletypesp1').show();
                                            $('#cabletypesp2').hide();
                                            $('#cabletypesp3').hide();
                                            $('#cabletypesp4').hide();
                                            $('#cabletypesp5').hide();
                                            $('#cabletypesp6').hide();
                                            $('#cabletypesp7').hide();
                                            $('#cabletypesp8').hide();
                                            $('#cabletypesp9').hide();
                                            break;
                                        case 'rad102':
                                            $('#cabletypesp1').hide();
                                            $('#cabletypesp2').show();
                                            $('#cabletypesp3').hide();
                                            $('#cabletypesp4').hide();
                                            $('#cabletypesp5').hide();
                                            $('#cabletypesp6').hide();
                                            $('#cabletypesp7').hide();
                                            $('#cabletypesp8').hide();
                                            $('#cabletypesp9').hide();
                                            break;
                                        case 'rad103':
                                            $('#cabletypesp1').hide();
                                            $('#cabletypesp2').hide();
                                            $('#cabletypesp3').show();
                                            $('#cabletypesp4').hide();
                                            $('#cabletypesp5').hide();
                                            $('#cabletypesp6').hide();
                                            $('#cabletypesp7').hide();
                                            $('#cabletypesp8').hide();
                                            $('#cabletypesp9').hide();
                                            break;
                                        case 'rad104':
                                            $('#cabletypesp1').hide();
                                            $('#cabletypesp2').hide();
                                            $('#cabletypesp3').hide();
                                            $('#cabletypesp4').show();
                                            $('#cabletypesp5').hide();
                                            $('#cabletypesp6').hide();
                                            $('#cabletypesp7').hide();
                                            $('#cabletypesp8').hide();
                                            $('#cabletypesp9').hide();
                                            break;
                                        case 'rad105':
                                            $('#cabletypesp1').hide();
                                            $('#cabletypesp2').hide();
                                            $('#cabletypesp3').hide();
                                            $('#cabletypesp4').hide();
                                            $('#cabletypesp5').show();
                                            $('#cabletypesp6').hide();
                                            $('#cabletypesp7').hide();
                                            $('#cabletypesp8').hide();
                                            $('#cabletypesp9').hide();
                                            break;
                                        case 'rad106':
                                            $('#cabletypesp1').hide();
                                            $('#cabletypesp2').hide();
                                            $('#cabletypesp3').hide();
                                            $('#cabletypesp4').hide();
                                            $('#cabletypesp5').hide();
                                            $('#cabletypesp6').show();
                                            $('#cabletypesp7').hide();
                                            $('#cabletypesp8').hide();
                                            $('#cabletypesp9').hide();
                                            break;
                                        case 'rad107':
                                            $('#cabletypesp1').hide();
                                            $('#cabletypesp2').hide();
                                            $('#cabletypesp3').hide();
                                            $('#cabletypesp4').hide();
                                            $('#cabletypesp5').hide();
                                            $('#cabletypesp6').hide();
                                            $('#cabletypesp7').show();
                                            $('#cabletypesp8').hide();
                                            $('#cabletypesp9').hide();
                                            break;
                                        case 'rad108':
                                            $('#cabletypesp1').hide();
                                            $('#cabletypesp2').hide();
                                            $('#cabletypesp3').hide();
                                            $('#cabletypesp4').hide();
                                            $('#cabletypesp5').hide();
                                            $('#cabletypesp6').hide();
                                            $('#cabletypesp7').hide();
                                            $('#cabletypesp8').show();
                                            $('#cabletypesp9').hide();
                                            break;
                                        case 'rad109':
                                            $('#cabletypesp1').hide();
                                            $('#cabletypesp2').hide();
                                            $('#cabletypesp3').hide();
                                            $('#cabletypesp4').hide();
                                            $('#cabletypesp5').hide();
                                            $('#cabletypesp6').hide();
                                            $('#cabletypesp7').hide();
                                            $('#cabletypesp8').hide();
                                            $('#cabletypesp9').show();
                                            break;
                                    }
                                });
                                
								$('#kzform').submit(function(event) {
								    radioId = $('.checked input:radio[name=cabletype1]').attr('id');
									radioVal = $('.checked input:radio[name=cabletype1]').val();
									radioLabel = $('label[for='+radioId+']').html();
									
									// Предотвращаем обычную отправку формы
									event.preventDefault();
								
									var formData = $('#kzform').serializeArray();
									formData.push({name: 'ajax',value: true});
									formData.push({name: 'cabletype1_html',value: radioLabel});
									switch(radioVal){
										case '0': 
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp1 option:selected').html()});
											break;
                                        case '1': 
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp2 option:selected').html()});
											break;
                                        case '2': 
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp3 option:selected').html()});
											break;
                                        case '3': 
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp4 option:selected').html()});
											break;
                                        case '4': 
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp5 option:selected').html()});
											break;
                                        case '5':  
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp6 option:selected').html()});
											break;
                                        case '6':  
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp7 option:selected').html()});
											break;
                                        case '7':  
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp8 option:selected').html()});
											break;
                                        case '8':  
											formData.push({name: 'cabletypesp_html',value: $('#cabletypesp9 option:selected').html()});
											break;
										default: break;
									}
									formData.push({name: 'cablelength1',value: $('#cablelength1').val()});
									formData.push({name: 'rez37',value: $('#lbrez37').html()});
									formData.push({name: 'rez38',value: $('#lbrez38').html()});
									formData.push({name: 'rez39',value: $('#lbrez39').html()});
									formData.push({name: 'rez40',value: $('#lbrez40').html()});
									formData.push({name: 'rez49',value: $('#lbrez49').html()});
									formData.push({name: 'rez41',value: $('#lbrez41').html()});
									formData.push({name: 'rez42',value: $('#lbrez42').html()});
									formData.push({name: 'rez43',value: $('#lbrez43').html()});
									formData.push({name: 'rez44',value: $('#lbrez44').html()});
									formData.push({name: 'rez50',value: $('#lbrez50').html()});
									formData.push({name: 'rez45',value: $('#lbrez45').html()});
									formData.push({name: 'rez46',value: $('#lbrez46').html()});
									formData.push({name: 'rez47',value: $('#lbrez47').html()});
									formData.push({name: 'rez48',value: $('#lbrez48').html()});
									formData.push({name: 'rez51',value: $('#lbrez51').html()});
								    
									$.post(	'to_pdf.php?form=kz', 
											formData,
								            function(data) {
												window.location = '/../' + data;
								            });/**/
							    });
								
								function getCableFeaturesOnType(type, feature){
                                    if( isNaN(parseFloat(type)) ||
                                        isNaN(parseFloat(feature)) )
                                        return 'error';
                                    featureObj = null;
                                    switch(type){
                                        case '0':   //Параметры_3_жильного_кабеля_с_алюминиевыми_жилами_в_алюминиевой_оболочке
                                            switch(feature){
                                                case '0':
                                                    return {    r1: 9.61, r2: 9.61,
																x1_1: 0.12, x2_1: 0.12,
																x1_3: 0.09, x2_3: 0.09,
																r0: 9.61,
																x0_1: 0.12, x0_3: 0.09 };
                                                case '1':
                                                    return {    r1: 6.41, r2: 6.41,
																x1_1: 0.12, x2_1: 0.12,
																x1_3: 0.09, x2_3: 0.09,
																r0: 6.41,
																x0_1: 0.12, x0_3: 0.09 };
                                                case '2':
                                                    return {    r1: 3.84, r2: 3.84,
																x1_1: 0.11, x2_1: 0.11,
																x1_3: 0.09, x2_3: 0.09,
																r0: 3.84,
																x0_1: 0.11, x0_3: 0.09 };
                                                case '3':
                                                    return {    r1: 2.4, r2: 2.4,
																x1_1: 0.11, x2_1: 0.11,
																x1_3: 0.09, x2_3: 0.09,
																r0: 2.4,
																x0_1: 0.11, x0_3: 0.09 };
                                                case '4':
                                                    return {    r1: 1.54, r2: 1.54,
																x1_1: 0.1, x2_1: 0.1,
																x1_3: 0.08, x2_3: 0.08,
																r0: 1.54,
																x0_1: 0.1, x0_3: 0.08 };
                                                case '5':
                                                    return {    r1: 1.1, r2: 1.1,
																x1_1: 0.1, x2_1: 0.1,
																x1_3: 0.08, x2_3: 0.08,
																r0: 1.1,
																x0_1: 0.1, x0_3: 0.08 };
                                                case '6':
                                                    return {    r1: 0.769, r2: 0.769,
																x1_1: 0.1, x2_1: 0.1,
																x1_3: 0.08, x2_3: 0.08,
																r0: 0.769,
																x0_1: 0.1, x0_3: 0.08 };
                                                case '7':
                                                    return {    r1: 0.549, r2: 0.549,
																x1_1: 0.09, x2_1: 0.09,
																x1_3: 0.08, x2_3: 0.08,
																r0: 0.549,
																x0_1: 0.09, x0_3: 0.08 };
                                                case '8':
                                                    return {    r1: 0.405, r2: 0.405,
																x1_1: 0.09, x2_1: 0.09,
																x1_3: 0.08, x2_3: 0.08,
																r0: 0.405,
																x0_1: 0.09, x0_3: 0.08 };
                                                case '9':
                                                    return {    r1: 0.32, r2: 0.32,
																x1_1: 0.09, x2_1: 0.09,
																x1_3: 0.07, x2_3: 0.07,
																r0: 0.32,
																x0_1: 0.09, x0_3: 0.07 };
                                                case '10':
                                                    return {    r1: 0.256, r2: 0.256,
																x1_1: 0.08, x2_1: 0.08,
																x1_3: 0.07, x2_3: 0.07,
																r0: 0.256,
																x0_1: 0.08, x0_3: 0.07 };
                                                case '11':
                                                    return {    r1: 0.208, r2: 0.208,
																x1_1: 0.08, x2_1: 0.08,
																x1_3: 0.07, x2_3: 0.07,
																r0: 0.208,
																x0_1: 0.08, x0_3: 0.07 };
                                                case '12':
                                                    return {    r1: 0.16, r2: 0.16,
																x1_1: 0.08, x2_1: 0.08,
                                                        		x1_3: 0.07, x2_3: 0.07,
																r0: 0.16,
																x0_1: 0.08, x0_3: 0.07 };
                                                default: return null;
                                            }
                                            break;
                                        case '1':   //Параметры_3_жильного_кабеля_с_алюминиевыми_жилами_в_свинцовой_оболочке
                                            switch(feature) {
                                                case '0':
                                                    featureObj = {	r1: 9.61,
                                                                    r2: 9.61,
                                                                    x1: 0.092,
                                                                    x2: 0.092,
                                                                    r0: 11.6,
                                                                    x0: 1.24 };
                                                    return featureObj;
                                                case '1':
                                                    featureObj = {	r1: 6.41,
                                                                    r2: 6.41,
                                                                    x1: 0.087,
                                                                    x2: 0.087,
                                                                    r0: 8.38,
                                                                    x0: 1.2 };
                                                    return featureObj;
                                                case '2':
                                                    featureObj = {	r1: 3.84,
                                                                    r2: 3.84,
                                                                    x1: 0.082,
                                                                    x2: 0.082,
                                                                    r0: 5.78,
                                                                    x0: 1.16 };
                                                    return featureObj;
                                                case '3':
                                                    featureObj = {	r1: 2.4,
                                                                    r2: 2.4,
                                                                    x1: 0.078,
                                                                    x2: 0.078,
                                                                    r0: 4.32,
                                                                    x0: 1.12 };
                                                    return featureObj;
                                                case '4':
                                                    return {    r1: 1.54, r2: 1.54,
                                                                x1: 0.062, x2: 0.062,
                                                                r0: 3.44,
                                                                x0: 1.07 };
                                                case '5':
                                                    return {    r1: 1.1, r2: 1.1,
                                                                x1: 0.061, x2: 0.061,
                                                                r0: 2.96,
                                                                x0: 1.01 };
                                                case '6':
                                                    return {    r1: 0.769, r2: 0.769,
                                                                x1: 0.06, x2: 0.06,
                                                                r0: 2.6,
                                                                x0: 0.963 };
                                                case '7':
                                                    return {    r1: 0.549, r2: 0.549,
                                                                x1: 0.059, x2: 0.059,
                                                                r0: 2.31,
                                                                x0: 0.884 };
                                                case '8':
                                                    return {    r1: 0.405, r2: 0.405,
                                                                x1: 0.057, x2: 0.057,
                                                                r0: 2.1,
                                                                x0: 0.793 };
                                                case '9':
                                                    return {    r1: 0.32, r2: 0.32,
                                                                x1: 0.057, x2: 0.057,
                                                                r0: 1.96,
                                                                x0: 0.742 };
                                                case '10':
                                                    return {    r1: 0.256, r2: 0.256,
                                                                x1: 0.056, x2: 0.056,
                                                                r0: 1.82,
                                                                x0: 0.671 };
                                                case '11':
                                                    return {    r1: 0.208, r2: 0.208,
                                                                x1: 0.056, x2: 0.056,
                                                                r0: 1.69,
                                                                x0: 0.606 };
                                                case '12':
                                                    return {    r1: 0.16, r2: 0.16,
                                                                x1: 0.055, x2: 0.055,
                                                                r0: 1.55,
                                                                x0: 0.535 };
                                                default:
                                                    return null;
                                            }
                                            break;
                                        case '2':   //Параметры_3_жильного_кабеля_с_алюминиевыми_жилами_в_непроводящей_оболочке
                                            switch(feature) {
                                                case '0':
                                                    return {    r1: 9.61, r2: 9.61,
                                                                x1: 0.092, x2: 0.092,
                                                                r0: 11.7,
                                                                x0: 2.31 };
                                                case '1':
                                                    return {    r1: 6.41, r2: 6.41,
                                                                x1: 0.087, x2: 0.087,
                                                                r0: 8.51,
                                                                x0: 2.274 };
                                                case '2':
                                                    return {    r1: 3.84, r2: 3.84,
                                                                x1: 0.082, x2: 0.082,
                                                                r0: 5.94,
                                                                x0: 2.24 };
                                                case '3':
                                                    return {    r1: 2.4, r2: 2.4,
                                                                x1: 0.078, x2: 0.078,
                                                                r0: 4.5,
                                                                x0: 2.2 };
                                                case '4':
                                                    return {    r1: 1.54, r2: 1.54,
                                                                x1: 0.062, x2: 0.062,
                                                                r0: 3.64,
                                                                x0: 2.17 };
                                                case '5':
                                                    return {    r1: 1.1, r2: 1.1,
                                                                x1: 0.061, x2: 0.061,
                                                                r0: 3.3,
                                                                x0: 2.14 };
                                                case '6':
                                                    return {    r1: 0.769, r2: 0.769,
                                                                x1: 0.06, x2: 0.06,
                                                                r0: 2.869,
                                                                x0: 2.08 };
                                                case '7':
                                                    return {    r1: 0.549, r2: 0.549,
                                                                x1: 0.059, x2: 0.059,
                                                                r0: 2.649,
                                                                x0: 2.07 };
                                                case '8':
                                                    return {    r1: 0.405, r2: 0.405,
                                                                x1: 0.057, x2: 0.057,
                                                                r0: 2.505,
                                                                x0: 2.05 };
                                                case '9':
                                                    return {    r1: 0.32, r2: 0.32,
                                                                x1: 0.057, x2: 0.057,
                                                                r0: 2.42,
                                                                x0: 2.03 };
                                                case '10':
                                                    return {    r1: 0.256, r2: 0.256,
                                                                x1: 0.056, x2: 0.056,
                                                                r0: 2.36,
                                                                x0: 2 };
                                                default:
                                                    return null;
                                            }
                                            break;
                                        case '3':   //Параметры_4_жильного_кабеля_с_алюминиевыми_жилами_в_алюминиевой_оболочке
                                            switch(feature) {
                                                case '0':
                                                    return {    r1: 9.61, r2: 9.61,
                                                                x1: 0.098, x2: 0.098,
                                                                r0: 10.87,
                                                                x0: 0.57 };
                                                case '1':
                                                    return {    r1: 6.41, r2: 6.41,
                                                                x1: 0.094, x2: 0.094,
                                                                r0: 7.6,
                                                                x0: 0.463 };
                                                case '2':
                                                    return {    r1: 3.84, r2: 3.84,
                                                                x1: 0.088, x2: 0.088,
                                                                r0: 4.94,
                                                                x0: 0.401 };
                                                case '3':
                                                    return {    r1: 2.4, r2: 2.4,
                                                                x1: 0.084, x2: 0.084,
                                                                r0: 3.39,
                                                                x0: 0.336 };
                                                case '4':
                                                    return {    r1: 1.54, r2: 1.54,
                                                                x1: 0.072, x2: 0.072,
                                                                r0: 2.41,
                                                                x0: 0.256 };
                                                case '5':
                                                    return {    r1: 1.1, r2: 1.1,
                                                                x1: 0.068, x2: 0.068,
                                                                r0: 1.94,
                                                                x0: 0.232 };
                                                case '6':
                                                    return {    r1: 0.769, r2: 0.769,
                                                                x1: 0.066, x2: 0.066,
                                                                r0: 1.44,
                                                                x0: 0.179 };
                                                case '7':
                                                    return {    r1: 0.549, r2: 0.549,
                                                                x1: 0.065, x2: 0.065,
                                                                r0: 1.11,
                                                                x0: 0.145 };
                                                case '8':
                                                    return {    r1: 0.405, r2: 0.405,
                                                                x1: 0.064, x2: 0.064,
                                                                r0: 0.887,
                                                                x0: 0.124 };
                                                default:
                                                    return null;
                                            }
                                            break;
                                        case '4':   //Параметры_4_жильного_кабеля_с_алюминиевыми_жилами_в_свинцовой_оболочке
                                            switch(feature) {
                                                case '0':
                                                    return {    r1: 9.61, r2: 9.61,
                                                                x1: 0.098, x2: 0.098,
                                                                r0: 11.52,
                                                                x0: 1.13 };
                                                case '1':
                                                    return {    r1: 6.41, r2: 6.41,
                                                                x1: 0.094, x2: 0.094,
                                                                r0: 8.28,
                                                                x0: 1.05 };
                                                case '2':
                                                    return {    r1: 3.84, r2: 3.84,
                                                                x1: 0.088, x2: 0.088,
                                                                r0: 5.63,
                                                                x0: 0.966 };
                                                case '3':
                                                    return {    r1: 2.4, r2: 2.4,
                                                                x1: 0.084, x2: 0.084,
                                                                r0: 4.09,
                                                                x0: 0.831 };
                                                case '4':
                                                    return {    r1: 1.54, r2: 1.54,
                                                                x1: 0.072, x2: 0.072,
                                                                r0: 3.08,
                                                                x0: 0.668 };
                                                case '5':
                                                    return {    r1: 1.1, r2: 1.1,
                                                                x1: 0.068, x2: 0.068,
                                                                r0: 2.63,
                                                                x0: 0.647 };
                                                case '6':
                                                    return {    r1: 0.769, r2: 0.769,
                                                                x1: 0.066, x2: 0.066,
                                                                r0: 2.1,
                                                                x0: 0.5 };
                                                case '7':
                                                    return {    r1: 0.549, r2: 0.549,
                                                                x1: 0.065, x2: 0.065,
                                                                r0: 1.71,
                                                                x0: 0.393 };
                                                case '8':
                                                    return {    r1: 0.405, r2: 0.405,
                                                                x1: 0.064, x2: 0.064,
                                                                r0: 1.39,
                                                                x0: 0.317 };
                                                case '9':
                                                    return {    r1: 0.32, r2: 0.32,
                                                                x1: 0.064, x2: 0.064,
                                                                r0: 1.27,
                                                                x0: 0.301 };
                                                case '10':
                                                    return {    r1: 0.256, r2: 0.256,
                                                                x1: 0.063, x2: 0.063,
                                                                r0: 1.05,
                                                                x0: 0.248 };
                                                case '11':
                                                    return {    r1: 0.208, r2: 0.208,
                                                                x1: 0.063, x2: 0.063,
                                                                r0: 0.989,
                                                                x0: 0.244 };
                                                default:
                                                    return null;
                                            }
                                            break;
                                        case '5':   //Параметры_4_жильного_кабеля_с_алюминиевыми_жилами_в_непроводящей_оболочке
                                            switch(feature) {
                                                case '0':
                                                    return {    r1: 9.61, r2: 9.61,
                                                                x1: 0.098, x2: 0.098,
                                                                r0: 11.71,
                                                                x0: 2.11 };
                                                case '1':
                                                    return {    r1: 6.41, r2: 6.41,
                                                                x1: 0.094, x2: 0.094,
                                                                r0: 8.71,
                                                                x0: 1.968 };
                                                case '2':
                                                    return {    r1: 3.84, r2: 3.84,
                                                                x1: 0.088, x2: 0.088,
                                                                r0: 5.9,
                                                                x0: 1.811 };
                                                case '3':
                                                    return {    r1: 2.4, r2: 2.4,
                                                                x1: 0.084, x2: 0.084,
                                                                r0: 4.39,
                                                                x0: 1.558 };
                                                case '4':
                                                    return {    r1: 1.54, r2: 1.54,
                                                                x1: 0.072, x2: 0.072,
                                                                r0: 3.42,
                                                                x0: 1.258 };
                                                case '5':
                                                    return {    r1: 1.1, r2: 1.1,
                                                                x1: 0.068, x2: 0.068,
                                                                r0: 2.97,
                                                                x0: 1.241 };
                                                case '6':
                                                    return {    r1: 0.769, r2: 0.769,
                                                                x1: 0.066, x2: 0.066,
                                                                r0: 2.449,
                                                                x0: 0.949 };
                                                case '7':
                                                    return {    r1: 0.549, r2: 0.549,
                                                                x1: 0.065, x2: 0.065,
                                                                r0: 2.039,
                                                                x0: 0.741 };
                                                case '8':
                                                    return {    r1: 0.405, r2: 0.405,
                                                                x1: 0.064, x2: 0.064,
                                                                r0: 1.665,
                                                                x0: 0.559 };
                                                case '9':
                                                    return {    r1: 0.32, r2: 0.32,
                                                                x1: 0.064, x2: 0.064,
                                                                r0: 1.54,
                                                                x0: 0.545 };
                                                case '10':
                                                    return {    r1: 0.256, r2: 0.256,
                                                                x1: 0.063, x2: 0.063,
                                                                r0: 1.276,
                                                                x0: 0.43 };
                                                default:
                                                    return null;
                                            }
                                            break;
                                        case '6':   //Параметры_3_жильного_кабеля_с_медными_жилами_в_стальной_оболочке
                                            switch(feature) {
                                                case '0':
                                                    return {    r1: 3.54, r2: 3.54,
                                                                x1: 0.094, x2: 0.094,
                                                                r0: 4.07,
                                                                x0: 1.69 };
                                                case '1':
                                                    return {    r1: 2.13, r2: 2.13,
                                                                x1: 0.088, x2: 0.088,
                                                                r0: 2.66,
                                                                x0: 1.65 };
                                                case '2':
                                                    return {    r1: 1.33, r2: 1.33,
                                                                x1: 0.082, x2: 0.082,
                                                                r0: 1.86,
                                                                x0: 1.61 };
                                                case '3':
                                                    return {    r1: 0.85, r2: 0.85,
                                                                x1: 0.084, x2: 0.084,
                                                                r0: 4.39,
                                                                x0: 1.558 };
                                                case '4':
                                                    return {    r1: 0.61, r2: 0.61,
																x1: 0.079, x2: 0.079,
																r0: 1.14,
																x0: 1.54 };
                                                case '5':
                                                    return {    r1: 0.43, r2: 0.43,
																x1: 0.078, x2: 0.078,
																r0: 0.96,
																x0: 1.51 };
                                                case '6':
                                                    return {    r1: 0.3, r2: 0.3,
																x1: 0.065, x2: 0.065,
																r0: 0.83,
																x0: 1.48 };
                                                case '7':
                                                    return {    r1: 0.22, r2: 0.22,
																x1: 0.064, x2: 0.064,
																r0: 0.75,
																x0: 1.45 };
                                                case '8':
                                                    return {    r1: 0.18, r2: 0.18,
																x1: 0.062, x2: 0.062,
																r0: 0.71,
																x0: 1.43 };
                                                case '9':
                                                    return {    r1: 0.14, r2: 0.14,
																x1: 0.061, x2: 0.061,
																r0: 0.67,
																x0: 1.41 };
                                                case '10':
                                                    return {    r1: 0.115, r2: 0.115,
																x1: 0.061, x2: 0.061,
																r0: 0.65,
																x0: 1.39 };
                                                case '11':
                                                    return {    r1: 0.089, r2: 0.089,
																x1: 0.06, x2: 0.06,
																r0: 0.62,
																x0: 1.36 };
                                                default:
                                                    return null;
                                            }
                                            break;
                                        case '7':	//Параметры_4_жильного_кабеля_с_медными_жилами_в_стальной_оболочке
                                            switch(feature) {
                                                case '0':
                                                    return {    r1: 3.54, r2: 3.54,
																x1: 0.1, x2: 0.1,
																r0: 4.19,
																x0: 1.55 };
                                                case '1':
                                                    return {    r1: 2.13, r2: 2.13,
																x1: 0.095, x2: 0.095,
																r0: 2.82,
																x0: 1.46 };
                                                case '2':
                                                    return {    r1: 1.33, r2: 1.33,
																x1: 0.09, x2: 0.09,
																r0: 2.07,
																x0: 1.31 };
                                                case '3':
                                                    return {    r1: 0.85, r2: 0.85,
																x1: 0.089, x2: 0.089,
																r0: 1.63,
																x0: 1.11 };
                                                case '4':
                                                    return {    r1: 0.61, r2: 0.61,
																x1: 0.086, x2: 0.086,
																r0: 1.37,
																x0: 1.09 };
                                                case '5':
                                                    return {    r1: 0.43, r2: 0.43,
																x1: 0.086, x2: 0.086,
																r0: 1.18,
																x0: 0.88 };
                                                case '6':
                                                    return {    r1: 0.3, r2: 0.3,
																x1: 0.073, x2: 0.073,
																r0: 1.05,
																x0: 0.851 };
                                                case '7':
                                                    return {    r1: 0.3, r2: 0.3,
																x1: 0.074, x2: 0.074,
																r0: 1.01,
																x0: 0.654 };
                                                case '8':
                                                    return {    r1: 0.22, r2: 0.22,
																x1: 0.072, x2: 0.072,
																r0: 0.92,
																x0: 0.69 };
                                                case '9':
                                                    return {    r1: 0.22, r2: 0.22,
																x1: 0.072, x2: 0.072,
																r0: 0.84,
																x0: 0.54 };
                                                case '10':
                                                    return {    r1: 0.18, r2: 0.18,
																x1: 0.072, x2: 0.072,
																r0: 0.88,
																x0: 0.68 };
                                                case '11':
                                                    return {    r1: 0.18, r2: 0.18,
																x1: 0.07, x2: 0.07,
																r0: 0.7,
																x0: 0.47 };
                                                case '12':
                                                    return {    r1: 0.14, r2: 0.14,
																x1: 0.07, x2: 0.07,
																r0: 0.74,
																x0: 0.54 };
                                                case '13':
                                                    return {    r1: 0.14, r2: 0.14,
																x1: 0.07, x2: 0.07,
																r0: 0.66,
																x0: 0.42 };
                                                case '14':
                                                    return {    r1: 0.115, r2: 0.115,
																x1: 0.07, x2: 0.07,
																r0: 0.7,
																x0: 0.54 };
                                                case '15':
                                                    return {    r1: 0.115, r2: 0.115,
																x1: 0.069, x2: 0.069,
																r0: 0.54,
																x0: 0.34 };
                                                default:
                                                    return null;
                                            }
											break;
                                        case '8':	//Параметры_четырехжильного_кабеля_с_медными_жилами_в_стальной_оболочке
                                            switch(feature) {
                                                case '0':
                                                    return {    r1: 3.54, r2: 3.54,
																x1: 0.1, x2: 0.1,
																r0: 4.24,
																x0: 1.49 };
                                                case '1':
                                                    return {    r1: 2.13, r2: 2.13,
																x1: 0.095, x2: 0.095,
																r0: 2.88,
																x0: 1.34 };
                                                case '2':
                                                    return {    r1: 1.33, r2: 1.33,
																x1: 0.09, x2: 0.09,
																r0: 2.12,
																x0: 1.14 };
                                                case '3':
                                                    return {    r1: 0.86, r2: 0.86,
																x1: 0.089, x2: 0.089,
																r0: 1.63,
																x0: 0.91 };
                                                case '4':
                                                    return {    r1: 0.61, r2: 0.61,
																x1: 0.086, x2: 0.086,
																r0: 1.33,
																x0: 0.74 };
                                                case '5':
                                                    return {    r1: 0.43, r2: 0.43,
																x1: 0.086, x2: 0.086,
																r0: 1.05,
																x0: 0.58 };
                                                case '6':
                                                    return {    r1: 0.3, r2: 0.3,
																x1: 0.073, x2: 0.073,
																r0: 0.85,
																x0: 0.42 };
                                                case '7':
                                                    return {    r1: 0.22, r2: 0.22,
																x1: 0.072, x2: 0.072,
																r0: 0.66,
																x0: 0.35 };
                                                case '8':
                                                    return {    r1: 0.18, r2: 0.18,
																x1: 0.07, x2: 0.07,
																r0: 0.54,
																x0: 0.31 };
                                                case '9':
                                                    return {    r1: 0.14, r2: 0.14,
																x1: 0.07, x2: 0.07,
																r0: 0.45,
																x0: 0.28 };
                                                case '10':
                                                    return {    r1: 0.115, r2: 0.115,
																x1: 0.069, x2: 0.069,
																r0: 0.37,
																x0: 0.27 };
												default:
												return null;
                                            }
                                            break;
                                        default: break;
                                    }
                                }
                                function getCableFeaturesOnCrossSection(crossSection) {
                                    if ( isNaN(parseFloat(crossSection)))
                                        return 'error';
                                    switch(crossSection){
										case '0':
										    return { r: 0.06, x_1: 0.08, x_4: 0.07, z_1: 0.10, z_4: 0.07 };
                                        case '1':
                                            return { r: 0.08, x_1: 0.08, x_4: 0.07, z_1: 0.11, z_4: 0.11 };
                                        case '2':
                                            return { r: 0.10, x_1: 0.08, x_4: 0.07, z_1: 0.13, z_4: 0.12 };
                                        case '3':
                                            return { r: 0.12, x_1: 0.08, x_4: 0.07, z_1: 0.15, z_4: 0.14 };
                                        case '4':
                                            return { r: 0.16, x_1: 0.09, x_4: 0.07, z_1: 0.18, z_4: 0.17 };
                                        case '5':
                                            return { r: 0.20, x_1: 0.09, x_4: 0.08, z_1: 0.21, z_4: 0.21 };
                                        case '6':
                                            return { r: 0.27, x_1: 0.09, x_4: 0.08, z_1: 0.28, z_4: 0.28 };
                                        case '7':
                                            return { r: 0.37, x_1: 0.10, x_4: 0.08, z_1: 0.38, z_4: 0.38 };
                                        case '8':
                                            return { r: 0.53, x_1: 0.10, x_4: 0.08, z_1: 0.54, z_4: 0.54 };
                                        case '9':
                                            return { r: 0.74, x_1: 0.10, x_4: 0.08, z_1: 0.75, z_4: 0.75 };
                                        case '10':
                                            return { r: 1.16, x_1: 0.11, x_4: 0.09, z_1: 1.17, z_4: 1.17 };
                                        case '11':
                                            return { r: 1.86, x_1: 0.11, x_4: 0.09, z_1: 1.86, z_4: 1.86 };
                                        case '12':
                                            return { r: 3.10, x_1: 0.12, x_4: 0.09, z_1: 3.10, z_4: 3.10 };
                                        case '13':
                                            return { r: 4.65, x_1: 0.12, x_4: 0.09, z_1: 4.65, z_4: 4.65 };
                                        case '14':
                                            return { r: 7.44, x_1: 0.13, x_4: 0.10, z_1: 7.44, z_4: 7.44 };
                                        case '15':
                                            return { r: 12.40, x_1: 0.13, x_4: 0.10, z_1: 12.40, z_4: 12.40 };
									}
                                }
                                $('#btnclear8').click(function () {	//кнопка Сброс
																								
																	$('input:radio[name=cabletype1]#rad101').iCheck('check');
																	$('#lbrez37').html(''); //R1
																	$('#lbrez38').html(''); //X1
																	$('#lbrez39').html(''); //R0
																	$('#lbrez40').html(''); //X0
																	$('#lbrez49').html(''); //Iкз

																	$('#lbrez41').html(''); //R1
																	$('#lbrez42').html(''); //X1
																	$('#lbrez43').html(''); //R0
																	$('#lbrez44').html(''); //X0
																	$('#lbrez50').html(''); //Iкз

																	$('#lbrez45').html(''); //R1
																	$('#lbrez46').html(''); //X1
																	$('#lbrez47').html(''); //R0
																	$('#lbrez48').html(''); //X0
																	$('#lbrez51').html('');
																	//Iкз/**/
																	return false;
																	});
								function calcKZ(){
                                    cableType = null;
                                    if($('#rad101').prop('checked')) cableType = '0';
                                    if($('#rad102').prop('checked')) cableType = '1';
                                    if($('#rad103').prop('checked')) cableType = '2';
                                    if($('#rad104').prop('checked')) cableType = '3';
                                    if($('#rad105').prop('checked')) cableType = '4';
                                    if($('#rad106').prop('checked')) cableType = '5';
                                    if($('#rad107').prop('checked')) cableType = '6';
                                    if($('#rad108').prop('checked')) cableType = '7';
                                    if($('#rad109').prop('checked')) cableType = '8';
                                    //alert(cableType);
									cableFeature = null;
									switch(cableType){
										case '0': cableFeature = $('#cabletypesp1').val(); break;
                                        case '1': cableFeature = $('#cabletypesp2').val(); break;
                                        case '2': cableFeature = $('#cabletypesp3').val(); break;
                                        case '3': cableFeature = $('#cabletypesp4').val(); break;
                                        case '4': cableFeature = $('#cabletypesp5').val(); break;
                                        case '5': cableFeature = $('#cabletypesp6').val(); break;
                                        case '6': cableFeature = $('#cabletypesp7').val(); break;
                                        case '7': cableFeature = $('#cabletypesp8').val(); break;
                                        case '8': cableFeature = $('#cabletypesp9').val(); break;
										default: break;
									}
                                    cableFeatureOnType = getCableFeaturesOnType(cableType, cableFeature);
                                    cableLength = $('#cablelength1').val();
									if(cableLength == '' || isNaN(parseFloat(cableLength))){
									    alert("Необходимо указать длину кабеля");
									    return;
									}
									//alert();
									R1_1f 	= R1_2f 	= R1_3f 	= null;
                                    X1_1f 	= X1_2f 	= X1_3f 	= null;
                                    R0_1f 	= R0_2f 	= R0_3f 	= null;
                                    X0_1f 	= X0_2f 	= X0_3f 	= null;
                                    x1_1f 	= x1_2f 	= x1_3f 	= null;
                                    x0_1f 	= x0_2f 	= x0_3f 	= null;
                                    r1_1f 	= r1_2f 	= r1_3f 	= null;
                                    r0_1f 	= r0_2f 	= r0_3f 	= null;
                                    Ikz_1f 	= Ikz_2f 	= Ikz_3f 	= null;

                                    if(cableType == '0'){
                                        x0_1f = cableFeatureOnType.x0_1;
                                        x1_1f = cableFeatureOnType.x1_1;
                                        r0_1f = cableFeatureOnType.r0;
                                        r1_1f = cableFeatureOnType.r1;

                                        x0_2f = cableFeatureOnType.x0_3;
                                        x1_2f = cableFeatureOnType.x1_3;
                                        r0_2f = cableFeatureOnType.r0;
                                        r1_2f = cableFeatureOnType.r1;

                                        x0_3f = cableFeatureOnType.x0_3;
                                        x1_3f = cableFeatureOnType.x1_3;
                                        r0_3f = cableFeatureOnType.r0;
                                        r1_3f = cableFeatureOnType.r1;
									} else {
                                        x0_1f = cableFeatureOnType.x0;
                                        x1_1f = cableFeatureOnType.x1;
                                        r0_1f = cableFeatureOnType.r0;
                                        r1_1f = cableFeatureOnType.r1;

                                        x0_2f = cableFeatureOnType.x0;
                                        x1_2f = cableFeatureOnType.x1;
                                        r0_2f = cableFeatureOnType.r0;
                                        r1_2f = cableFeatureOnType.r1;

                                        x0_3f = cableFeatureOnType.x0;
                                        x1_3f = cableFeatureOnType.x1;
                                        r0_3f = cableFeatureOnType.r0;
                                        r1_3f = cableFeatureOnType.r1;
									}

                                    R1_1f = r1_1f * cableLength / 1000.0;
                                    X1_1f = x1_1f * cableLength / 1000.0;
                                    R0_1f = r0_1f * cableLength / 1000.0;
                                    X0_1f = x0_1f * cableLength / 1000.0;

                                    R1_2f = r1_2f * cableLength / 1000.0;
                                    X1_2f = x1_2f * cableLength / 1000.0;
                                    R0_2f = r0_2f * cableLength / 1000.0;
                                    X0_2f = x0_2f * cableLength / 1000.0;

                                    R1_3f = r1_3f * cableLength / 1000.0;
                                    X1_3f = x1_3f * cableLength / 1000.0;
                                    R0_3f = r0_3f * cableLength / 1000.0;
                                    X0_3f = x0_3f * cableLength / 1000.0;

                                    Ikz_1f = ( Math.sqrt(3) + 380.0 ) / ( Math.sqrt(Math.pow((2 * R1_1f + R0_1f),2) + Math.pow((2 * X1_1f + X0_1f),2)) );
                                    Ikz_2f = 380.0 / ( 2.0 * Math.sqrt(R1_2f * R1_2f + X1_2f * X1_2f));
                                    Ikz_3f = 380.0 / ( Math.sqrt(3.0) * Math.sqrt(R1_3f * R1_3f + X1_3f * X1_3f));

                                    $('#lbrez37').html(R1_1f.toFixed(2)); //R1
                                    $('#lbrez38').html(X1_1f.toFixed(2)); //X1
                                    $('#lbrez39').html(R0_1f.toFixed(2)); //R0
                                    $('#lbrez40').html(X0_1f.toFixed(2)); //X0
                                    $('#lbrez49').html(Ikz_1f.toFixed(2)); //Iкз

                                    $('#lbrez41').html(R1_2f.toFixed(2)); //R1
                                    $('#lbrez42').html(X1_2f.toFixed(2)); //X1
                                    $('#lbrez43').html(R0_2f.toFixed(2)); //R0
                                    $('#lbrez44').html(X0_2f.toFixed(2)); //X0
                                    $('#lbrez50').html(Ikz_2f.toFixed(2)); //Iкз

                                    $('#lbrez45').html(R1_3f.toFixed(2)); //R1
                                    $('#lbrez46').html(X1_3f.toFixed(2)); //X1
                                    $('#lbrez47').html(R0_3f.toFixed(2)); //R0
                                    $('#lbrez48').html(X0_3f.toFixed(2)); //X0
                                    $('#lbrez51').html(Ikz_3f.toFixed(2)); //Iкз
								}
                            </script>
                        </div>
						<div class="tab-pane" id="panel-359134">
							<br>
							<form class="topdf-form" action="to_pdf.php?form=thermal_resistance" method="post">
								<div class="row" style="border-bottom: 1px solid #cecece;/* */padding-top: 15px; padding-bottom: 15px;">
									<div class="col-sm-3">
										<label class="control-label red_text">Номинальное сечение жилы, мм<sup>2</sup>:</label>
									</div>
									<div class="col-sm-9">
										<select class="selectpicker" id="wirecrosssection1" name="wirecrosssection1" style="width: 170px">
											<option value="0.17">1,5</option>
											<option value="0.27">2,5</option>
											<option value="0.43">4</option>
											<option value="0.65">6</option>
											<option value="1.09">10</option>
											<option value="1.74">16</option>
											<option value="2.78">25</option>
											<option value="3.86">35</option>
											<option value="5.23">50</option>
											<option value="7.54">70</option>
											<option value="10.48">95</option>
											<option value="13.21">120</option>
											<option value="16.3">150</option>
											<option value="20.39">185</option>
											<option value="26.8">240</option>
										</select>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; margin-top: 20px; padding-bottom: 15px;">
									<div class="col-md-3"><p class="red_text">Наибольший ток КЗ, кА:</p></div>
									<div class="col-md-9"><input type="text" id="largestcurrent1" name="largestcurrent1" value="" style="width: 170px"></div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; margin-top: 10px; padding-bottom: 15px;">
									<div class="col-md-3"><p class="red_text">Система заземления:</p></div>
									<div class="col-sm-9">
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="systemtype1" id="rad110" value="0">
											<label for="rad110" class="label_text" style="margin-left: 10px;">Система TN</label>
										</div><br>
										<div style="display: inline-block; margin-left: 10px;">
											<input type="radio" name="systemtype1" id="rad111" value="1">
											<label for="rad111" class="label_text" style="margin-left: 10px;">Система IT</label>
										</div>
									</div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; margin-top: 20px; padding-bottom: 15px;" id="phaseblock1">
									<div class="col-md-3"><p class="red_text">Номинальное фазное напряжение U<sub>0</sub>, В:</p></div>
									<div class="col-md-9"><input type="text" id="nominalphasevoltage1" name="nominalphasevoltage1" value="" style="width: 170px"></div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; margin-top: 20px; padding-bottom: 15px;" id="lineblock1">
									<div class="col-md-3"><p class="red_text">Номинальное линейное напряжение U<sub>0</sub>, В:</p></div>
									<div class="col-md-9"><input type="text" id="nominallinevoltage1" name="nominallinevoltage1" value="" style="width: 170px"></div>
								</div>
								<div class="row" style="border-bottom: 1px solid #cecece; margin-top: 20px; padding-bottom: 15px;">
									<div class="col-md-3"><p class="red_text">Время отключения, с:</p></div>
									<div class="col-md-9"><input type="text" id="breaktime1" name="breaktime1" value="" style="width: 170px"></div>
								</div>


								<div class="row" style="padding-top: 15px; padding-bottom: 15px;">
									<div class="col-md-6">
										<button class="btn btn_calc" id="btncalc9" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать</button>
										<button class="btn btn_reset" id="btnclear9" style="margin-left:15px; display: inline-block;">Сброс</button>
									</div>
								</div>
								<div class="row" style="margin-top: 20px">
									<div class="col-sm-6"><label class="control-label red_text" style="margin-top:8px;">Эквивалентный допустимый ток ( J<sub>терм.доп</sub> ), кА/мм:</label></div>
									<div class="col-md-6"><label class="control-label rez_text" id="lbrez52"></label></div>
								</div>
								<div class="row" style="margin-top: 20px">
									<div class="col-sm-6"><label class="control-label red_text" style="margin-top:8px;">Эквивалентный термический ток ( J<sub>терм.эк</sub> ), кА/мм:</label></div>
									<div class="col-md-6"><label class="control-label rez_text" id="lbrez53"></label></div>
								</div>
								<div class="row" style="margin-top: 20px">
									<div class="col-sm-6"><label class="control-label red_text" style="margin-top:8px;">Критерий J<sub>терм.доп</sub> > J<sub>терм.эк</sub> :</label></div>
									<div class="col-md-6"><label class="control-label rez_text" id="lbrez54"></label></div>
								</div>
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
								
							</form>
							
							<script>
                                $('input:radio[name=systemtype1]#rad110').iCheck('check');
                                $('#phaseblock1').show();
                                $('#lineblock1').hide();

                                var systemType1 = 0;
                                $('input:radio[name=systemtype1]').on('ifChecked',function() {
                                    //alert($(this).val());
                                    switch ($(this).attr('id')) {
                                        case 'rad110':
                                            $('#phaseblock1').show();
                                            $('#lineblock1').hide();
                                            systemType1 = 0;
                                            break;
                                        case 'rad111':
                                            $('#phaseblock1').hide();
                                            $('#lineblock1').show();
                                            systemType1 = 1;
                                            break;
                                    }
                                });

                                $('#btncalc9').click(
									function(){
										calcThermalResistance();
										return false;
										}
									);
                                $('#btnclear9').click(
                                    function(){
                                        //alert();
                                        $('input:radio[name=systemtype1]#rad110').iCheck('check');
                                        $('#wirecrosssection1').val('0.17');
                                        $('#largestcurrent1').val('');
                                        $('#nominalphasevoltage1').val('');
                                        $('#nominallinevoltage1').val('');
                                        $('#lbrez52').html('');
                                        $('#lbrez53').html('');
                                        $('#lbrez54').html('');
										return false;

									}
								);

                                function calcTime(systemType,voltage){
                                    //alert();
                                    sType 	= Number(systemType);
                                    vol 	= Number(voltage);
                                    switch(sType){
                                        case 0:
                                            //alert(0);
											if(vol <= 127.0) return 0.8;
                                            if(vol > 127.0 && vol <= 220.0) return 0.4;
                                            if(vol > 220.0 && vol <= 380.0) return 0.2;
                                            if(vol > 380.0) return 0.1;
                                            break;
                                        case 1:
                                            //alert(0);
                                            if(vol <= 220.0) return 0.8;
                                            if(vol > 220.0 && vol <= 380.0) return 0.4;
                                            if(vol > 380.0 && vol <= 660.0) return 0.2;
                                            if(vol > 660.0) return 0.1;
                                            break;
										default: return null;
                                    }
								}/**/
								function calcThermalResistance(){
                                    s = $('#wirecrosssection1 :selected').html().replace(',','.');
								    I_term_dop = $('#wirecrosssection1 :selected').val();
                                    Ikz = $('#largestcurrent1').val();
								    t = $('#breaktime1').val();
                                    //alert(t);
								    if(	isNaN(Number(s)) 			||
										s == '' 					||
									    isNaN(Number(I_term_dop))	||
                                        I_term_dop == '' 			||
										isNaN(Number(Ikz)) 			||
                                        Ikz == ''					||
										isNaN(Number(t))			||
										t == ''
									){
									    alert('Некорректно указаны данные');
									    return;
									}
									J_term_dop = (I_term_dop * s) / Math.sqrt(1.0 / t);
								    J_term_ek  = I_term_dop / s;

								    $('#lbrez52').html(J_term_dop.toFixed(3));
									$('#lbrez52').append('<input type="hidden" name="rez52" value="' + J_term_dop.toFixed(3) + '">');
                                    $('#lbrez53').html(J_term_ek.toFixed(3));
									$('#lbrez53').append('<input type="hidden" name="rez53" value="' + J_term_ek.toFixed(3) + '">');
                                    if(J_term_dop > J_term_ek){
                                    	$('#lbrez54').html('соблюден');
										$('#lbrez54').append('<input type="hidden" name="rez54" value="соблюден">');
									}
                                    else{
                                        $('#lbrez54').html('не соблюден');
										$('#lbrez54').append('<input type="hidden" name="rez54" value="не соблюден">');
									}
								}

                                $('#nominalphasevoltage1').change(
                                    function(){
                                        if(isNaN(Number($(this).val()))){
                                            alert('Некорректно указано напряжение.');
                                            return;
                                        }
                                        t = calcTime(systemType1, $(this).val());
                                        $('#breaktime1').val(t);
                                    }
								);

                                $('#nominallinevoltage1').change(
                                    function(){
                                        if(isNaN(Number($(this).val()))){
                                            alert('Некорректно указано напряжение.');
                                            return;
                                        }
                                        t = calcTime(systemType1, $(this).val());
                                        $('#breaktime1').val(t);
                                    }
                                );


							</script>
						</div>
						<div class="tab-pane" id="panel-3591369">
							<?=$APPLICATION->IncludeComponent('bitmaven:selectivity.calc');?>
						</div>
						<div class="tab-pane" id="panel-359140">
							<div style="clear:both;"></div>
							<?=$APPLICATION->IncludeComponent('dvasilyev:microclimate.conf');/**/?>
						</div>
                        <div class="tab-pane" id="panel-359135">
                            <style>
                                .row-border-bottom{
                                    border-bottom: 1px solid #cecece;
                                    padding-top: 10px;/**/
                                    padding-bottom: 15px;
                                }
                                .col-radio-width{
                                    width: 40px;
                                }
                                .text-vertical-align{
                                    display: inline-block !important;
                                    float: none !important; 
                                    vertical-align: middle !important;
                                }
                                .radio-block-div{
                                    display: inline-block;
                                    //margin-left: 10px;
                                    margin-bottom: 5px;
                                }
                                .radio-block-label-left-margin{
                                    margin-left: 10px;
                                }
                                .input-left-sign{
                                    margin-left: 5px;
                                }
                                .bsblock{
                                    border: 1px solid #cecece;
                                    padding: 10px 0 10px 0;
                                    margin-bottom: 10px;
                                }
                                .lbrez-top-margin{
                                    margin-top:8px;
                                }
                            </style>
                            <br />
                            <div class="row row-border-bottom">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="control-label red_text">Тип здания:</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                   <input type="radio" name="buildtype2" id="rad112" value="1">
                                                    <label for="rad112" class="black_text radio-block-label-left-margin">Сосредоточенное (труба, вышка, башня и т.п.)
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <input type="radio" name="buildtype2" id="rad113" value="2">
                                                    <label for="rad113" class="black_text radio-block-label-left-margin">Прямоугольное
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-border-bottom">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12" >
                                            <label class="control-label red_text">Габариты здания:</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 input-left-sign"><label class="red_text" id="lengthordiamsign1">Диаметр А, м:</label></div>
                                        <div class="col-sm-8 radio-block-div"><input type="text" id="lengthordiam1" value=""></div>
                                    </div>
                                    <div class="row" id="buildwidthblock1">
                                        <div class="col-sm-3 input-left-sign"><label class="red_text">Ширина B, м:</label></div>
                                        <div class="col-sm-8 radio-block-div"><input type="text" id="buildwidthval1" value=""></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 input-left-sign"><label class="red_text">Высота h<sub>x</sub>, м:</label></div>
                                        <div class="col-sm-8 radio-block-div"><input type="text" id="buildheightval1" value=""></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-border-bottom">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label red_text">Удельная плотность ударов молнии в землю n, 1/(км<sup>2</sup>×год):</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <select class="selectpicker" id="densitybumps1">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="4">4</option>
                                                <option value="5.5">5,5</option>
                                                <option value="7">7</option>
                                                <option value="8.5">8,5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="control-label red_text">Ожидаемое количество поражений молнией в год N, шт:</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <label class="control-label rez_text" id="lbrez55">укажите тип здания и габариты</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-border-bottom" >
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="control-label red_text">Тип молниезащиты:</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6" >
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <input type="radio" name="lightningprotection1" id="rad114" value="1">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad114" class="black_text">Одиночный стержневой молниеотвод</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <input type="radio" name="lightningprotection1" id="rad115" value="2">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad115" class="black_text">Двойной стержневой молниеотвод равной длины</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <input type="radio" name="lightningprotection1" id="rad116" value="3">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad116" class="black_text">Двойной стержневой молниеотвод разной длины</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <input type="radio" name="lightningprotection1" id="rad117" value="4">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad117" class="black_text">Многократный стержневой молниеотвод</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <input type="radio" name="lightningprotection1" id="rad118" value="5">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad118" class="black_text">Одиночный тросовый молниеотвод</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <input type="radio" name="lightningprotection1" id="rad119" value="6">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad119" class="black_text">Двойной тросовый молниеотвод одинаковой высоты</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1">
                                                    <input type="radio" name="lightningprotection1" id="rad120" value="7">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad120" class="black_text">Двойной тросовый молниеотвод разной высоты</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-center" >
                                            <img src="img/light1.jpg" height="260px" id="lightimg1" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-border-bottom" >
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="control-label red_text">Характеристики молниеотвода:</label>
                                        </div>
                                    </div>
                                    <div class="row" id="lightningqty1">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Количество молниеотводов k<sub>m</sub>, шт:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lightningqtyval1" value="">
                                        </div>
                                    </div>
                                    <div class="row" id="lightningheight_0">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Высота молниеотвода h, м:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lightningheight_0val" value="">
                                        </div>
                                    </div>
                                    <div class="row" id="lightningheight_1">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Высота молниеотвода h<sub>1</sub>, м:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lightningheight_1val" value="">
                                        </div>
                                    </div>
                                    <div class="row" id="lightningheight_2">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Высота молниеотвода h<sub>2</sub>, м:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lightningheight_2val" value="">
                                        </div>
                                    </div>
                                    <div class="row" id="lightningheight_op">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Высота молниеотвода h<sub>ОП</sub>, м:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lightningheight_opval" value="">
                                        </div>
                                    </div>
                                    <div class="row" id="lightningheight_op1">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Высота молниеотвода h<sub>ОП1</sub>, м:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lightningheight_op1val" value="">
                                        </div>
                                    </div>
                                    <div class="row" id="lightningheight_op2">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Высота молниеотвода h<sub>ОП2</sub>, м:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lightningheight_op2val" value="">
                                        </div>
                                    </div>
                                    <div class="row" id="lightningdistance_1">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Расстояние между молниеотводами L, м:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lightningdistance_1val" value="">
                                        </div>
                                    </div>
                                    <div class="row" id="lengthspan1">
                                        <div class="col-sm-5 input-left-sign">
                                            <label class="control-label red_text">Длина пролета a, м:</label>
                                        </div>
                                        <div class="col-sm-6 radio-block-div">
                                            <input type="text" id="lengthspan1val" value="">
                                        </div>
                                    </div>
                                    <div class='list-link' onclick='openCloseLightningHeightBlock(this);' href='#lightningheightblock' id='lightningheightblocklink' >— Свернуть</div>
                                    <div class='panel-collapse' id='lightningheightblock'></div>
                                </div>
                            </div>
                            <div class="row row-border-bottom">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="control-label red_text">Здания и сооружения:</label>
                                        </div>
                                    </div>
                                    <div class="row" style="height: 70px;"><!--
                                        --><div class="col-sm-12 text-vertical-align"><!--
                                            --><label class="control-label black_text" id="buildingsandstructuresselectedval1">Здания и сооружения или их части, помещения которых согласно ПУЭ относятся к зонам классов В-I и В-II.</label><!--
                                        --></div><!--
                                    --></div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="list-link" style="display: block; margin-bottom: 10px;" onclick="openCloseBSBlock(this);" href="#bsblock_0" >— Свернуть</div>
                                        </div>
                                    </div>
                                    <div class="panel-collapse bsblock row" id="bsblock_0">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad121" value="1">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad121" class="black_text">1 Здания и сооружения или их части, помещения которых согласно ПУЭ относятся к зонам классов В-I и В-II.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad122" value="2">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad122" class="black_text">2 Наружные установки, создающие согласно ПУЭ зону класса В-Iг.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad123" value="3">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad123" class="black_text">3 Здания и сооружения или их части, помещения которых согласно ПУЭ относятся к зонам классов П-I, П-II, П-IIа. Для зданий и сооружений I и II степеней огнестойкости.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad124" value="4">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad124" class="black_text">4 Здания и сооружения или их части, помещения которых согласно ПУЭ относятся к зонам классов П-I, П-II, П-IIа. Для зданий и сооружений  III — V степеней огнестойкости.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad125" value="5">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad125" class="black_text">5 Здания и соору­жения или их части, помещения которых согласно ПУЭ отно­сятся к зонам клас­сов П-I, П-II, П-IIа. Для зда­ний и со­оружений  I — V степеней огнестойкости.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad126" value="6">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad126" class="black_text">6 Расположенные в сельской местности небольшие строения III — V степеней огнестойкости, помещения которых согласно ПУЭ относятся к зонам классов П-I, П-II, П-IIа.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad127" value="7">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad127" class="black_text">7 Наружные установки и открытые склады, создающие согласно ПУЭ зону классов П-III.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad128" value="8">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad128" class="black_text">8 Здания и сооружения III, IIIa, IIIб, IV, V степеней огнестойкости, в которых отсутствуют помещения, относимые по ПУЭ к зонам взрыво- и пожароопасных классов.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad129" value="9">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad129" class="black_text">9 Здания и сооружения из легких металлических конструкций со сгораемым утеплителем (IVa степени огнестойкости), в которых отсутствуют помещения, относимые по ПУЭ к зонам взрыво- и пожароопасных классов.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad130" value="10">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad130" class="black_text">10 Небольшие строения III-V степеней огнестойкости, расположенные в сельской местности, в которых отсутствуют помещения, относимые по ПУЭ к зонам взрыво- и пожароопасных классов.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad131" value="11">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad131" class="black_text">11 Здания вычислительных центров, в том числе расположенные в городской застройке.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad132" value="12">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad132" class="black_text">12 Животноводческие и птицеводческие здания и сооружения III-V степеней огнестойкости: для крупного рогатого скота и свиней на 100 голов и более, для овец на 500 голов и более, для птицы на 1000 голов и более, для лошадей на 40 голов и более.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad133" value="13">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad133" class="black_text">13 Дымовые и прочие трубы предприятий и котельных, башни и вышки всех назначений высотой 15 м и более.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad134" value="14">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad134" class="black_text">14 Жилые и общественные здания, высота которых более чем на 25 м превышает среднюю высоту окружающих зданий в радиусе 400 м, а также отдельно стоящие здания высотой более 30 м, удаленные от других зданий более чем на 400 м.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad135" value="15">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad135" class="black_text">15 Отдельно стоящие жилые и общественные здания в сельской местности высотой более 30 м.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad136" value="16">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad136" class="black_text">16 Общественные здания III-V степеней огнестойкости следующего назначения: детские дошкольные учреждения, школы и школы-интернаты, стационары лечебных учреждений, спальные корпуса и столовые учреждений здравоохранения и отдыха, культурно-просветительные и зрелищные учреждения, административные здания, вокзалы, гостиницы, мотели и кемпинги.
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad137" value="17">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad137" class="black_text">17 Открытые зрелищные учреждения (зрительные залы открытых кинотеатров, трибуны открытых стадионов и т.п.).
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-1 col-radio-width">
                                                    <input type="radio" name="buildingsandstructures1" id="rad138" value="18">
                                                </div>
                                                <div class="col-sm-11">
                                                    <label for="rad138" class="black_text">18 Здания и сооружения, являющиеся памятниками истории, архитектуры и культуры (скульптуры, обелиски и т.п.).
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-border-bottom">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12" >
                                            <label class="control-label red_text">Местоположение:</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1 col-radio-width">
                                            <input type="radio" name="location1" id="rad139" value="1">
                                        </div>
                                        <div class="col-sm-11">
                                            <label for="rad139" class="black_text">На всей территории СССР
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1 col-radio-width">
                                            <input type="radio" name="location1" id="rad140" value="2">
                                        </div>
                                        <div class="col-sm-11">
                                            <label for="rad140" class="black_text">В местностях со средней продолжительностью гроз 10 ч в год и более
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1 col-radio-width">
                                            <input type="radio" name="location1" id="rad141" value="3">
                                        </div>
                                        <div class="col-sm-11">
                                            <label for="rad141" class="black_text">В местностях со средней продолжительностью гроз 20 ч в год и более
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1 col-radio-width">
                                            <input type="radio" name="location1" id="rad142" value="4">
                                        </div>
                                        <div class="col-sm-11">
                                            <label for="rad142" class="black_text">В местностях со средней продолжительностью гроз 20 ч в год и более для III, IIIa, IIIб, IV, V степеней огнестойкости
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1 col-radio-width">
                                            <input type="radio" name="location1" id="rad143" value="5">
                                        </div>
                                        <div class="col-sm-11">
                                            <label for="rad143" class="black_text">В местностях со средней продолжительностью гроз 20 ч в год и более для IVa степени огнестойкости
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1 col-radio-width">
                                            <input type="radio" name="location1" id="rad144" value="6">
                                        </div>
                                        <div class="col-sm-11">
                                            <label for="rad144" class="black_text">В местностях со средней продолжительностью гроз 40 ч в год и более
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-border-bottom">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="control-label red_text" style="padding-left: 15px;">Тип зоны защиты:</label>
                                    </div>
                                    <div class="col-sm-1 col-radio-width">
                                        <input type="radio" name="protektzonetype1" id="rad145" value="1">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="rad145" class="black_text">А
                                        </label>
                                    </div>
                                    <div class="col-sm-1 col-radio-width">
                                        <input type="radio" name="protektzonetype1" id="rad146" value="2">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="rad146" class="black_text">Б
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-border-bottom">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="control-label red_text" style="padding-left: 15px;">Категория молниезащиты:</label>
                                    </div>
                                    <div class="col-sm-1 col-radio-width">
                                        <input type="radio" name="lightprotcat1" id="rad147" value="1">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="rad147" class="black_text">I
                                        </label>
                                    </div>
                                    <div class="col-sm-1 col-radio-width">
                                        <input type="radio" name="lightprotcat1" id="rad148" value="2">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="rad148" class="black_text">II
                                        </label>
                                    </div>
                                    <div class="col-sm-1 col-radio-width">
                                        <input type="radio" name="lightprotcat1" id="rad149" value="3">
                                    </div>
                                    <div class="col-sm-1">
                                        <label for="rad149" class="black_text">III
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 15px; padding-bottom: 15px;">
                                <div class="col-md-6">
                                    <button class="btn btn_calc" id="btncalc10" style="margin-right:15px; display: inline-block;" onclick="sendCntAjax('masterscale','calc','calc',null);">Рассчитать</button>
                                    <button class="btn btn_reset" id="btnclear10" style="margin-left:15px; display: inline-block;">Сброс</button>
                                </div>
                            </div>
                            <div class="row" id="divrez57">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez57title">h<sub>0</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez57"></label></div>
                            </div>
                            <div class="row" id="divrez58">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez58title">r<sub>0</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez58"></label></div>
                            </div>
                            <div class="row" id="divrez59">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez59title">r<sub>x</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez59"></label></div>
                            </div>
                            <div class="row" id="divrez60">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez60title">α:</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez60"></label></div>
                            </div>
                            <div class="row" id="divrez61">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez61title">h<sub>c</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez61"></label></div>
                            </div>
                            <div class="row" id="divrez62">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez62title">r<sub>c</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez62"></label></div>
                            </div>
                            <div class="row" id="divrez63">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez63title">r<sub>cx</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez63"></label></div>
                            </div>
                            <div class="row" id="divrez64">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez64title">h<sub>01</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez64"></label></div>
                            </div>
                            <div class="row" id="divrez65">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez65title">r<sub>01</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez65"></label></div>
                            </div>
                            <div class="row" id="divrez66">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez66title">r<sub>x1</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez66"></label></div>
                            </div>
                            <div class="row" id="divrez67">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez67title">h<sub>02</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez67"></label></div>
                            </div>
                            <div class="row" id="divrez68">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez68title">r<sub>02</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez68"></label></div>
                            </div>
                            <div class="row" id="divrez69">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez69title">r<sub>x2</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez69"></label></div>
                            </div>
                            <div class="row" id="divrez70">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez70title">h<sub>c1</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez70"></label></div>
                            </div>
                            <div class="row" id="divrez71">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez71title">h<sub>c2</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez71"></label></div>
                            </div>
                            <div class="row" id="divrez72">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez72title">α<sub>1</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez72"></label></div>
                            </div>
                            <div class="row" id="divrez73">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez73title">α<sub>2</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez73"></label></div>
                            </div>
                            <div class="row" id="divrez74">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez74title">r<sub>cx1</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez74"></label></div>
                            </div>
                            <div class="row" id="divrez75">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez75title">r<sub>cx2</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez75"></label></div>
                            </div>
                            <div class="row" id="divrez76">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez76title">r'<sub>x1</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez76"></label></div>
                            </div>
                            <div class="row" id="divrez77">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez77title">r'<sub>x2</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez77"></label></div>
                            </div>
                            <div class="row" id="divrez78">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez78title">r'<sub>x</sub> :</label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez78"></label></div>
                            </div>
                            <div class="row" id="divrez56">
                                <div class="col-sm-6"><label class="control-label red_text lbrez-top-margin" id="lbrez56title"></label></div>
                                <div class="col-md-6"><label class="control-label rez_text" id="lbrez56"></label></div>
                            </div>
                            <div id="lightningpropscontainer">

                            </div>
							<form id="lightningprotectionform"class="topdf-form" action="to_pdf.php?form=lightningprotection" method="post">
								<input type="hidden" name="pageTitle" value="Расчёт молниезащиты">
								<input type="submit" class="topdf-button" name="topdf" value="Сохранить результат в PDF">
							</form>
                            <script>
                                $('#lightningqty1').hide();
                                $('#lightningheight_0').show();
                                $('#lightningheight_1').hide();
                                $('#lightningheight_2').hide();
                                $('#lightningheight_op').hide();
                                $('#lightningheight_op1').hide();
                                $('#lightningheight_op2').hide();
                                $('#lightningdistance_1').hide();
                                $('#lengthspan1').hide();
                                $('#lightningheightblocklink').hide();
                                $('#lightningheightblock').hide();
								
								$('#lightningprotectionform').submit(function(event) {
								    // Предотвращаем обычную отправку формы
									
									event.preventDefault();
									var formData = $('#lightningprotectionform').serializeArray();
									
									formData.push({name: 'ajax',value: true});
									
									buildtype2Id = $('.checked input:radio[name=buildtype2]').attr('id');
									buildtype2Val = $('.checked input:radio[name=buildtype2]').val();
									buildtype2Label = $('label[for='+buildtype2Id+']').html();
									    
									formData.push({name: 'buildtype2Val',value: buildtype2Val});
									formData.push({name: 'buildtype2Label',value: buildtype2Label});
									
									if(buildtype2Val == '1'){
										formData.push({name: 'lengthordiam1',value: $('#lengthordiam1').val()});
										formData.push({name: 'buildheightval1',value: $('#buildheightval1').val()});
										
									}
									if(buildtype2Val == '2'){
										formData.push({name: 'lengthordiam1',value: $('#lengthordiam1').val()});
										formData.push({name: 'buildwidthval1',value: $('#buildwidthval1').val()});
										formData.push({name: 'buildheightval1',value: $('#buildheightval1').val()});
									}
									
									formData.push({name: 'densitybumps1',value: $('#densitybumps1 option:selected').html()});
									formData.push({name: 'rez55',value: $('#lbrez55').html()});
									
									//lightningprotection1
									lightningprotection1Id = $('.checked input:radio[name=lightningprotection1]').attr('id');
									lightningprotection1Val = $('.checked input:radio[name=lightningprotection1]').val();
									lightningprotection1Label = $('label[for='+lightningprotection1Id+']').html();
									
									formData.push({name: 'lightningprotection1Val',value: lightningprotection1Val});
									formData.push({name: 'lightningprotection1Label',value: lightningprotection1Label});
									
									switch (lightningprotection1) {
                                        case '1':
											formData.push({name: 'lightningheight_0val',value: $('#lightningheight_0val').val()});
                                           break;
                                        case '2':
											formData.push({name: 'lightningheight_0val',value: $('#lightningheight_0val').val()});
											formData.push({name: 'lightningdistance_1val',value: $('#lightningdistance_1val').val()});
											break;
                                        case '3':
											formData.push({name: 'lightningheight_1val',value: $('#lightningheight_1val').val()});
											formData.push({name: 'lightningheight_2val',value: $('#lightningheight_2val').val()});
											formData.push({name: 'lightningdistance_1val',value: $('#lightningdistance_1val').val()});
											break;
                                        case '4':
											lightningqtyval1 = parseInt($('#lightningqtyval1').val());
											formData.push({name: 'lightningqtyval1',value: lightningqtyval1});											
											for(i=1; i<=lightningqtyval1 ;i++){
												formData.push({name: 'lightningheight' + i,value: $('#lightningheight' + i).val()});
												if(i == lightningqtyval1){
													formData.push({name: 'lightningdist' + lightningqtyval1 + '1',value: $('#lightningdist' + lightningqtyval1 + '1').val()});
													continue;
												}
												formData.push({name: 'lightningdist' + i + '' + (i + 1),value: $('#lightningdist' + i + '' + (i + 1)).val()});
											}
                                            break;
                                        case '5':
											formData.push({name: 'lightningheight_opval',value: $('#lightningheight_opval').val()});
											formData.push({name: 'lengthspan1val',value: $('#lengthspan1val').val()});
                                            break;
                                        case '6':
											formData.push({name: 'lightningheight_opval',value: $('#lightningheight_opval').val()});
											formData.push({name: 'lengthspan1val',value: $('#lengthspan1val').val()});
                                            break;
                                        case '7':
											formData.push({name: 'lightningheight_op1val',value: $('#lightningheight_op1val').val()});
											formData.push({name: 'lightningheight_op2val',value: $('#lightningheight_op2val').val()});
											formData.push({name: 'lengthspan1val',value: $('#lengthspan1val').val()});
                                            break;
                                    }
									
									buildingsandstructures1Id = $('.checked input:radio[name=buildingsandstructures1]').attr('id');
									buildingsandstructures1Val = $('.checked input:radio[name=buildingsandstructures1]').val();
									buildingsandstructures1Label = $('label[for='+buildingsandstructures1Id+']').html();
									
									formData.push({name: 'buildingsandstructures1Val',value: buildingsandstructures1Val});
									formData.push({name: 'buildingsandstructures1Label',value: buildingsandstructures1Label});
									
									location1Id = $('.checked input:radio[name=location1]').attr('id');
									location1Val = $('.checked input:radio[name=location1]').val();
									location1Label = $('label[for='+location1Id+']').html();
									
									formData.push({name: 'location1Val',value: location1Val});
									formData.push({name: 'location1Label',value: location1Label});
									
									protektzonetype1Id = $('.checked input:radio[name=protektzonetype1]').attr('id');
									protektzonetype1Val = $('.checked input:radio[name=protektzonetype1]').val();
									protektzonetype1Label = $('label[for='+protektzonetype1Id+']').html();
									
									formData.push({name: 'protektzonetype1Val',value: protektzonetype1Val});
									formData.push({name: 'protektzonetype1Label',value: protektzonetype1Label});
									
									lightprotcat1Id = $('.checked input:radio[name=lightprotcat1]').attr('id');
									lightprotcat1Val = $('.checked input:radio[name=lightprotcat1]').val();
									lightprotcat1Label = $('label[for='+lightprotcat1Id+']').html();
									
									formData.push({name: 'lightprotcat1Val',value: lightprotcat1Val});
									formData.push({name: 'lightprotcat1Label',value: lightprotcat1Label});
									
									if(lightningprotection1 != '4'){
										for(i=56;i<=78;i++){
											if($('#divrez'+i).css('display')!='none'){
												formData.push({name: 'reztitle'+i,value: $('#lbrez'+i+'title').html()});
												formData.push({name: 'rez'+i,value: $('#lbrez'+i).html()});
												}
										}
									} else {
										for(i=1; i<=lightningqtyval1 ;i++){
											if(i == lightningqtyval1)
												containerSelector = '#lightning'+lightningqtyval1+'1props';
											else
												containerSelector = '#lightning'+i+(i+1)+'props';
											for(j=56;j<=78;j++){												
												if($(containerSelector + ' #divrez'+j).css('display')!='none'){
													title = $(containerSelector+' #lbrez'+j+'title').html();
													rez = $(containerSelector+' #lbrez'+j).html();
													if($.trim(title) != '' && $.trim(rez) != ''){
														formData.push({name: 'reztitle'+i+'_'+j,value: title});
														formData.push({name: 'rez'+i+'_'+j,value: rez})
													}
													
												}
											}
										}
									}
									
									$.post(	'to_pdf.php?form=lightningprotection', 
											formData,
								            function(data) {
												window.location = '/../' + data;
								
								            });/**/
							    });

                                lightningRezClear();

                                $('input:radio[name=buildtype2]#rad112').iCheck('check');
                                $('input:radio[name=lightningprotection1]#rad114').iCheck('check');
                                $('input:radio[name=buildingsandstructures1]#rad121').iCheck('check');

                                $('input:radio[name=location1]#rad139').iCheck('check');
                                $('input:radio[name=location1]#rad141').iCheck('disable');
                                $('input:radio[name=location1]#rad142').iCheck('disable');
                                $('input:radio[name=location1]#rad143').iCheck('disable');
                                $('input:radio[name=location1]#rad144').iCheck('disable');

                                $('input:radio[name=protektzonetype1]#rad145').iCheck('check');
                                $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                $('input:radio[name=protektzonetype1]#rad146').iCheck('disable');
                                $('input:radio[name=lightprotcat1]#rad147').iCheck('check');
                                $('input:radio[name=lightprotcat1]#rad147').iCheck('enable');
                                $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                $('input:radio[name=lightprotcat1]#rad149').iCheck('disable');

                                $('#lengthordiamsign1').html('Диаметр A, м:');
                                $('#buildwidthblock1').hide();
                                $('input:radio[name=buildtype2]').on('ifChecked',function() {
                                    switch ($(this).attr('id')) {
                                        case 'rad112':
                                            $('#lengthordiamsign1').html('Диаметр A, м:');
                                            $('#buildwidthblock1').hide();
                                            break;
                                        case 'rad113':
                                            $('#lengthordiamsign1').html('Длина A, м:');
                                            $('#buildwidthblock1').show();
                                            break;
                                    }
                                });

                                $('input:radio[name=buildingsandstructures1]').on('ifChecked',function(){
                                    html = $("label[for=" + $(this).attr("id") + "]").html();
                                    $("#buildingsandstructuresselectedval1").html(html);
                                    rad_val = $(this).attr("value");
                                    //1-18
                                    switch(rad_val){
                                        case '1':
                                            $('input:radio[name=location1]#rad139').iCheck('check');
                                            $('input:radio[name=location1]#rad139').iCheck('enable');
                                            $('input:radio[name=location1]#rad140').iCheck('enable');
                                            $('input:radio[name=location1]#rad141').iCheck('disable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '2':
                                            $('input:radio[name=location1]#rad139').iCheck('check');
                                            $('input:radio[name=location1]#rad139').iCheck('enable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('disable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '3':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '4':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '5':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '6':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '7':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '8':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('check');
                                            $('input:radio[name=location1]#rad140').iCheck('enable');
                                            $('input:radio[name=location1]#rad141').iCheck('disable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '9':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('check');
                                            $('input:radio[name=location1]#rad140').iCheck('enable');
                                            $('input:radio[name=location1]#rad141').iCheck('disable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '10':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('disable');
                                            $('input:radio[name=location1]#rad142').iCheck('check');
                                            $('input:radio[name=location1]#rad142').iCheck('enable');
                                            $('input:radio[name=location1]#rad143').iCheck('check');
                                            $('input:radio[name=location1]#rad143').iCheck('enable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '11':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '12':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('disable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('check');
                                            $('input:radio[name=location1]#rad144').iCheck('enable');
                                            break;
                                        case '13':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('enable');
                                            $('input:radio[name=location1]#rad140').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('disable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '14':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '15':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '16':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        case '17':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                        break;
                                        case '18':
                                            $('input:radio[name=location1]#rad139').iCheck('disable');
                                            $('input:radio[name=location1]#rad140').iCheck('disable');
                                            $('input:radio[name=location1]#rad141').iCheck('check');
                                            $('input:radio[name=location1]#rad141').iCheck('enable');
                                            $('input:radio[name=location1]#rad142').iCheck('disable');
                                            $('input:radio[name=location1]#rad143').iCheck('disable');
                                            $('input:radio[name=location1]#rad144').iCheck('disable');
                                            break;
                                        default:
                                            break;
                                    }
                                });
                                lightningprotection1 = '1';
                                $('input:radio[name=lightningprotection1]').on('ifChecked',function() {
                                    lightningprotection1 = $(this).val();
                                    switch ($(this).attr('id')) {
                                        case 'rad114':
                                            $('#lightimg1').attr('src','img/light1.jpg');

                                            $('#lightningqty1').hide();
                                            $('#lightningheight_0').show();
                                            $('#lightningheight_1').hide();
                                            $('#lightningheight_2').hide();
                                            $('#lightningheight_op').hide();
                                            $('#lightningheight_op1').hide();
                                            $('#lightningheight_op2').hide();
                                            $('#lightningdistance_1').hide();
                                            $('#lengthspan1').hide();
                                            $('#lightningheightblocklink').hide();
                                            $('#lightningheightblock').hide();
                                            break;
                                        case 'rad115':
                                            $('#lightimg1').attr('src','img/light2.jpg');

                                            $('#lightningqty1').hide();
                                            $('#lightningheight_0').show();
                                            $('#lightningheight_1').hide();
                                            $('#lightningheight_2').hide();
                                            $('#lightningheight_op').hide();
                                            $('#lightningheight_op1').hide();
                                            $('#lightningheight_op2').hide();
                                            $('#lightningdistance_1').show();
                                            $('#lengthspan1').hide();
                                            $('#lightningheightblocklink').hide();
                                            $('#lightningheightblock').hide();
                                            break;
                                        case 'rad116':
                                            $('#lightimg1').attr('src','img/light3.jpg');

                                            $('#lightningqty1').hide();
                                            $('#lightningheight_0').hide();
                                            $('#lightningheight_1').show();
                                            $('#lightningheight_2').show();
                                            $('#lightningheight_op').hide();
                                            $('#lightningheight_op1').hide();
                                            $('#lightningheight_op2').hide();
                                            $('#lightningdistance_1').show();
                                            $('#lengthspan1').hide();
                                            $('#lightningheightblocklink').hide();
                                            $('#lightningheightblock').hide();
                                            break;
                                        case 'rad117':
                                            $('#lightimg1').attr('src','img/light4.jpg');

                                            $('#lightningqty1').show();
                                            $('#lightningheight_0').hide();
                                            $('#lightningheight_1').hide();
                                            $('#lightningheight_2').hide();
                                            $('#lightningheight_op').hide();
                                            $('#lightningheight_op1').hide();
                                            $('#lightningheight_op2').hide();
                                            $('#lightningdistance_1').hide();
                                            $('#lengthspan1').hide();
                                            $('#lightningheightblocklink').hide();
                                            $('#lightningheightblock').hide();
                                            break;
                                        case 'rad118':
                                            $('#lightimg1').attr('src','img/light5.jpg');

                                            $('#lightningqty1').hide();
                                            $('#lightningheight_0').hide();
                                            $('#lightningheight_1').hide();
                                            $('#lightningheight_2').hide();
                                            $('#lightningheight_op').show();
                                            $('#lightningheight_op1').hide();
                                            $('#lightningheight_op2').hide();
                                            $('#lightningdistance_1').hide();
                                            $('#lengthspan1').show();
                                            $('#lightningheightblocklink').hide();
                                            $('#lightningheightblock').hide();
                                            break;
                                        case 'rad119':
                                            $('#lightimg1').attr('src','img/light6.jpg');

                                            $('#lightningqty1').hide();
                                            $('#lightningheight_0').hide();
                                            $('#lightningheight_1').hide();
                                            $('#lightningheight_2').hide();
                                            $('#lightningheight_op').show();
                                            $('#lightningheight_op1').hide();
                                            $('#lightningheight_op2').hide();
                                            $('#lightningdistance_1').hide();
                                            $('#lengthspan1').show();
                                            $('#lightningheightblocklink').hide();
                                            $('#lightningheightblock').hide();
                                            break;
                                        case 'rad120':
                                            $('#lightimg1').attr('src','img/light7.jpg');

                                            $('#lightningqty1').hide();
                                            $('#lightningheight_0').hide();
                                            $('#lightningheight_1').hide();
                                            $('#lightningheight_2').hide();
                                            $('#lightningheight_op').hide();
                                            $('#lightningheight_op1').show();
                                            $('#lightningheight_op2').show();
                                            $('#lightningdistance_1').hide();
                                            $('#lengthspan1').show();
                                            $('#lightningheightblocklink').hide();
                                            $('#lightningheightblock').hide();
                                            break;
                                    }
                                });

                                //number of lesions
                                $('input:radio[name=buildtype2]').on('ifChecked', function(){calcNumberOfLesions();});
                                $('#densitybumps1').change(function(){calcNumberOfLesions();});
                                $('#lengthordiam1').change(function(){calcNumberOfLesions();});
                                $('#buildheightval1').change(function(){calcNumberOfLesions();});
                                $('#buildwidthval1').change(function(){calcNumberOfLesions();});

                                
								function openCloseBSBlock(obj){
                                    if($(obj).html() == '+ Открыть список зданий и строений') {
                                        $('#bsblock_0').slideDown();
                                        $(obj).html('— Свернуть');
                                    }
                                    else {
                                        $('#bsblock_0').slideUp();
                                        $(obj).html('+ Открыть список зданий и строений');
                                    }
                                }
                                N = null;   //количество поражений молнией в год
                                function calcNumberOfLesions() {
                                    buildType = $('input:radio[name=buildtype2]:checked').val();
                                    n = $('#densitybumps1').val();
                                    //alert(n);
                                    hx = $('#buildheightval1').val();    //высота
                                    A =  $('#lengthordiam1').val();      //длина или диаметр
                                    B =  $('#buildwidthval1').val();     //ширина

                                    switch(buildType){
                                        case '1':
                                            hx = Number($('#buildheightval1').val());
                                            if( isNaN(hx) || hx == '' ||
                                                isNaN(n)  || n == '' ){
                                                $('#lbrez55').html('укажите высоту здания');
                                                return;
                                            }
                                            N = 9 * Math.PI * hx * hx * n * 0.000001;
                                            $('#lbrez55').html(N.toFixed(2));
                                            break;
                                        case '2':
                                            hx = Number($('#buildheightval1').val());
                                            A =  Number($('#lengthordiam1').val());
                                            B =  Number($('#buildwidthval1').val());
                                            if( isNaN(hx) || hx == '' ||
                                                isNaN(A)  || A  == '' ||
                                                isNaN(B)  || B  == ''){
                                                $('#lbrez55').html('укажите габариты здания');
                                                return;
                                            }
                                            N = ( ( B + 6 * hx ) * ( A + 6 * hx ) - 7.7 * hx * hx ) * n * 0.000001;
                                            $('#lbrez55').html(N.toFixed(2));
                                            break;
                                        default:
                                            $('#lbrez55').html('укажите тип здания');
                                            break;
                                    }
                                }

                                buildingsandstructures1 = '1';
                                $('input:radio[name=buildingsandstructures1]').on('ifChecked',function(){
                                    buildingsandstructures1 = $(this).val();
                                    calcLightProtCategory();
                                });

                                location1 = '1';
                                $('input:radio[name=location1]').on('ifChecked',function(){
                                    location1 = $(this).val();
                                    calcLightProtCategory();
                                });

                                protektzonetype1 = '1';
                                $('input:radio[name=protektzonetype1]').on('ifChecked',function(){
                                    protektzonetype1 = $(this).val();
                                    calcLightProtCategory();
                                });

                                lightprotcat1 = '1';
                                function calcLightProtCategory(){
                                    switch(buildingsandstructures1){
                                        case '1':
                                            switch(location1){
                                                case '1':
                                                    $('input:radio[name=protektzonetype1]#rad145').iCheck('check');
                                                    $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                                    $('input:radio[name=protektzonetype1]#rad146').iCheck('disable');
                                                    protektzonetype1 = '1';

                                                    $('input:radio[name=lightprotcat1]#rad147').iCheck('check');
                                                    $('input:radio[name=lightprotcat1]#rad147').iCheck('enable');
                                                    $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                                    $('input:radio[name=lightprotcat1]#rad149').iCheck('disable');
                                                    lightprotcat1 = '1';
                                                    break;
                                                case '2':
                                                    $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                                    $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');

                                                    $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                                    $('input:radio[name=lightprotcat1]#rad148').iCheck('check');
                                                    $('input:radio[name=lightprotcat1]#rad148').iCheck('enable');
                                                    $('input:radio[name=lightprotcat1]#rad149').iCheck('disable');
                                                    lightprotcat1 = '2';
                                                    break;
                                                default:
                                                    break;
                                            }
                                            break;
                                        case '2':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('enable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('disable');
                                            lightprotcat1 = '2';
                                            break;
                                        case '3':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '4':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '5':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('disable');
                                            protektzonetype1 = '1';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '6':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('disable');
                                            protektzonetype1 = '1';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '7':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '8':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '9':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '10':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('disable');
                                            protektzonetype1 = '1';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '11':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('enable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('disable');
                                            lightprotcat1 = '2';
                                            break;
                                        case '12':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '13':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '14':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '15':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '16':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '17':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2';

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        case '18':
                                            $('input:radio[name=protektzonetype1]#rad145').iCheck('disable');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('check');
                                            $('input:radio[name=protektzonetype1]#rad146').iCheck('enable');
                                            protektzonetype1 = '2'

                                            $('input:radio[name=lightprotcat1]#rad147').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('check');
                                            $('input:radio[name=lightprotcat1]#rad149').iCheck('enable');
                                            lightprotcat1 = '3';
                                            break;
                                        default:
                                            break;
                                    }
                                }

                                function openCloseLightningHeightBlock(obj){
                                    if($(obj).html() == '+ Открыть блок ввода данных'){
                                        $('#lightningheightblock').slideDown();
                                        $(obj).html('— Свернуть');
                                    } else {
                                        $('#lightningheightblock').slideUp();
                                        $(obj).html('+ Открыть блок ввода данных');
                                    }
                                }

                                //
                                $('#lightningqtyval1').change(function(){
                                    i = Number($(this).val());
                                    if(isNaN(i) || i == '' ){
                                        alert('Некорректно введено количество молниеотводов');
                                        $('#lightningheightblocklink').hide();
                                        $('#lightningheightblock').hide();
                                        return;
                                    }
                                    if ( i < 3 ) {
                                        alert('Укажите не менее 3-х молниеотводов');
                                        return;
                                    }
                                    if ( i > 30 ) {
                                        alert('Укажите не больше 30 молниеотводов');
                                        return;
                                    }
                                    $('#lightningheightblock').empty();
                                    for (j = 1; j <= i; j++) {
                                        $('#lightningHeightTmpl').tmpl().appendTo('#lightningheightblock');
                                    }
                                    for (j = 1, k = 1; j <= i; j++) {
                                        if(j == i) k = 1;
                                        else k = j + 1;
                                        $('#lightningDistanceTmpl').tmpl().appendTo('#lightningheightblock');
                                    }

                                    $('#lightningheightblocklink').show();
                                    $('#lightningheightblock').show();
									
                                });/**/

                                $('#btnclear10').click(function(){
                                    N = null;
                                    lightningprotection1 = '1';
                                    buildingsandstructures1 = '1';
                                    location1 = '1';
                                    protektzonetype1 = '1';
                                    lightprotcat1 = '1';
                                    $('#lightningqty1').hide();
                                    $('#lightningheight_0').show();
                                    $('#lightningheight_1').hide();
                                    $('#lightningheight_2').hide();
                                    $('#lightningheight_op').hide();
                                    $('#lightningheight_op1').hide();
                                    $('#lightningheight_op2').hide();
                                    $('#lightningdistance_1').hide();
                                    $('#lengthspan1').hide();
                                    $('#lightningheightblocklink').hide();
                                    $('#lightningheightblock').hide();

                                    $('#lightningqtyval1').val('');
                                    $('#lightningheight_0val').val('');
                                    $('#lightningheight_1val').val('');
                                    $('#lightningheight_2val').val('');
                                    $('#lightningheight_opval').val('');
                                    $('#lightningheight_op1val').val('');
                                    $('#lightningheight_op2val').val('');
                                    $('#lightningdistance_1val').val('');
                                    $('#lengthspan1val').val('');
                                    $('#lengthordiam1').val('');
                                    $('#buildwidthval1').val('');
                                    $('#buildheightval1').val('');
                                    $('#densitybumps1').val('1');
                                    $('#lightningheightblock').empty();

                                    $('input:radio[name=buildtype2]#rad112').iCheck('check');
                                    $('input:radio[name=lightningprotection1]#rad114').iCheck('check');
                                    $('input:radio[name=buildingsandstructures1]#rad121').iCheck('check');

                                    $('input:radio[name=location1]#rad139').iCheck('check');
                                    $('input:radio[name=location1]#rad141').iCheck('disable');
                                    $('input:radio[name=location1]#rad142').iCheck('disable');
                                    $('input:radio[name=location1]#rad143').iCheck('disable');
                                    $('input:radio[name=location1]#rad144').iCheck('disable');

                                    $('input:radio[name=protektzonetype1]#rad145').iCheck('check');
                                    $('input:radio[name=protektzonetype1]#rad145').iCheck('enable');
                                    $('input:radio[name=protektzonetype1]#rad146').iCheck('disable');
                                    $('input:radio[name=lightprotcat1]#rad147').iCheck('check');
                                    $('input:radio[name=lightprotcat1]#rad147').iCheck('enable');
                                    $('input:radio[name=lightprotcat1]#rad148').iCheck('disable');
                                    $('input:radio[name=lightprotcat1]#rad149').iCheck('disable');

                                    $('#lengthordiamsign1').html('Диаметр, м:');
                                    $('#buildwidthblock1').hide();
                                    lightningRezClear();
                                });
                                $('#btncalc10').click(function(){
                                    lightningRezClear();
                                    switch (lightningprotection1) {
                                        case '1':
                                            if(true) {
                                                pz = Number(protektzonetype1);
                                                h = Number($('#lightningheight_0val').val().replace(',', '.'));
                                                hx = Number($('#buildheightval1').val().replace(',', '.'));
                                                A = Number($('#lengthordiam1').val().replace(',', '.'));
                                                if (isNaN(h) || h == '' ||
                                                    isNaN(hx) || hx == '' ||
                                                    isNaN(pz) || pz == '' ||
                                                    isNaN(A) || A == '') {
                                                    alert('Неверно указаны высота молниеотвода, тип зоны защиты, высота или длина здания.');
                                                    return;
                                                }
                                                if (h > 600) {
                                                    alert('Высота молниеотвода превышает 600 м.');
                                                    return;
                                                }
                                                h0 = 0;
                                                r0 = 0;
                                                rx = 0;
                                                alfa = 0;
                                                if (h <= 150 && pz == 1) {
                                                    h0 = 0.85 * h;
                                                    r0 = ( 1.1 - 0.002 * h ) * h;
                                                    rx = ( 1.1 - 0.002 * h ) * ( h - hx / 0.85 );
                                                    alfa = Math.atan( r0 / h0 );
                                                }
                                                if (h <= 150 && pz == 2) {
                                                    h0 = 0.92 * h;
                                                    r0 = 1.5 * h;
                                                    rx = 1.5 * (h - hx / 0.92);
                                                    alfa = Math.atan(r0 / h0);
                                                }
                                                if (h > 150 && h <= 600 && pz == 1) {
                                                    h0 = (0.85 - 1.7 * 0.001 * (h - 150)) * h;
                                                    r0 = (0.80 - 1.7 * 0.001 * (h - 150)) * h;
                                                    rx = (0.85 - 1.7 * 0.001 * (h - 150)) * h * (1 - hx / ((0.85 - 1.7 * 0.001 * (h - 150)) * h));
                                                    alfa = Math.atan(r0 / h0);
                                                }
                                                if (h > 150 && h <= 600 && pz == 2) {
                                                    h0 = (0.92 - 0.8 * 0.001 * (h - 150)) * h;
                                                    r0 = 225;
                                                    rx = 225 - (225 * hx) / ((0.92 - 0.8 * 0.001 * (h - 150)) * h);
                                                    alfa = Math.atan(r0 / h0);
                                                }
                                                protCrit = A < rx;

                                                $('#divrez56').show();  //Критерий защищенности
                                                $('#divrez57').show();  //Высота вершины конуса стержневого молниеотвода h<sub>0</sub>
                                                $('#divrez58').show();  //Радиус защиты на уровне земли r<sub>0</sub>
                                                $('#divrez59').show();  //Радиус защиты на уровне защищаемого объекта r<sub>x</sub>
                                                $('#divrez60').show();  //Угол защиты (между вертикалью и образующей) α

                                                $('#lbrez57').html(h0.toFixed(2));
                                                $('#lbrez58').html(r0.toFixed(2));
                                                $('#lbrez59').html(rx.toFixed(2));
                                                $('#lbrez60').html(alfa.toFixed(2));
                                                $('#lbrez56title').html('Критерий защищенности A < r<sub>x</sub> :');
                                                if (protCrit) $('#lbrez56').html('соблюден');
                                                else $('#lbrez56').html('не соблюден');

                                            }
                                            break;
                                        case '2':
                                            if(true) {
                                                pz = Number(protektzonetype1); //1
                                                h  = Number($('#lightningheight_0val').val().replace(',', '.'));
                                                hx = Number($('#buildheightval1').val().replace(',', '.'));
                                                A  = Number($('#lengthordiam1').val().replace(',', '.'));
                                                B  = Number($('#buildwidthval1').val().replace(',', '.'));
                                                L  = Number($('#lightningdistance_1val').val().replace(',', '.'));
                                                if (isNaN(h)  || h  == '' ||
                                                    isNaN(hx) || hx == '' ||
                                                    isNaN(pz) || pz == '' ||
                                                    isNaN(L)  || L  == '' ||
                                                    isNaN(A)  || A  == '' ||
                                                    isNaN(B)
                                                ) {
                                                    alert('Неверно указаны высота молниеотвода, тип зоны защиты, высота или длина здания.');
                                                    return;}
                                                if ( h > 150 ) { alert('Высота молниеотвода превышает 150 м.'); return; }
                                                if ( h  <= 150 && L <= h && pz == 1 ) {
                                                    h0 = 0.85 * h;
                                                    hc = h0 - ( 0.17 + 0.0003 * h ) * ( L - h );
                                                    r0 = ( 1.1 - 0.002 * h ) * h;
                                                    rc = r0;
                                                    rcx = rc * ( hc - hx ) / hc;
                                                    if( B == '' ) B = A;
                                                    protCrit = B < rcx && hc > hx;
                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>
                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(hc.toFixed(2));
                                                    $('#lbrez62').html(rc.toFixed(2));
                                                    $('#lbrez63').html(rcx.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub> :');// B<rcx и  hc>hx
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                if ( h <= 150 && L > h && L <= 4 * h && pz == 1 ) {
                                                    h0 = 0.85 * h;
                                                    hc = h0 - ( 0.17 + 0.0003 * h ) * ( L - h );
                                                    r0 = ( 1.1 - 0.002 * h ) * h;
                                                    rc = r0 * ( 1 - 0.2 * ( L - 2 * h ) / h );
                                                    rcx = rc * ( hc - hx ) / hc;
                                                    if( B == '' ) B = A;
                                                    protCrit = B < rcx && hc > hx;
                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>
                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(hc.toFixed(2));
                                                    $('#lbrez62').html(rc.toFixed(2));
                                                    $('#lbrez63').html(rcx.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub> :');// B<rcx и  hc>hx
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                if ( h <= 150 && L > 4 * h && pz == 1 ) {
                                                    h0 = 0.85 * h;
                                                    r0 = (1.1 - 0.002 * h) * h;
                                                    rx = (1.1 - 0.002 * h) * (h - hx / 0.85);
                                                    alfa = Math.atan(r0 / h0);
                                                    if( B == '' ) B = A;
                                                    protCrit = B < 2 * rx && A < 2 * rx;
                                                    $('#divrez57').show();  //h<sub>0</sub>
                                                    $('#divrez58').show();  //r<sub>0</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>
                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez57').html(h0.toFixed(2));
                                                    $('#lbrez58').html(r0.toFixed(2));
                                                    $('#lbrez63').html(rcx.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < 2r<sub>x</sub> и A < 2r<sub>x</sub>');// B<rcx и  hc>hx
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                if ( h  <= 150 && L <= h && pz == 2 ) {
                                                    h0 = 0.92 * h;
                                                    hc = h0;
                                                    r0 = 1.5 * h;
                                                    rc = r0;
                                                    rx = 1.5 * (h - hx / 0.92);
                                                    rcx = hx;
                                                    if( B == '' ) B = A;
                                                    protCrit = B < rcx && hc > hx;
                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>
                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(hc.toFixed(2));
                                                    $('#lbrez62').html(rc.toFixed(2));
                                                    $('#lbrez63').html(rcx.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub>');// B<rcx и  hc>hx
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                if ( h <= 150 && L > h && L <= 6 * h && pz == 2 ) {
                                                    h0 = 0.92 * h;
                                                    hc = h0 - 0.14 * ( L - h );
                                                    r0 = 1.5 * h;
                                                    rc = r0;
                                                    rcx = r0 * ( hc - hx ) / hc;
                                                    if( B == '' ) B = A;
                                                    protCrit = B < rcx && hc > hx;
                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>
                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(hc.toFixed(2));
                                                    $('#lbrez62').html(rc.toFixed(2));
                                                    $('#lbrez63').html(rcx.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub>');
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                if ( h <= 150 && L > 6 * h && pz == 2 ) {
                                                    h0 = 0.85 * h;
                                                    r0 = (1.1 - 0.002 * h) * h;
                                                    rx = (1.1 - 0.002 * h) * (h - hx / 0.85);
                                                    alfa = Math.atan(r0 / h0);
                                                    if( B == '' ) B = A;
                                                    protCrit = B < 2 * rx && A < 2 * rx;
                                                    $('#divrez57').show();  //h<sub>0</sub>
                                                    $('#divrez58').show();  //r<sub>0</sub>
                                                    $('#divrez59').show();  //r<sub>x</sub>
                                                    $('#divrez60').show();  //α
                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez57').html(h0.toFixed(2));
                                                    $('#lbrez58').html(r0.toFixed(2));
                                                    $('#lbrez59').html(rx.toFixed(2));
                                                    $('#lbrez60').html(alfa.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < 2r<sub>x</sub> и A < 2r<sub>x</sub>');
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                            }
                                            break;
                                        case '3':
                                            if(true) {
                                                pz = Number(protektzonetype1);
                                                h1 = Number($('#lightningheight_1val').val().replace(',', '.'));
                                                h2 = Number($('#lightningheight_2val').val().replace(',', '.'));
                                                hx = Number($('#buildheightval1').val().replace(',', '.'));
                                                A  = Number($('#lengthordiam1').val().replace(',', '.'));
                                                B  = Number($('#buildwidthval1').val().replace(',', '.'));
                                                L  = Number($('#lightningdistance_1val').val().replace(',', '.'));
                                                if (isNaN(h1)  || h1  == '' ||
                                                    isNaN(h2)  || h2  == '' ||
                                                    isNaN(hx)  || hx  == '' ||
                                                    isNaN(pz)  || pz  == '' ||
                                                    isNaN(L)   || L   == '' ||
                                                    isNaN(A)   || A   == '' ||
                                                    isNaN(B)
                                                ) {
                                                    alert('Неверно указаны высоты молниеотвода, тип зоны защиты, высота или длина здания.');
                                                    return;
                                                }

                                                hmin = Math.min(h1,h2);

                                                if ( Number(Math.max(h1,h2)) > 150 ) { alert('Высота одного из молниеотводов превышает 150 м.'); return; }
                                                if ( hmin  <= 150 && L <= 4 * hmin && pz == 1 ) {
                                                    h01 = 0.85 * h1;
                                                    r01 = (1.1 - 0.002 * h1) * h1;
                                                    rx1 = (1.1 - 0.002 * h1) * (h1 - hx / 0.85);

                                                    h02 = 0.85 * h2;
                                                    r02 = (1.1 - 0.002 * h2) * h2;
                                                    rx2 = (1.1 - 0.002 * h2) * (h2 - hx / 0.85);

                                                    hc1 = h01 - (0.17 + 0.0003 * h1) * (L - h1);
                                                    hc2 = h02 - (0.17 + 0.0003 * h2) * (L - h2);

                                                    hc = (hc1 + hc2) / 2;
                                                    rc = (r01 + r02) / 2;

                                                    rcx = rc * (hc - hx) / hc;

                                                    if( B == '' ) B = A;
                                                    protCrit = B < rcx && hc > hx;
                                                    $('#divrez64').show();  //h<sub>01</sub>
                                                    $('#divrez65').show();  //r<sub>01</sub>
                                                    $('#divrez66').show();  //r<sub>x1</sub>
                                                    $('#divrez67').show();  //h<sub>02</sub>
                                                    $('#divrez68').show();  //r<sub>02</sub>
                                                    $('#divrez69').show();  //r<sub>x2</sub
                                                    $('#divrez70').show();  //h<sub>c1</sub>
                                                    $('#divrez71').show();  //h<sub>c2</sub>
                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez64').html(h01.toFixed(2));  //h<sub>01</sub>
                                                    $('#lbrez65').html(r01.toFixed(2));  //r<sub>01</sub>
                                                    $('#lbrez66').html(rx1.toFixed(2));  //r<sub>x1</sub>
                                                    $('#lbrez67').html(h02.toFixed(2));  //h<sub>02</sub>
                                                    $('#lbrez68').html(r02.toFixed(2));  //r<sub>02</sub>
                                                    $('#lbrez69').html(rx2.toFixed(2));  //r<sub>x2</sub
                                                    $('#lbrez70').html(hc1.toFixed(2));  //h<sub>c1</sub>
                                                    $('#lbrez71').html(hc2.toFixed(2));  //h<sub>c2</sub>
                                                    $('#lbrez61').html(hc.toFixed(2));  //h<sub>c</sub>
                                                    $('#lbrez62').html(rc.toFixed(2));  //r<sub>c</sub>
                                                    $('#lbrez63').html(rcx.toFixed(2));  //r<sub>cx</sub>

                                                    $('#lbrez56title').html('Критерий защищенности B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub>');
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                if ( hmin  <= 150 && L > 4 * hmin && pz == 1 ) {
                                                    h01 = 0.85 * h1;
                                                    r01 = (1.1 - 0.002 * h1) * h1;
                                                    rx1 = (1.1 - 0.002 * h1) * (h1 - hx / 0.85);
                                                    alfa1 = Math.atan(r01 / h01);

                                                    h02 = 0.85 * h2;
                                                    r02 = (1.1 - 0.002 * h2) * h2;
                                                    rx2 = (1.1 - 0.002 * h2) * (h2 - hx / 0.85);
                                                    alfa2 = Math.atan(r01 / h01);

                                                    if( B == '' ) B = A;
                                                    protCrit = B < Math.min(rx1, rx2) && A < Math.min(rx1, rx2);
                                                    $('#divrez64').show();  //h<sub>01</sub>
                                                    $('#divrez65').show();  //r<sub>01</sub>
                                                    $('#divrez66').show();  //r<sub>x1</sub>
                                                    $('#divrez72').show();  //α<sub>1</sub>
                                                    $('#divrez67').show();  //h<sub>02</sub>
                                                    $('#divrez68').show();  //r<sub>02</sub>
                                                    $('#divrez69').show();  //r<sub>x2</sub>
                                                    $('#divrez73').show();  //α<sub>2</sub>

                                                    $('#lbrez64').html(h01.toFixed(2));
                                                    $('#lbrez65').html(r01.toFixed(2));
                                                    $('#lbrez66').html(rx1.toFixed(2));
                                                    $('#lbrez67').html(h02.toFixed(2));
                                                    $('#lbrez68').html(r02.toFixed(2));
                                                    $('#lbrez69').html(rx2.toFixed(2));
                                                    $('#lbrez72').html(alfa1.toFixed(2));
                                                    $('#lbrez73').html(alfa2.toFixed(2));
													
                                                }
                                                //
                                                if ( hmin  <= 150 && L <= 6 * hmin && pz == 2 ) {
                                                    h01 = 0.92 * h1;
                                                    r01 = 1.5 * h1;
                                                    rx1 = 1.5 * (h1 - hx / 0.92);

                                                    h02 = 0.92 * h2;
                                                    r02 = 1.5 * h2;
                                                    rx2 = 1.5 * (h2 - hx / 0.92);

                                                    hc1 = h01 - (0.17 + 0.0003 * h1) * (L - h1);
                                                    hc2 = h02 - (0.17 + 0.0003 * h2) * (L - h2);

                                                    hc = (hc1 + hc2) / 2;
                                                    rc = (r01 + r02) / 2;

                                                    rcx = rc * (hc - hx) / hc;

                                                    if( B == '' ) B = A;
                                                    protCrit = B < rcx && hc > hx;

                                                    $('#divrez64').show();  //h<sub>01</sub>
                                                    $('#divrez65').show();  //r<sub>01</sub>
                                                    $('#divrez66').show();  //r<sub>x1</sub>
                                                    $('#divrez67').show();  //h<sub>02</sub>
                                                    $('#divrez68').show();  //r<sub>02</sub>
                                                    $('#divrez69').show();  //r<sub>x2</sub
                                                    $('#divrez70').show();  //h<sub>c1</sub>
                                                    $('#divrez71').show();  //h<sub>c2</sub>
                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez64').html(h01.toFixed(2));  //h<sub>01</sub>
                                                    $('#lbrez65').html(r01.toFixed(2));  //r<sub>01</sub>
                                                    $('#lbrez66').html(rx1.toFixed(2));  //r<sub>x1</sub>
                                                    $('#lbrez67').html(h02.toFixed(2));  //h<sub>02</sub>
                                                    $('#lbrez68').html(r02.toFixed(2));  //r<sub>02</sub>
                                                    $('#lbrez69').html(rx2.toFixed(2));  //r<sub>x2</sub
                                                    $('#lbrez70').html(hc1.toFixed(2));  //h<sub>c1</sub>
                                                    $('#lbrez71').html(hc2.toFixed(2));  //h<sub>c2</sub>
                                                    $('#lbrez61').html(hc.toFixed(2));  //h<sub>c</sub>
                                                    $('#lbrez62').html(rc.toFixed(2));  //r<sub>c</sub>
                                                    $('#lbrez63').html(rcx.toFixed(2));  //r<sub>cx</sub>

                                                    $('#lbrez56title').html('Критерий защищенности B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub>');
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                if ( hmin  <= 150 && L > 6 * hmin && pz == 2 ) {
                                                    h01 = 0.92 * h1;
                                                    r01 = 1.5 * h1;
                                                    rx1 = 1.5 * (h1 - hx / 0.92);
                                                    alfa1 = Math.atan(r01 / h01);

                                                    h02 = 0.92 * h2;
                                                    r02 = 1.5 * h2;
                                                    rx2 = 1.5 * (h2 - hx / 0.92);
                                                    alfa2 = Math.atan(r02 / h02);

                                                    if( B == '' ) B = A;
                                                    protCrit = B < Math.min(rx1, rx2) && A < Math.min(rx1, rx2);
                                                    //alert('h01 = ' + h01 + ' r01 = ' + r01 + ' rx1 = ' + rx1 + ' h02 = ' + h02 + ' r02 = ' + r02 + ' rx2 = ' + rx2 + ' protCrit = ' + protCrit );
                                                    $('#divrez64').show();  //h<sub>01</sub>
                                                    $('#divrez65').show();  //r<sub>01</sub>
                                                    $('#divrez66').show();  //r<sub>x1</sub>
                                                    $('#divrez72').show();  //α<sub>1</sub>
                                                    $('#divrez67').show();  //h<sub>02</sub>
                                                    $('#divrez68').show();  //r<sub>02</sub>
                                                    $('#divrez69').show();  //r<sub>x2</sub>
                                                    $('#divrez73').show();  //α<sub>2</sub>

                                                    $('#lbrez64').html(h01.toFixed(2));
                                                    $('#lbrez65').html(r01.toFixed(2));
                                                    $('#lbrez66').html(rx1.toFixed(2));
                                                    $('#lbrez67').html(h02.toFixed(2));
                                                    $('#lbrez68').html(r02.toFixed(2));
                                                    $('#lbrez69').html(rx2.toFixed(2));
                                                    $('#lbrez72').html(alfa1.toFixed(2));
                                                    $('#lbrez73').html(alfa2.toFixed(2));
                                                }
                                            }
                                            break;
                                        case '4':
                                            if(true) {
                                                n  = Number($('#lightningqtyval1').val().replace(',', '.'));
                                                if ( isNaN(n) || n == '' ) {
                                                    alert('Неверно указано количество молниеотводов');
                                                    return;
                                                }
                                                if ( n < 3 ) {
                                                    alert('Укажите не менее 3-х молниеотводов');
                                                    return;
                                                }
                                                if ( n > 30 ) {
                                                    alert('Укажите не больше 30 молниеотводов');
                                                    return;
                                                }
                                                lightHeightArr = [];
                                                lightDistArr = [];
                                                for(i = 1; i <= n; i++){
                                                    if(i == n) k = i + '' + 1;
                                                    else k = i + '' + ( i + 1 );
                                                    lightHeightArrItem  = Number($('#lightningheight' + i).val().replace(',', '.'));
                                                    lightDistArrItem    = Number($('#lightningdist' + k).val().replace(',', '.'));
                                                    if( isNaN(lightHeightArrItem) || lightHeightArrItem == '' ||
                                                        isNaN(lightDistArrItem) || lightDistArrItem == '' ){
                                                        alert('Неверно указаны высота или дистанция для молниеотвода ' + i);
                                                        return;
                                                    }
                                                    if( lightHeightArrItem > 150 ){
                                                        alert('Высота молниеотвода ' + i + ' превышает 150 метров');
                                                        return;
                                                    }
                                                    lightHeightArr.push(lightHeightArrItem);
                                                    lightDistArr.push(lightDistArrItem);
                                                }

                                                pz = Number(protektzonetype1);
                                                hx = Number($('#buildheightval1').val().replace(',', '.'));
                                                A  = Number($('#lengthordiam1').val().replace(',', '.'));
                                                B  = Number($('#buildwidthval1').val().replace(',', '.'));
                                                if(  isNaN(pz)  || pz  == '' ||
                                                     isNaN(hx)  || hx  == '' ||
                                                     isNaN(A)   || A   == '' ||
                                                     isNaN(B) ) {
                                                    alert('Неверно указаны тип зоны защиты, высота или длина здания.');
                                                    return;
                                                }

                                                lightningData = [];
                                                for( i = 0; i < lightHeightArr.length; i++ ){
                                                    neighbor = i + 1;
                                                    if( i + 1 == lightHeightArr.length )
                                                        neighbor = 0;
                                                    if( lightHeightArr[i] == lightHeightArr[neighbor] ){
														
                                                        L = lightHeightArr[i];
                                                        h = lightDistArr[i];
                                                        if ( L <= h && pz == 1 ) {
                                                            h0 = 0.85 * h;
                                                            hc = h0 - ( 0.17 + 0.0003 * h ) * ( L - h );
                                                            r0 = ( 1.1 - 0.002 * h ) * h;
                                                            rc = r0;
                                                            rcx = rc * ( hc - hx ) / hc;
                                                            if( B == '' ) B = A;
                                                            protCrit = B < rcx && hc > hx;
                                                            item = { hc: hc,
                                                                     rc: rc,
                                                                     rcx: rcx,
                                                                     protCritStr: ' B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub> ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                        if ( L > h && L <= 4 * h && pz == 1 ) {
                                                            h0 = 0.85 * h;
                                                            hc = h0 - ( 0.17 + 0.0003 * h ) * ( L - h );
                                                            r0 = ( 1.1 - 0.002 * h ) * h;
                                                            rc = r0 * ( 1 - 0.2 * ( L - 2 * h ) / h );
                                                            rcx = rc * ( hc - hx ) / hc;
                                                            if( B == '' ) B = A;
                                                            protCrit = B < rcx && hc > hx;
                                                            item = { hc: hc,
                                                                     rc: rc,
                                                                     rcx: rcx,
                                                                     protCritStr: ' B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub> ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                        if ( L > 4 * h && pz == 1 ) {
                                                            h0 = 0.85 * h;
                                                            r0 = (1.1 - 0.002 * h) * h;
                                                            rx = (1.1 - 0.002 * h) * (h - hx / 0.85);
                                                            alfa = Math.atan(r0 / h0);
                                                            if( B == '' ) B = A;
                                                            protCrit = B < 2 * rx && A < 2 * rx;
                                                            item = { h0: h0,
                                                                     r0: r0,
                                                                     rx: rx,
                                                                     alfa: alfa,
                                                                     protCritStr: ' B < 2r<sub>x</sub> и A < 2r<sub>x</sub> ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                        if ( L <= h && pz == 2 ) {
                                                            h0 = 0.92 * h;
                                                            hc = h0;
                                                            r0 = 1.5 * h;
                                                            rc = r0;
                                                            rx = 1.5 * (h - hx / 0.92);
                                                            rcx = hx;
                                                            if( B == '' ) B = A;
                                                            protCrit = B < rcx && hc > hx;
                                                            item = { hc: hc,
                                                                     rc: rc,
                                                                     rx: rx,
                                                                     rcx: rcx,
                                                                     protCritStr: ' B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub> ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                        if ( L > h && L <= 6 * h && pz == 2 ) {
                                                            h0 = 0.92 * h;
                                                            hc = h0 - 0.14 * ( L - h );
                                                            r0 = 1.5 * h;
                                                            rc = r0;
                                                            rcx = r0 * ( hc - hx ) / hc;
                                                            if( B == '' ) B = A;
                                                            protCrit = B < rcx && hc > hx;
                                                            item = { hc: hc,
                                                                     rc: rc,
                                                                     rcx: rcx,
                                                                     protCritStr: ' B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub> ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                        if ( L > 6 * h && pz == 2 ) {
                                                            h0 = 0.85 * h;
                                                            r0 = (1.1 - 0.002 * h) * h;
                                                            rx = (1.1 - 0.002 * h) * (h - hx / 0.85);
                                                            alfa = Math.atan(r0 / h0);
                                                            if( B == '' ) B = A;
                                                            protCrit = B < 2 * rx && A < 2 * rx;
                                                            item = { h0: h0,
                                                                     r0: r0,
                                                                     rx: rx,
                                                                     alfa: alfa,
                                                                     protCritStr: ' B < 2r<sub>x</sub> и B < 2r<sub>x</sub> ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                    }
                                                    else {
                                                        h1 = lightHeightArr[i];
                                                        h2 = lightHeightArr[neighbor];
                                                        L  = lightDistArr[i];

                                                        hmin = Math.min(h1,h2);

                                                        if ( hmin  <= 150 && L <= 4 * hmin && pz == 1 ) {
                                                            h01 = 0.85 * h1;
                                                            r01 = (1.1 - 0.002 * h1) * h1;
                                                            rx1 = (1.1 - 0.002 * h1) * (h1 - hx / 0.85);

                                                            h02 = 0.85 * h2;
                                                            r02 = (1.1 - 0.002 * h2) * h2;
                                                            rx2 = (1.1 - 0.002 * h2) * (h2 - hx / 0.85);

                                                            hc1 = h01 - (0.17 + 0.0003 * h1) * (L - h1);
                                                            hc2 = h02 - (0.17 + 0.0003 * h2) * (L - h2);

                                                            hc = (hc1 + hc2) / 2;
                                                            rc = (r01 + r02) / 2;

                                                            rcx = rc * (hc - hx) / hc;

                                                            if( B == '' ) B = A;
                                                            protCrit = B < rcx && hc > hx;

                                                            item = { h01: h01,
                                                                     r01: r01,
                                                                     rx1: rx1,
                                                                     hc1: hc1,
                                                                     h02: h02,
                                                                     r02: r02,
                                                                     rx2: rx2,
                                                                     hc2: hc2,
                                                                     hc: hc,
                                                                     rc: rc,
                                                                     rcx: rcx,
                                                                     protCritStr: ' B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub> ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                        if ( hmin  <= 150 && L > 4 * hmin && pz == 1 ) {
                                                            h01 = 0.85 * h1;
                                                            r01 = (1.1 - 0.002 * h1) * h1;
                                                            rx1 = (1.1 - 0.002 * h1) * (h1 - hx / 0.85);
                                                            alfa1 = Math.atan(r01 / h01);

                                                            h02 = 0.85 * h2;
                                                            r02 = (1.1 - 0.002 * h2) * h2;
                                                            rx2 = (1.1 - 0.002 * h2) * (h2 - hx / 0.85);
                                                            alfa1 = Math.atan(r01 / h01);

                                                            if( B == '' ) B = A;
                                                            protCrit = B < Math.min(rx1, rx2) && A < Math.min(rx1, rx2);
															
                                                            item = { h01: h01,
                                                                     r01: r01,
                                                                     rx1: rx1,
                                                                     alfa1: alfa1,
                                                                     h02: h02,
                                                                     r02: r02,
                                                                     rx2: rx2,
                                                                     alfa2: alfa2,
                                                                     protCritStr: ' уточнить ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                        //
                                                        if ( hmin  <= 150 && L <= 6 * hmin && pz == 2 ) {
                                                            h01 = 0.92 * h1;
                                                            r01 = 1.5 * h1;
                                                            rx1 = 1.5 * (h1 - hx / 0.92);

                                                            h02 = 0.92 * h2;
                                                            r02 = 1.5 * h2;
                                                            rx2 = 1.5 * (h2 - hx / 0.92);

                                                            hc1 = h01 - (0.17 + 0.0003 * h1) * (L - h1);
                                                            hc2 = h02 - (0.17 + 0.0003 * h2) * (L - h2);

                                                            hc = (hc1 + hc2) / 2;
                                                            rc = (r01 + r02) / 2;

                                                            rcx = rc * (hc - hx) / hc;

                                                            if( B == '' ) B = A;
                                                            protCrit = B < rcx && hc > hx;

                                                            item = { h01: h01,
                                                                     r01: r01,
                                                                     rx1: rx1,
                                                                     h02: h02,
                                                                     r02: r02,
                                                                     rx2: rx2,
                                                                     hc: hc,
                                                                     rc: rc,
                                                                     rcx: rcx,
                                                                     protCritStr: ' B < r<sub>cx</sub> и h<sub>c</sub> > h<sub>x</sub> ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                        if ( hmin  <= 150 && L > 6 * hmin && pz == 2 ) {
                                                            h01 = 0.92 * h1;
                                                            r01 = 1.5 * h1;
                                                            rx1 = 1.5 * (h1 - hx / 0.92);
                                                            alfa1 = Math.atan(r01 / h01);

                                                            h02 = 0.92 * h2;
                                                            r02 = 1.5 * h2;
                                                            rx2 = 1.5 * (h2 - hx / 0.92);
                                                            alfa2 = Math.atan(r02 / h02);

                                                            if( B == '' ) B = A;
                                                            protCrit = B < Math.min(rx1, rx2) && A < Math.min(rx1, rx2);
															
                                                            item = { h01: h01,
                                                                     r01: r01,
                                                                     rx1: rx1,
                                                                     alfa1: alfa1,
                                                                     h02: h02,
                                                                     r02: r02,
                                                                     rx2: rx2,
                                                                     alfa2: alfa2,
                                                                     protCritStr: ' уточнить ',
                                                                     protCrit: protCrit,
                                                                     zone: pz };
                                                            lightningData[i] = item;
                                                        }
                                                    }
                                                }

                                                showMultipleLightningOptions(lightningData);
                                            }
                                            break;
                                        case '5':
                                            if(true) {
                                                pz = Number(protektzonetype1);
                                                hop = Number($('#lightningheight_opval').val().replace(',', '.'));
                                                hx = Number($('#buildheightval1').val().replace(',', '.'));
                                                A  = Number($('#lengthordiam1').val().replace(',', '.'));
                                                B  = Number($('#buildwidthval1').val().replace(',', '.'));
                                                a  = Number($('#lengthspan1val').val().replace(',', '.'));
                                                if (isNaN(hop)  || hop  == '' ||
                                                    isNaN(hx)   || hx   == '' ||
                                                    isNaN(pz)   || pz   == '' ||
                                                    isNaN(a)    || a    == '' ||
                                                    isNaN(A)    || A    == '' ||
                                                    isNaN(B)
                                                ) {
                                                    alert('Неверно указаны высота молниеотвода, тип зоны защиты, длина пролета, высота или длина здания.');
                                                    return;
                                                }

                                                if ( a > 150 ) { alert('Длина пролета превышает 150 м.'); return; }

                                                ht = 0;

                                                if ( a <= 120 ) ht = hop - 2;
                                                else ht = hop - 3;

                                                h0 = 0;
                                                r0 = 0;
                                                rx = 0;
                                                protCrit = false;

                                                if ( pz == 1 ) {
                                                    h0 = 0.85 * ht;
                                                    r0 = (1.35 - 0.0025 * ht) * ht;
                                                    rx = (1.35 - 0.0025 * ht) * (ht - hx / 0.85);
                                                }
                                                if ( pz == 2 ) {
                                                    h0 = 0.92 * ht;
                                                    r0 = 1.7 * ht;
                                                    rx = 1.7 * (ht - hx / 0.92);
                                                }
                                                if( B == '' ) B = A;
                                                protCrit = B < 2 * rx && A < a;

                                                $('#divrez57').show();  //h<sub>0</sub>
                                                $('#divrez58').show();  //r<sub>0</sub>
                                                $('#divrez59').show();  //r<sub>x</sub>

                                                $('#divrez56').show();  //Критерий защищенности

                                                $('#lbrez57').html(h0.toFixed(2));
                                                $('#lbrez58').html(r0.toFixed(2));
                                                $('#lbrez59').html(rx.toFixed(2));
                                                $('#lbrez56title').html('Критерий защищенности B < 2r<sub>x</sub> и A < a :');
                                                if (protCrit) $('#lbrez56').html('соблюден');
                                                else $('#lbrez56').html('не соблюден');
                                            }
                                            break;
                                        case '6':
                                            if(true) {
                                                pz  = Number(protektzonetype1);
                                                hop = Number($('#lightningheight_opval').val().replace(',', '.'));
                                                hx  = Number($('#buildheightval1').val().replace(',', '.'));
                                                A   = Number($('#lengthordiam1').val().replace(',', '.'));
                                                B   = Number($('#buildwidthval1').val().replace(',', '.'));
                                                a   = Number($('#lengthspan1val').val().replace(',', '.'));
                                                if (isNaN(hop)  || hop  == '' ||
                                                    isNaN(hx)   || hx   == '' ||
                                                    isNaN(pz)   || pz   == '' ||
                                                    isNaN(a)    || a    == '' ||
                                                    isNaN(A)    || A    == '' ||
                                                    isNaN(B)
                                                ) {
                                                    alert('Неверно указаны высота молниеотвода, тип зоны защиты, длина пролета, высота или длина здания.');
                                                    return;
                                                }

                                                if ( a > 150 ) { alert('Длина пролета превышает 150 м.'); return; }

                                                ht = 0;

                                                if ( a <= 120 ) ht = hop - 2;
                                                else ht = hop - 3;

                                                h0 = 0.85 * ht;
                                                r0 = (1.35 - 0.0025 * ht) * ht;
                                                rx = (1.35 - 0.0025 * ht) * (ht - hx / 0.85);
                                                protCrit = B < 2 * rx && A < a;

                                                if ( pz == 1 && a <= ht ) {
                                                    hc = h0;
                                                    rc = r0;
                                                    rcx = rx;
                                                    if( B == '' ) B = A;
                                                    protCrit = B < (a + rcx) && hc > hx && A < a;

                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(h0.toFixed(2));
                                                    $('#lbrez62').html(r0.toFixed(2));
                                                    $('#lbrez63').html(rx.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>x</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }

                                                if ( pz == 1 && a > ht && a < 2 * ht ) {
                                                    hc = h0 - (0.14 - 0.0005 * ht) * (a - ht);
                                                    r_touch_x = (a / 2) * ((h0 - hx) / (h0 - hc));
                                                    rcx = r0 * (hc - hx) / hc;
                                                    rc = r0;
                                                    protCrit = B < (a + rcx) && hc > hx && A < a;

                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>
                                                    $('#divrez78').show();  //r'<sub>x</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(hc.toFixed(2));
                                                    $('#lbrez62').html(rc.toFixed(2));
                                                    $('#lbrez63').html(rcx.toFixed(2));
                                                    $('#lbrez78').html(r_touch_x.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>x</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }

                                                if ( pz == 1 && a > 2 * ht && a <= 4 * ht ) {
                                                    hc = h0 - (0.14 - 0.0005 * ht) * (a - ht);
                                                    r_touch_x = (a / 2) * ((h0 - hx) / (h0 - hc));
                                                    rcx = r0 * (hc - hx) / hc;
                                                    rc = r0 * (1 - 0.2 * (a - 2 * ht) / ht);
                                                    protCrit = B < (a + rcx) && hc > hx && A < a;

                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez63').show();  //r<sub>cx</sub>
                                                    $('#divrez78').show();  //r'<sub>x</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(hc.toFixed(2));
                                                    $('#lbrez62').html(rc.toFixed(2));
                                                    $('#lbrez63').html(rcx.toFixed(2));
                                                    $('#lbrez78').html(r_touch_x.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>x</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');

                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }

                                                if ( pz == 1 && a > 4 * ht ) {
                                                    // выводим h0 r0 rx protCrit;
                                                    $('#divrez57').show();  //h<sub>0</sub>
                                                    $('#divrez58').show();  //r<sub>0</sub>
                                                    $('#divrez59').show();  //r<sub>x</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez57').html(h0.toFixed(2));
                                                    $('#lbrez58').html(r0.toFixed(2));
                                                    $('#lbrez59').html(rx.toFixed(2));
                                                    $('#lbrez56title').html('Критерий защищенности B < 2r<sub>x</sub> и A < a :');
                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                //
                                                if ( pz == 2 && a <= ht ) {
                                                    hc = h0;
                                                    rc = r0;
                                                    rcx = rx;
                                                    if( B == '' ) B = A;
                                                    protCrit = B < (a + rcx) && hc > hx && A < a;

                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez59').show();  //r<sub>x</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(hc.toFixed(2));
                                                    $('#lbrez62').html(rc.toFixed(2));
                                                    $('#lbrez59').html(rcx.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>cx</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');

                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                                if ( pz == 2 && a > ht && a <= 6 * ht ) {
                                                    hc = h0 - 0.12 * (a - ht);
                                                    r_touch_x = (a / 2) * ((h0 - hx) / (h0 - hc));
                                                    rcx = r0 * (hc - hx) / hc;
                                                    rc = r0;
                                                    protCrit = B < (a + rcx) && hc > hx && A < a;

                                                    $('#divrez61').show();  //h<sub>c</sub>
                                                    $('#divrez62').show();  //r<sub>c</sub>
                                                    $('#divrez59').show();  //r<sub>x</sub>
                                                    $('#divrez78').show();  //r'<sub>x</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez61').html(hc.toFixed(2));
                                                    $('#lbrez62').html(rc.toFixed(2));
                                                    $('#lbrez59').html(rcx.toFixed(2));
                                                    $('#lbrez78').html(r_touch_x.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>cx</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');

                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }

                                                if ( pz == 2 && a > 6 * ht ) {
                                                    h0 = 0.92 * ht;
                                                    r0 = 1.7 * ht;
                                                    rx = 1.7 * (ht - hx / 0.92);
                                                    protCrit = B < 2 * rcx && A < a;

                                                    $('#divrez57').hide();  //h<sub>0</sub>
                                                    $('#divrez58').hide();  //r<sub>0</sub>
                                                    $('#divrez59').hide();  //r<sub>x</sub>

                                                    $('#divrez56').show();  //Критерий защищенности

                                                    $('#lbrez57').html(h0.toFixed(2));
                                                    $('#lbrez58').html(r0.toFixed(2));
                                                    $('#lbrez59').html(rx.toFixed(2));

                                                    $('#lbrez56title').html('Критерий защищенности B < 2r<sub>cx</sub> и A < a :');

                                                    if (protCrit) $('#lbrez56').html('соблюден');
                                                    else $('#lbrez56').html('не соблюден');
                                                }
                                            }
                                            break;
                                        case '7':
                                            if(true) {
                                                pz   = Number(protektzonetype1);
                                                hop1 = Number($('#lightningheight_op1val').val().replace(',', '.'));
                                                hop2 = Number($('#lightningheight_op2val').val().replace(',', '.'));
                                                hx   = Number($('#buildheightval1').val().replace(',', '.'));
                                                A    = Number($('#lengthordiam1').val().replace(',', '.'));
                                                B    = Number($('#buildwidthval1').val().replace(',', '.'));
                                                a    = Number($('#lengthspan1val').val().replace(',', '.'));
                                                if (isNaN(hop1)  || hop1  == '' ||
                                                    isNaN(hop2)  || hop2  == '' ||
                                                    isNaN(hx)    || hx    == '' ||
                                                    isNaN(pz)    || pz    == '' ||
                                                    isNaN(a)     || a     == '' ||
                                                    isNaN(A)     || A     == '' ||
                                                    isNaN(B)
                                                ) {
                                                    alert('Неверно указаны высота молниеотвода, тип зоны защиты, длина пролета, высота или длина здания.');
                                                    return;
                                                }

                                                if ( a > 150 ) { alert('Длина пролета превышает 150 м.'); return; }

                                                ht1 = 0;
                                                ht2 = 0;

                                                if ( a <= 120 ){
                                                    ht1 = hop1 - 2;
                                                    ht2 = hop2 - 2;
                                                }
                                                else{
                                                    ht1 = hop1 - 3;
                                                    ht2 = hop2 - 3;
                                                }

                                                htmin = Math.min(ht1,ht2);

                                                if(pz == 1){
                                                    h01 = 0.85 * ht1;
                                                    r01 = (1.35 - 0.0025 * ht1) * ht1;
                                                    rx1 = (1.35 - 0.0025 * ht1) * (ht1 - hx / 0.85);

                                                    h02 = 0.85 * ht2;
                                                    r02 = (1.35 - 0.0025 * ht2) * ht2;
                                                    rx2 = (1.35 - 0.0025 * ht2) * (ht2 - hx / 0.85);

                                                    if(a <= htmin){
                                                        hc1 = h01;
                                                        hc2 = h02;
                                                        rc = (r01 + r02) / 2;
                                                        hc = (hc1 - hc2) / 2;
                                                        rcx1 = rx1;
                                                        rcx2 = rx2;
                                                        protCrit = B < (a + rx1 + rx2) && hc > hx && A < a;

                                                        $('#divrez70').show();  //h<sub>c1</sub>
                                                        $('#divrez71').show();  //h<sub>c2</sub>
                                                        $('#divrez61').show();  //h<sub>c</sub>
                                                        $('#divrez62').show();  //r<sub>c</sub>
                                                        $('#divrez74').show();  //r<sub>cx1</sub>
                                                        $('#divrez75').show();  //r<sub>cx2</sub>

                                                        $('#lbrez70').html(hc1.toFixed(2));
                                                        $('#lbrez71').html(hc2.toFixed(2));
                                                        $('#lbrez61').html(hc.toFixed(2));
                                                        $('#lbrez62').html(rc.toFixed(2));
                                                        $('#lbrez74').html(rcx1.toFixed(2));
                                                        $('#lbrez75').html(rcx2.toFixed(2));

                                                        $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>x1</sub> + r<sub>x2</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');

                                                        if (protCrit) $('#lbrez56').html('соблюден');
                                                        else $('#lbrez56').html('не соблюден');
                                                    }
                                                    if(a > htmin && a <= 2 * htmin){
                                                        hc1 = h01 - (0.14 - 0.0005 * ht1) * (a - ht1);
                                                        hc2 = h02 - (0.14 - 0.0005 * ht2) * (a - ht2);
                                                        rc = (r01 + r02) / 2;
                                                        hc = (hc1 - hc2) / 2;
                                                        r_toch_x1 = (a / 2) * (h01 - hx) / (h01 - hc1);
                                                        r_toch_x2 = (a / 2) * (h02 - hx) / (h02 - hc2);
                                                        rcx = rc * (hc - hx) / hc;
                                                        protCrit = B < (a + rx1 + rx2) && hc > hx && A < a;

                                                        $('#divrez70').show();  //h<sub>c1</sub>
                                                        $('#divrez71').show();  //h<sub>c2</sub>
                                                        $('#divrez61').show();  //h<sub>c</sub>
                                                        $('#divrez62').show();  //r<sub>c</sub>
                                                        $('#divrez76').show();  //r'<sub>x1</sub>
                                                        $('#divrez77').show();  //r'<sub>x2</sub>
                                                        $('#divrez63').show();  //r<sub>cx</sub>

                                                        $('#lbrez70').html(hc1.toFixed(2));
                                                        $('#lbrez71').html(hc2.toFixed(2));
                                                        $('#lbrez61').html(hc.toFixed(2));
                                                        $('#lbrez62').html(rc.toFixed(2));
                                                        $('#lbrez76').html(r_toch_x1.toFixed(2));
                                                        $('#lbrez77').html(r_toch_x2.toFixed(2));
                                                        $('#lbrez63').html(rcx.toFixed(2));


                                                        $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>x1</sub> + r<sub>x2</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');

                                                        if (protCrit) $('#lbrez56').html('соблюден');
                                                        else $('#lbrez56').html('не соблюден');
                                                    }
                                                    if(a > 2 * htmin && a <= 4 * htmin){
                                                        hc1 = h01 - (0.14 - 0.0005 * ht1) * (a - ht1);
                                                        hc2 = h02 - (0.14 - 0.0005 * ht2) * (a - ht2);
                                                        rc = (r01 + r02) / 2;
                                                        hc = (hc1 - hc2) / 2;
                                                        r_toch_x1 = (a / 2) * (h01 - hx) / (h01 - hc1);
                                                        r_toch_x2 = (a / 2) * (h02 - hx) / (h02 - hc2);
                                                        rcx = rc * (hc - hx) / hc;
                                                        if( B == '' ) B = A;
                                                        protCrit = B < (a + rx1 + rx2) && hc > hx && A < a;

                                                        $('#divrez70').show();  //h<sub>c1</sub>
                                                        $('#divrez71').show();  //h<sub>c2</sub>
                                                        $('#divrez61').show();  //h<sub>c</sub>
                                                        $('#divrez62').show();  //r<sub>c</sub>
                                                        $('#divrez76').show();  //r'<sub>x1</sub>
                                                        $('#divrez77').show();  //r'<sub>x2</sub>
                                                        $('#divrez63').show();  //r<sub>cx</sub>

                                                        $('#lbrez70').html(hc1.toFixed(2));
                                                        $('#lbrez71').html(hc2.toFixed(2));
                                                        $('#lbrez61').html(hc.toFixed(2));
                                                        $('#lbrez62').html(rc.toFixed(2));
                                                        $('#lbrez76').html(r_toch_x1.toFixed(2));
                                                        $('#lbrez77').html(r_toch_x2.toFixed(2));
                                                        $('#lbrez63').html(rcx.toFixed(2));

                                                        $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>x1</sub> + r<sub>x2</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');

                                                        if (protCrit) $('#lbrez56').html('соблюден');
                                                        else $('#lbrez56').html('не соблюден');
                                                    }
                                                    if(a > 4 * htmin){

                                                        if( B == '' ) B = A;
                                                        //B<2*rx1+2*rx2  и А<a
                                                        protCrit = B < (2 * rx1 + 2 * rx2) && A < a;
                                                        //alert('h0 = ' + h0 + ' r0 = ' + r0 + ' rx = ' + rx);

                                                        $('#divrez64').show();  //h<sub>01</sub>
                                                        $('#divrez65').show();  //r<sub>01</sub>
                                                        $('#divrez66').show();  //r<sub>x1</sub>
                                                        $('#divrez67').show();  //h<sub>02</sub>
                                                        $('#divrez68').show();  //r<sub>02</sub>
                                                        $('#divrez69').show();  //r<sub>x2</sub>

                                                        $('#divrez56').show();  //Критерий защищенности

                                                        $('#lbrez64').html(h01.toFixed(2));
                                                        $('#lbrez65').html(r01.toFixed(2));
                                                        $('#lbrez66').html(rx1.toFixed(2));
                                                        $('#lbrez67').html(h02.toFixed(2));
                                                        $('#lbrez68').html(r02.toFixed(2));
                                                        $('#lbrez69').html(rx2.toFixed(2));

                                                        $('#lbrez56title').html('Критерий защищенности B < ( 2r<sub>x1</sub> + 2r<sub>x2</sub> ) и A < a :');

                                                        if (protCrit) $('#lbrez56').html('соблюден');
                                                        else $('#lbrez56').html('не соблюден');
                                                    }
                                                }

                                                if(pz == 2){
                                                    h01 = 0.92 * ht1;
                                                    r01 = 1.7 * ht1;
                                                    rx1 = 1.7 * (ht1 - hx / 0.92);

                                                    h01 = 0.92 * ht1;
                                                    r01 = 1.7 * ht1;
                                                    rx1 = 1.7 * (ht1 - hx / 0.92);

                                                    if(a <= htmin){

                                                        hc1 = h01;
                                                        hc2 = h02;
                                                        rc = (r01 + r02) / 2;
                                                        hc = (hc1 - hc2) / 2;
                                                        rcx1 = rx1;
                                                        rcx2 = rx2;
                                                        //B<Lт+rx1+rx2 и  hc>hx и А<a
                                                        protCrit = B < (a + rx1 + rx2) && hc > hx && A < a;

                                                        $('#divrez70').show();  //h<sub>c1</sub>
                                                        $('#divrez71').show();  //h<sub>c2</sub>
                                                        $('#divrez61').show();  //h<sub>c</sub>
                                                        $('#divrez62').show();  //r<sub>c</sub>
                                                        $('#divrez74').show();  //r<sub>cx1</sub>
                                                        $('#divrez75').show();  //r<sub>cx2</sub>

                                                        $('#divrez56').show();  //Критерий защищенности

                                                        $('#lbrez70').html(hc1.toFixed(2));
                                                        $('#lbrez71').html(hc2.toFixed(2));
                                                        $('#lbrez61').html(hc.toFixed(2));
                                                        $('#lbrez62').html(rc.toFixed(2));
                                                        $('#lbrez74').html(rcx1.toFixed(2));
                                                        $('#lbrez75').html(rcx2.toFixed(2));

                                                        $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>x1</sub> + r<sub>x2</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');

                                                        if (protCrit) $('#lbrez56').html('соблюден');
                                                        else $('#lbrez56').html('не соблюден');
                                                    }
                                                    if(a > htmin && a <= 6 * htmin){
                                                        hc1 = h01 - 0.12 * (a - ht1);
                                                        hc2 = h02 - 0.12 * (a - ht2);
                                                        rc = (r01 + r02) / 2;
                                                        hc = (hc1 - hc2) / 2;
                                                        r_toch_x1 = (a / 2) * (h01 - hx) / (h01 - hc1);
                                                        r_toch_x2 = (a / 2) * (h02 - hx) / (h02 - hc2);
                                                        rcx = rc * (hc - hx) / hc;
                                                        protCrit = B < (a + rx1 + rx2) && hc > hx && A < a;

                                                        $('#divrez70').show();  //h<sub>c1</sub>
                                                        $('#divrez71').show();  //h<sub>c2</sub>
                                                        $('#divrez61').show();  //h<sub>c</sub>
                                                        $('#divrez62').show();  //r<sub>c</sub>
                                                        $('#divrez76').show();  //r'<sub>x1</sub>
                                                        $('#divrez77').show();  //r'<sub>x2</sub>
                                                        $('#divrez63').show();  //r<sub>cx</sub>

                                                        $('#divrez56').show();  //Критерий защищенности

                                                        $('#lbrez70').html(hc1.toFixed(2));
                                                        $('#lbrez71').html(hc2.toFixed(2));
                                                        $('#lbrez61').html(hc.toFixed(2));
                                                        $('#lbrez62').html(rc.toFixed(2));
                                                        $('#lbrez76').html(r_toch_x1.toFixed(2));
                                                        $('#lbrez77').html(r_toch_x2.toFixed(2));
                                                        $('#lbrez63').html(rcx.toFixed(2));

                                                        $('#lbrez56title').html('Критерий защищенности B < ( a + r<sub>x1</sub> + r<sub>x2</sub> ) и h<sub>c</sub> > h<sub>x</sub> и A < a :');

                                                        if (protCrit) $('#lbrez56').html('соблюден');
                                                        else $('#lbrez56').html('не соблюден');
                                                    }
                                                    if(a > 6 * htmin){

                                                        if( B == '' ) B = A;
														
                                                        protCrit = B < (2 * rx1 + 2 * rx2) && A < a;
														
                                                        $('#divrez64').show();  //h<sub>01</sub>
                                                        $('#divrez65').show();  //r<sub>01</sub>
                                                        $('#divrez66').show();  //r<sub>x1</sub>
                                                        $('#divrez67').show();  //h<sub>02</sub>
                                                        $('#divrez68').show();  //r<sub>02</sub>
                                                        $('#divrez69').show();  //r<sub>x2</sub>

                                                        $('#divrez56').show();  //Критерий защищенности

                                                        $('#lbrez64').html(h01.toFixed(2));
                                                        $('#lbrez65').html(r01.toFixed(2));
                                                        $('#lbrez66').html(rx1.toFixed(2));
                                                        $('#lbrez67').html(h02.toFixed(2));
                                                        $('#lbrez68').html(r02.toFixed(2));
                                                        $('#lbrez69').html(rx2.toFixed(2));

                                                        $('#lbrez56title').html('Критерий защищенности B < ( 2r<sub>x1</sub> + 2r<sub>x2</sub> ) и A < a :');

                                                        if (protCrit) $('#lbrez56').html('соблюден');
                                                        else $('#lbrez56').html('не соблюден');
                                                    }
                                                }
                                            }
                                            break;
                                    }
                                });

                                function lightningRezClear(){
                                    $('#divrez56').hide();  //Критерий защищенности
                                    $('#divrez57').hide();  //h<sub>0</sub>
                                    $('#divrez58').hide();  //r<sub>0</sub>
                                    $('#divrez59').hide();  //r<sub>x</sub>
                                    $('#divrez60').hide();  //α
                                    $('#divrez61').hide();  //h<sub>c</sub>
                                    $('#divrez62').hide();  //r<sub>c</sub>
                                    $('#divrez63').hide();  //r<sub>cx</sub>
                                    $('#divrez64').hide();  //h<sub>01</sub>
                                    $('#divrez65').hide();  //r<sub>01</sub>
                                    $('#divrez66').hide();  //r<sub>x1</sub>
                                    $('#divrez67').hide();  //h<sub>02</sub>
                                    $('#divrez68').hide();  //r<sub>02</sub>
                                    $('#divrez69').hide();  //r<sub>x2</sub>
                                    $('#divrez70').hide();  //h<sub>c1</sub>
                                    $('#divrez71').hide();  //h<sub>c2</sub>
                                    $('#divrez72').hide();  //α<sub>1</sub>
                                    $('#divrez73').hide();  //α<sub>2</sub>
                                    $('#divrez74').hide();  //r<sub>cx1</sub>
                                    $('#divrez75').hide();  //r<sub>cx2</sub>
                                    $('#divrez78').hide();  //r'<sub>x</sub>
                                    $('#divrez76').hide();  //r'<sub>x1</sub>
                                    $('#divrez77').hide();  //r'<sub>x2</sub>
                                    $('#lightningpropscontainer').empty()
                                }

                                function showMultipleLightningOptions(lightningData){
                                    for(i = 1; i <= lightningData.length; i++){
                                        neighbor = i + 1;
                                        if( i == lightningData.length )
                                            neighbor = 1;
                                        $('#multipleLightningPropsTmpl').tmpl().appendTo('#lightningpropscontainer');
                                        id= '#lightning' + i + '' + neighbor + 'props';
                                        lightningDataItem = lightningData[i - 1];

                                        for(key in lightningDataItem){
                                            switch(key){
                                                case 'hc':
                                                    htmlItem = $(id).find('#divrez61');
                                                    $(htmlItem).find('#lbrez61').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'rc':
                                                    htmlItem = $(id).find('#divrez62');
                                                    $(htmlItem).find('#lbrez62').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'rcx':
                                                    htmlItem = $(id).find('#divrez63');
                                                    $(htmlItem).find('#lbrez63').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'protCrit':
                                                    htmlItem = $(id).find('#divrez56');
                                                    $(htmlItem).find('#lbrez56title').html(lightningDataItem['protCritStr']);
                                                    if(Boolean(lightningDataItem[key]))
                                                        $(htmlItem).find('#lbrez56').html('соблюден');
                                                    else
                                                        $(htmlItem).find('#lbrez56').html('не соблюден');
                                                    $(htmlItem).show();
                                                    break;
                                                case 'zone':
                                                    break;
                                                case 'h0':
                                                    htmlItem = $(id).find('#divrez57');
                                                    $(htmlItem).find('#lbrez57').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'r0':
                                                    htmlItem = $(id).find('#divrez58');
                                                    $(htmlItem).find('#lbrez58').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'rx':
                                                    htmlItem = $(id).find('#divrez59');
                                                    $(htmlItem).find('#lbrez59').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'alfa':
                                                    htmlItem = $(id).find('#divrez60');
                                                    $(htmlItem).find('#lbrez60').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'h01':
                                                    htmlItem = $(id).find('#divrez64');
                                                    $(htmlItem).find('#lbrez64').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'r01':
                                                    htmlItem = $(id).find('#divrez65');
                                                    $(htmlItem).find('#lbrez65').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'rx1':
                                                    htmlItem = $(id).find('#divrez59');
                                                    $(htmlItem).find('#lbrez59').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'hc1':
                                                    htmlItem = $(id).find('#divrez70');
                                                    $(htmlItem).find('#lbrez70').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'h02':
                                                    htmlItem = $(id).find('#divrez67');
                                                    $(htmlItem).find('#lbrez67').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'r02':
                                                    htmlItem = $(id).find('#divrez68');
                                                    $(htmlItem).find('#lbrez68').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'rx2':
                                                    htmlItem = $(id).find('#divrez69');
                                                    $(htmlItem).find('#lbrez69').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'hc2':
                                                    htmlItem = $(id).find('#divrez71');
                                                    $(htmlItem).find('#lbrez71').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'alfa1':
                                                    htmlItem = $(id).find('#divrez72');
                                                    $(htmlItem).find('#lbrez72').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                case 'alfa2':
                                                    htmlItem = $(id).find('#divrez73');
                                                    $(htmlItem).find('#lbrez73').html(lightningDataItem[key].toFixed(2));
                                                    $(htmlItem).show();
                                                    break;
                                                default: break;
                                            }
                                        }
                                    }
                                }
                            </script>
                        </div>
                        <div class="tab-pane" id="panel-359136">
							<div class="row" style="border-bottom: 1px solid #cecece; border-top: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;margin-top: 9px;">
								<div class="col-md-5">
									<label class="control-label red_text">Область использования:</label>
								</div>
								<div class="col-md-7">
									<select class="selectpicker" id="usearea1" style="width: 250px !important;  height: 40px !important;">
										<option value="0.3">Вентиляция</option>
										<option value="0.27">Компрессор</option>
										<option value="0.33">Насос</option>
									</select>
								</div>
							</div>
							<div class="row" style="border-bottom: 1px solid #cecece; padding-bottom: 15px;margin-top: 9px;">
								<div class="col-md-5">
									<label class="control-label red_text">Питающая сеть:</label>
								</div>
								<div class="col-md-7">
									<select class="selectpicker" id="powerline1" style="width: 250px !important;  height: 40px !important;">
										<option value="1х230">1х230</option>
										<option value="3х400">3х400</option>
									</select>
								</div>
							</div>
							<div class="row" style="border-bottom: 1px solid #cecece; padding-bottom: 15px;margin-top: 9px;">
								<div class="col-md-5">
									<label class="control-label red_text">Характеристики двигателя:</label>
								</div>
								<div class="col-md-7">
									<select class="selectpicker" id="engineoptions1" style="width: 250px !important;  height: 40px !important;">
										<option value="0.4/5.4">0,4кВт / 5,4А</option>
										<option value="0.75/8.2">0,75кВт / 8,2А</option>
										<option value="1.5/14">1,5кВт / 14А</option>
										<option value="2.2/24">2,2кВт / 24А</option>
									</select>
								</div>
							</div>
							<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
								<div class="col-md-5">
									<label class="control-label red_text">Среднее время использования двигателя:</label>
								</div>
								<div class="col-md-7">
									<input name="averagetime1" id="averagetime1" type="text" value="6000" style="height: 40px !important;">
								</div>
							</div>
							<div class="row" style="margin-top: 15px;">
								<div class="col-md-12">
									<button class="btn btn_calc" id="btncalc12" style="display: inline-block;height: 50px !important; width: 235px !important;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Подобрать и рассчитать</button>
								</div>
							</div>
							<div class="row" style="margin-top: 15px;">
								<div class="col-md-12">
									<label class="control-label red_text"><h4 style="font-weight: bold;">Рекомендованный преобразователь частоты:</h4></label>									 
								</div>
							</div>
							<div id="rezblock2" style="display: none;">
								<div class="row" style="margin-top: 5px;">
									<div class="col-md-12">
										<a href="" target='_blank' style="font-size: 22px;"></a>
									</div>
								</div>
								<div class="row" style="margin-top: 5px;">
									<div class="col-md-4">
										<img src="" width="230px;">
									</div>
									<div class="col-md-8">										
										<div class="row" style="margin-top: 5px;">
											<div class="col-md-3">
												<label class="control-label red_text">Артикул:</label>
											</div>
											<div class="col-md-9">
												<label id="rez86" class="control-label rez_text"></label>
											</div>
										</div>
										<div class="row" style="margin-top: 5px;">
											<div class="col-md-3">
												<label class="control-label red_text">Выгода от применения, руб. в год:</label>
											</div>
											<div class="col-md-9">
												<label id="rez87" class="control-label rez_text"></label>
											</div>
										</div>										
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="table-responsive"> 
											<table class="table table-bordered">
												<tr >
													<td><label class="control-label red_text"  style="font-size: 9px;">Средняя эффективность использования преобразователя частоты, %</label></td>									
													<td><label class="control-label red_text"  style="font-size: 9px;">Среднее время использования двигателя, ч. в год</label></td>
													<td><label class="control-label red_text"  style="font-size: 9px;">Цена за кВт*ч, руб</label></td>
													<td><label class="control-label red_text"  style="font-size: 9px;">Потребление без преобразователя, кВт*ч</label></td>
													<td><label class="control-label red_text"  style="font-size: 9px;">Затраты на электроэнергию без преобразователя, руб. в год</label></td>
													<td><label class="control-label red_text"  style="font-size: 9px;">Потребление с преобразователем, кВт*ч</label></td>
													<td><label class="control-label red_text"  style="font-size: 9px;">Затраты на электроэнергию с преобразователем, руб. в год</label></td>													
												</tr>
												<tr>
													<td><input value='' type='text' id='rez88' style="width: 80px; font-size: 12px;" disabled></td>									
													<td><input value='' type='text' id='rez89' style="width: 80px; font-size: 12px;" disabled></td>
													<td><input value='' type='text' id='rez90' style="width: 80px; font-size: 12px;" disabled></td>
													<td><input value='' type='text' id='rez91' style="width: 90px; font-size: 12px;" disabled></td>
													<td><input value='' type='text' id='rez92' style="width: 90px; font-size: 12px;" disabled></td>
													<td><input value='' type='text' id='rez93' style="width: 90px; font-size: 12px;" disabled></td>
													<td><input value='' type='text' id='rez94' style="width: 90px; font-size: 12px;" disabled></td>
												</tr>												
											</table>
										</div>
									</div>
								</div>
							</div>
							<script>
								$("#powerline1").change(function(){
									switch($(this).val()){
										case '1х230':
										$("#engineoptions1 option").remove();
										$("#engineoptions1").append("<option value='0.4/5.4'>0,4кВт / 5,4А</option>");
										$("#engineoptions1").append("<option value='0.75/8.2'>0,75кВт / 8,2А</option>");
										$("#engineoptions1").append("<option value='1.5/14'>1,5кВт / 14А</option>");
										$("#engineoptions1").append("<option value='2.2/24'>2,2кВт / 24А</option>");
										break;
										case '3х400':
										$("#engineoptions1 option").remove();
										$("#engineoptions1").append("<option value='0.75/3.4'>0,75кВт / 3,4А</option>");
										$("#engineoptions1").append("<option value='1.5/5'>1,5кВт / 5А</option>");
										$("#engineoptions1").append("<option value='11/26'>11кВт / 26А</option>");
										$("#engineoptions1").append("<option value='15/35'>15кВт / 35А</option>");
										$("#engineoptions1").append("<option value='18/38'>18кВт / 38А</option>");
										$("#engineoptions1").append("<option value='2.2/5.8'>2,2кВт  / 5,8А</option>");
										$("#engineoptions1").append("<option value='22/46'>22кВт / 46А</option>");
										$("#engineoptions1").append("<option value='30/62'>30кВт / 62А</option>");
										$("#engineoptions1").append("<option value='37/76'>37кВт / 76А</option>");
										$("#engineoptions1").append("<option value='45/92'>45кВт / 92А</option>");
										$("#engineoptions1").append("<option value='4/11'>4кВт / 11А</option>");
										$("#engineoptions1").append("<option value='5.5/14.6'>5,5кВт / 14,6А</option>");
										$("#engineoptions1").append("<option value='55/112'>55кВт / 112А</option>");
										$("#engineoptions1").append("<option value='7.5/20.5'>7,5кВт / 20,5А</option>");
										$("#engineoptions1").append("<option value='75/157'>75кВт / 157А</option>");
										break;
										default: return false;
									}
								});
								function getConverters(){
									return [ { 	mains: '1х230', 			power: 0.4, 
												article: 'VT100-0R4-1B', 	maxPower: 0.75, 
												electricity: 5.4, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-0-4-0-75kvt-1kh230v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/ff6/ff62216cfcf2a6473f860fc0941b3de2.jpg' },
											 { 	mains: '1х230', 			power: 0.75, 
												article: 'VT100-0R7-1B', 	maxPower: 1.5, 
												electricity: 8.2, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-0-75-1-5kvt-1kh230v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/85b/85b14e7e401bc5a3532dd0e7ba357b9f.jpg' },
											 { 	mains: '1х230', 			power: 1.5, 
												article: 'VT100-1R5-1B', 	maxPower: 2.2, 
												electricity: 14, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-1-5-2-2kvt-1kh230v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/596/59628a5f2c5500917fc49bf2c069982c.jpg' },
											 { 	mains: '1х230', 			power: 2.2, 
												article: 'VT100-2R2-1B', 	maxPower: 4, 
												electricity: 24, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-2-2-4kvt-1kh230v-vector-100-ekf-proxima/', 
												recImg: 'http://ekfgroup.com/upload/iblock/f6c/f6cfb9ace73dc29eae9fc9b14be1b556.jpg' },
											 { 	mains: '3х400', 			power: 0.75, 
												article: 'VT100-0R7-3B', 	maxPower: 1.5, 
												electricity: 3.4, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-0-75-1-5kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/05b/05b04af88e47aa51b8d46321d6d271b4.jpg' },
											 { 	mains: '3х400', 			power: 1.5, 
												article: 'VT100-1R5-3B', 	maxPower: 2.2, 
												electricity: 5, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-1-5-2-2kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/134/134b9d3c0dcb8749f9a08ded624007c8.jpg' },
											 { 	mains: '3х400', 			power: 11, 
												article: 'VT100-011-3B', 	maxPower: 15, 
												electricity: 26, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-11-15kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/f5d/f5d30f600f3b697d7279629a1043913e.jpg' },
											{ 	mains: '3х400', 			power: 15, 
												article: 'VT100-015-3B', 	maxPower: 18, 
												electricity: 35, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-15-18kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/db6/db6118c009199495109606124124bfb6.jpg' },
											{ 	mains: '3х400', 			power: 18, 
												article: 'VT100-018-3', 	maxPower: 22, 
												electricity: 38, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-18-22kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/513/513283da79c3c64ffd16f4d805fd17d3.jpg' },
											{ 	mains: '3х400', 			power: 2.2, 
												article: 'VT100-2R2-3B', 	maxPower: 4, 
												electricity: 5.8, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-2-2-4kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/a8a/a8afd7182e7724740ee7b0023f5c8a0c.jpg' },
											{ 	mains: '3х400', 			power: 22, 
												article: 'VT100-022-3', 	maxPower: 30, 
												electricity: 46, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-22-30kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/c69/c69b918fb008f5fe800866c45e07be28.jpg' },
											{ 	mains: '3х400', 			power: 30, 
												article: 'VT100-030-3', 	maxPower: 37, 
												electricity: 62, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-30-37kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/8d4/8d4cc39f0c1b593942b7737c3236d14a.jpg' },
											{ 	mains: '3х400', 			power: 37, 
												article: 'VT100-037-3', 	maxPower: 45, 
												electricity: 76, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-37-45kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/c57/c575ad3679de440a86529436b404762d.jpg' },
											{ 	mains: '3х400', 			power: 45, 
												article: 'VT100-045-3', 	maxPower: 55, 
												electricity: 92, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-45-55kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/070/070094458b3a90843e28780de9068865.jpg' },
											{ 	mains: '3х400', 			power: 4, 
												article: 'VT100-4R0-3B', 	maxPower: 5.5, 
												electricity: 11, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-4-5-5kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/614/614cf68cddc1e9098a6ef5561ecaab8a.jpg' },
											{ 	mains: '3х400', 			power: 5.5, 
												article: 'VT100-5R5-3B', 	maxPower: 7.5, 
												electricity: 14.6, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-5-5-7-5kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/203/203e132b8f9104458f95433fc1ad205e.jpg' },
											{ 	mains: '3х400', 			power: 55, 
												article: 'VT100-055-3', 	maxPower: 75, 
												electricity: 112, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-55-75kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/95f/95fee5ddee71171c9fe768b779fffd9a.jpg' },
											{ 	mains: '3х400', 			power: 7.5, 
												article: 'VT100-7R5-3B', 	maxPower: 77, 
												electricity: 20.5, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-7-5-11kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/b95/b956813cab729178f2941d00268d21b5.jpg' },
											{ 	mains: '3х400', 			power: 75, 
												article: 'VT100-075-3', 	maxPower: 90, 
												electricity: 157, 
												frecUrl: 'https://ekfgroup.com/produktsiya/preobrazovateli-chastoty-vector/preobrazovatel-chastoty-75-90kvt-3kh400v-vector-100-ekf-proxima/', 
												frecImg: 'http://ekfgroup.com/upload/iblock/a62/a625d53d9733fc571a68f475acc6ada4.jpg' }
									];
								}
								$('#btncalc12').click(function(){
									powerline = $('#powerline1').val();
									engineoptions_html = $('#engineoptions1 option:selected').html().replace(',','.').replace(',','.');
									engineoptions_val = $('#engineoptions1 option:selected').val();
									power = engineoptions_val.split('/')[0];
									current = engineoptions_val.split('/')[1];
									converters = getConverters();
									averagetime = parseInt($("#averagetime1").val());
									useArea = $('#usearea1 option:selected').val().replace(',','.').replace(',','.');
									kvtPrice = 3.5;
									if(isNaN(averagetime)) return false;
									recomConv = null;
									converters.forEach(function(item){
										checkStr = item.power + 'кВт / ' + item.electricity + 'А';
										if(powerline == item.mains && checkStr == engineoptions_html)
											recomConv = item;										
									});
									effectivity = (averagetime * power * kvtPrice) - (averagetime * recomConv.power * (1 - useArea) * kvtPrice);
									link = "<strong>Преобразователь частоты VECTOR-100 " + recomConv.power + "/" + recomConv.maxPower + " кВт " + recomConv.mains + "В EKF PROxima</strong>";
									
									$("#rezblock2 a").attr('href',recomConv.frecUrl);
									$("#rezblock2 a").html(link);
									$("#rez86").html(recomConv.article);
									$("#rezblock2 img").attr('src',recomConv.frecImg);
									$("#rez87").html(effectivity.toFixed(2));
									$("#rez88").val((useArea * 100.0).toFixed(0));
									$("#rez89").val((averagetime).toFixed(0));
									$("#rez90").val((kvtPrice).toFixed(2));
									$("#rez91").val((power * averagetime).toFixed(2));
									$("#rez92").val((power * averagetime * kvtPrice).toFixed(2));
									$("#rez93").val((averagetime * recomConv.power * (1 - useArea)).toFixed(2));
									$("#rez94").val((averagetime * recomConv.power * (1 - useArea) * kvtPrice).toFixed(2));
									$("#rezblock2").show();
								});
							</script>
                        </div>
						<div class="tab-pane" id="panel-359137">						
							<br>
							<div class="row" style="border: 1px solid black; padding: 5px;">
								<div class="col-md-12">
									<span><b>Выбор и проверка приборов учета:</b></span>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Коэффициент трансформации трансформатора тока:</label>
										</div>
										<div class="col-md-7">
											<select class="selectpicker" id="transkoeff1" name="transkoeff1" style="width: 250px !important;  height: 40px !important;">
												<option value="novalue" selected="">Выберите...</option>
												<option value="2">10/5</option>
												<option value="4">20/5</option>
												<option value="6">30/5</option>
												<option value="8">40/5</option>
												<option value="10">50/5</option>
												<option value="15">75/5</option>
												<option value="20">100/5</option>
												<option value="25">125/5</option>
												<option value="30">150/5</option>
												<option value="40">200/5</option>
												<option value="50">250/5</option>
												<option value="60">300/5</option>
												<option value="80">400/5</option>
												<option value="100">500/5</option>
												<option value="200">1000/5</option>
											  </select>
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Cos(ϕ):</label>
										</div>
										<div class="col-md-7">
											<select class="selectpicker" id="cosf4" name="cosf4" style="width: 250px !important;  height: 40px !important;">
												<option value="novalue" selected="">Выберите...</option>
												<option value="0.01">0,01</option>
												<option value="0.02">0,02</option>
												<option value="0.03">0,03</option>
												<option value="0.04">0,04</option>
												<option value="0.05">0,05</option>
												<option value="0.06">0,06</option>
												<option value="0.07">0,07</option>
												<option value="0.08">0,08</option>
												<option value="0.09">0,09</option>
												<option value="0.1">0,1</option>
												<option value="0.11">0,11</option>
												<option value="0.12">0,12</option>
												<option value="0.13">0,13</option>
												<option value="0.14">0,14</option>
												<option value="0.15">0,15</option>
												<option value="0.16">0,16</option>
												<option value="0.17">0,17</option>
												<option value="0.18">0,18</option>
												<option value="0.19">0,19</option>
												<option value="0.20">0,20</option>
												<option value="0.21">0,21</option>
												<option value="0.22">0,22</option>
												<option value="0.23">0,23</option>
												<option value="0.24">0,24</option>
												<option value="0.25">0,25</option>
												<option value="0.26">0,26</option>
												<option value="0.27">0,27</option>
												<option value="0.28">0,28</option>
												<option value="0.29">0,29</option>
												<option value="0.30">0,30</option>
												<option value="0.31">0,31</option>
												<option value="0.32">0,32</option>
												<option value="0.33">0,33</option>
												<option value="0.34">0,34</option>
												<option value="0.35">0,35</option>
												<option value="0.36">0,36</option>
												<option value="0.37">0,37</option>
												<option value="0.38">0,38</option>
												<option value="0.39">0,39</option>
												<option value="0.40">0,40</option>
												<option value="0.41">0,41</option>
												<option value="0.42">0,42</option>
												<option value="0.43">0,43</option>
												<option value="0.44">0,44</option>
												<option value="0.45">0,45</option>
												<option value="0.46">0,46</option>
												<option value="0.47">0,47</option>
												<option value="0.48">0,48</option>
												<option value="0.49">0,49</option>
												<option value="0.50">0,50</option>
												<option value="0.51">0,51</option>
												<option value="0.52">0,52</option>
												<option value="0.53">0,53</option>
												<option value="0.54">0,54</option>
												<option value="0.55">0,55</option>
												<option value="0.56">0,56</option>
												<option value="0.57">0,57</option>
												<option value="0.58">0,58</option>
												<option value="0.59">0,59</option>
												<option value="0.60">0,60</option>
												<option value="0.61">0,61</option>
												<option value="0.62">0,62</option>
												<option value="0.63">0,63</option>
												<option value="0.64">0,64</option>
												<option value="0.65">0,65</option>
												<option value="0.66">0,66</option>
												<option value="0.67">0,67</option>
												<option value="0.68">0,68</option>
												<option value="0.69">0,69</option>
												<option value="0.60">0,70</option>
												<option value="0.71">0,71</option>
												<option value="0.72">0,72</option>
												<option value="0.73">0,73</option>
												<option value="0.74">0,74</option>
												<option value="0.75">0,75</option>
												<option value="0.76">0,76</option>
												<option value="0.77">0,77</option>
												<option value="0.78">0,78</option>
												<option value="0.79">0,79</option>
												<option value="0.80">0,80</option>
												<option value="0.81">0,81</option>
												<option value="0.82">0,82</option>
												<option value="0.83">0,83</option>
												<option value="0.84">0,84</option>
												<option value="0.85">0,85</option>
												<option value="0.86">0,86</option>
												<option value="0.87">0,87</option>
												<option value="0.88">0,88</option>
												<option value="0.89">0,89</option>
												<option value="0.90">0,90</option>
												<option value="0.91">0,91</option>
												<option value="0.92">0,92</option>
												<option value="0.93">0,93</option>
												<option value="0.94">0,94</option>
												<option value="0.95">0,95</option>
												<option value="0.96">0,96</option>
												<option value="0.97">0,97</option>
												<option value="0.98">0,98</option>
												<option value="0.99">0,99</option>
												<option value="1.00">1,00</option>
											  </select>
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Рр, кВт max:</label>
										</div>
										<div class="col-md-7">
											<input name="ppmax1" id="ppmax1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Iр, А max:</label>
										</div>
										<div class="col-md-7">
											<input name="ipmax1" id="ipmax1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Рр, кВт min:</label>
										</div>
										<div class="col-md-7">
											<input name="ppmin1" id="ppmin1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Iр, А min:</label>
										</div>
										<div class="col-md-7">
											<input name="ipmin1" id="ipmin1" type="text" value="">
										</div>
									</div>
									<br>
									<span>Обеспечение точности по условию:</span>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Ip.max*100%/Iсч.ном*Ктт>40%Iном.сч.:</label>
											<label class="control-label rez_text" id="condition1" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Ip.min*100%/Iсч.ном*Ктт>5%Iном.сч.:</label>
											<label class="control-label rez_text" id="condition2" style="margin-left: 20px;"></label>
										</div>
									</div>
								</div>	
							</div>
							<br />
							<div class="row" style="border: 1px solid black; padding: 5px;">
								<div class="col-md-12">
									<span><b>Проверка нагрузки вторичной цепи ТТ:</b></span>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Трансформатор тока:</label>
										</div>
										<div class="col-md-7">
											<select class="selectpicker" id="transkoeff2" name="transkoeff2" style="width: 250px !important;  height: 40px !important;">
												<option value="novalue" selected="">Выберите...</option>
												<option value="2">10/5</option>
												<option value="4">20/5</option>
												<option value="6">30/5</option>
												<option value="8">40/5</option>
												<option value="10">50/5</option>
												<option value="15">75/5</option>
												<option value="20">100/5</option>
												<option value="25">125/5</option>
												<option value="30">150/5</option>
												<option value="40">200/5</option>
												<option value="50">250/5</option>
												<option value="60">300/5</option>
												<option value="80">400/5</option>
												<option value="100">500/5</option>
												<option value="200">1000/5</option>
										  </select>
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Длина провода до счетчика (2,5мм2), м:</label>
										</div>
										<div class="col-md-7">
											<input name="wirelen1" id="wirelen1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Сопротивление проводов Rпр, Ом:</label>
										</div>
										<div class="col-md-7">
											<input name="rpr1" id="rpr1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Сопротивление контактов Rк, Ом:</label>
										</div>
										<div class="col-md-7">
											<input name="rk1" id="rk1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Максимальный ток в первичной обмотке Imax1, А:</label>
										</div>
										<div class="col-md-7">
											<input name="i_max1" id="i_max1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Максимальный ток во вторичной обмотке Imax2, А:</label>
										</div>
										<div class="col-md-7">
											<input name="i_max2" id="i_max2" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Максимальный ток в первичной обмотке Iн1, А:</label>
										</div>
										<div class="col-md-7">
											<input name="i_n1" id="i_n1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Максимальный ток во вторичной обмотке Iн2, А:</label>
										</div>
										<div class="col-md-7">
											<input name="i_n2" id="i_n2" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Мощность проводов при Imax2 Sпр_max, ВА:</label>
										</div>
										<div class="col-md-7">
											<input name="i_max2_spr_max1" id="i_max2_spr_max1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Мощность контактов при Imax2 Sк_max, Ом:</label>
										</div>
										<div class="col-md-7">
											<input name="i_max2_sk_max1" id="i_max2_sk_max1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Мощность проводов при Iн2 Sпр_н, ВА:</label>
										</div>
										<div class="col-md-7">
											<input name="i_n2_spr_n1" id="i_n2_spr_n1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Мощность контактов при Iн2 Sк_н, Ом:</label>
										</div>
										<div class="col-md-7">
											<input name="i_n2_sk_n1" id="i_n2_sk_n1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Прибор учета:</label>
										</div>
										<div class="col-md-7">
											<input name="metering_device" id="metering_device" type="text" value="Меркурий 234ART" style="width: 250px;">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Мощность цепи счетчика Sсч, ВА:</label>
										</div>
										<div class="col-md-7">
											<input name="s_sch1" id="s_sch1" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Выбор мощности догрузочного сопротивления Sдог, ВА:</label>
										</div>
										<div class="col-md-7">
											<select class="selectpicker" id="s_dog1" name="s_dog1" style="width: 250px !important;  height: 40px !important;">
												<option value="novalue" selected="">Выберите...</option>
												<option value="1.25">1,25</option>
												<option value="2.5">2,5</option>
												<option value="3.75">3,75</option>
												<option value="5">5</option>
												<option value="8">8</option>
												<option value="10">10</option>
												<option value="17">17</option>
												<option value="20">20</option>
										  </select>
										</div>
									</div>									
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Величина догрузочного сопротивления Rдог, Ом:</label>
											<label class="control-label rez_text" id="r_dog1" style="margin-left: 20px;"></label>
										</div>
									</div>	
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Суммарная мощность на вторичной обмотке TT Sсумм_max, ВА:</label>
											<label class="control-label rez_text" id="s_summ_max1" style="margin-left: 20px;"></label>
										</div>
									</div>	
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Суммарная мощность на вторичной обмотке TT Sсумм_н, ВА:</label>
											<label class="control-label rez_text" id="s_summ_n" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Выполнение условия по максимальной нагрузке<br />вторичной обмотки ТТ 3,75ВА&#60;Sсумм&#60;5ВА:</label>
											<label class="control-label rez_text" id="rez78" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Выполнение условия по номинальной нагрузке<br />вторичной обмотки ТТ 3,75ВА&#60;Sсумм&#60;6ВА:</label>
											<label class="control-label rez_text" id="rez79" style="margin-left: 20px;"></label>
										</div>
									</div>
									<br>									
								</div>	
							</div>
							<form class="topdf-form" action="to_pdf.php?form=wire_section_by_diameter" method="post">
								<input type="hidden" name="pageTitle" value="Подбор догрузочного сопротивления">
							</form>
							<script>
								$("#transkoeff1").change(function(){selectionAndVerificationMeterDevices();});
								$("#cosf4").change(function(){selectionAndVerificationMeterDevices();});
								$("#ppmax1").change(function(){selectionAndVerificationMeterDevices();});
								$("#ppmin1").change(function(){selectionAndVerificationMeterDevices();});
								function selectionAndVerificationMeterDevices(){
									transkoeff = parseFloat($('#transkoeff1 option:selected').val());
									cosf = parseFloat($('#cosf4 option:selected').val());
									pp_max = parseFloat($("#ppmax1").val());
									if(!pp_max){return false;}
									if(!transkoeff){return false;}
									ip_max = pp_max / (Math.sqrt(3) * 0.38 * cosf);
									if(isNaN(ip_max)) ip_max = 0;
									$("#ipmax1").val(ip_max.toFixed(2));
									pp_min = parseFloat($("#ppmin1").val());
									if(!pp_min){return false;}
									ip_min = pp_min / (Math.sqrt(3) * 0.38 * cosf);
									if(isNaN(ip_min)) ip_min = 0;
									$("#ipmin1").val(ip_min.toFixed(2));
									condition1 = (ip_max * 100.0) / (5.0 * transkoeff);
									condition2 = (ip_min * 100.0) / (5.0 * transkoeff);
									if( condition1 > 40.0 )
										$("#condition1").html(condition1.toFixed(2)).css("color", "green");
									else
										$("#condition1").html(condition1.toFixed(2)).css("color", "red");
									if( condition2 > 5.0 )
										$("#condition2").html(condition2.toFixed(2)).css("color", "green");
									else
										$("#condition2").html(condition2.toFixed(2)).css("color", "red");									
								}
								$("#transkoeff2").change(function(){checkLoadSecondaryCircuitTT();});
								$("#wirelen1").change(function(){checkLoadSecondaryCircuitTT();});
								$("#rk1").change(function(){checkLoadSecondaryCircuitTT();});
								$("#i_max1").change(function(){checkLoadSecondaryCircuitTT();});
								$("#i_n1").change(function(){checkLoadSecondaryCircuitTT();});
								$("#s_sch1").change(function(){checkLoadSecondaryCircuitTT();});
								$("#s_dog1").change(function(){checkLoadSecondaryCircuitTT();});
								
								function checkLoadSecondaryCircuitTT(){
									transkoeff = parseFloat($('#transkoeff2 option:selected').val());
									if(!transkoeff){return false;}
									wirelen = parseFloat($('#wirelen1').val());
									if(!wirelen){return false;}
									rpr = wirelen / 57.0 / 2.5;
									$("#rpr1").val(rpr.toFixed(3));
									rk = parseFloat($("#rk1").val());
									i_max1 = parseFloat($("#i_max1").val());									
									if(!rk){return false;}
									if(!i_max1){return false;}									
									i_max2 = i_max1 / transkoeff;
									$("#i_max2").val(i_max2.toFixed(3));
									i_n1 = parseFloat($("#i_n1").val());
									if(!i_n1){return false;}
									i_n2 = i_n1 / transkoeff;
									i_max2_spr_max = i_max2 * i_max2 * rpr;
									i_max2_sk_max = i_max2 * i_max2 * rk;
									i_n2_spr_n = i_n2 * i_n2 * rpr;
									i_n2_sk_n = i_n2 * i_n2 * rk;
									$("#i_n2").val(i_n2.toFixed(3));
									$("#i_max2_spr_max1").val(i_max2_spr_max.toFixed(3));
									$("#i_max2_sk_max1").val(i_max2_sk_max.toFixed(3));
									$("#i_n2_spr_n1").val(i_n2_spr_n.toFixed(3));
									$("#i_n2_sk_n1").val(i_n2_sk_n.toFixed(3));
									s_sch = parseFloat($("#s_sch1").val());
									if(!s_sch){return false;}
									s_dog = parseFloat($("#s_dog1 option:selected").val());
									if(!s_dog){return false;}
									r_dog = null;
									switch(s_dog + 0.0){
										case 1.25: r_dog = 0.05; break;
										case 2.5: r_dog = 0.1; break;
										case 3.75: r_dog = 0.15; break;
										case 5.0: r_dog = 0.2; break;
										case 8.0: r_dog = 0.35; break;
										case 10.0: r_dog = 0.4; break;
										case 17.0: r_dog = 0.68; break;
										case 20.0: r_dog = 0.8; break;
										default: break;
									}/**/
									$("#r_dog1").html(r_dog);
									s_summ_max = i_max2_spr_max + i_max2_sk_max + s_sch + s_dog;
									$("#s_summ_max1").html(s_summ_max.toFixed(3));
									s_summ_n = i_n2_spr_n + i_n2_sk_n + s_sch + s_dog;
									$("#s_summ_n").html(s_summ_n.toFixed(3));
									if(s_summ_max < 3.75)
										$("#rez78").html('Недогрузка');
									else if (s_summ_max >= 3.75 && s_summ_max <= 5.0)
										$("#rez78").html('Выполнено');
									else 
										$("#rez78").html('Перегрузка');
									
									if(s_summ_n < 3.75)
										$("#rez79").html('Недогрузка');
									else if (s_summ_n >= 3.75 && s_summ_n <= 6.0)
										$("#rez79").html('Выполнено');
									else 
										$("#rez79").html('Перегрузка');
								}
							</script>
						</div>
						<div class="tab-pane" id="panel-359138">						
							<br>
							<div class="row" style="border: 1px solid black; padding: 5px;">
								<div class="col-md-12">
									<span><b>Выбор и проверка приборов учета (произвольная):</b></span>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Коэффициент трансформации трансформатора тока:</label>
										</div>
										<div class="col-md-7">
											<select class="selectpicker" id="transkoeff3" name="transkoeff3" style="width: 250px !important;  height: 40px !important;">
												<option value="novalue" selected="">Выберите...</option>
												<option value="2">10/5</option>
												<option value="4">20/5</option>
												<option value="6">30/5</option>
												<option value="8">40/5</option>
												<option value="10">50/5</option>
												<option value="15">75/5</option>
												<option value="20">100/5</option>
												<option value="25">125/5</option>
												<option value="30">150/5</option>
												<option value="40">200/5</option>
												<option value="50">250/5</option>
												<option value="60">300/5</option>
												<option value="80">400/5</option>
												<option value="100">500/5</option>
												<option value="200">1000/5</option>
											  </select>
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Cos(ϕ):</label>
										</div>
										<div class="col-md-7">
											<select class="selectpicker" id="cosf5" name="cosf5" style="width: 250px !important;  height: 40px !important;">
												<option value="novalue" selected="">Выберите...</option>
												<option value="0.01">0,01</option>
												<option value="0.02">0,02</option>
												<option value="0.03">0,03</option>
												<option value="0.04">0,04</option>
												<option value="0.05">0,05</option>
												<option value="0.06">0,06</option>
												<option value="0.07">0,07</option>
												<option value="0.08">0,08</option>
												<option value="0.09">0,09</option>
												<option value="0.1">0,1</option>
												<option value="0.11">0,11</option>
												<option value="0.12">0,12</option>
												<option value="0.13">0,13</option>
												<option value="0.14">0,14</option>
												<option value="0.15">0,15</option>
												<option value="0.16">0,16</option>
												<option value="0.17">0,17</option>
												<option value="0.18">0,18</option>
												<option value="0.19">0,19</option>
												<option value="0.20">0,20</option>
												<option value="0.21">0,21</option>
												<option value="0.22">0,22</option>
												<option value="0.23">0,23</option>
												<option value="0.24">0,24</option>
												<option value="0.25">0,25</option>
												<option value="0.26">0,26</option>
												<option value="0.27">0,27</option>
												<option value="0.28">0,28</option>
												<option value="0.29">0,29</option>
												<option value="0.30">0,30</option>
												<option value="0.31">0,31</option>
												<option value="0.32">0,32</option>
												<option value="0.33">0,33</option>
												<option value="0.34">0,34</option>
												<option value="0.35">0,35</option>
												<option value="0.36">0,36</option>
												<option value="0.37">0,37</option>
												<option value="0.38">0,38</option>
												<option value="0.39">0,39</option>
												<option value="0.40">0,40</option>
												<option value="0.41">0,41</option>
												<option value="0.42">0,42</option>
												<option value="0.43">0,43</option>
												<option value="0.44">0,44</option>
												<option value="0.45">0,45</option>
												<option value="0.46">0,46</option>
												<option value="0.47">0,47</option>
												<option value="0.48">0,48</option>
												<option value="0.49">0,49</option>
												<option value="0.50">0,50</option>
												<option value="0.51">0,51</option>
												<option value="0.52">0,52</option>
												<option value="0.53">0,53</option>
												<option value="0.54">0,54</option>
												<option value="0.55">0,55</option>
												<option value="0.56">0,56</option>
												<option value="0.57">0,57</option>
												<option value="0.58">0,58</option>
												<option value="0.59">0,59</option>
												<option value="0.60">0,60</option>
												<option value="0.61">0,61</option>
												<option value="0.62">0,62</option>
												<option value="0.63">0,63</option>
												<option value="0.64">0,64</option>
												<option value="0.65">0,65</option>
												<option value="0.66">0,66</option>
												<option value="0.67">0,67</option>
												<option value="0.68">0,68</option>
												<option value="0.69">0,69</option>
												<option value="0.60">0,70</option>
												<option value="0.71">0,71</option>
												<option value="0.72">0,72</option>
												<option value="0.73">0,73</option>
												<option value="0.74">0,74</option>
												<option value="0.75">0,75</option>
												<option value="0.76">0,76</option>
												<option value="0.77">0,77</option>
												<option value="0.78">0,78</option>
												<option value="0.79">0,79</option>
												<option value="0.80">0,80</option>
												<option value="0.81">0,81</option>
												<option value="0.82">0,82</option>
												<option value="0.83">0,83</option>
												<option value="0.84">0,84</option>
												<option value="0.85">0,85</option>
												<option value="0.86">0,86</option>
												<option value="0.87">0,87</option>
												<option value="0.88">0,88</option>
												<option value="0.89">0,89</option>
												<option value="0.90">0,90</option>
												<option value="0.91">0,91</option>
												<option value="0.92">0,92</option>
												<option value="0.93">0,93</option>
												<option value="0.94">0,94</option>
												<option value="0.95">0,95</option>
												<option value="0.96">0,96</option>
												<option value="0.97">0,97</option>
												<option value="0.98">0,98</option>
												<option value="0.99">0,99</option>
												<option value="1.00">1,00</option>
											  </select>
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Рр, кВт max:</label>
										</div>
										<div class="col-md-7">
											<input name="ppmax2" id="ppmax2" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Iр, А max:</label>
										</div>
										<div class="col-md-7">
											<input name="ipmax2" id="ipmax2" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Рр, кВт min:</label>
										</div>
										<div class="col-md-7">
											<input name="ppmin2" id="ppmin2" type="text" value="">
										</div>
									</div>
									<div class="row" style="border-bottom: 1px solid #cecece; padding-top: 15px; padding-bottom: 15px;">
										<div class="col-md-5">
											<label class="control-label red_text">Iр, А min:</label>
										</div>
										<div class="col-md-7">
											<input name="ipmin2" id="ipmin2" type="text" value="">
										</div>
									</div>
									<br>
									<span>Обеспечение точности по условию:</span>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Ip.max*100%/Iсч.ном*Ктт>40%Iном.сч.:</label>
											<label class="control-label rez_text" id="condition3" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Ip.min*100%/Iсч.ном*Ктт>5%Iном.сч.:</label>
											<label class="control-label rez_text" id="condition4" style="margin-left: 20px;"></label>
										</div>
									</div>
								</div>	
							</div>
							<br />
							<form class="topdf-form" action="to_pdf.php?form=wire_section_by_diameter" method="post">
								<input type="hidden" name="pageTitle" value="Подбор догрузочного сопротивления">
							</form>
							<script>
								$("#transkoeff3").change(function(){selectionAndVerificationMeterDevices1();});
								$("#cosf5").change(function(){selectionAndVerificationMeterDevices1();});
								$("#ppmax2").change(function(){selectionAndVerificationMeterDevices1();});
								$("#ppmin2").change(function(){selectionAndVerificationMeterDevices1();});
								function selectionAndVerificationMeterDevices1(){
									//alert();
									transkoeff = parseFloat($('#transkoeff3 option:selected').val());
									cosf = parseFloat($('#cosf5 option:selected').val());
									pp_max = parseFloat($("#ppmax2").val());
									if(!pp_max){return false;}
									if(!transkoeff){return false;}
									ip_max = pp_max / (Math.sqrt(3) * 0.38 * cosf);
									if(isNaN(ip_max)) ip_max = 0;
									$("#ipmax2").val(ip_max.toFixed(2));
									pp_min = parseFloat($("#ppmin2").val());
									if(!pp_min){return false;}
									ip_min = pp_min / (Math.sqrt(3) * 0.38 * cosf);
									if(isNaN(ip_min)) ip_min = 0;
									$("#ipmin2").val(ip_min.toFixed(2));
									condition1 = (ip_max * 100.0) / (5.0 * transkoeff);
									condition2 = (ip_min * 100.0) / (5.0 * transkoeff);
									if( condition1 > 40.0 )
										$("#condition3").html(condition1.toFixed(2)).css("color", "green");
									else
										$("#condition3").html(condition1.toFixed(2)).css("color", "red");
									if( condition2 > 5.0 )
										$("#condition4").html(condition2.toFixed(2)).css("color", "green");
									else
										$("#condition4").html(condition2.toFixed(2)).css("color", "red");									
								}
								
							</script>
						</div>
						<div class="tab-pane" id="panel-359139">						
							<br>
							<div class="row" style="border: 1px solid black; padding: 5px;">
								<div class="col-xs-12">
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-xs-12">
											<label class="control-label red_text"><h4 style="font-weight: bold;">Параметры лотка:</h4></label>
										</div>							
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-xs-4">
											<label class='control-label red_text'>Высота лотка, мм:</label><br />
											<select class="selectpicker" id="trayHeight1"style="width: 210px !important;  height: 40px !important;">
												<option value="novalue" selected="">Выберите...</option>
												<option value="50">50</option>
												<option value="80">80</option>
											</select>
										</div>
										<div class="col-xs-4">
											<label class='control-label red_text'>Ширина лотка, мм:</label><br />
											<select class="selectpicker" id="trayWidth1"style="width: 210px !important;  height: 40px !important;">
												<option value="novalue" selected="">Выберите...</option>
												<option value="50">50</option>
												<option value="100">100</option>
												<option value="150">150</option>
												<option value="200">200</option>
												<option value="300">300</option>
												<option value="400">400</option>
												<option value="500">500</option>
												<option value="600">600</option>
											</select>
										</div>
										<div class="col-xs-4">
											<label class='control-label red_text'>Сечение лотка, мм<sup>2</sup>:</label><br />
											<input value="" type="text" id="traySection1" style='height: 40px !important; width: 160px !important;' disabled=""></input>
										</div>
									</div>
									<br />
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-xs-12">
											<label class="control-label red_text"><h4 style="font-weight: bold;">Характеристики кабеля:</h4></label>
										</div>							
									</div>

									<div id="cableArrData1" class="load-type-block-margin"></div>
									<br />
									<div class="row" style="margin-top: 10px; margin-bottom: 10px;" id="loadTypeArrAddButton">
										<div class="col-xs-4">
											<input style="height: 50px !important; width: 215px !important;" class="btn btn_reset" type="button" id="cableAddElement" value="Добавить кабель" onclick="addCable()">
										</div>
										<div class="col-xs-4">
											<button class="btn btn_calc" id="btncalc11" style="display: inline-block;height: 50px !important; width: 215px !important;" onclick="sendCntAjax('masterscale','calc','calc',null);return false;">Рассчитать</button>
										</div>
										<div class="col-xs-4">
											<button class="btn btn_reset" id="btnclear11" style="display: inline-block;height: 50px !important; width: 215px !important;">Сброс</button>
										</div>
										
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Объем горючей массы, л:</label>
											<label class="control-label rez_text" id="rez80" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Масса кабелей, кг:</label>
											<label class="control-label rez_text" id="rez81" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Суммарное сечение кабелей, мм<sup>2</sup>:</label>
											<label class="control-label rez_text" id="rez82" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Процент заполнения, %:</label>
											<label class="control-label rez_text" id="rez83" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Заполнение 40% и менее:</label>
											<label class="control-label rez_text" id="rez84" style="margin-left: 20px;"></label>
										</div>
									</div>
									<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
										<div class="col-md-12">														
											<label class="control-label red_text" style="margin-top:8px;">Необходимость пожаротушения<br />1,5-7л -  датчик<br />>7л - пожаротушение:</label>
											<label class="control-label rez_text" id="rez85" style="margin-left: 20px;"></label>
										</div>
									</div>
								</div>
							</div>
							<br />
							<form class="topdf-form" action="to_pdf.php?form=wire_section_by_diameter" method="post">
								<input type="hidden" name="pageTitle" value="Подбор сечения лотка и необходимости пожаротушения">
							</form>
							<script>
							
								cableBlockId = 0;
								
								function addCable(obj){
                                    id = "cableBlock_" + cableBlockId;                                   
                                    $('#crossSectionOfTrayAndFireTmpl').tmpl(id).appendTo('#cableArrData1');
									cableBlockId++;
									crossSectionOfTrayAndFireCalc();
                                }
								
								function updateHtmlContent1(obj){
									parent = obj.parentNode.parentNode.parentNode.parentNode;
									switch($(obj).attr('id')){
										case 'cableType1':
											$.get( 	"/programs/master-scale/ajax/", 
													{cableType1: $(parent).find('#cableType1').val()},
													function(data){
														cableCrossSectionData = JSON.parse(data);
														$(parent).find("#outdiam1").val(cableCrossSectionData[0].OUTER_DIAMETER);
														$(parent).find("#cablemass1").val(cableCrossSectionData[0].CABLE_MASS);
														$(parent).find("#volumecombustiblemass1").val(cableCrossSectionData[0].VOLUME_COMBUSTIBLE_MASS);
														cableCrossSectionSP = $(parent).find("#cableCrossSection1");
														cableCrossSectionSP.empty();
														cableCrossSectionData.forEach(function(entry){
																							s = "<option value='"+entry.ID+"'>"+entry.NAME+"</option>"
																							cableCrossSectionSP.append(s);
																						} );
														calcCableProperties(parent);
														crossSectionOfTrayAndFireCalc();
													}
												);
											
										break;
										case 'cableCrossSection1':
											cableCrossSection1 = $('#cableCrossSection1').val();
											$.get( 	"/programs/master-scale/ajax/", 
													{	cableCrossSection1: $(parent).find('#cableCrossSection1').val()
														},
													function(data){
														cableCrossSectionData = JSON.parse(data);
														console.log(cableCrossSectionData);
														$(parent).find("#outdiam1").val(cableCrossSectionData[0].OUTER_DIAMETER);
														$(parent).find("#cablemass1").val(cableCrossSectionData[0].CABLE_MASS);
														$(parent).find("#volumecombustiblemass1").val(cableCrossSectionData[0].VOLUME_COMBUSTIBLE_MASS);
														calcCableProperties(parent);
														crossSectionOfTrayAndFireCalc();
													}
												);
											
										break;
										case 'lineCount1':
											cableCrossSection1 = $(parent).find('#cableCrossSection1').val();
											calcCableProperties(parent);
											crossSectionOfTrayAndFireCalc();											
										break;
										default: break;
									}
									return false;
								}
								
								function calcCableProperties(obj){									
									lineCount = parseFloat($(obj).find("#lineCount1").val().replace(',','.'));
									outdiam = parseFloat($(obj).find("#outdiam1").val().replace(',','.'));
									cablemass = parseFloat($(obj).find("#cablemass1").val().replace(',','.'));
									volumecombustiblemass = parseFloat($(obj).find("#volumecombustiblemass1").val().replace(',','.'));
									if(	isNaN(lineCount) 	|| 
										isNaN(outdiam) 		|| 
										isNaN(cablemass) 	|| 
										isNaN(volumecombustiblemass))
										return false;	
									cablesCrossSection = (outdiam / 2.0) * (outdiam / 2.0) * Math.PI * lineCount;
									cablesmass = cablemass * 1.0 * lineCount;
									volumecombustiblemass2 = volumecombustiblemass * 1.0 * lineCount;
									$(obj).find("#cablescrosssection1").val(cablesCrossSection.toFixed(3).replace('.',','));
									$(obj).find("#cablesmass1").val(cablesmass.toFixed(3).replace('.',','));
									$(obj).find("#volumecombustiblemass2").val(volumecombustiblemass2.toFixed(3).replace('.',','));									
								}
								
								$("#btncalc11").click(function(){crossSectionOfTrayAndFireCalc();});
								
								function crossSectionOfTrayAndFireCalc(){
									volumecombustiblemassTotal = 0;
									cablemassTotal = 0;
									outdiamTotal = 0;
									fillPercentage = 0;
									traySection = parseFloat($("#traySection1").val());									
									if(isNaN(traySection)) return false;
									$("#cableArrData1").children().each(function(){											
											outdiam = parseFloat($(this).find("#cablescrosssection1").val().replace(',','.'));
											cablemass = parseFloat($(this).find("#cablesmass1").val().replace(',','.'));
											volumecombustiblemass = parseFloat($(this).find("#volumecombustiblemass2").val().replace(',','.'));
											if(	isNaN(outdiam) 		|| 
												isNaN(cablemass) 	|| 
												isNaN(volumecombustiblemass))
												return false;											
											volumecombustiblemassTotal += volumecombustiblemass;
											cablemassTotal += cablemass;
											outdiamTotal += outdiam;
										});									
									fillPercentage = (outdiamTotal + 0.0) / (traySection + 0.0) * 100.0;
									$("#rez80").html(volumecombustiblemassTotal.toFixed(3));
									$("#rez81").html(cablemassTotal.toFixed(2));
									$("#rez82").html(outdiamTotal.toFixed(2));
									$("#rez83").html(fillPercentage.toFixed(2));
									if( fillPercentage <= 40.0 )
										$("#rez84").html("cоответствует").css("color", "green");
									else
										$("#rez84").html("не cоответствует").css("color", "red");
									
									if( volumecombustiblemassTotal < 1.5 )
										$("#rez85").html("безопасно").css("color", "green");
									else if( volumecombustiblemassTotal >= 1.5 && volumecombustiblemassTotal < 7 )
										$("#rez85").html("нужен датчик").css("color","orange");
									else
										$("#rez85").html("необходимо пожаротушение").css("color","red");
									
								}
								
								$("#trayHeight1").change(function(){calcTraySection();crossSectionOfTrayAndFireCalc();});
								$("#trayWidth1").change(function(){calcTraySection();crossSectionOfTrayAndFireCalc();});
								
								function calcTraySection(){
									height = parseFloat($("#trayHeight1").val());
									width = parseFloat($("#trayWidth1").val());
									if(isNaN(height) || isNaN(width)) return false;
									$("#traySection1").val((height * width).toFixed(3));
								}
								
								$("#btnclear11").click(function(){
									$("#trayHeight1").val('novalue');
									$("#trayWidth1").val('novalue');
									$("#traySection1").val('');
									$("#cableArrData1").empty();
									$("#rez80").html("");
									$("#rez81").html("");
									$("#rez82").html("");
									$("#rez83").html("");
									$("#rez84").html("");
									$("#rez85").html("");
								});
							</script>
						</div>
						<div class="tab-pane <? if ($_GET['a']) { ?>active<? } ?>" id="panel-359141">
							<div style="clear:both;"></div>
							<?=$APPLICATION->IncludeComponent('dvasilyev:uerm.conf');/**/?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/div>
</div-->


<?
require($_SERVER["DOCUMENT_ROOT"]."/programs/counters/index.php");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>