<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/lib/CSOAPProcProcessor.php');

use \Bitrix\Main\Loader;
use \Bitrix\Main\Engine\Contract\Controllerable;
use \Bitrix\Main\Data\Cache;
use \Neti\Utils\SOAPProcessor;

class CEbayCalculator extends CBitrixComponent implements Controllerable
{
    protected const LK_BOXBERRY_RU_EBAY_WSDL = '***********';
    protected const LK_BOXBERRY_RU_EBAY_TOKEN = '***********';
    protected const CBR_RU_SCRIPTS_XML_DAILY_ASP = '***********';
    protected const CBR_RU_SCRIPTS_XML_DAILY_ASP_CASHE_TIME = 84600;

    public function executeComponent()
    {
        $this->arResult['DeliveryLaP'] = $this->getCitiesListTo();
        $this->includeComponentTemplate();
    }

    // Обязательный метод
    public function configureActions()
    {
        // Сбрасываем фильтры по-умолчанию (ActionFilter\Authentication и ActionFilter\HttpMethod)
        // Предустановленные фильтры находятся в папке /bitrix/modules/main/lib/engine/actionfilter/
        return [
            'calcParcel' => [ // Ajax-метод
                'prefilters' => [],
            ],
        ];
    }

    // Ajax-методы должны быть с постфиксом Action
    public function calcParcelAction($cityCode, $deliveryType, $parselWeight, $additInsurance)
    {
        $sp = new SOAPProcessor($this::LK_BOXBERRY_RU_EBAY_WSDL);
        $spi = $sp->SOAPInit();

        if($spi->connect) {
            $sp->setToken(self::LK_BOXBERRY_RU_EBAY_TOKEN);
            $data = $sp->callCalcParcel($cityCode, $deliveryType, $parselWeight);
            $data->data->cost_usd = round($data->data->costUsd * 0.01, 2);
            /*$cachedRate = $this->getCurrentExchangeRate('USD');*/
            $data->data->cost_ru = round($data->data->costRub * 0.01,2);
            return ['data' => $data->data];
        }
        return null;
    }

    public function getCurrentExchangeRate($valuteCode = 'USD') {
        $cache = Cache::createInstance(); // получаем экземпляр класса
        if ($cache->initCache($this::CBR_RU_SCRIPTS_XML_DAILY_ASP_CASHE_TIME, 'cache_exchange_rate_ebay')) {
            $currencies = $cache->getVars()['exchange_rate_ebay'];
        }
        elseif ($cache->startDataCache()) {
            $xml = simplexml_load_string(file_get_contents($this::CBR_RU_SCRIPTS_XML_DAILY_ASP));
            $currencies = array();
            foreach ($xml->xpath('//Valute') as $valute) {
                $currencies[(string)$valute->CharCode] = (float)str_replace(',', '.', $valute->Value);
            }
            $cache->endDataCache(array('exchange_rate_ebay' => $currencies));
        }
        if (isset($currencies[trim($valuteCode)])) {
            return $currencies[$valuteCode];
        } else {
            return $currencies;
        }
    }

    private function getCitiesListTo()
    {
        if (Loader::includeModule('iblock')) {

            $arSort = ['NAME' => 'ASC'];
            $arSelect = ['ID', 'NAME', 'PROPERTY_CityCode', 'PROPERTY_UniqName',
                'PROPERTY_MAX_WEIGHT', 'PROPERTY_MAX_VOLUME', 'CODE'];

            //Город получателя ПиП DeliveryLaP
            $arFilterDeliveryLAP = [
                'IBLOCK_ID' => 1,
                'ACTIVE' => 'Y',
                'PROPERTY_COUNTRYCODE' => 643
            ];

            $arFilterDeliveryLAP[] = [
                'LOGIC' => 'OR',
                array('=PROPERTY_DeliveryLaP' => 1),
                array('=PROPERTY_CourierDelivery' => 1),
            ];

            $rsIBlockElement = CIBlockElement::GetList($arSort, $arFilterDeliveryLAP, false, false, $arSelect);

            $result = null;

            while ($el = $rsIBlockElement->GetNext()) {
                $result[$el['PROPERTY_UNIQNAME_VALUE']] = [
                    'code' => $el['PROPERTY_CITYCODE_VALUE'],
                    'name' => $el['NAME'],
                ];
            }

            return $result;
        }
    }

    private function getCitiesListFrom()
    {
        if (Loader::includeModule('iblock')) {

            $arSort = ['NAME' => 'ASC'];
            $arSelect = ['ID', 'NAME', 'PROPERTY_CityCode', 'PROPERTY_UniqName',
                'PROPERTY_MAX_WEIGHT', 'PROPERTY_MAX_VOLUME', 'CODE'];

            //Калькулятор ПиП
            //Город отправителя ПиП ReceptionLaP
            $arFilter = [
                'IBLOCK_ID' => 1,
                'ACTIVE' => 'Y',
                'PROPERTY_COUNTRYCODE' => 643,
                'PROPERTY_RECEPTIONLAP' => 1
            ];

            $rsIBlockElement = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);

            $result = null;

            while ($el = $rsIBlockElement->GetNext()) {
                $result[$el['PROPERTY_UNIQNAME_VALUE']] = [
                    'code' => $el['PROPERTY_CITYCODE_VALUE'],
                    'name' => $el['NAME'],
                    'sef_code' => CUtil::translit(
                        $el["PROPERTY_UNIQNAME_VALUE"],
                        'ru',
                        ["replace_space" => "_", "replace_other" => "_"]
                    )
                ];
            }

            return $result;
        }
    }
}