<table class="calc-result-tbl" cellpadding="5">	
	<tbody>		
		<tr>
			<td>Тип короба</td>
			<td><?=$boxtype_mod?></td>
		</tr>
		<tr>
			<td>Размеры кабельного канала</td>
			<td><?=$boxsize_mod?></td>
		</tr>
		<tr>
			<td>Тип кабеля</td>
			<td><?=$cabletype_mod?></td>
		</tr>
		<?if ($cabletype == 'flat'){?>
		<tr>
			<td>Ширина внешней изоляции, мм</td>
			<td><?=$insulationwidth?></td>
		</tr>
		<tr>
			<td>Высота внешней изоляции, мм</td>
			<td><?=$insulationheight?></td>
		</tr>
		<?}elseif($cabletype == 'round'){?>
		<tr>
			<td>Диаметр внешней изоляции, мм</td>
			<td><?=$insulationdiam?></td>
		</tr>
		<?}?>
	</tbody>
	<tfoot>
		<tr>
			<td>Заполняемость канала</td>
			<td><?=$rez13?></td>
		</tr>		
	</tfoot>
</table>