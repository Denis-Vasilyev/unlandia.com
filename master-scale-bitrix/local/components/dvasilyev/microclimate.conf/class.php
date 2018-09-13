<?

use Ekf\System\Def;

class EKFMicroclimateConf extends CBitrixComponent
{	
	var $iblockId = 116;
	
	public function executeComponent()
	{			
		$this->includeComponentTemplate();
	}
	
	public function getFans()
	{			
		$items = CIBlockElement::GetList(	array(	'ID' => 'asc'), 
											array(	'IBLOCK_ID' => $this->iblockId, 
													'ACTIVE' => 'Y', 
													'>PROPERTY_objemnyj_raskhod_vozduha_beskanalnaja_po_VALUE' => 0),
											false,
											false,
											array(	'PROPERTY_objemnyj_raskhod_vozduha_beskanalnaja_po',
													'CODE',
													'DETAIL_PAGE_URL',
													'DETAIL_PICTURE',
													'EXTERNAL_ID',
													'IBLOCK_SECTION_ID',
													'ID',
													'NAME',
													'PREVIEW_PICTURE',
													'PREVIEW_TEXT',
													'SEARCHABLE_CONTENT',
													'XML_ID',
													'PROPERTY_ARTIKUL'));	
		$mssql = new ms_sql_connect(	Def::mds_password,
										Def::mds_user,
										Def::mds_db,
										Def::mds_server );
		while($item = $items->GetNext()){
			if(!is_numeric($item["PROPERTY_OBJEMNYJ_RASKHOD_VOZDUHA_BESKANALNAJA_PO_VALUE"])) continue;
			$item['PRICE'] = $this->getItemPriceById($item['ID']);
			$item['PICTURE'] = CFile::GetPath($item["PREVIEW_PICTURE"]);
			$item['ADDITIONAL_EQUIP'] = $this->getAdditionalEquip($item['XML_ID'], $mssql);
			$result[] = $item;
		}
		return $result;		
	}
	
	public function getHeaters()
	{			
		$items = CIBlockElement::GetList(	array(	'ID' => 'asc'), 
											array(	'IBLOCK_ID' => $this->iblockId, 
													'ACTIVE' => 'Y', 
													'>PROPERTY_nominalnaja_moshhnost0_VALUE' => 0),
											false,
											false,
											array(	'PROPERTY_nominalnaja_moshhnost0',
													'CODE',
													'DETAIL_PAGE_URL',
													'DETAIL_PICTURE',
													'EXTERNAL_ID',
													'IBLOCK_SECTION_ID',
													'ID',
													'NAME',
													'PREVIEW_PICTURE',
													'PREVIEW_TEXT',
													'SEARCHABLE_CONTENT',
													'XML_ID',
													'PROPERTY_ARTIKUL' ));													
		while($item = $items->GetNext()){
			if(!is_numeric($item["PROPERTY_NOMINALNAJA_MOSHHNOST0_VALUE"])) continue;
			$item['PRICE'] = $this->getItemPriceById($item['ID']);
			$item['PICTURE'] = CFile::GetPath($item["PREVIEW_PICTURE"]);
			$result[] = $item;
		}
		return $result;		
	}
	
	public function getThermostats()
	{		
		$items = CIBlockElement::GetList(	array(	'ID' => 'asc'), 
											array(	'IBLOCK_ID' => $this->iblockId, 
													'ACTIVE' => 'Y', 
													array(
														"LOGIC" => "OR",
														array('=PROPERTY_tip_funkcionalnyh_perekluchatelej_VALUE' => 'NC (обогрев)'),
														array('=PROPERTY_tip_funkcionalnyh_perekluchatelej_VALUE' => 'NO (охлаждение)'),
														array('=PROPERTY_tip_funkcionalnyh_perekluchatelej_VALUE' => 'NO (охлаждение) / NC (обогрев)'),
														array('=PROPERTY_tip_funkcionalnyh_perekluchatelej_VALUE' => 'NO (охлаждение) + NC (обогрев)')
													) ),
											false,
											false,
											array(	'PROPERTY_tip_funkcionalnyh_perekluchatelej',
													'CODE',
													'DETAIL_PAGE_URL',
													'DETAIL_PICTURE',
													'EXTERNAL_ID',
													'IBLOCK_SECTION_ID',
													'ID',
													'NAME',
													'PREVIEW_PICTURE',
													'PREVIEW_TEXT',
													'SEARCHABLE_CONTENT',
													'XML_ID',
													'PROPERTY_ARTIKUL' ));		
		while($item = $items->GetNext()){
			$item['PRICE'] = $this->getItemPriceById($item['ID']);
			$item['PICTURE'] = CFile::GetPath($item["PREVIEW_PICTURE"]);			
			$result[] = $item;
		}
		return $result;		
	}
	
	public function getItemPriceById($PRODUCT_ID){
		$db_res = CPrice::GetList(
				array(),
				array(	"PRODUCT_ID" => $PRODUCT_ID,
						"CATALOG_GROUP_ID" => 2 )
		);
		if ($ar_res = $db_res->Fetch())
				return $ar_res["PRICE"];
		else 
				return null;
	}
	
	public function getAdditionalEquip($xmlId, $mssql){
		$type = iconv('utf-8', 'cp1251', 'Дополнительный товар');
		$sql = "SELECT TOP 50 * FROM products_analogs WHERE product_id='{$xmlId}' AND analog_type='{$type}'";
		$MDSResult = $mssql->MDSGetAll($sql);
		if(!count($MDSResult)) return null;
		$bxLogicArr = ["LOGIC" => "OR"];
		for($i=0; $i<count($MDSResult); $i++){
			$MDSResult[$i]['analog_type'] = iconv('cp1251', 'utf-8', $MDSResult[$i]['analog_type']);
			$bxLogicArr[] = [ 'XML_ID' => $MDSResult[$i]['analog_product_id'] ];
		}
		$items = CIBlockElement::GetList(	array(	'ID' => 'asc'), 
											array(	'IBLOCK_ID' => $this->iblockId, 
													'ACTIVE' => 'Y', 
													$bxLogicArr ),
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
													'SEARCHABLE_CONTENT',
													'XML_ID',
													'PROPERTY_ARTIKUL' ));	
		while($item = $items->Fetch()){
			$item['PRICE'] = $this->getItemPriceById($item['ID']);
			$item['PICTURE'] = CFile::GetPath($item["PREVIEW_PICTURE"]);
			
			$result[] = $item;
		}
		return $result;
	}
}
?>