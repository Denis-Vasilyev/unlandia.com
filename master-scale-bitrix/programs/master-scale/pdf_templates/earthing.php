<!-- Определение сечения провода по заданой потере напряжения, мощности нагрузки и длины линии -->
<div><img alt="zaz.png" src="<?=$_SERVER['DOCUMENT_ROOT']?>/programs/master-scale/img/zaz.png" style="border: 1px solid #cecece; width: 20cm; height: 6cm;"></div>
<table class="calc-result-tbl" cellpadding="5">	

	<tbody>	
		<!--tr>
			<td colspan=2><img alt="zaz.png" src="img/zaz.png" style="border: 1px solid #cecece; width: 20cm; height: 5cm;"></td>
		</tr-->
		<tr>
			<td>Верхний слой грунта</td>
			<td><?=$selpuplay_html?></td>			
		</tr>
		<tr>
			<td>Нижний слой грунта</td>
			<td><?=$selpdownlay_html?></td>
		</tr>
		<tr>
			<td>Количество вертикальных заземлителей, шт</td>
			<td><?=$earthing?></td>
		</tr>
		<tr>
			<td>Климатический коэффициент</td>
			<td><?=$climzone_mod?></td>
		</tr>		
		<tr>
			<td>Глубина верхнего слоя грунта (H), м</td>
			<td><?=$toplayerdeep?></td>
		</tr>
		<tr>
			<td>Длина вертикального заземлителя (L1), м</td>
			<td><?=$vertearthinglen?></td>
		</tr>
		<tr>
			<td>Диаметр вертикального заземлителя (D), м</td>
			<td><?=$vertearthingdiam?></td>
		</tr>
		<tr>
			<td>Глубина горизонтального заземлителя (h2), м</td>
			<td><?=$horearthinghalfheight?></td>
		</tr>
		<tr>
			<td>Ширина полки горизонтального заземлителя (b), м</td>
			<td><?=$horearthingshelfwidth?></td>
		</tr>
		<tr>
			<td>Длина соединительной полосы до ввода в здание (L3), м</td>
			<td><?=$connectstriplen?></td>
		</tr>		
	</tbody>
	<tfoot>
		<tr>
			<td>Удельное электрическое сопротивление грунта, Ом*м<sup>2</sup></td>
			<td><?=$rez5?></td>
		</tr>
		<tr>
			<td>Сопротивление одиночного вертикального  заземлителя, Ом</td>
			<td><?=$rez6?></td>
		</tr>
		<tr>
			<td>Сопротивление горизонтального заземлителя, Ом</td>
			<td><?=$rez7?></td>
		</tr>
		<tr>
			<td>Длина горизонтального заземлителя, м</td>
			<td><?=$rez8?></td>
		</tr>
		<tr>
			<td>Общее сопротивление растекания электрического тока, Ом</td>
			<td><?=$rez9?></td>
		</tr>
		<tr>
			<td colspan=2></td>
		</tr>
	</tfoot>
</table>