<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
if (strtolower($_REQUEST["CODE"]) == "shop") { //Где купить
    $APPLICATION->IncludeComponent(
        "ul:wtbuy",
        "",
        array(
            "IBLOCK_TYPE" => "articles",
            "IBLOCK_CODE" => "where_to_buy",
            "ADD_SECTIONS_CHAIN" => "Y",
            "SET_TITLE" => "Y",
            "CACHE_TIME" => "84600",
            "SECTION_CODE_LIST" => array("wholesale") //"wholesale", "retail", "corp"
        ),
        false
    );
} elseif(strtolower($_REQUEST["CODE"]) == "about") { //О бренде
    $APPLICATION->IncludeComponent("bitrix:news.detail", "info", array(
        "IBLOCK_TYPE" => "articles",
        "IBLOCK_ID" => IBLOCK_INFO,
        "ELEMENT_ID" => "",
        "ELEMENT_CODE" => $_REQUEST["CODE"],
        "CHECK_DATES" => "Y",
        "FIELD_CODE" => array(
            0 => "ID",
            1 => "NAME",
            2 => "PREVIEW_TEXT",
            3 => "DETAIL_TEXT",
        ),
        "IBLOCK_URL" => "",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_GROUPS" => "N",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "USE_PERMISSIONS" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Товар",
        "PAGER_TEMPLATE" => "",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_ADDITIONAL" => ""
    ),
        false
    );
} else {
    LocalRedirect('/404.php');
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>
