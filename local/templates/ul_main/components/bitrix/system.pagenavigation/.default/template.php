<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
?><div class="Pagination">
    <ul class="Pagination__list"><?

$bFirst = true;
if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
    ?><li class="Pagination__item Pagination__item--active"><a class="Pagination__link"><?=$arResult["nStartPage"]?></a></li><?
else:
    ?><li class="Pagination__item"><a href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=1"<?
    ?> class="Pagination__link">1</a></li><?
endif;
if ($arResult["nStartPage"] > 2) {
    echo "<li class='Pagination__item'>&nbsp;...</li>";
}

do
{
    ?><?
    if ($arResult["nStartPage"] === 1) {
        $arResult["nStartPage"]++;
        continue;
    }
    if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
        ?><li class="Pagination__item  Pagination__item--active"><a class="Pagination__link"><?=$arResult["nStartPage"]?></a></li><?
    elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
        ?><li class="Pagination__item"><a href="<?=$arResult["sUrlPath"]?>" class="Pagination__link"><?=$arResult["nStartPage"]?></a></li><?
    else:
        ?><li class="Pagination__item"><a href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"<?
        ?> class="Pagination__link"><?=$arResult["nStartPage"]?></a></li><?
    endif;
    $arResult["nStartPage"]++;
    $bFirst = false;
} while($arResult["nStartPage"] <= $arResult["nEndPage"]);

if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
    ?><li class="Pagination__item">&nbsp;...</li><li class="Pagination__item"><a href="<?=$arResult["sUrlPath"]?>?PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>" class="Pagination__link"><?=$arResult["NavPageCount"]?></a></li><?
endif;
?>
</ul></div>