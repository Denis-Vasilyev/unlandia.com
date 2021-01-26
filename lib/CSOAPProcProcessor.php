<?php

namespace Neti\Utils;

use SoapClient;
use SoapFault;

/**
 * Класс с функционалом взаимодействия по SOAP
 * Class SOAPProcessor
 * @package Neti\Utils
 */
class SOAPProcessor
{
    protected const WRONG_METHOD_INPUT_DATA = 'Некорректно указаны входные данные метода';
    protected const UNKNOWN_CONNECTION_ERROR = 'Неизвестная ошибка подключения';
    protected const WRONG_AUTHENTICATION_DATA = 'Некорректно указаны данные аутентификации';
    protected const UNKNOWN_METHOD_CALL_ERROR = 'Неизвестная ошибка вызова метода';

    /**
     * токен для аутентификации в вызываемом сервисе
     * @var string
     */
    private $token;

    /**
     * урл WSDL вызываемого сервиса
     * @var string
     */
    private $WSDLURL;

    /**
     * текущий статус коннекта с вызываемым сервисом (true/false)
     * @var bool
     */
    private $connectionStatus;

    /**
     * Объект контекста соединения с вызываемым сервисом
     * @var object
     */
    public  $client;

    /**
     * SOAPProcessor constructor.
     * @param $WSDLURL - урл WSDL вызываемого сервиса
     */
    public function __construct ($WSDLURL)
    {
        ini_set('soap.wsdl_cache_enabled', '0');
        ini_set('default_socket_timeout', '10');

        $this->WSDLURL = trim($WSDLURL);
        $this->connectionStatus = false;
    }

    /**
     * @param string $token - выставляет значение токена для аутентификации в вызываемом сервисе
     */
    public function setToken($token): void
    {
        $this->token = trim($token);
    }

    /**
     * Создает коннекст с вызываемым сервисом
     * @return SOAPProcResponse
     * @throws SoapFault
     */
    public function SOAPInit(): SOAPProcResponse
    {
        if ($this->connectionStatus === true) {
            return $this->createResponse();
        }
        try {
            $this->client = new SoapClient($this->WSDLURL);
            $this->connectionStatus = true;
            return $this->createResponse();
        } catch (Exception $e) {
            $this->connectionStatus = false;
            if ($msg = $e->getMessage()) {
                return $this->createResponse($msg);
            } else {
                return $this->createResponse(self::UNKNOWN_CONNECTION_ERROR);
            }
        }
    }

    /**
     * Осуществляет вызов метода calcParcel
     * @param string $cityCode - код города
     * @param bool $cd: true - КД, false - ПВЗ
     * @param int $weight - вес отправления в граммах
     * @return SOAPProcResponse
     */
    public function callCalcParcel($cityCode, $cd, $weight): SOAPProcResponse
    {
        if(!empty($this->token)) {
            if(empty(trim($cityCode)) || empty(trim($cd)) || empty(trim($weight))) {
                return $this->createResponse(self::WRONG_METHOD_INPUT_DATA);
            }
            $response = $this->client->calcParcel(
                [ 'data' =>
                    [
                        'token' => $this->token,
                        'cityCode' => $cityCode,
                        'cd' => $cd === 'true',
                        //'cd' => false,
                        'weight' => $weight
                    ]
                ]
            );
            if(property_exists($response,'return')) {
                return $this->createResponse($response->return);
            } else {
                return $this->createResponse(self::UNKNOWN_METHOD_CALL_ERROR);
            }
        } else {
            $this->connectionStatus = true;
            return $this->createResponse(self::WRONG_AUTHENTICATION_DATA);
        }
    }

    /**
     * Возвращает объект с данными взаимодействия с сервером по SOAP
     * @param object $data
     * @return SOAPProcResponse
     */
    private function createResponse($data = null) : SOAPProcResponse {
        return new SOAPProcResponse($this->connectionStatus, $data);
    }
}

/**
 * Класс со структурой возвращаемых классом SOAPProcessor данных
 * Class SOAPProcResponse
 * @package Neti\Utils
 */
class SOAPProcResponse
{
    /**
     * текущий статус коннекта с вызываемым сервисом (true/false)
     * @var bool
     */
    public $connect;

    /**
     * сообщение об ошибке, либо объект с возвращенными вызываемым методом данными
     * @var mixed
     */
    public $data;

    /**
     * SOAPProcResponse constructor.
     * @param $connect - теукищий статус коннекта с вызываемым сервисом (true/false)
     * @param $data - сообщение об ошибке, либо объект с возвращенными вызываемым методом данными
     */
    public function __construct($connect,$data)
    {
        $this->connect = $connect;
        $this->data = $data;
    }
}
