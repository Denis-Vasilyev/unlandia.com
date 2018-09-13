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
    <h1>Раскраски</h1>
    <p>Картины для раскрашивания по темам</p>
<!--filter-->
<!--<div class="MasterClassItem__theme">-->
<!--    <span class="Btn">Все</span><span class="Btn">Животные</span><span class="Btn">Космос</span><span class="Btn">Роботы</span>-->
<!--</div>-->

<ul class="PhotoList__list group js-more">
    <? foreach($arResult["ITEMS"] as $arItem): ?>
        <li class="PhotoList__item js-moreElements">
            <a href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" class="PhotoList__link js-openFancyboxColoring">
                <span class="PhotoList__imgCont">
                    <img style="width: 150%" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
                        class="PhotoList__img" />
                </span>
                <span style="height: 33px;" class="PhotoList__title"><?echo $arItem["NAME"]?></span>
            </a>
        </li>
    <? endforeach; ?>
</ul>
<?=$arResult['NAV_STRING']?>


