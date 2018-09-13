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
$this->setFrameMode(true);
?>
<h1><?=$arResult["NAME"]?></h1>
<div class="MasterClassItem__imgWrapper"><img src="<?=$arResult["DETAIL_PICTURE"]['SRC']?>"></div>
<p><? echo $arResult["DETAIL_TEXT"]; ?></p>
<?
     foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
     <? if ($pid == 'MATERIALS'): ?>
         <h3><?=$arProperty['NAME']; ?></h3>
         <ul>
        <? foreach ($arProperty["DISPLAY_VALUE"] as  $value): ?>
            <li><?=$value;?></li>
        <? endforeach; ?>
         </ul>
    <? endif ?>
    <? if ($pid == 'PHOTO_MATERIALS'): ?>
        <div class="MasterClassItem__imgWrapper">
            <img src="<?=$arProperty['FILE_VALUE']['SRC']?>">
        </div>
    <? endif ?>
    <? if ($pid == 'PHOTO_ETAP'): ?>
        <ul class="MasterClassItem__list group">
        <? foreach ($arProperty['FILE_VALUE'] as  $count => $value): ?>
            <li class="MasterClassItem__item">
                <div class="MasterClassItem__imgCont" >
                    <img class="MasterClassItem__img" src="<?=$value['SRC']?>">
                    <div class="MasterClassItem__itemNumber"><?=$count + 1?></div>
                </div>
                <div class="MasterClassItem__title" style="height: 81px;"><?=$value['DESCRIPTION']?></div>
            </li>

        <? endforeach; ?>
        </ul>
    <? endif ?>
<? endforeach; ?>




