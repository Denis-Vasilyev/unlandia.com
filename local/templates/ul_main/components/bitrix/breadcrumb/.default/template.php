<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (count($arResult) <= 1) {
    return "";
}

$strReturn = '<div class="Breadcrumbs Page__wrapper" style="padding-bottom: 0;"><ul class="Breadcrumbs__list">';

global $APPLICATION;
$curUri = $APPLICATION->GetCurDir();

for ($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++) {
    $title = changeQuotes(htmlspecialchars($arResult[$index]["TITLE"]));
    $strReturn .= '<li class="Breadcrumbs__item'
        . ($index + 1 == $itemSize ? ' active' : '') . '">';
    if (
        empty($arResult[$index]["LINK"])
        || ($index + 1 == $itemSize && $arResult[$index]["LINK"] == $curUri)
    ) {
        $strReturn .= "<span>" . $title . "</span>";
    } else {
        if($index == 0) {
            $strReturn .= '<a class="Breadcrumbs__link" href="' . $arResult[$index]["LINK"] . '"><img src="/assets/img/svg/home.svg" alt=""></a>';
        } else {
            $strReturn .= '<a class="Breadcrumbs__link" href="' . $arResult[$index]["LINK"] . '">' . $title . '</a>';
        }
        
    }
    $strReturn .= "</li>";
}

$strReturn .= "</ul></div>";

return $strReturn;