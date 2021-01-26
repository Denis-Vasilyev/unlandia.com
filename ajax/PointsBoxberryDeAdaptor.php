<?php
namespace Neti\Utils;

class PointsBoxberryDeAdaptor
{
    protected const API_TOKEN = '*******************';
    protected const YMAPS_API_TOKEN = '*******************';
    protected const URL = '*******************';
    protected const YMAPS_URL = 'https://geocode-maps.yandex.ru';
    protected const YMAPS_VERSION_1X = '1.x';
    protected const LOG_DIR = '/log/';
    protected const CASH_DIR = '/bitrix/cache/PointsBoxberryDeAdaptor/';
    protected const CASH_HRS_TIME_LIMIT = 1; //время актуальности кэша в часах

    protected const UNKNOWN_API_ERROR_TEXT = 'Внутренняя ошибка API.';
    protected const API_METHOD_NOT_FOUND = 'API-метод не найден.';
    protected const EMPTY_API_METHOD = 'Не указан API-метод.';
    protected const API_METHOD_DATA_NOT_FOUND = 'Данные API-метода не найдены.';
    protected const YMAPS_DATA_NOT_FOUND = 'Яндекс геокодер не вернул координат.';

    public function getCityCoordsByName($name, $useCache = true)
    {
        $cacheFileName = strtolower($name);
        $method = 'cityCoords';
        $data = array('city' => $name);
        $jsonEncResult = null;
        if ($useCache) {
            $jsonEncResult = self::getCache($cacheFileName, $method);
        }
        if (!$jsonEncResult) {
            $query = $this->buildAPIRequestQuery($method, $data);
            $jsonResult = $this->fileGetCurlContents($query);
            $decResult = json_decode($jsonResult,true);
            $procResult = $this->processApiResponse($decResult);
            if (!is_array($procResult)) {
                $ymData = array('geocode' => $name, 'format' => 'json');
                $ymQuery = $this->buildYMAPSApiRequestQuery(self::YMAPS_VERSION_1X, $ymData);
                $ymJsonResult = $this->fileGetCurlContents($ymQuery);
                $ymDecResult = json_decode($ymJsonResult,true);
                $ymProcResult = $this->processYMAPSApiResponse($ymDecResult);
                $jsonEncResult = is_array($ymProcResult) ? json_encode($ymProcResult) : $ymProcResult;
            } else {
                $jsonEncResult = json_encode($procResult);
            }
        }
        if ($useCache) {
            $this->setCache($cacheFileName, $jsonEncResult, $method);
        }
        return $jsonEncResult;
    }

    public function fileGetCurlContents($url)
    {
        $timeout = 3;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_LOW_SPEED_TIME, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $curlResult = curl_exec($ch);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            return false;
        } else {
            return $curlResult;
        }
    }

    public function processInputHTTPQuery($query)
    {
        if (empty($query['method'])) {
            return self::EMPTY_API_METHOD;
        }

        $method = trim($query['method']);
        $useCache = true;

        if (isset($query['useCache'])) {
            $useCache = (bool)(int)$query['useCache'];
        }

        switch ($method) {
            case 'cityCoords':
                if (empty($query['name'])) {
                    return self::API_METHOD_DATA_NOT_FOUND;
                }
                //$query['name'] = 'ываывз';
                return $this->getCityCoordsByName($query['name'], $useCache);
                break;
            default:
                return self::API_METHOD_NOT_FOUND;
        }
    }

    private function processApiResponse($response)
    {
        if (!is_array($response)) {
            return (string)$response;
        } else if (!empty($response['error'])) {
            if (empty($response['message'])) {
                return self::UNKNOWN_API_ERROR_TEXT;
            } else {
                return (string)$response['message'];
            }
        } else if (empty($response['message'])) {
            return self::UNKNOWN_API_ERROR_TEXT;
        } else {
            return $response['message'];
        }
    }

    private function processYMAPSApiResponse($response)
    {
        if (!is_array($response)) {
            return (string)$response;
        } elseif ( isset($response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']) ) {
            $coordArr = explode(' ',
                $response['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos']
            );
            return array_reverse($coordArr);
        } else {
            return self::YMAPS_DATA_NOT_FOUND;
        }
    }

    private function buildAPIRequestQuery($method, $queryData)
    {
        $queryData['token'] = self::API_TOKEN;
        return self::URL . '/' . $method . '/?' . http_build_query($queryData);
    }

    private function buildYMAPSApiRequestQuery($version, $queryData)
    {
        $queryData['apikey'] = self::YMAPS_API_TOKEN;
        return self::YMAPS_URL . '/' . $version . '/?' . http_build_query($queryData);
    }

    public static function writeLogRecord($file_name, $mess)
    {
        $srcFile = $_SERVER["DOCUMENT_ROOT"] . self::LOG_DIR . $file_name;
        chmod($srcFile, 0777);
        file_put_contents($srcFile, date('Y-m-d H:i:s') . " " . $mess, FILE_APPEND);
    }

    private function getCache($cacheFileName, $method = null)
    {
        $fullCacheFileName = $cacheFileName . '.cache';
        $dir = trim($method)
            ? $_SERVER['DOCUMENT_ROOT'] . self::CASH_DIR . $method . '/'
            : $_SERVER['DOCUMENT_ROOT'] . self::CASH_DIR . '/';
        $cacheSrc = $dir . $fullCacheFileName;
        if (is_file($cacheSrc)
            && (filemtime($cacheSrc) >= (time() - (3600 * self::CASH_HRS_TIME_LIMIT)))
            && self::CASH_HRS_TIME_LIMIT) {
            return @file_get_contents($cacheSrc);
        }
        return false;
    }

    private function setCache($cacheFileName, $data, $method = null)
    {
        $dir = trim($method)
            ? $_SERVER['DOCUMENT_ROOT'] . self::CASH_DIR . $method . '/'
            : $_SERVER['DOCUMENT_ROOT'] . self::CASH_DIR . '/';

        if (!is_dir($dir)) {
            if (mkdir($dir, 0777, true) && !is_dir($dir)) {
                return false;
                //throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }
            chmod($dir, 0777);
        }

        $fullCacheFileName = $cacheFileName . '.cache';
        $cacheSrc = $dir . $fullCacheFileName;

        return file_put_contents($cacheSrc, $data, LOCK_EX);
    }
}

$pbde = new PointsBoxberryDeAdaptor();
$trimmedRequest = array_map('trim', $_REQUEST);
echo $pbde->processInputHTTPQuery($trimmedRequest);