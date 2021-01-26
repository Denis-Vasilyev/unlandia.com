<?
//\Bitrix\Main\Loader::includeModule('catalog');
//\Bitrix\Main\Loader::includeModule('iblock');
//CModule::IncludeModule("catalog");
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("connector");
CBitrixComponent::IncludeComponentClass('dvasilyev:uerm.conf');
$Calculator = new EKFUERMConf;
switch ($_REQUEST['action']) {
	case 'get_items':
		$result['items'] = $Calculator->getItems();
		$json = json_encode($result, JSON_UNESCAPED_UNICODE);
		echo $json;
	break;
	case 'get_report':
		$file = $Calculator->getExcelReport($_REQUEST['xlsData']);
		$json = json_encode($file, JSON_UNESCAPED_UNICODE);
		$json = $file;
		echo $json;	
	break;
	case 'get_items1':
		$result['items'] = $Calculator->getItems1();
		echo ($result['items']['uerm-ket-t-1890']) . "<br>";
		//var_dump($result['items']) . "<br>";
		$json = json_encode($result, JSON_UNESCAPED_UNICODE);
		echo $json;
	break;
	default:
		$result = "unknown action";
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
		break;
}
?>