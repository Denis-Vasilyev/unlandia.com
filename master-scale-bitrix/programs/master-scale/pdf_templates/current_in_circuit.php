<!-- Определение сечения провода по заданой потере напряжения, мощности нагрузки и длины линии -->
<table class="calc-result-tbl" cellpadding="5">	
	<tbody>		
		<tr>
			<td>Питающая сеть</td>
			<td><?=$chaintype_mod?></td>
		</tr>
		<tr>
			<td>Характеристика нагрузки</td>
			<td><?=$loadfeature_mod?></td>
		</tr>
		<tr>
			<td>Мощность нагрузки, Вт</td>
			<td><?=$loadpower?></td>
		</tr>
		<tr>
			<td>Фактическое напряжение в сети, В</td>
			<td><?=$factvoltage?></td>
		</tr>		
		<tr>
			<td>Коэффициент мощности, cosϕ</td>
			<td><?=$cosf2?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>Сила тока в цепи, А</td>
			<td><?=$rez10?></td>
		</tr>
	</tfoot>
</table>