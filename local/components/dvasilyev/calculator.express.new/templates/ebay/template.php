<?=bitrix_sessid_post()?>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">
<link href="<?= SITE_TEMPLATE_PATH.'/css/select2calc.min.css' ?>" rel="stylesheet" type="text/css" />
<div class="container calc-ebay-container">
    <div class="row">
        <div class="calc-ebay-head col-12">
            <p class="calc-ebay-title">Калькулятор</p>
            <p class="calc-ebay-title2">Расчитать стоимость доставки</p>
        </div>
    </div>
    <div class="row">
        <div class="calc-ebay-body col-12">
            <div class="row">
                <div class="col-4">Город получателя</div>
                <div class="col-8">
                    <select class="with_search js-to-ebay select2-hidden-accessible" style="min-width: calc(100% - 30px);">
                        <option value="0">Город получателя</option>
                        <? if (isset($arResult['DeliveryLaP']) && is_array($arResult['DeliveryLaP'])) { ?>
                            <? foreach ($arResult['DeliveryLaP'] as $city_name=> $city_code) { ?>
                                <option value="<?=$city_code['code'];?>" data-simplename="<?=$city_code['name'];?>" ><?=$city_name;?></option>
                            <? } ?>
                        <? } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-4">Способ доставки</div>
                <div class="col-8">
                    <div class="row" style="margin-left: 0; margin-right: 0;">
                        <div class="col-6" style="padding: 0">
                            <button class="calc-ebay-button js-calc-ebay-button" type="button" data-val="door">До двери</button>
                        </div>
                        <div class="col-6" style="padding: 0">
                            <button class="calc-ebay-button js-calc-ebay-button active" type="button" data-val="office">До отделения</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">Вес посылки</div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-5 calc-ebay-weight">
                            <span class="calc-ebay-weight-sign">кг</span>
                            <input type="text" class="calc-ebay-weight-input js-calc-ebay-weight" />
                            <div class="weight-error-label">Вес должен быть не более 15 кг.</div>
                        </div>
                        <div class="col-7 calc-ebay-weight">&nbsp;&nbsp;&nbsp;- не более 15 кг</div>
                    </div>
                </div>
            </div>
            <div class="row" style="display: none;">
                <div class="col-4">Дополнительная<br>страховка</div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-1">
                            <input type="checkbox" class="js-calc-ebay-addit-insurance" />
                        </div>
                        <div class="col-11">&nbsp;&nbsp;&nbsp;0.5% от стоимости товара</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">&nbsp;</div>
                <div class="col-8" style="text-align: center">
                    <button class="calc-ebay-btn js-calc-ebay-btn">
                        <img src="/local/components/bberry/pop.ups/images/small_calculator.png" alt="Калькулятор">
                        <span>Рассчитать</span>
                    </button>
                    <img class="ebay-load-gif" src="<?= $templateFolder . '/images/ajload.gif' ?>" alt="">
                    <div class="ajax-error-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row calc-ebay-result">
        <div class="col-4"></div>
        <div class="col-8">
            <div class="container">
                <div class="row">
                    <div class="col-5 calc-ebay-ammount-label">Стоимость доставки:</div>
                    <div class="col-3 calc-ebay-ammount-container"><span class="calc-ebay-ammount-usd js-calc-ebay-ammount-usd">7.28 $</span></div>
                    <div class="col-4 calc-ebay-ammount-container"><span class="calc-ebay-ammount-ru js-calc-ebay-ammount-ru">464.5 ₽</span><br><span class="calc-ebay-ammount-ru-sign">(по курсу ЦБ РФ)</span></div>
                </div>
                <div class="row" style="margin-top: 10px;">
                    <div class="col-5 calc-ebay-delivery-time-label">Доставка:</div>
                    <div class="col-7 calc-ebay-delivery-time-container"><span class="calc-ebay-delivery-time js-calc-ebay-delivery-time">От склада в США до отделения</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container calc-ebay-link-list">
    <div class="row">
        <div class="col-1">&nbsp;</div>
        <div class="col-11">
            <div class="row calc-ebay-menu-content">
                <div class="col-3">
                    <img src="<?= $templateFolder . '/images/calc_question.png' ?>" alt="Знак вопроса" height="42" width="42">
                </div>
                <div class="col-9">
                    <a href="#" class="calc-ebay-menu-item">О доставке с eBay</a><br>
                    <a href="#" class="calc-ebay-menu-item">Об ограничениях веса</a><br>
                    <a href="#" class="calc-ebay-menu-item">О дополнительных услугах</a><br>
                    <a href="#" class="calc-ebay-menu-item">Как это работает?</a>
                </div>
            </div>
        </div>
    </div>
</div>