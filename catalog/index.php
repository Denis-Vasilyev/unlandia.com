<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$pageTitle = "Каталог";
if(isset($_REQUEST["SECTION_CODE"])){
    $pageTitle = getSectionNameByCode($_REQUEST["SECTION_CODE"]);
}
$APPLICATION->SetTitle($pageTitle);
?>
    <h1><?=changeQuotes($pageTitle)?></h1>
    <div class="group">
        <div class="Page__nav"><?
            $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "left",
                array(
                    "ROOT_MENU_TYPE" => "left",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "left",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "COMPONENT_TEMPLATE" => "left",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            );
            ?></div>
        <div class="Content__wrapper"><?
            $section = '';
            if (!empty($_GET['SECTION_CODE'])) {
                $section = $_GET['SECTION_CODE'];
            }
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "catalog",
                array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => IBLOCK_CATALOG,
                    "NEWS_COUNT" => "15",
                    "SORT_BY1" => "CREATED",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "NAME",
                    "SORT_ORDER2" => "ASC",
                    "FIELD_CODE" => array(
                        0 => "ID",
                        1 => "XML_ID",
                        2 => "NAME",
                        3 => "",
                    ),
                    "PROPERTY_CODE" => array(
                        0 => "",
                        1 => "PHOTO",
                        2 => "",
                    ),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "N",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => SET_SITE_CACHE_TIME,
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "N",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "SET_TITLE" => "N",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "Y",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => $section,
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => SET_SITE_CACHE_TIME,
                    "PAGER_SHOW_ALL" => "Y",
                    "DISPLAY_DATE" => "Y",
                    "DISPLAY_NAME" => "Y",
                    "DISPLAY_PICTURE" => "N",
                    "DISPLAY_PREVIEW_TEXT" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "COMPONENT_TEMPLATE" => "catalog",
                    "SET_BROWSER_TITLE" => "Y",
                    "SET_META_KEYWORDS" => "Y",
                    "SET_META_DESCRIPTION" => "Y",
                    "SET_LAST_MODIFIED" => "N",
                    "STRICT_SECTION_CHECK" => "N",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "SHOW_404" => "N",
                    "MESSAGE_404" => ""
                ),
                false
            );
            ?></div>
    </div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");