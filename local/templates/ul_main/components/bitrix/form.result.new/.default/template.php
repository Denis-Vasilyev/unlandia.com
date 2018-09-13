<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<h1><?=$arResult['FORM_TITLE']?></h1>
<div class="Feedback">
    <?=str_replace('<form', '<form class="Form Form--feedback" ',$arResult['FORM_HEADER']);?>
    <div class="Form__set Form__set--fields">
        <? foreach ($arResult['QUESTIONS'] as $fieldSID => $arQuestion) {
            if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
                echo $arQuestion["HTML_CODE"];
            } else {
                $error = false;
                $strError = '';
                if (is_array($arResult["FORM_ERRORS"])
                    && array_key_exists($fieldSID, $arResult['FORM_ERRORS'])
                ) {
                    $error = true;
                    if (strpos($arResult['FORM_ERRORS'][$fieldSID], '��������') !== false) {
                        $strError = '��������� ���� ';
                    } else {
                        $strError = $arResult['FORM_ERRORS'][$fieldSID];
                    }
                }
                switch ($fieldSID) {
                    case 'interest':
                        $selValue = 0;
                        if (isset($_REQUEST['form_dropdown_interest'])) {
                            $selValue = intval($_REQUEST['form_dropdown_interest']);
                        }
                        $findHeadSelect = strpos($arQuestion['HTML_CODE'], '<option');
                        $headSelect = substr($arQuestion['HTML_CODE'], 0, $findHeadSelect);
                        $headSelect = str_replace('class="inputselect"',
                            ' data-placeholder="���������� ������� �������" class="Select__select" ',
                            $headSelect);
                        ?>
                        <div class="Form__field Form__field--interest <?=!empty($error) ? 'error' : ''?>">
                            <span class="Form__title">
                                <label for="id0" class="Form__label"><?=$arQuestion['CAPTION']?></label>
                            </span>
                            <div class="Select">
                                <label class="Select__label">
                                    <? $valueSelect = '���������� ������� �������';
                                    if (!empty($headSelect)) {
                                        echo $headSelect;
                                    } else {
                                    ?><select data-placeholder="���������� ������� �������" class="Select__select"><?
                                        }
                                        ?><option value="" <?=($selValue == 0) ? 'selected="selected"' : '' ?> disabled="disabled"><?=$valueSelect?></option><?
                                        foreach ($arQuestion['STRUCTURE'] as $key => $item) {
                                            $selected = '';
                                            if ($selValue != 0
                                                && $item['ID'] == $selValue
                                            ) {
                                                $selected = 'selected="selected"';
                                                $valueSelect = $item['MESSAGE'];
                                            }
                                            ?><option value="<?=$item['ID']?>" <?=$selected?>><?=$item['MESSAGE']?></option><?
                                        }
                                        ?></select>
                                    <span class="Select__text Field"><?=$valueSelect?></span>
                                </label>
                            </div>
                            <? if (!empty($error)): ?>
                            <div class="Form__error"><?=$strError?></div>
                            <? endif; ?>
                        </div><?
                        break;
                    case 'name':
                    case 'mail':
                    case 'phone':
                    case 'city':
                    case 'message':
                        ?>
                        <div class="Form__field Form__field--<?=$fieldSID?> <?=!empty($error) ? 'error' : ''?>">
                            <span class="Form__title">
                                <label for="<?=$fieldSID?>" class="Form__label"><?=$arQuestion['CAPTION']?></label>
                            </span><?=$arQuestion['HTML_CODE']?>
                            <? if (!empty($error)): ?>
                            <div class="Form__error"><?=$strError?></div>
                            <? endif; ?>
                        </div><?
                        break;
                    case 'agree':
                        ?>
                        <div class="Form__field Form__field--policy">
                        <span class="Form__title"></span><div class="Checkbox ">
                            <?=substr($arQuestion['HTML_CODE'], 0, strpos($arQuestion['HTML_CODE'], '<label'));?>
                            <label class="Checkbox__label" for="<?=$arQuestion['STRUCTURE'][0]['ID']?>">
                                <span class="Checkbox__button"></span>
                                <span class="Checkbox__text">
                                    ������� ������ �����������, � ����������� ���� �������������� �
                                    <a class="js-personalDataAgree" href="#">��� ��������</a>
                                    �� ��������� ������������ ������ � ������������ �
                                    <a class="js-personalDataPolicy" target="_blank" href="https://www.samsonopt.ru/privacy_policy.php">��������� ��������.</a>
                                </span>
                            </label>
                            <?
                            if ($error) {
                                ?><span class="Form__error">����� �� ����� ���� ���������� ��� ��������� ������ �������� �� ��������� ����� ������������ ������ � ������������ � �.1 ������ 6 ������������ ������ �152-�� �� ������������ �������.</span><?
                            }
                            ?>
                        </div>
                        </div><?
                        if (!empty($arResult['arForm']['DESCRIPTION'])) {
                            ?><div class="js-agreement" style="display: none">
                            <?=$arResult['arForm']['DESCRIPTION']?>
                            </div><?
                        }
                        break;
                }
            }
        } ?>
    </div>
    <div class="Form__set Form__set--submit">
        <button class="BtnMain Form__submit" type="submit" name="web_form_submit" value="<?=$arResult['arForm']['BUTTON']?>"><?=$arResult['arForm']['BUTTON']?></button>
    </div>
    <?=$arResult['FORM_FOOTER']?>
    <div class="Feedback__unlandiaHero Hero">
        <div class="CloudsQuote Hero__quote">
            <div class="CloudsQuote__line">���������</div>
            �������
        </div>
    </div>
</div>
<? if (isset($_SESSION['SUCCESS_FEEDBACK']) && empty($arResult["FORM_ERRORS"])): ?>
<div class="js-formResultOk" style="display: none;">
    <div class="Fancybox__wrapper Fancybox__wrapper--heightAuto">
        <h2>������ ���������</h2>

        <div class="Message Message--default Message--wideText Message--success">
            <div class="Message__title">
                ���! ���� ��������� ������� ����������
            </div>
            <div class="Message__text">
                � ��������� ����� � ���� �������� ��� ���������.<br>
                ��������� �� ������� �������� ��� �������������� ����������.
            </div>
        </div>

        <div class="Fancybox__btnCont Fancybox__btnCont--noBG">
            <div class="BtnMain js-fancyboxClose">������</div>
        </div>
    </div>
</div>
<? unset($_SESSION['SUCCESS_FEEDBACK']); ?>
<? endif; ?>
<? if (isset($_SESSION['ERROR_FEEDBACK'])): ?>
<div class="js-formResultError" style="display: none;">
    <div class="Fancybox__wrapper Fancybox__wrapper--heightAuto">
        <h2>������ ���������</h2>

        <div class="Message Message--default Message--fail">
            <div class="Message__title">
                ���� ��������� �� ����������
            </div>
            <div class="Message__text">
                ���������� ��� ���. ��������� �&nbsp;<a href="/feedback/">�������� �����</a>
                ���&nbsp;�������������� ����������.
            </div>
        </div>

        <div class="Fancybox__btnCont Fancybox__btnCont--noBG">
            <div class="BtnMain js-fancyboxClose">������</div>
        </div>
    </div>
</div>
<? unset($_SESSION['ERROR_FEEDBACK']); ?>
<? endif; ?>
