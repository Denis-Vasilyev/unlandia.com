<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
    die();
}
/** @var array $arCurrentValues */
if (!\Bitrix\Main\Loader::includeModule('iblock')) {
    return;
}
$arIBlockType = CIBlockParameters::GetIBlockTypes();
$arIBlock = array();
$rsIBlock = CIBlock::GetList(Array('sort' => 'asc'), Array('TYPE' => $arCurrentValues['IBLOCK_TYPE'], 'ACTIVE'=>'Y'), true);
while ($arr=$rsIBlock->Fetch()) {
    $arIBlock[$arr['CODE']] = '[' . $arr['ID'] . '] ' . $arr['NAME'];
}
$arComponentParameters = array(
    'GROUPS' => array(
    ),
    'PARAMETERS' => array(
        'IBLOCK_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('CP_WTBUY_IBLOCK_TYPE'),
            'TYPE' => 'LIST',
            'VALUES' => $arIBlockType,
            'REFRESH' => 'Y',
        ),
        'IBLOCK_CODE' => array(
            'PARENT' => 'BASE',
            'NAME' => GetMessage('CP_WTBUY_IBLOCK_ID'),
            'TYPE' => 'LIST',
            'ADDITIONAL_VALUES' => 'Y',
            'VALUES' => $arIBlock,
            'REFRESH' => 'Y',
        ),
        'ADD_SECTIONS_CHAIN' => Array(
            'PARENT' => 'ADDITIONAL_SETTINGS',
            'NAME' => GetMessage('CP_WTBUY_ADD_SECTIONS_CHAIN'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
        'SET_TITLE' => Array(
            'PARENT' => 'ADDITIONAL_SETTINGS',
            'NAME' => GetMessage('CP_WTBUY_SET_TITLE'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
        'CACHE_TIME'  =>  Array('DEFAULT'=>360000),
        'CACHE_GROUPS' => array(
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => GetMessage('CP_WTBUY_CACHE_GROUPS'),
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
		"FILTER_NAME" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => GetMessage("T_IBLOCK_FILTER"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
    ),
);