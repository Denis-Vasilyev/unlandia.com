<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
$this->setFrameMode(true);

if (!empty($arResult)) { ?>
    <ul class="FooterMenu__list"><?
        foreach ($arResult as $arItem) {
            ?><li class="FooterMenu__item"><a href="<?=$arItem["LINK"]?>" class="FooterMenu__link"><?=
                htmlspecialchars($arItem["TEXT"], ENT_COMPAT, "cp1251")
            ?></a></li>
            <?
        } ?>
    </ul>
<? } ?>
