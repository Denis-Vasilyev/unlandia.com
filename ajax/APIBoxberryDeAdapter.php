<?php

namespace Neti\Utils;

$_SERVER["DOCUMENT_ROOT"] = $_SERVER["DOCUMENT_ROOT"] ?: str_replace('/lib', '', __dir__);
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

class APIBoxberryDeAdapter
{
    protected const API_TOKEN = '***************';
    protected const URL = '***************';
    protected const LOG_DIR = '/log/';
    protected const CASH_KEY = 'APIBoxberryDeAdapter';
    protected const CASH_TIME_LIMIT = 30; //время актуальности кэша в секундах

    protected const UNKNOWN_API_ERROR_TEXT = 'Внутренняя ошибка API.';
    protected const EMPTY_API_METHOD = 'Не указан API-метод.';
    protected const API_METHOD_DATA_NOT_FOUND = 'Данные API-метода не найдены.';
    protected const API_METHOD_NOT_FOUND = 'API-метод не найден.';
    protected const POINTS_DESCRIPTION_SCHEDULE_ERROR = 'Ошибка получения графика работы ПВЗ';

    public function callPointsDescription($code = "", $photo = 0, $no_cache = 1) {
        $code = trim($code);
        $method = 'PointsDescription';
        $cache = \Bitrix\Main\Data\Cache::createInstance();
        $cacheKey = self::CASH_KEY . '_' . $method . '_' . $code;
        if ($cache->initCache(self::CASH_TIME_LIMIT, $cacheKey)) { // проверяем кеш и задаём настройки
            return json_encode($cache->getVars()); // достаем переменные из кеша
        }
        $data = array('code' => $code, 'photo' => $photo , 'no_cache' => $no_cache);
        $result = $this->processApiResponse(
            $this->fileGetCurlContents(
                $this->buildAPIRequestQuery($method, $data)
            )
        );
        if (is_array($result)) {
            $cache->startDataCache();
            $cache->endDataCache(array($cacheKey => $result)); // записываем в кеш
            return json_encode($result);
        }
        return $result;
    }

    public function callPointsDescriptionOnlySched($code = "", $no_cache = 1) {
        $code = trim($code);
        $method = 'PointsDescription';
        $cache = \Bitrix\Main\Data\Cache::createInstance();
        $cacheKey = self::CASH_KEY . '_' . $method . 'OnlySched_' . $code;
        if ($cache->initCache(self::CASH_TIME_LIMIT, $cacheKey)) { // проверяем кеш и задаём настройки
            return json_encode($cache->getVars()[$cacheKey]); // достаем переменные из кеша
        }
        $data = array('code' => $code, 'photo' => 0 , 'no_cache' => $no_cache);
        $result = $this->processApiResponse(
            $this->fileGetCurlContents(
                $this->buildAPIRequestQuery($method, $data)
            )
        );
        if (is_array($result)) {
                $schedule = json_decode($result["schedule"],true);
                if (is_array($schedule)) {
                    $cache->startDataCache();
                    $cache->endDataCache(array($cacheKey => $schedule)); // записываем в кеш
                    return json_encode($schedule);
                }
            return self::POINTS_DESCRIPTION_SCHEDULE_ERROR;
        }
        return $result;
    }

    public function fileGetCurlContents($url) {
        $timeout = 3;
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_LOW_SPEED_TIME, $timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curlResult = curl_exec($curl);

        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
            return false;
        } else {
            return $curlResult;
        }
    }

    private function processApiResponse($response = null) {
        $response = json_decode($response,true);
        if (is_array($response)) {
            if (isset($response[0]['err'])) {
                return $response[0]['err'];
            } else {
                return $response;
            }
        }
        return self::UNKNOWN_API_ERROR_TEXT;
    }

    private function buildAPIRequestQuery($method, $queryData) {
        $queryData['token'] = self::API_TOKEN;
        $queryData['method'] = $method;
        return self::URL . '?' . http_build_query($queryData);
    }

    public function processInputHTTPQuery($query) {
        if (empty($query['method'])) return self::EMPTY_API_METHOD;
        $method = trim($query['method']);
        switch ($method) {
            case 'PointsDescription':
                $code = empty($query['code']) ?: trim($query['code']);
                $photo = empty($query['photo']) ?: trim($query['photo']);
                $no_cache = empty($query['no_cache']) ?: trim($query['no_cache']);
                if (empty($code)) {
                    return self::API_METHOD_DATA_NOT_FOUND;
                }
                return $this->callPointsDescription($code,$photo,$no_cache);
                break;
            case 'PointsDescriptionOnlySched':
                $code = empty($query['code']) ?: trim($query['code']);
                $no_cache = empty($query['no_cache']) ?: trim($query['no_cache']);
                if (empty($code)) {
                    return self::API_METHOD_DATA_NOT_FOUND;
                }
                return $this->callPointsDescriptionOnlySched($code, $no_cache);
                break;
            default: return self::API_METHOD_NOT_FOUND;
        }
    }

    public static function writeLogRecord($file_name, $mess) {
        $srcFile = $_SERVER["DOCUMENT_ROOT"] . self::LOG_DIR . $file_name;
        chmod($srcFile, 0777);
        file_put_contents($srcFile, date('Y-m-d H:i:s') . " " . $mess . PHP_EOL, FILE_APPEND);
    }
}

$abda = new APIBoxberryDeAdapter();

echo $abda->processInputHTTPQuery($_REQUEST);