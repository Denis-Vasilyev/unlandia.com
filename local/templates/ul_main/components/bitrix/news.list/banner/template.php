<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$frame = $this->createFrame()->begin()?>
<div class="SliderBanner ">		
    <h3>Акции и конкурсы</h3>
    <div class="SliderBanner__cont">
        <div class="SliderBanner__wrapper">
            <ul class="SliderBanner__list">
                <?  foreach ($arResult["ITEMS"] as $key => $arItem){
                    ?><li class="SliderBanner__item<?=$key == 0 ? " SliderBanner__item--active" : ""?>" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')">
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="SliderBanner__link">Подробнее</a>
                    </li><?
                } ?>
            </ul>
            <div class="Btn Btn--backward js-prev_slide_banner"></div>
            <div class="Btn Btn--forward js-next_slide_banner"></div>
        </div>
        <ul class="SliderBannerNav__list">
            <?  foreach ($arResult["ITEMS"] as $key => $arItem){
                    ?><li class="SliderBannerNav__item<?=$key == 0 ? " SliderBannerNav__item--active" : ""?>"></li><?
                } ?>
        </ul>
    </div>
</div>
<?$frame->end()?>