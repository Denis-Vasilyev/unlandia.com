<html>
	<head>
		<title><?=$pageTitle?></title>
		<style>
			.calc-result-tbl {
				margin: 0;
				padding: 0;
				border-collapse: collapse;
				width: 100%;
			}
			.calc-result-tbl td {
				text-align: left;
				padding: 5px;
			}
			.header {
				text-align: left;
				padding: 20px;
				border-bottom: 1px solid #333;
				margin-bottom: 20px;
			}
			.header table {
				width: 100%;
				font-size: 8px;
			}
			.header table td{
				width: 33.33%;
			}
			.address {
				font-size: 10px;
			}			
			.calc-result-tbl tfoot {
				padding-top: 15px;				
				border-top: 1px solid #333;;
			}
			h1 {
				font-size: 16px;
				margin-bottom: 15px;
			}	
			.table-delimiter {
				height: 50px;
			}		
		</style>
	</head>
	<body>
		<div class="header">
			<table width="100%">
				<tr>					
					<td width="30%">
						<img src="../../images/newlogo.png" alt="Логотип компании EKF" class="logo">												
					</td>					
					<td width="10%"></td>
					<td width="60%">
						111141, Россия, г. Москва, 3-й проезд Перова Поля, 8 строение 11<br>	
						info@ekf.su<br>
						http://ekfgroup.com<br>
						+7 (495) 788-88-15, 8-800-333-88-15 (многоканальный).<br>
					</td>
				</tr>
			</table>
		</div>
		<h1><?=$pageTitle?></h1>
		<?=$mainContent?>
	</body>
</html>