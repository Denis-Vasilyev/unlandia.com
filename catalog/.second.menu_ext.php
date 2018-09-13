<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "",
    array(
        "IS_SEF" => "N",
        "ID" => $_REQUEST["ID"],
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => IBLOCK_CATALOG,
        "SECTION_URL" => "",
        "DEPTH_LEVEL" => "1",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600"
    ),
    false
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>