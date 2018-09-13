<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$frame = $this->createFrame()->begin();
$arPhoto = getPhotoUrl($arResult, "x", true);
$bigPhoto = getPhotoUrl($arResult, "xl", true);
$firstPhoto = reset($arPhoto);
$firstBigPhoto = reset($bigPhoto);
?>
<h1><?=changeQuotes($arResult["NAME"])?></h1>
<div class="ProductCard">
	<div class="group">
        <? if (count($arPhoto) > 1): ?>
		<div class="VerticalSlider">        
			<ul class="VerticalSlider__list"><?                
                    foreach ($arPhoto as $key => $photo) {
                        ?><li class="VerticalSlider__item js-switchPreviewImg<?=$key == 0 ? " active" : "" ?>"
                              data-src="<?=$photo?>"
                              data-xl-src="<?=!empty($bigPhoto[$key]) ? $bigPhoto[$key] : ''?>"
                              data-photo-index="<?=$key?>">
                            <img src="<?=$photo?>" alt="" class="VerticalSlider__img"><?
                    }
          ?></ul>
			<div class="VerticalSlider__prev js-VerticalSlider__prev"></div>
			<div class="VerticalSlider__next js-VerticalSlider__next"></div>
		</div>
        <? endif; ?>
		<div class="ProductCard__imgCont js-openProductCardFancybox">
			<img src="<?=$firstPhoto?>" data-xl-src="<?=$firstBigPhoto?>" alt="" class="ProductCard__img js-switchFullImg">
		</div>
		<div class="ProductCard__features">
			<div class="VendorCode">
                <?=GetMessage("ARTICLE")?><span class="VendorCode__code js-copy_text"><?=$arResult["XML_ID"]?></span>
			</div>
			<h4><?=GetMessage("CHARACTERISTIC")?></h4>
			<ul>
                <? foreach ($arResult["PROPERTIES"]["CHARACTERISTIC"]["VALUE"] as $charValue): ?>
				<li><?=$charValue?></li>
                <? endforeach; ?>
			</ul>
			<a href="/info/shop/" class="BtnMain">Где купить</a>
		</div>
	</div>
    <? if (!empty($arResult["DETAIL_TEXT"])) { ?>
    <div class="ProductCard__description">
		<h3><?=changeQuotes(GetMessage("DESCRIPTION"))?></h3>
		<p><?=changeQuotes($arResult["DETAIL_TEXT"])?></p>
	</div>
    <? } elseif (!empty($arResult["PREVIEW_TEXT"])) { ?>
    <div class="ProductCard__description">
        <h3><?=changeQuotes(GetMessage("DESCRIPTION"))?></h3>
		<p><?=changeQuotes($arResult["PREVIEW_TEXT"])?></p>
    </div>
    <? } ?>	
</div>
<?
$frame->end();
if (!empty($arResult["IBLOCK_SECTION_ID"])) {
    global $arFilterAnalogues;
    $arFilterAnalogues = array(
        "!XML_ID" => $arResult["XML_ID"],
    );
    $APPLICATION->IncludeComponent("bitrix:news.list", "slider", array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => IBLOCK_CATALOG,
        "NEWS_COUNT" => "9999",
        "SORT_BY1" => "SORT",
        "SORT_ORDER1" => "ASC",
        "SORT_BY2" => "NAME",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => "arFilterAnalogues",
        "FIELD_CODE" => array(
            0 => "ID",
            1 => "XML_ID",
            2 => "NAME",
            3 => "DATE_CREATE",
        ),
        "PROPERTY_CODE" => array(
            0 => "PHOTO",
        ),
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "3600",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "N",
        "PREVIEW_TRUNCATE_LEN" => "",
        "ACTIVE_DATE_FORMAT" => "d.m.Y",
        "SET_TITLE" => "N",
        "SET_STATUS_404" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "PARENT_SECTION" => $arResult["IBLOCK_SECTION_ID"],
        "PARENT_SECTION_CODE" => "",
        "INCLUDE_SUBSECTIONS" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
        "PAGER_SHOW_ALL" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "AJAX_OPTION_ADDITIONAL" => ""
        ),
        false
    );
}
?>
