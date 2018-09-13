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
    <h1>������-������</h1>
    <p>������� ���������� ������ � �����������</p>

<ul class="PhotoList__list group js-more">
<? foreach ($arResult["ITEMS"] as $arItem): ?>
    <li class="PhotoList__item">
        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="PhotoList__link">
            <span class="PhotoList__imgCont js-moreElements">
                <img style="width: 150%" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" class="PhotoList__img">
            </span>
            <span class="PhotoList__title"><?echo $arItem["NAME"]?></span>
        </a>
    </li>
<? endforeach; ?>
</ul>
<?=$arResult['NAV_STRING']?>


