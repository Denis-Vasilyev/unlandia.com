<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);

if (!empty($arResult)) { ?>
    <ul class="HeaderMenu__list"><?
        $previousLevel = 1;
        foreach ($arResult as $key => $arItem) {
            $arItem['TEXT'] = htmlspecialchars($arItem["TEXT"], ENT_COMPAT, "cp1251", false);
            $arItem['TEXT'] = changeQuotes($arItem['TEXT']);
            if ($previousLevel == 2 && $arItem["DEPTH_LEVEL"] == 1) {
                ?></ul></li><?
            }
            if ($arItem["DEPTH_LEVEL"] == 1) {
                ?><li class="HeaderMenu__item<?=$arItem["SELECTED"] == 1 ? " HeaderMenu__item--active" : "" ?>"><a href="<?=$arItem["LINK"]?>" class="HeaderMenu__link"><?=
                        $arItem['TEXT']
                    ?></a>
            <?}
            if ($arItem["DEPTH_LEVEL"] == 2 && $previousLevel == 1) {
                ?><ul class="HeaderSubMenu"><?
            }
            if ($arItem["DEPTH_LEVEL"] == 2) {
                ?><li class="HeaderSubMenu__item"><a href="<?=$arItem["LINK"]?>" class="HeaderSubMenu__link"><?=
                        $arItem['TEXT']
                    ?></a></li><?
            }
            if ($key == (count($arResult) - 1) && $arItem["DEPTH_LEVEL"] == 1) {
                ?></li><?
            }
            if ($key == (count($arResult) - 1) && $arItem["DEPTH_LEVEL"] == 2) {
                ?></ul></li><?
            }
            
            $previousLevel = $arItem["DEPTH_LEVEL"] * 1;
        } ?>
    </ul>
<? } ?>
