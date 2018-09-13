<!-- Расчёт токов короткого замыкания -->
<table class="calc-result-tbl" cellpadding="5">
	<tbody>
		<tr>
			<td colspan="3">Расчёт для</td>
			<td colspan="3"><?=$calctypelabel?></td>			
		</tr>
		<tr>
			<td colspan="3">Количество жил и сечение, (шт., мм<sup>2</sup>)</td>
			<td colspan="3"><?=$cabletypesp_html?></td>
		</tr>
		<tr>
			<td colspan="3">Длина кабеля (м)</td>
			<td colspan="3"><?=$cablelength1?></td>
		</tr>					
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">Однофазное КЗ:</td>
			<td colspan="2">Двухфазное КЗ:</td>
			<td colspan="2">Трехфазное КЗ:</td>
			<td></td><td></td><td></td>
		</tr>		
		<tr>
			<td>R1 ,(Ом)</td>
			<td><?=$rez37?></td>
			<td>R1 ,(Ом)</td>
			<td><?=$rez41?></td>
			<td>R1 ,(Ом)</td>
			<td><?=$rez45?></td>
		</tr>
		<tr>
			<td>X1 ,(Ом)</td>
			<td><?=$rez38?></td>
			<td>X1 ,(Ом)</td>
			<td><?=$rez42?></td>
			<td>X1 ,(Ом)</td>
			<td><?=$rez46?></td>
		</tr>
		<tr>
			<td>R0 ,(Ом)</td>
			<td><?=$rez39?></td>
			<td>R0 ,(Ом)</td>
			<td><?=$rez43?></td>
			<td>R0 ,(Ом)</td>
			<td><?=$rez47?></td>
		</tr>
		<tr>
			<td>X0 ,(Ом)</td>
			<td><?=$rez40?></td>
			<td>X0 ,(Ом)</td>
			<td><?=$rez44?></td>
			<td>X0 ,(Ом)</td>
			<td><?=$rez48?></td>
		</tr>
		<tr>
			<td>Iкз ,(А)</td>
			<td><?=$rez49?></td>
			<td>Iкз ,(А)</td>
			<td><?=$rez50?></td>
			<td>Iкз ,(А)</td>
			<td><?=$rez51?></td>
		</tr>
	</tfoot>
</table>