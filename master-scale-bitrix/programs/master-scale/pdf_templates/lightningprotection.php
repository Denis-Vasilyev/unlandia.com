<!-- Расчет молниезащиты -->
<table class="calc-result-tbl" cellpadding="5">	
	<tbody>	
		<tr>
			<td>Тип здания</td>
			<td><?=$buildtype2Label?></td>
		</tr>
		<tr>
			<td colspan='2'>Габариты здания</td>
		</tr>
		<?if($buildtype2Val == '1'){?>
		<tr>
			<td>Диаметр A, м</td>
			<td><?=$lengthordiam1?></td>
		</tr>
		<tr>
			<td>Высота h<sub>x</sub>, м</td>
			<td><?=$buildheightval1?></td>
		</tr>
		<?}else if($buildtype2Val == '2'){?>
		<tr>
			<td>Длина A, м</td>
			<td><?=$lengthordiam1?></td>
		</tr>
		<tr>
			<td>Ширина B, м</td>
			<td><?=$buildwidthval1?></td>
		</tr>
		<tr>
			<td>Высота h<sub>x</sub>, м</td>
			<td><?=$buildheightval1?></td>
		</tr>
		<?}?>
		<tr>
			<td>Удельная плотность ударов молнии в землю n, 1/(км<sup>2</sup>×год)</td>
			<td><?=$densitybumps1?></td>
		</tr>		
		<tr>
			<td>Ожидаемое количество поражений молнией в год N, шт</td>
			<td><?=$rez55?></td>
		</tr>
		<tr>
			<td colspan='2'>Тип молниезащиты:</td>
		</tr>
		<?switch($lightningprotection1Val){
			case '1': $imgsrc = $_SERVER['DOCUMENT_ROOT'] . "/programs/master-scale/img/light1.jpg"; break;
			case '2': $imgsrc = $_SERVER['DOCUMENT_ROOT'] . "/programs/master-scale/img/light2.jpg"; break;
			case '3': $imgsrc = $_SERVER['DOCUMENT_ROOT'] . "/programs/master-scale/img/light3.jpg"; break;
			case '4': $imgsrc = $_SERVER['DOCUMENT_ROOT'] . "/programs/master-scale/img/light4.jpg"; break;
			case '5': $imgsrc = $_SERVER['DOCUMENT_ROOT'] . "/programs/master-scale/img/light5.jpg"; break;
			case '6': $imgsrc = $_SERVER['DOCUMENT_ROOT'] . "/programs/master-scale/img/light6.jpg"; break;
			case '7': $imgsrc = $_SERVER['DOCUMENT_ROOT'] . "/programs/master-scale/img/light7.jpg"; break;
		}
		?>
		<tr>
			<td><?=$lightningprotection1Label?></td>
			<td>
				<img src="<?=$imgsrc?>" alt="" height="5cm">
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan='2'>Характеристики молниеотвода:</td>
		</tr>
		<?if($lightningprotection1Val == '1'){?>
		<tr>
			<td>Высота молниеотвода h, м</td>
			<td><?=$lightningheight_0val?></td>
		</tr>
		<?}else if($lightningprotection1Val == '2'){?>
		<tr>
			<td>Высота молниеотвода h, м</td>
			<td><?=$lightningheight_0val?></td>
		</tr>
		<tr>
			<td>Расстояние между молниеотводами L, м</td>
			<td><?=$lightningdistance_1val?></td>
		</tr>
		<?}else if($lightningprotection1Val == '3'){?>
		<tr>
			<td>Высота молниеотвода h<sub>1</sub>, м</td>
			<td><?=$lightningheight_1val?></td>
		</tr>
		<tr>
			<td>Высота молниеотвода h<sub>2</sub>, м</td>
			<td><?=$lightningheight_2val?></td>
		</tr>
		<tr>
			<td>Расстояние между молниеотводами L, м</td>
			<td><?=$lightningdistance_1val?></td>
		</tr>
		<?}else if($lightningprotection1Val == '4'){?>
		<tr>
			<td>Количество молниеотводов k<sub>m</sub>, шт</td>
			<td><?=$lightningqtyval1?></td>
		</tr>
		<?for($i=1; $i<=$lightningqtyval1;$i++){if($i!=$lightningqtyval1){?>
		<tr>
			<td>Высота молниеотвода <?=$i?> h<sub><?=$i?></sub>, м</td>
			<td><?=${'lightningheight'.$i}?></td>
		</tr>
		<tr>
			<td>Расстояние между молниеотводами <?=$i?> и <?=$i+1?> L<sub><?=$i . ($i + 1)?></sub>, м</td>
			<td><?=${'lightningdist'.$i.($i+1)}?></td>
		</tr>
		<?}else{?>
		<tr>
			<td>Высота молниеотвода <?=$i?> h<sub><?=$i?></sub>, м</td>
			<td><?=${'lightningheight'.$i}?></td>
		</tr>
		<tr>
			<td>Расстояние между молниеотводами <?=$i?> и 1 L<sub><?=($i . '1')?></sub>, м</td>
			<td><?=${'lightningdist'.$i.'1'}?></td>
		</tr>
		<?}}}else if($lightningprotection1Val == '5'){?>
		<tr>
			<td>Высота молниеотвода h<sub>ОП</sub>, м</td>
			<td><?=$lightningheight_opval?></td>
		</tr>
		<tr>
			<td>Длина пролета a, м</td>
			<td><?=$lengthspan1val?></td>
		</tr>
		<?}else if($lightningprotection1Val == '6'){?>
		<tr>
			<td>Высота молниеотвода h<sub>ОП</sub>, м</td>
			<td><?=$lightningheight_opval?></td>
		</tr>
		<tr>
			<td>Длина пролета a, м</td>
			<td><?=$lengthspan1val?></td>
		</tr>
		<?}else if($lightningprotection1Val == '7'){?>
		<tr>
			<td>Высота молниеотвода h<sub>ОП1</sub>, м</td>
			<td><?=$lightningheight_op1val?></td>
		</tr>
		<tr>
			<td>Высота молниеотвода h<sub>ОП2</sub>, м</td>
			<td><?=$lightningheight_op2val?></td>
		</tr>
		<tr>
			<td>Длина пролета a, м</td>
			<td><?=$lengthspan1val?></td>
		</tr>
		<?}?>
		<tr>
			<td>Здания и сооружения</td>
			<td><?=$buildingsandstructures1Label?></td>
		</tr>
		<tr>
			<td>Местоположение</td>
			<td><?=$location1Label?></td>
		</tr>
		<tr>
			<td>Тип зоны защиты</td>
			<td><?=$protektzonetype1Label?></td>
		</tr>
		<tr>
			<td>Категория молниезащиты</td>
			<td><?=$lightprotcat1Label?></td>
		</tr>
	</tbody>
	<tfoot>
		<?if($lightningprotection1Val == '4'){
			for($i=1;$i<=$lightningqtyval1;$i++){
				if($i==$lightningqtyval1){$index = $i.'1';}else{$index = $i.($i+1);}?>
		<tr>
			<td colspan='2'>Характеристики молниеотвода <?=$index?> :</td>
		</tr>
		<?for($j=56;$j<=78;$j++){if(isset(${'reztitle'.$i.'_'.$j}) && isset(${'rez'.$i.'_'.$j})){?>
		<tr>
			<td><?=${'reztitle'.$i.'_'.$j}?></td>
			<td><?=${'rez'.$i.'_'.$j}?></td>
		</tr>	
		<?}?>
		<?}}}else{for($i=56;$i<=78;$i++){if(isset(${'reztitle'.$i}) && isset(${'rez'.$i})){?>
		<tr>
			<td><?=${'reztitle'.$i}?></td>
			<td><?=${'rez'.$i}?></td>
		</tr>			
		<?}}}?>
	</tfoot>
</table>