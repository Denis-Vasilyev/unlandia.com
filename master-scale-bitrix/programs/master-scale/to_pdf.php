<?
/**
 * Сохранение калькуляторов в ПДФ
 * Данные получаем с формы \programs\master-scale\index.php
 * Там же скрипт, который заметяет значение радио кнопок и чекбоксов на текст из соответствующих элементов label
 */
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/lib/vendor/tcpdf/tcpdf.php');
if (!empty($_REQUEST['form'])) {	
	try {		
		$wrapTemplateFile = __DIR__ . '/pdf_templates/wrap.php';
		$templateFile = __DIR__ . '/pdf_templates/' . $_REQUEST['form'] . '.php';
		if (file_exists($templateFile)) {
			extract($_REQUEST);
			//var_dump($_REQUEST);
			//exit();

			ob_start();				
			include($templateFile);
			$mainContent = ob_get_contents();
			ob_end_clean();

			ob_start();				
			include($wrapTemplateFile);
			$wrapContent = ob_get_contents();
			ob_end_clean();
			
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);
			$pdf->SetFont('dejavusans', '', 10, '', true);

			$pdf->SetAuthor('ekfgroup.com');
			$pdf->SetTitle('EKF | ' . $pageTitle);

			$pdf->AddPage();
			$pdf->writeHTMLCell(0, 0, '', '', $wrapContent, 0, 1, 0, true, '', true);
			$file_name = 'example_001.pdf';
			$catalog = 'upload/master_scale_pdf/';
			//$document_root = '/data/www/ekfgroup';
			if($ajax){
				//$pdf->Output($_SERVER['DOCUMENT_ROOT'].'programs/master-scale/pdf_files/example_001.pdf','F');
				$pdf->Output($_SERVER['DOCUMENT_ROOT'].$catalog.$file_name,'F');
				echo $catalog.$file_name;
			} else {
				$pdf->Output($file_name,'I');
			}
		} else {
			exit('Нет шаблона для вывода');
		}		    
	} catch (HTML2PDF_exception $e) {
	    echo $e;
	    exit;
	}	
}
?>