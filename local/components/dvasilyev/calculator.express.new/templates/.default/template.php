<?=bitrix_sessid_post()?>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">
<link href="<?= SITE_TEMPLATE_PATH.'/css/select2calc.min.css' ?>" rel="stylesheet" type="text/css" />
<div class="container calc-ebay-container">
    <div class="row">
        <div class="calc-ebay-head col-12">
            <p class="calc-ebay-title">Калькулятор</p>
            <p>Предварительный расчет стоимости доставки из США в Россию</p>
        </div>
    </div>
    <div class="row">
        <div class="calc-ebay-body col-12">
            <div class="row">
                <div class="col-5">Город получателя</div>
                <div class="col-7">
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
                <div class="col-5">Способ доставки</div>
                <div class="col-7">
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
                <div class="col-5">Вес посылки</div>
                <div class="col-7">
                    <div class="row">
                        <div class="col-5 calc-ebay-weight">
                            <!--<span class="calc-ebay-weight-sign">кг</span>-->
                            <input type="text" class="calc-ebay-weight-input js-calc-ebay-weight" />
                        </div>
                        <div class="col-7 calc-ebay-weight">&nbsp;&nbsp;&nbsp;- не более 15 кг</div>
                    </div>
                </div>
            </div>
            <div class="row" style="display: none;">
                <div class="col-5">Дополнительная<br>страховка</div>
                <div class="col-7">
                    <div class="row">
                        <div class="col-1">
                            <input type="checkbox" class="js-calc-ebay-addit-insurance" />
                        </div>
                        <div class="col-11">&nbsp;&nbsp;&nbsp;0.5% от стоимости товара</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5">&nbsp;</div>
                <div class="col-7">
                    <button class="calc-ebay-btn js-calc-ebay-btn">
                        <img src="/local/components/bberry/pop.ups/images/small_calculator.png" alt="Калькулятор">
                        <span>Рассчитать</span>
                    </button>
                </div>
            </div>
            <div class="row calc-ebay-menu-bottom-container calc-ebay-menu-bottom calc-ebay-menu-content">
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
        <div class="calc-ebay-menu-right col-5">
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
    </div>
    <div class="row calc-ebay-result">
        <div class="calc-ebay-body col-12 border-top-none">
            <div class="row">
                <div class="col-6 calc-ebay-ammount-label">Стоимость услуги:</div>
                <div class="col-6 calc-ebay-ammount-container"><span class="calc-ebay-ammount js-calc-ebay-ammount">464.5 Р</span></div>
            </div>
            <div class="row">
                <div class="col-6 calc-ebay-delivery-time-label">Срок доставки:</div>
                <div class="col-6 calc-ebay-delivery-time-container"><span class="calc-ebay-delivery-time js-calc-ebay-delivery-time">25 декабря 2019 <span class="js-calc-ebay-day-qty">(2 дня)</span></span></div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="calc-ebay-weight calc-ebay-promo">
                        <button class="calc-ebay-promo-apply-btn">применить</button>
                        <input type="text" class="calc-ebay-promo-code js-calc-ebay-promo-code" placeholder="Промокод" />
                    </div>
                </div>
                <div class="col-6">
                    <a href="http://test5-lk.boxberry.ru/ebay/" style="text-decoration: none;" target="_blank">
                        <button class="calc-ebay-doc-create-btn js-calc-ebay-doc-create-btn">
                            <img src="<?= $templateFolder . '/images/create-doc-img.png' ?>" alt="Калькулятор">
                            <span>перейти в личный кабинет</span>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row calc-ebay-addit-services">
        <div class="calc-ebay-body col-12 border-top-none">
            <div class="row">
                <div class="col-12 calc-ebay-lbl-services-included">В услугу входит:</div>
            </div>
            <div class="row">
                <div class="col-1"><div class="calc-ebay-jackdaw"></div></div>
                <div class="col-11">
                    <span class="calc-ebay-jackdaw-label">Доставка со склада Boxberry в США в Россию выбранным способом доставки</span>
                </div>
            </div>
            <div class="row">
                <div class="col-1"><div class="calc-ebay-jackdaw"></div></div>
                <div class="col-11">
                    <span class="calc-ebay-jackdaw-label">Фотографирование отправки для проверки корректности заказа</span>
                </div>
            </div>
            <div class="row">
                <div class="col-1"><div class="calc-ebay-jackdaw"></div></div>
                <div class="col-11">
                    <span class="calc-ebay-jackdaw-label">Таможенное оформление</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span class="calc-ebay-note-to-services">* Сумма услуги может измениться после уточнения фактических параметров отправления: адреса, габаритов и т.д.</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span class="calc-ebay-note-to-services">** Срок доставки указан в рабочих днях, без учета дня приема отправления.</span>
                </div>
            </div>
        </div>
    </div>
</div>