<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$data = array();
$iblockId = 134;
if(isset($_REQUEST['cableType1'])){
	$sectionId = $_REQUEST['cableType1'];
	$ct_Sections = CIBlockElement::GetList(	array(	'ID' => 'asc'), 
											array(	'IBLOCK_ID' => $iblockId, 
													'ACTIVE' => 'Y', 
													'SECTION_ID' => $sectionId),
											false,
											false,
											array(	"ID",
													"NAME",
													"PROPERTY_outer_diameter",
													"PROPERTY_cable_mass",
													"PROPERTY_volume_combustible_mass"
												));	
	while ($sectionData = $ct_Sections->Fetch())
		$data[] = array(	"ID" => $sectionData["ID"],
							"NAME" => $sectionData["NAME"],
							"OUTER_DIAMETER" => $sectionData["PROPERTY_OUTER_DIAMETER_VALUE"],
							"CABLE_MASS" => $sectionData["PROPERTY_CABLE_MASS_VALUE"],
							"VOLUME_COMBUSTIBLE_MASS" => $sectionData["PROPERTY_VOLUME_COMBUSTIBLE_MASS_VALUE"]
					);/**/	
} else if(isset($_REQUEST['cableCrossSection1'])){
	$ct_Sections = CIBlockElement::GetList(	array(	'ID' => 'asc'), 
											array(	'IBLOCK_ID' => $iblockId, 
													'ACTIVE' => 'Y', 
													'ID' => $_REQUEST['cableCrossSection1']),
											false,
											false,
											array(	"PROPERTY_outer_diameter",
													"PROPERTY_cable_mass",
													"PROPERTY_volume_combustible_mass"
												));
	$data = array();
	while ($sectionData = $ct_Sections->Fetch())
		$data[] = array(	"OUTER_DIAMETER" => $sectionData["PROPERTY_OUTER_DIAMETER_VALUE"],
							"CABLE_MASS" => $sectionData["PROPERTY_CABLE_MASS_VALUE"],
							"VOLUME_COMBUSTIBLE_MASS" => $sectionData["PROPERTY_VOLUME_COMBUSTIBLE_MASS_VALUE"]
					);
}else $data[0] = "empty";
echo json_encode($data, JSON_UNESCAPED_UNICODE);