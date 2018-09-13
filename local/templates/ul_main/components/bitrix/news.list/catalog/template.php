<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$frame = $this->createFrame()->begin();

?><div class="Catalog">
    <ul class="Catalog__list"><?
        ?><? foreach($arResult["ITEMS"] as $arItem): ?><?
                $photoUrl = getPhotoUrl($arItem, "l");
                    ?><li class="Catalog__item">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="Catalog__link">
                            <span class="Catalog__imgCont">
                                <img src="<?=$photoUrl?>" alt="<?=changeQuotes($arItem["NAME"])?>" class="Catalog__img">
                            </span>
                            <span class="Catalog__title"><?=changeQuotes($arItem["NAME"])?></span>
                        </a>
                    </li><?
        ?><? endforeach; ?></ul>
        <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
            <?=$arResult["NAV_STRING"]?>
        <?endif;?>
</div><?php
$frame->end()?>

