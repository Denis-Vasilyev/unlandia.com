<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}?>
<?= !empty($arResult['DETAIL_TEXT']) ? $arResult['DETAIL_TEXT'] : $arResult['PREVIEW_TEXT'] ?>