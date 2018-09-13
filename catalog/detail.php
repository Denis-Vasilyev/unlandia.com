<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новинки");
?>
<?
$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    ".default",
    array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => IBLOCK_CATALOG,
        "ELEMENT_ID" => "",
        "ELEMENT_CODE" => $_REQUEST["XML_ID"],
        "CHECK_DATES" => "Y",
        "FIELD_CODE" => array(
            0 => "ID",
            1 => "XML_ID",
            2 => "NAME",
            3 => "PREVIEW_TEXT",
            4 => "DETAIL_TEXT",
            5 => "DATE_CREATE",
            6 => "IBLOCK_SECTION_ID",
            7 => "",
        ),
        "PROPERTY_CODE" => array(
            0 => "",
            1 => "CHARACTERISTIC",
            2 => "PHOTO",
            3 => "",
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
        "ADD_SECTIONS_CHAIN" => "Y",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "USE_PERMISSIONS" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Товар",
        "PAGER_TEMPLATE" => "",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_ADDITIONAL" => "",
        "COMPONENT_TEMPLATE" => ".default",
        "DETAIL_URL" => "",
        "SET_CANONICAL_URL" => "N",
        "SET_BROWSER_TITLE" => "Y",
        "SET_META_KEYWORDS" => "Y",
        "SET_META_DESCRIPTION" => "Y",
        "SET_LAST_MODIFIED" => "N",
        "ADD_ELEMENT_CHAIN" => "N",
        "STRICT_SECTION_CHECK" => "N",
        "COMPOSITE_FRAME_MODE" => "A",
        "COMPOSITE_FRAME_TYPE" => "AUTO",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "SHOW_404" => "N",
        "MESSAGE_404" => ""
    ),
    false
);
?>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");