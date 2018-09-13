<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}
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

?>
<h1><? if ($arParams["SET_TITLE"] == "Y") {
        $APPLICATION->ShowTitle();
    } ?></h1>
<p>Эксклюзивным представителем в Российской Федерации является группа компаний «Самсон».<br>
    Для оптовых закупок, обращайтесь в ближайшее подразделение ГК «Самсон», из приведенного ниже списка.</p>
<div class="Tab__wrapper">
    <? if (count($arResult["SECTIONS"]) > 1): ?>
    <ul class="Tab__list"><?
        $firstSectionFlag = true;
        foreach ($arResult["SECTIONS"] as $arSection) {
            ?><li class="Tab__item<?= $firstSectionFlag ? " Tab__item--active" : "" ?>">
            <a class="Tab__text" href="#<?=$arSection["CODE"]?>"><?= $arSection["NAME"] ?></a>
            </li><?
            $firstSectionFlag = false;
        }
        ?></ul>
    <? endif; ?>
    <?  $firstSectionFlag = true;
    foreach ($arResult["SECTIONS"] as $arSection) { ?>
        <div class="Tab__content<?= $firstSectionFlag ? " Tab__content--active" : "" ?>" id="<?=$arSection["CODE"]?>">
            <table class="WhereBuy__table">
                <thead>
                <tr>
                    <th>Город</th>
                    <th>Адрес</th>
                    <th>Электронная почта</th>
                    <th>Телефон/факс</th>
                </tr>
                </thead>
                <tbody><?
                foreach ($arSection["ELEMENTS"] as $city => $arElements) {
                    $firstInCityFlag = true;
                    foreach ($arElements as $arElement) { ?>
                        <tr>
                            <? if ($firstInCityFlag) {
                                $firstInCityFlag = false; ?>
                                <td rowspan="<?= sizeof($arElements) ?>">
                                    <strong><?= $city ?></strong>
                                </td>
                            <? } ?>
                            <td><span><?=$arElement["ADDRESS"]?></span></td>
                            <td><a href="mailto:<?=$arElement["EMAIL"]?>"><?=$arElement["EMAIL"]?></a></td>
                            <td style="white-space: nowrap;"><?=implode("<br/>", $arElement["PHONE"])?></td>
                        </tr>
                    <? } ?>
                <? } ?>
                </tbody>
            </table>
        </div>
        <? $firstSectionFlag = false;
    } ?>
</div>
