<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
    die();
}
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


/*************************************************************************
    Processing of received parameters
*************************************************************************/
if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 360000;
}

$arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
$arParams['IBLOCK_CODE'] = trim($arParams['IBLOCK_CODE']);
$arParams['SET_TITLE'] = $arParams['SET_TITLE']!='N';
$arParams['ADD_SECTIONS_CHAIN'] = $arParams['ADD_SECTIONS_CHAIN']!='N'; //Turn on by default
$arResult['SECTIONS']=array();

/*************************************************************************
          Work with cache
*************************************************************************/
if ($this->StartResultCache()) {
    if (!\Bitrix\Main\Loader::includeModule('iblock')) {
        $this->AbortResultCache();
        ShowError(GetMessage('IBLOCK_MODULE_NOT_INSTALLED'));
        return;
    }
    //Получаем ID инфоблока-приёмника по его символьному коду
    $res = CIBlock::GetList(
        Array(),
        Array(
            'TYPE' => 'articles',
            'ACTIVE' => 'Y',
            'CODE' => $arParams['IBLOCK_CODE'],
        ), true
    );
    while ($arRes = $res->Fetch()) {
        $IBLOCK_ID = $arRes['ID'];
    }
    $arSelect = array('ID',
        'IBLOCK_ID',
        'IBLOCK_SECTION_ID',
        'NAME',
        'DESCRIPTION',
        'CODE',
        'XML_ID',
        'UF_DESCRIPTION',
    );
    $arResult = array();
    //ORDER BY
    $arSort = array(
        'SORT' => 'ASC',
        'NAME' => 'ASC',
    );
    //EXECUTE
    $sectionIds = array();
    $arFilter = array(
        'ACTIVE' => 'Y',
        'GLOBAL_ACTIVE' => 'Y',
        'IBLOCK_ID' => $IBLOCK_ID,
        'CODE' => $arParams['SECTION_CODE_LIST']
    );    
    $rsSections = CIBlockSection::GetList($arSort, $arFilter, false, $arSelect);
    while ($arSection = $rsSections->GetNext()) {
        $arResult['SECTIONS'][$arSection['ID']]=$arSection;
        $sectionIds[$arSection['CODE']] = $arSection['ID'];
    }
    $arSelect = array(
        'ID',
        'IBLOCK_SECTION_ID',
        'NAME',
        'DETAIL_TEXT',
    );
    $arProps = array(
        'CITY',
        'ADDRESS',
        'PHONE',
        'WORKHOURS',
        'LATITUDE',
        'LONGITUDE',
        'EMAIL',
    );
    foreach ($arProps as $prop) {
        $arSelect[] = 'PROPERTY_' . $prop;
    }
    $arFilter = array(
        'ACTIVE' => 'Y',
        'GLOBAL_ACTIVE' => 'Y',
        'IBLOCK_ID' => $IBLOCK_ID,
        'SECTION_CODE' => $arParams['SECTION_CODE_LIST'],
    );
    $rsElements = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
    while ($arElement = $rsElements->GetNext()) {
        foreach ($arProps as $prop) {
            $arElement[$prop] = $arElement['PROPERTY_' . $prop . '_VALUE'];
            unset($arElement['PROPERTY_' . $prop . '_VALUE']);
            unset($arElement['PROPERTY_' . $prop . '_VALUE_ID']);
            unset($arElement['~PROPERTY_' . $prop . '_VALUE']);
            unset($arElement['~PROPERTY_' . $prop . '_VALUE_ID']);
            unset($arElement['PROPERTY_' . $prop . '_DESCRIPTION']);
            unset($arElement['~PROPERTY_' . $prop . '_DESCRIPTION']);
            unset($arElement['PROPERTY_' . $prop . '_PROPERTY_VALUE_ID']);
            unset($arElement['~PROPERTY_' . $prop . '_PROPERTY_VALUE_ID']);
        }
        $arResult['SECTIONS'][$arElement['IBLOCK_SECTION_ID']]['ELEMENTS']
            [$arElement['CITY']][$arElement['ID']] = $arElement;
    }    
    if(isset($arResult['SECTIONS'][$sectionIds['retail']]['ELEMENTS']))
        ksort($arResult['SECTIONS'][$sectionIds['retail']]['ELEMENTS']);//розница сортируется по TITLE, остальные по SORT
    if(isset($arResult['SECTIONS'][$sectionIds['wholesale']]['ELEMENTS']))
        ksort($arResult['SECTIONS'][$sectionIds['wholesale']]['ELEMENTS']);//опт тоже сортируется по TITLE, остальные по SORT
    $this->SetResultCacheKeys(array(
        'SECTIONS',
    ));
    $this->IncludeComponentTemplate();
}
if ($arParams['ADD_SECTIONS_CHAIN']) {
    $APPLICATION->AddChainItem(GetMessage('CHAIN_ITEM'));
}
if ($arParams['SET_TITLE']) {
    $APPLICATION->SetTitle(GetMessage('CHAIN_ITEM'));
}