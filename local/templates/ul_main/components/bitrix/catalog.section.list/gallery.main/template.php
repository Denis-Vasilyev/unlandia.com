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
<div class="Section group">
<?foreach($arResult['SECTIONS'] as $arItem):?>
        <div class="Section__column">
            <div class="Section__imgCont">
                <img src="<?=$arItem["PICTURE"]["SRC"]?>" class="Section__img"/>
            </div>
                <div class="Section__title" style="height: 60px">
                    <a href="<?=$arItem["SECTION_PAGE_URL"]?>" >
                        <?= $arItem['NAME']; ?>
                    </a>
                </div>
            <div class="Section__description" style="height: 135px;"><?=$arItem['DESCRIPTION']; ?></div>
        </div>
<?endforeach;?>
</div>