<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);
if (!empty($arResult["ITEMS"])) { ?>
<h3><?= $APPLICATION->GetCurDir() == "/" ? GetMessage("MAIN_PAGE_TITLE") : GetMessage("PRODUCT_DETAIL_PAGE_TITLE") ?></h3>
<div class="Showcase ">
    <div class="Showcase__cont">
        <ul class="Showcase__list">
        <?
        foreach ($arResult["ITEMS"] as $key => $arItem) {
            $photoUrl = getPhotoUrl($arItem, "l");
        ?>
            <li class="Showcase__item" id="<?= $this->GetEditAreaId($arItem["ID"]) ?>">
                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="Showcase__imgCont"><img class="Showcase__img" src="<?=$photoUrl?>" alt="<?= changeQuotes($arItem["NAME"]) ?>"></a>
                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="Showcase__title" style="height: 120px;"><?= changeQuotes($arItem["NAME"]) ?></a>
            </li>
        <? } ?>
        </ul>
        <? if (count($arResult["ITEMS"]) > 4): ?>
        <div class="Btn Btn--backward js-prev_slide_showcase"></div>
        <div class="Btn Btn--forward js-next_slide_showcase"></div>
        <? endif; ?>
    </div>
</div>
<?}
