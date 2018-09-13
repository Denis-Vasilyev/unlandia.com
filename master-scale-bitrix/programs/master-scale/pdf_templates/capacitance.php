<!-- Определение сечения провода по заданой потере напряжения, мощности нагрузки и длины линии -->
<table class="calc-result-tbl" cellpadding="5">	
	<tbody>		
		<tr>
			<td>Соединение обмоток двигателя</td>
			<td><?=$motor_winding_mod?></td>
		</tr>
		<tr>
			<td>Мощность двигателя, Вт</td>
			<td><?=$power1?></td>
		</tr>
		<tr>
			<td>Напряжене в сети, В</td>
			<td><?=$voltage1?></td>
		</tr>
		<tr>
			<td>Коэффициент мощности, cosϕ</td>
			<td><?=$cosf1?></td>
		</tr>		
		<tr>
			<td>КПД двигателя</td>
			<td><?=$effengine1?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>Ёмкость рабочего конденсатора, мкФ</td>
			<td><?=$rez3?></td>
		</tr>
		<tr>
			<td>Ёмкость пускового конденсатора, мкФ</td>
			<td><?=$rez4?></td>
		</tr>
	</tfoot>
</table>