<?

use Ekf\System\Def;

class EKFUERMConf extends CBitrixComponent
{	
	var $iblockId = 116;
	
	public function executeComponent()
	{			
		$this->includeComponentTemplate();
	}
	
	public function getItems(){
		$articles = [	'uerm-ket-s-1890',
						'uerm-ket-t-1890',
						'uerm-kss-1890',
						'uerm-kor-600',					
						'uerm-slide-110',
						'uerm-slide-260',
						'uerm-slide-410',
						'uerm-slide-560',					
						'uerm-din-400',
						'uerm-mp-600'/**/
					];
		for($i=0; $i<count($articles); $i++){
			$item = CIBlockElement::GetList(	array(	'ID' => 'asc'), 
												array(	'IBLOCK_ID' => $this->iblockId, 
														'ACTIVE' => 'Y', 
														'PROPERTY_ARTIKUL' => $articles[$i]
														),
												false,
												false,
												array(	'CODE',
														'DETAIL_PAGE_URL',
														'DETAIL_PICTURE',
														'EXTERNAL_ID',
														'IBLOCK_SECTION_ID',
														'ID',
														'NAME',
														'PREVIEW_PICTURE',
														'PREVIEW_TEXT',
														'PROPERTY_ARTIKUL' ));
			$item = $item->GetNext();
			$item['PRICE'] = $this->getItemPriceById($item['ID']);
			$item['PICTURE'] = CFile::GetPath($item["PREVIEW_PICTURE"]);			
			$result[$item['PROPERTY_ARTIKUL_VALUE']] = $item;
		}		
		return $result;
	}
	
	public function getItemPriceById($PRODUCT_ID){
		$db_res = CPrice::GetList(
				array(),
				array(	"PRODUCT_ID" => $PRODUCT_ID,
						"CATALOG_GROUP_ID" => 4 )
		);
		if ($ar_res = $db_res->Fetch())
				return $ar_res["PRICE"];
		else 
				return null;
	}
	
	public function getItems1(){
		$items = [	'uerm-ket-s-1890' 	=> 'Короб КЭТ силовой (1890х300х150) EKF Basic',
					'uerm-ket-t-1890' 	=> 'Короб КЭТ транзитный (1890х300х150) EKF Basic',
					'uerm-kss-1890' 	=> 'Короб КСС (1890х300х150) EKF Basic',
					'uerm-kor-600' 		=> 'Короб верхний для КСС/КЭТ (600х300х150) EKF Basic',					
					'uerm-slide-110' 	=> 'Цоколь верхний с компенсатором (110х300х150) EKF Basic',
					'uerm-slide-260' 	=> 'Цоколь верхний с компенсатором (260х300х150) EKF Basic',
					'uerm-slide-410' 	=> 'Цоколь верхний с компенсатором (410х300х150) EKF Basic',
					'uerm-slide-560' 	=> 'Цоколь верхний с компенсатором (560х300х150) EKF Basic',					
					'uerm-din-400' 		=> 'ЯУР для УЭРМ счетчик на DIN-рейку (400х300х150) EKF Basic',
					'uerm-mp-600' 		=> 'ЯУР для УЭРМ счетчик на монтажную панель (600х300х150) EKF Basic',
				];
		return $items;
	}
	
	public function getExcelReport($xlsData){
		include_once $_SERVER["DOCUMENT_ROOT"]."/local/php_interface/init/include/PHPExcel.php";
		$totalPrice = $xlsData[1];
		$xlsData = $xlsData[0];
		$pExcel = new PHPExcel();
		$pExcel->setActiveSheetIndex(0);
		$aSheet = $pExcel->getActiveSheet();
		// Ориентация страницы и  размер листа
		$aSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$aSheet->getPageSetup()->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		// Поля документа
		$aSheet->getPageMargins()->setTop(1);
		$aSheet->getPageMargins()->setRight(0.75);
		$aSheet->getPageMargins()->setLeft(0.75);
		$aSheet->getPageMargins()->setBottom(1);
		// Название листа
		$aSheet->setTitle('Спецификация УЭРМ');
		// Шапка и футер (при печати)
		$aSheet->getHeaderFooter()->setOddHeader('EKF Электротехника: '.$aSheet->getTitle());
		$aSheet->getHeaderFooter()->setOddFooter('&L&B'.$aSheet->getTitle().'&RСтраница &P из &N');
		//Лого
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');

		$objDrawing->setPath($_SERVER['DOCUMENT_ROOT'] . "/programs/epros/img/logo.png");

		//$objDrawing->setCoordinates('B2');
		
		//$objDrawing->setPath($logo);
		$objDrawing->setOffsetX(0);    // setOffsetX works properly
		$objDrawing->setOffsetY(0);  //setOffsetY has no effect
		$objDrawing->setCoordinates('A1');
		$objDrawing->setHeight(40); // logo height
		$objDrawing->setWorksheet($pExcel->getActiveSheet());//.
		// Настройки шрифта
		$pExcel->getDefaultStyle()->getFont()->setName('Calibry');
		$pExcel->getDefaultStyle()->getFont()->setSize(11);
		$aSheet->getColumnDimension('A')->setWidth(20);
		$aSheet->getColumnDimension('B')->setWidth(40);		
		$aSheet->getColumnDimension($this->сellIndex(count($xlsData[0])))->setWidth(15);
		$aSheet->mergeCells('A3:' . $this->сellIndex(count($xlsData[0]),3));
		//$aSheet->getRowDimension('1')->setRowHeight(20);
		$aSheet->setCellValue('B1','Спецификация создана при помощи сервиса EKF MasterTOOL');
		$aSheet->setCellValue('B2','https://ekfgroup.com/programs/master-scale/');
		$aSheet->mergeCells('A4:' . $this->сellIndex(count($xlsData[0]),4));
		$style_header1 = array(
							//Шрифт
								'font'=>array(
									'bold' => true,
									//'name' => 'Times New Roman',
									'size' => 16
								),
							//Выравнивание
								'alignment' => array(
									'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
									'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
								)
							);
		$aSheet->getStyle('A4')->applyFromArray($style_header1);
		$aSheet->setCellValue('A4','Спецификация УЭРМ');		
		$aSheet->mergeCells('A5:A6');
		$aSheet->setCellValue('A5','Артикул ЭКФ');
		$aSheet->mergeCells('B5:B6');
		$aSheet->setCellValue('B5','Наименование');
		$aSheet->mergeCells('C5:'  . $this->сellIndex(count($xlsData[0]) - 3,5));
		$aSheet->setCellValue('C5','Количество, шт');
		for($i = 1; $i <= count($xlsData[0]) - 5; $i++){
			$aSheet->setCellValue($this->сellIndex($i + 2, 6),"Изделие №" . $i);
			$aSheet->getColumnDimension($this->сellIndex($i + 2))->setWidth(13);
		}
		$aSheet->mergeCells($this->сellIndex(count($xlsData[0]) - 2 ,5) . ":" . $this->сellIndex(count($xlsData[0]) - 2, 6));		
		$aSheet->setCellValue($this->сellIndex(count($xlsData[0]) - 2 ,5),'ИТОГО, шт');
		$aSheet->getColumnDimension($this->сellIndex(count($xlsData[0]) - 2))->setWidth(10);
		$aSheet->mergeCells($this->сellIndex(count($xlsData[0]) - 1 ,5) . ":" . $this->сellIndex(count($xlsData[0]) - 1 ,6));		
		$aSheet->setCellValue($this->сellIndex(count($xlsData[0]) - 1 ,5),'Базовая цена, ₽');
		$aSheet->getColumnDimension($this->сellIndex(count($xlsData[0]) - 1))->setWidth(15);
		$aSheet->mergeCells($this->сellIndex(count($xlsData[0]) ,5) . ":" . $this->сellIndex(count($xlsData[0]) ,6));		
		$aSheet->setCellValue($this->сellIndex(count($xlsData[0]) ,5),'Сумма, ₽');
		$style_header2 = array(
							//Шрифт
								'font'=>array(
									'bold' => true,
									//'name' => 'Times New Roman',
									//'size' => 20
								),
							//Выравнивание
								'alignment' => array(
									'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
									'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
								),
							//Заполнение цветом
								'fill' => array(
									'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
									'color'=>array(
										'rgb' => 'CFCFCF'
									)
								)
							);
		$aSheet->getStyle('A5:' . $this->сellIndex(count($xlsData[0]) ,6))->applyFromArray($style_header2);
		for($i = 1; $i <= count($xlsData); $i++){
			for($j = 1; $j <= count($xlsData[$i - 1]); $j++){
				$aSheet->setCellValue($this->сellIndex($j ,$i + 6),$xlsData[$i-1][$j-1]);
				$aSheet->getStyle($this->сellIndex($j ,$i + 6))->getAlignment()->setWrapText(true);
			}
		}
		$borderStyle = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => '00000000'),
				),
			),
		);
		$aSheet->getStyle('A5:' . $this->сellIndex(count($xlsData[0]) , count($xlsData) + 6))->applyFromArray($borderStyle);
		//$aSheet->setCellValue('A20',count($xlsData));
		$aSheet->setCellValue($this->сellIndex(count($xlsData[0]) - 1, count($xlsData) + 7), "Итого:");
		$aSheet->setCellValue($this->сellIndex(count($xlsData[0]), count($xlsData) + 7), $totalPrice);
		$objWriter = new PHPExcel_Writer_Excel2007($pExcel);
		$fileLocalPath = '/upload/master_scale_xls/uerm_spec.xlsx';
		$filePath = $_SERVER["DOCUMENT_ROOT"] . $fileLocalPath;
		$objWriter->save($filePath);
		return $fileLocalPath;
	}
	
	private function сellIndex($colIndex, $rowIndex){ // надо сделать функцию более универсальной при необходимости
		//if(!is_int($index)){return null;}
		$symb = [ "A", "B", "C", "D", "E", "F", 
				  "G", "H", "I", "J", "K", "L", 
				  "M", "N", "O", "P", "Q", "R",
				  "S", "T", "U", "V", "W", "X", 
				  "Y", "Z" ];
		if(isset($rowIndex)) return $symb[$colIndex - 1] . $rowIndex; 
		else return $symb[$colIndex - 1]; 
	}/**/
}
?>