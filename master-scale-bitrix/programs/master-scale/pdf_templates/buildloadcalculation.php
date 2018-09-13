<!-- Расчёт токов короткого замыкания -->
<table class="calc-result-tbl" cellpadding="5">
	<tbody>		
		<tr>
			<td colspan="4">Рассчет для</td>
			<td colspan="4"><?=$calctypelabel?></td>			
		</tr>
		<?if($calctypeval == 'build'){?>
		<tr>
			<td colspan="4">Тип здания</td>
			<td colspan="4"><?=$buildtypelabel?></td>		
		</tr>
		<?}?>
		<?if($buildtypeval == '2'){?>
		<tr>
			<td colspan="4">Тип здания для коэффициента К</td>
			<td colspan="4"><?=$buildtypekk1?></td>		
		</tr>
		<?}?>
		<tr>
			<td colspan="8">
				<span>Данные по потребителям нагрузки</span><br><br>
				<table width="19cm" style="collapse:collapse;" border="1px solid black">
					<tr>
						<td>№</td>
						<td>Наименование</td>
						<td>Количество</td>
						<td>Средняя мощность Py1, кВт</td>
						<td>Коэф. спроса Кс</td>
						<td>cos(ϕ)</td>
						<td>Pp, кВт</td>
						<td>Qp, кВт</td>
					</tr>
					<? for($i=0; $i < $consumersCount; $i++){ ?>
					<tr>
						<td><?=$i+1?></td>
						<td><?=${'consumersType'.$i}?></td>
						<td><?=${'consumersCount'.$i}?></td>
						<td><?=${'py1'.$i}?></td>
						<td><?=${'kc'.$i}?></td>
						<td><?=${'cosf4'.$i}?></td>
						<td><?=${'pp'.$i}?></td>
						<td><?=${'qp'.$i}?></td>
					</tr>
					<? } ?>
				</table>
			</td>
		</tr>					
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">Py, кВт</td>
			<td colspan="4"><?=$rez15_1?></td>
		</tr>		
		<?if($buildtypeval == '2'){?>
		<tr>
			<td colspan="4">k</td>
			<td colspan="4"><?=$rez15_2?></td>		
		</tr>
		<tr>
			<td colspan="4">k1</td>
			<td colspan="4"><?=$rez15_3?></td>		
		</tr>
		<?}?>
		<?if($calctypeval == 'switchboard'){?>
		<tr>
			<td colspan="4">Pp, кВт</td>
			<td colspan="4"><?=$rez15?></td>		
		</tr>
		<tr>
			<td colspan="4">Qp, кВт</td>
			<td colspan="4"><?=$rez16?></td>		
		</tr>
		<tr>
			<td colspan="4">Kc</td>
			<td colspan="4"><?=$rez35?></td>		
		</tr>
		<tr>
			<td colspan="4">Tg(ϕ)</td>
			<td colspan="4"><?=$rez17?></td>		
		</tr>
		<tr>
			<td colspan="4">Cos(ϕ)</td>
			<td colspan="4"><?=$rez18?></td>		
		</tr>
		<tr>
			<td colspan="4">Sp, кВА</td>
			<td colspan="4"><?=$rez19?></td>		
		</tr>
		<tr>
			<td colspan="4">Ip, А</td>
			<td colspan="4"><?=$rez20?></td>		
		</tr>
		<?}?>
		<?if($calctypeval == 'build'){?>
		<tr>
			<td colspan="4">Рабочий режим</td>
			<td colspan="4">Режим при пожаре</td>		
		</tr>
		<tr>
			<td colspan="2">Pp, кВт</td>
			<td colspan="2"><?=$rez21?></td>	
			<td colspan="2">Pp, кВт</td>
			<td colspan="2"><?=$rez27?></td>
		</tr>
		<tr>
			<td colspan="2">Qp, кВт</td>
			<td colspan="2"><?=$rez22?></td>	
			<td colspan="2">Qp, кВт</td>
			<td colspan="2"><?=$rez28?></td>
		</tr>
		<tr>
			<td colspan="2">Kc</td>
			<td colspan="2"><?=$rez33?></td>	
			<td colspan="2">Kc</td>
			<td colspan="2"><?=$rez34?></td>
		</tr>
		<tr>
			<td colspan="2">Tg(ϕ)</td>
			<td colspan="2"><?=$rez23?></td>	
			<td colspan="2">Tg(ϕ)</td>
			<td colspan="2"><?=$rez29?></td>
		</tr>
		<tr>
			<td colspan="2">Cos(ϕ)</td>
			<td colspan="2"><?=$rez24?></td>	
			<td colspan="2">Cos(ϕ)</td>
			<td colspan="2"><?=$rez30?></td>
		</tr>
		<tr>
			<td colspan="2">Sp, кВА</td>
			<td colspan="2"><?=$rez25?></td>	
			<td colspan="2">Sp, кВА</td>
			<td colspan="2"><?=$rez31?></td>
		</tr>
		<tr>
			<td colspan="2">Sp, кВА</td>
			<td colspan="2"><?=$rez26?></td>	
			<td colspan="2">Sp, кВА</td>
			<td colspan="2"><?=$rez32?></td>
		</tr>
		<?}?>
	</tfoot>
</table>