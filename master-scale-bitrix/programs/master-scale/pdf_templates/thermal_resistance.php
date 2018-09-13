<table class="calc-result-tbl" cellpadding="5">	
	<tbody>		
		<tr>
			<td>Номинальное сечение жилы, мм<sup>2</sup></td>
			<td><?=$wirecrosssection1?></td>
		</tr>
		<tr>
			<td>Наибольший ток КЗ, кА</td>
			<td><?=$largestcurrent1?></td>
		</tr>	
		<tr>
			<td>Система заземления</td>
			<td><?=$systemtype1_mod?></td>
		</tr>
		<?if($systemtype1 == '0'){?>
		<tr>
			<td>Номинальное фазное напряжение U<sub>0</sub>, В</td>
			<td><?=$nominalphasevoltage1?></td>
		</tr>
		<?}else if($systemtype1 == '1'){?>
		<tr>
			<td>Номинальное линейное напряжение U<sub>0</sub>, В</td>
			<td><?=$nominallinevoltage1?></td>
		</tr>
		<?}?>
		<tr>
			<td>Время отключения, с</td>
			<td><?=$breaktime1?></td>
		</tr>		
	</tbody>
	<tfoot>
		<tr>
			<td>Эквивалентный допустимый ток ( J<sub>терм.доп</sub> ), кА/мм</td>
			<td><?=$rez52?></td>
		</tr>
		<tr>
			<td>Эквивалентный термический ток ( J<sub>терм.эк</sub> ), кА/мм</td>
			<td><?=$rez53?></td>
		</tr>	
		<tr>
			<td>Критерий J<sub>терм.доп</sub> > J<sub>терм.эк</sub></td>
			<td><?=$rez54?></td>
		</tr>
	</tfoot>
</table>