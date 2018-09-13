<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
CModule::IncludeModule("connector");
CBitrixComponent::IncludeComponentClass('dvasilyev:microclimate.conf');
$Calculator = new EKFMicroclimateConf;
switch ($_REQUEST['action']) {
	case 'get_items':
		$result['fans'] 		= $Calculator->getFans();
		$result['heaters'] 		= $Calculator->getHeaters();		
		$result['thermostats'] 	= $Calculator->getThermostats();
		$json = json_encode($result, JSON_UNESCAPED_UNICODE);
		echo $json;
	break;
	default:
		$result[] = "unknown action";
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
		break;
}
?>