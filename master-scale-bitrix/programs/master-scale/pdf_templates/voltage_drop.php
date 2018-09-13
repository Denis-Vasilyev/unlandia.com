<!-- Определение сечения провода по заданой потере напряжения, мощности нагрузки и длины линии -->
<table class="calc-result-tbl" cellpadding="5">	
	<tbody>		
		<tr>
			<td>Питающая сеть</td>
			<td><?=$voltagetype_mod?></td>
		</tr>
		<tr>
			<td>Напряжение в линии, В</td>
			<td><?=$voltage?></td>
		</tr>
		<tr>
			<td>Тип линии</td>
			<td><?=$linetype_mod?></td>
		</tr>
		<tr>
			<td>Провод</td>
			<td><?=$whire1_mod?></td>
		</tr>		
		<tr>
			<td>Сечение жил провода, мм<sup>2</sup></td>
			<td><?=$wirecross_mod?></td>
		</tr>
		<tr>
			<td>Мощность нагрузки, Вт</td>
			<td><?=$loadpower1?></td>
		</tr>
		<tr>
			<td>Коэффициент мощности, cosϕ</td>
			<td><?=$cosf3?></td>
		</tr>
		<tr>
			<td>Длина линии, м</td>
			<td><?=$linelen?></td>
		</tr>
		<tr>
			<td>Температура линии, С<sup>O</sup></td>
			<td><?=$linetemp?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>Падение напряжения в линиии, В</td>
			<td><?=$rez11?></td>
		</tr>
		<tr>
			<td>Падение напряжения в линиии, %</td>
			<td><?=$rez12?></td>
		</tr>
	</tfoot>
</table>