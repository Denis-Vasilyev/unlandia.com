<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin("�������� ���������");
?>
<?if($arResult["NavPageCount"] > 1):?>
    <?if ($arResult["NavPageNomer"]+1 <= $arResult["nEndPage"]):?>
        <?
        $plus = $arResult["NavPageNomer"]+1;
        $url = $arResult["sUrlPathParams"] . "PAGEN_1=" . $plus
        ?>

        <div class="More" >
            <span class="Btn js-loadMore" data-url="<?=$url?>">
            �������� ���
                <span class="Btn__spinner"></span>
            </span>
        </div>
    <?endif?>
<?endif?>