<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(false);
if (!empty($arResult)) { ?>
<div class="CatalogMenu">
    <div class="CatalogMenu__header"><?=GetMessage("MENU_TITLE")?></div>
    <div class="CatalogMenu__content">
        <ul class="CatalogMenu__list"><?
                foreach ($arResult as $key => $arItem) {
                    if ($arItem["DEPTH_LEVEL"] > 1) {
                        continue;
                    }
                    ?><li class="CatalogMenu__item"><?
                    ?><a class="CatalogMenu__link<?=$arItem["SELECTED"] == 1 ? " CatalogMenu__link--active" : "" ?>" href="<?=$arItem["LINK"]?>"><?=changeQuotes($arItem["TEXT"])?></a><?
                    ?></li><?
                }
            ?>
        </ul>
    </div>
</div>
<? } ?>
