<!-- Определение сечения провода по заданой потере напряжения, мощности нагрузки и длины линии -->
<table class="calc-result-tbl" cellpadding="5">	
	<tbody>		
		<tr>
			<td>Определение сечения для</td>
			<td><?=$phase_mod?></td>
		</tr>
		<tr>
			<td>Тип проводов (мм)</td>
			<td><?=$whire_mod?></td>
		</tr>
		<tr>
			<td>Допустимые потери напряжения</td>
			<td><?=$vollos_mod?></td>
		</tr>
		<tr>
			<td>Мощность нагрузки, Вт</td>
			<td><?=$lbpower?></td>
		</tr>		
		<tr>
			<td>Длина линии, м</td>
			<td><?=$lblenght?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>Сечение провода, мм2</td>
			<td><?=$result?></td>
		</tr>
	</tfoot>
</table>