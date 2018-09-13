<!-- Определение сечения провода по его диаметру -->
<table class="calc-result-tbl" cellpadding="5">	
	<tbody>
		<tr>
			<td colspan="2">
				<table width="100%">
					<tr>
						<td width="50%">
							<p>
							1. Намотайте витком к витку оголенную жилу провода на предмет цилиндрической формы (например отвертку). Старайтесь наматывать как можно плотнее, без зазоров.
							</p>
							<p>
							2. Измерьте штангель-циркулем длину намотанной жилы
							Внесите показания в соответствующие поля и нажмите клавишу enter
							</p>
						</td>
						<td width="50%">
							<img width="200" src="<?=$_SERVER['DOCUMENT_ROOT']?>/programs/master-scale/img/caliper.gif" alt="">
						</td>
					</tr>
				</table>				
			</td>
		</tr>
		<tr>
			<td colspan="2" class="table-delimiter"></td>
		</tr>
		<tr>
			<td>Количество витков</td>
			<td><?=$kolvovit?></td>
		</tr>
		<tr>
			<td>Длина намотки (мм)</td>
			<td><?=$dlinavit?></td>
		</tr>		
	</tbody>
	<tfoot>
		<tr>
			<td>Сечение провода, мм2</td>
			<td><?=$result?></td>
		</tr>
	</tfoot>
</table>