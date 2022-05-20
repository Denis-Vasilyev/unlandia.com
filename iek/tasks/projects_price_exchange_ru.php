<?php

if (PHP_SAPI !== 'cli') {
    die('Access denied'); // только по расписанию из CLI
}

$_SERVER['DOCUMENT_ROOT'] = empty($_SERVER['DOCUMENT_ROOT']) ? dirname(__DIR__) : $_SERVER['DOCUMENT_ROOT'];

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$go = getopt('', ['use_debug_file::', 'data_from_file::']);

//example: --use_debug_file=1
$useDebugFile = isset($go['use_debug_file']) && (int)$go['use_debug_file'];

//example: --data_from_file=1
$dataFromFile = isset($go['data_from_file']) && (int)$go['data_from_file'];

$ppe = new CProjectPriceExchange(null, $useDebugFile, $dataFromFile);

$ppe->updatePrice();

class CProjectPriceExchange
{
    private $db;
    private $host = '*****.***.*****';
    private $dbName = 'GOBER';
    private $version = '7.2';
    private $charSet = 'utf8';
    private $userName = '*****';
    private $password = '*****';

    private $documentRoot;


    private $iBlockId = 34;
    private $rootSectionId = null; //на данный момент не предусмотрена работа с $rootSectionId отличным от null

    private $currentSectionList = [];
    private $currentItemList = [];

    private $sectionSeparatorForHash = '<~|~>';

    private $useDebugFile;
    private $debugOutFile = '/debug.log';
    private $dataFromDebugFile;
    private $jsonDataFile = '/ProductsPrice.json';

    private $sectionPatt = '~Раздел~';
    private $pricePatt = '~[  ]~';

    private $syslogFuncCode = 'class-project-price-exchange';

    /**
     * @throws Exception
     */
    public function __construct($rootSectionId = null, $useDebugFile = false, $dataFromDebugFile = false)
    {
        $this->documentRoot = empty($_SERVER['DOCUMENT_ROOT'])
            ? dirname(__DIR__)
            : $_SERVER['DOCUMENT_ROOT'];

        CModule::IncludeModule('iblock');

        $this->sectionPatt = $this->cp1251ToUtf8($this->sectionPatt);
        $this->pricePatt = $this->cp1251ToUtf8($this->pricePatt);

        $this->rootSectionId = $rootSectionId;
        $this->dataFromDebugFile = $dataFromDebugFile;
        $this->useDebugFile = $useDebugFile;

        $this->db = new PDO(
            "dblib:host=$this->host;dbname=$this->dbName;version=$this->version;charset=$this->charSet",
            $this->userName,
            $this->password
        );

        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->exec('SET ANSI_NULLS ON');
        $this->db->exec('SET ANSI_WARNINGS ON');
    }

    public function getRemoteData()
    {
        if ($this->dataFromDebugFile) {
            return $this->getLocalData();
        }

        try {
            $sql = "SELECT * FROM [web].[ProductsPrice]";
            return $this->db->query($sql)->fetchAll();
        } catch (Exception $e) {
            $this->stopScriptWithMessage($e->getMessage());
        }
    }

    private function getLocalData()
    {
        return json_decode(file_get_contents($this->documentRoot . $this->jsonDataFile), 1);
    }

    /**
     * @throws Exception
     */
    public function updatePrice()
    {
        $message = $this->cp1251ToUtf8('Начало обновления прайса');

        syslog(LOG_INFO, $this->buildSyslogMessage($message));

        if ($this->useDebugFile) {
            $this->filePutContents($message);
        }

        $this->getCurrentSectionList();

        $this->getCurrentItemList();

        $data = $this->getRemoteData();

        if (!count($data)) {
            $message = $this->cp1251ToUtf8('Отсутствуют данные для обновления каталога');
            $this->stopScriptWithMessage($message);
        }

        $message = $this->cp1251ToUtf8('Получено ' . count($data) . ' элементов каталога');

        syslog(LOG_INFO, $this->buildSyslogMessage($message));

        if ($this->useDebugFile) {
            $this->filePutContents($message, true);
        }

        foreach ($data as $dItem) {
            $this->validateItem($dItem);
            $itemSectionArr = $this->getItemSections($dItem);
            $this->processItemSections($itemSectionArr);
            $this->addOrUpdateItem($dItem, $itemSectionArr);
        }

        $message = $this->cp1251ToUtf8('Закончено добавление и обновление элементов каталога');

        syslog(LOG_INFO, $this->buildSyslogMessage($message));

        if ($this->useDebugFile) {
            $this->filePutContents($message, true);
        }

        $actualItemArr = array();

        foreach ($this->currentItemList as $item) {
            if (!empty($item['ACTIVE']) && $item['ACTIVE'] === 'Y') {
                $actualItemArr[] = $item['ID'];
            }
        }

        $notAnActualItemArr = $this->getItemIdListByExcludeIdList($actualItemArr);

        $actualSectionArr = array();

        foreach ($this->currentSectionList as $section) {
            if (!empty($section['ACTIVE']) && $section['ACTIVE'] === 'Y') {
                $actualSectionArr[] = $section['ID'];
            }
        }

        $notAnActualSectionArr = $this->getSectionIdListByExcludeIdList($actualSectionArr);

        foreach ($notAnActualItemArr as $itemId) {
            $this->deleteItemById($itemId);
        }

        if(!empty($notAnActualItemArr)) {
            $message = $this->cp1251ToUtf8(
                'Осуществлено удаление неактуальных элементов каталога '
                . count($notAnActualItemArr) . ' шт.');

            syslog(LOG_INFO, $this->buildSyslogMessage($message));

            if ($this->useDebugFile) {
                $this->filePutContents($message, true);
            }
        }

        foreach ($notAnActualSectionArr as $sectionId) {
            $this->deleteSectionWithElementsById($sectionId);
        }

        if(!empty($notAnActualSectionArr)) {
            $message = $this->cp1251ToUtf8(
                'Осуществлено удаление неактуальных разделов каталога - '
                . count($notAnActualSectionArr) . ' шт.');

            syslog(LOG_INFO, $this->buildSyslogMessage($message));

            if ($this->useDebugFile) {
                $this->filePutContents($message, true);
            }
        }

        $message = $this->cp1251ToUtf8('Прайс обновлен');

        syslog(LOG_INFO, $this->buildSyslogMessage($message));

        if ($this->useDebugFile) {
            $this->filePutContents($message, true);
        }

        echo $message . PHP_EOL;
    }

    /**
     * @throws Exception
     */
    private function processItemSections($itemSectionsArr)
    {
        $lastSectionIndex = count($itemSectionsArr) - 1;

        $sectionGlobalName = '';

        for ($i = 0; $i <= $lastSectionIndex; $i++) {
            $currentSectionName = $itemSectionsArr[$i];
            $sectionGlobalName .=
                $i === 0
                    ? $currentSectionName
                    : $this->sectionSeparatorForHash . $currentSectionName;

            $sectionGlobalNameMd5 = md5($sectionGlobalName);
            $sectionGlobalNameMd5Arr[] = $sectionGlobalNameMd5;

            $currentSection = isset($this->currentSectionList[$sectionGlobalNameMd5])
                ? $this->currentSectionList[$sectionGlobalNameMd5] : null;

            if (!is_null($currentSection)) {
                $this->currentSectionList[$sectionGlobalNameMd5]['ACTIVE'] = 'Y';
                continue;
            }

            $parentSection = null;

            if ($i === 0) {
                $parentSection = $this->getSectionByIdFromCurrSectionsList($this->rootSectionId);
            } else {
                //не возможна ситуация когда $this->currentSectionList[$sectionGlobalNameMd5Arr[$i - 1]] не существует
                $parentSection = $this->currentSectionList[$sectionGlobalNameMd5Arr[$i - 1]];
            }

            $newSection = $this->createSection($itemSectionsArr[$i], $parentSection['ID']);
            $this->currentSectionList[$sectionGlobalNameMd5] = $newSection;
        }
    }

    /**
     * @throws Exception
     */
    private function createSection($sectionName, $parentSectionId = NULL)
    {
        $arFields = array(
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $this->iBlockId,
            'NAME' => $this->utf8ToCp1251($sectionName)
        );

        if (!empty($parentSectionId)) {
            $arFields['IBLOCK_SECTION_ID'] = $parentSectionId;
        }

        $bs = new CIBlockSection();

        if ($id = $bs->Add($arFields)) {
            return array('ID' => $id, 'NAME' => $sectionName, 'IBLOCK_SECTION_ID' => $parentSectionId, 'ACTIVE' => 'Y');
        } else {
            $message = 'Error: ' . $bs->LAST_ERROR . PHP_EOL . "Section: ID = $id, SECTION_ID = $parentSectionId, SECTION_NAME = $sectionName";
            $this->stopScriptWithMessage($message);
        }
    }

    /**
     * @throws Exception
     */
    public function deleteSectionWithElementsById($id)
    {
        $ibs = new CIBlockSection();

        if (!$ibs::Delete($id)) {
            $message = "Не удалось удалить - раздел id = $id";
            $message .= PHP_EOL . $ibs->LAST_ERROR;
            $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
        }
    }

    /**
     * @throws Exception
     */
    public function deleteItemById($id)
    {
        $ibe = new CIBlockElement();

        if (!$ibe::Delete($id)) {
            $message = "Не удалось удалить элемент id = $id";
            $message .= PHP_EOL . $ibe->LAST_ERROR;
            $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
        }
    }

    /**
     * @throws Exception
     */
    private function setActivityForElementById($id, $activity = true)
    {
        $arFields = array();

        if ($activity) {
            $arFields['ACTIVE'] = 'Y';
        } else {
            $arFields['ACTIVE'] = 'N';
        }

        $be = new CIBlockElement();

        $arFilter['ID'] = $id;

        $arSelect = array('ID', 'NAME');

        $res = $be->GetList(array(), $arFilter, false, false, $arSelect);

        if ($el = $res->GetNext()) {
            $id = $el['ID'];
            $name = $el['NAME'];
            if (!$be->Update($el['ID'], $arFields)) {
                $message = "Не удалось сменить активность - элемент id = $id, name = $name";
                $message .= $be->LAST_ERROR;
                $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
            }
        }
    }

    /**
     * @throws Exception
     */
    private function getItemSections($itemData)
    {
        $itemSections = [];

        $uidKey = array('cp1251' => 'UID', 'utf8' => $this->cp1251ToUtf8('UID'));
        $artKey = array('cp1251' => 'Артикул', 'utf8' => $this->cp1251ToUtf8('Артикул'));
        $nomKey = array('cp1251' => 'Номенклатура', 'utf8' => $this->cp1251ToUtf8('Номенклатура'));

        $errMess = '';

        $itemUniqueData = PHP_EOL;
        $itemUniqueData .= $uidKey['cp1251'] . ' = ' . $this->utf8ToCp1251($itemData[$uidKey['utf8']]) . PHP_EOL;
        $itemUniqueData .= $artKey['cp1251'] . ' = ' . $this->utf8ToCp1251($itemData[$artKey['utf8']]) . PHP_EOL;
        $itemUniqueData .= $nomKey['cp1251'] . ' = ' . $this->utf8ToCp1251($itemData[$nomKey['utf8']]) . PHP_EOL;

        $sectKeyArr = [];

        $message = '';

        foreach ($itemData as $dItemKey => $dItemVal) {

            $dItemKey = trim($dItemKey);
            $dItemVal = trim($dItemVal);

            if (preg_match($this->sectionPatt, $dItemKey)) {
                if (!empty($dItemVal)) {
                    $sectKeyArr[] = $dItemKey;
                    $sectionIndex = ((int)preg_replace($this->sectionPatt, '', $dItemKey)) - 1;
                    if ($sectionIndex >= 0) {
                        //пропускаем наименование раздела совпадающие с наименованием номенклатуры
                        if ($itemData[$nomKey['utf8']] === $dItemVal) {
                            continue;
                        }
                        $itemSections[$sectionIndex] = $dItemVal;
                    } else {
                        $message .= 'Встречен некорректный индекс раздела каталога ['
                            . $this->utf8ToCp1251($dItemKey) . ' : ' . $this->utf8ToCp1251($dItemVal) . '].' . $itemUniqueData;
                    }
                }
            }
        }

        if (!empty($message)) {
            $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
        }

        for ($i = 0, $iMax = count($itemSections); $i < $iMax; $i++) {
            if (empty($itemSections[$i])) {
                $message = "Некорректно указаны разделы элемента каталога." . $itemUniqueData . PHP_EOL;
                $message .= $this->utf8ToCp1251(implode(' | ', $sectKeyArr));
                $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
            }
        }

        return $itemSections;
    }

    private function cp1251ToUtf8($str)
    {
        return iconv('cp1251', 'utf8', $str);
    }

    private function utf8ToCp1251($str)
    {
        return iconv('utf8', 'cp1251//TRANSLIT', $str);
    }

    /**
     * @throws Exception
     */
    public function getSectionListByRootId($rootId = null, $active = true, $globalActive = true, $returnIdsOnly = false)
    {

        $arFilter['IBLOCK_ID'] = $this->iBlockId;

        if (!is_null($active)) {
            $arFilter['ACTIVE'] = $active ? 'Y' : 'N';
        }

        if (!is_null($globalActive)) {
            $arFilter['GLOBAL_ACTIVE'] = $globalActive ? 'Y' : 'N';
        }

        $sectionList = [];

        $rootSectionDepthLevel = 1;
        $rootSectionLeftMargin = 0;
        $rootSectionRightMargin = 0;

        if (!is_null($rootId)) {

            $arFilter['ID'] = $rootId;
            $arSelect = array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL', 'LEFT_MARGIN', 'RIGHT_MARGIN');

            $dbSections = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);

            if ($arSection = $dbSections->Fetch()) {
                $rootSectionDepthLevel = $arSection['DEPTH_LEVEL'];
                $rootSectionLeftMargin = $arSection['LEFT_MARGIN'];
                $rootSectionRightMargin = $arSection['RIGHT_MARGIN'];

                if ($returnIdsOnly) {
                    $sectionList[] = $arSection['ID'];
                } else {
                    $name = $this->cp1251ToUtf8(trim($arSection['NAME']));
                    $sectionList[] = array(
                        'ID' => $arSection['ID'],
                        'NAME' => $name,
                        'IBLOCK_SECTION_ID' => $arSection['IBLOCK_SECTION_ID'],
                        'DEPTH_LEVEL' => $arSection['DEPTH_LEVEL'],
                        'ACTIVE' => 'N'
                    );
                }

            } else {
                $message = "Не найден требуемый корневой раздел ID = $rootId";
                $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
            }
        }

        unset($arFilter['ID']);

        $arSelect = array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL');

        if (!is_null($rootId)) {
            $arFilter['IBLOCK_SECTION_ID'] = $rootId;
            $arFilter['>LEFT_MARGIN'] = $rootSectionLeftMargin;
            $arFilter['<RIGHT_MARGIN'] = $rootSectionRightMargin;
            $arFilter['>DEPTH_LEVEL'] = $rootSectionDepthLevel;
        }

        $dbSections = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);

        while ($arSection = $dbSections->Fetch()) {

            if ($returnIdsOnly) {
                $sectionList[] = $arSection['ID'];
            } else {
                $name = $this->cp1251ToUtf8(trim($arSection['NAME']));
                $sectionList[] = array(
                    'ID' => $arSection['ID'],
                    'NAME' => $name,
                    'IBLOCK_SECTION_ID' => $arSection['IBLOCK_SECTION_ID'],
                    'DEPTH_LEVEL' => $arSection['DEPTH_LEVEL'],
                    'ACTIVE' => 'N'
                );
            }
        }

        return $sectionList;
    }

    /**
     * @throws Exception
     */
    public function getSectionById($id)
    {
        if (empty((int)$id)) {
            return null;
        }

        $arFilter = array('IBLOCK_ID' => $this->iBlockId, 'ID' => $id);
        $arSelect = array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'DEPTH_LEVEL');

        $dbSections = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);

        if ($arSection = $dbSections->Fetch()) {
            return array(
                'ID' => $arSection['ID'],
                'NAME' => $this->cp1251ToUtf8(trim($arSection['NAME'])),
                'IBLOCK_SECTION_ID' => $arSection['IBLOCK_SECTION_ID'],
                'DEPTH_LEVEL' => $arSection['DEPTH_LEVEL']
            );
        } else {
            return null;
        }
    }

    private function getSectionByIdFromCurrSectionsList($id)
    {
        if (empty($id)) {
            return null;
        }

        $id = trim($id);

        foreach ($this->currentSectionList as $key => $val) {
            if (isset($val['ID']) && $val['ID'] === $id) {
                $val['NAME'] = $key;
                return $val;
            }
        }

        return null;
    }

    /**
     * @throws Exception
     */
    private function getCurrentSectionList()
    {
        $this->currentSectionList = [];
        $matchList = [];
        $arSectionList = $this->getSectionListByRootId($this->rootSectionId,true,true);

        foreach ($arSectionList as $section) {

            $sectionGlobalName = $this->getSectionGlobalName($section, $arSectionList);
            $sectionGlobalNameMd5 = md5($sectionGlobalName);

            if (isset($this->currentSectionList[$sectionGlobalNameMd5])) {
                $matchList[] = array(
                    'ID' => $section['ID'],
                    'NAME' => $section['NAME']
                );
            } else {
                $this->currentSectionList[$sectionGlobalNameMd5] = array(
                    'NAME' => $section['NAME'],
                    'ID' => $section['ID'],
                    'IBLOCK_SECTION_ID' => $section['IBLOCK_SECTION_ID'],
                    'DEPTH_LEVEL' => $section['DEPTH_LEVEL'],
                    'ACTIVE' => 'N'
                );
            }
        }

        if (count($matchList)) {

            foreach ($this->currentSectionList as $cslItem) {
                foreach ($matchList as $mlItem) {
                    if ($cslItem['NAME'] === $mlItem['NAME']) {
                        $matchList[] = ['ID' => $cslItem['ID'], 'NAME' => $cslItem['NAME']];
                        break;
                    }
                }
            }

            uasort($matchList, array($this, 'compareByNameVal'));

            $message = 'Найдены одноименные разделы:' . PHP_EOL;

            foreach ($matchList as $item) {
                $item['NAME'] = $this->utf8ToCp1251($item['NAME']);
                $message .= "ID = $item[ID], NAME = $item[NAME]" . PHP_EOL;
            }

            $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
        }
    }

    private function getSectionGlobalName($section, $arSectionList)
    {
        $gName = null;

        if (!empty($section)) {

            $gName = $this->sectionSeparatorForHash . $section['NAME'];
            $pSection = $this->getSectionByIdFromArray($section['IBLOCK_SECTION_ID'], $arSectionList);

            while ($pSection) {
                $gName = $this->sectionSeparatorForHash . $pSection['NAME'] . $gName;
                $pSection = $this->getSectionByIdFromArray($pSection['IBLOCK_SECTION_ID'], $arSectionList);
            }
        }

        return ltrim($gName, $this->sectionSeparatorForHash);
    }

    private function getSectionByIdFromArray($id, $arSectionList)
    {
        foreach ($arSectionList as $saItem) {
            if ($id === $saItem['ID']) {
                return $saItem;
            }
        }
        return null;
    }

    /**
     * @throws Exception
     */
    private function getCurrentItemList()
    {
        $arFilter = array(
            'IBLOCK_ID' => $this->iBlockId,
            'ACTIVE' => 'Y',
            'SECTION_ID' => $this->getSectionListByRootId($this->rootSectionId, true, true, true)
        );

        $dbItems = CIBlockElement::GetList(
            array(),
            $arFilter,
            false,
            false,
            array('ID', 'XML_ID', 'NAME', 'IBLOCK_SECTION_ID')
        );

        $matchList = [];

        while ($item = $dbItems->Fetch()) {

            $id = $item['ID'];
            $name = trim($item['NAME']);
            $xmlId = trim($item['XML_ID']);

            if (empty($xmlId)) {
                $this->setActivityForElementById($id, false);
                continue;
            }

            if (isset($this->currentItemList[$xmlId])) {
                $matchList[] = ['ID' => $id, 'NAME' => $name, 'XML_ID' => $xmlId];
            } else {
                $this->currentItemList[$xmlId] =
                    array(
                        'ID' => $id,
                        'NAME' => $item['NAME'],
                        'IBLOCK_SECTION_ID' => $item['IBLOCK_SECTION_ID'],
                        'ACTIVE' => 'N'
                    );
            }
        }

        if (count($matchList)) {

            foreach ($this->currentItemList as $key => $val) {
                foreach ($matchList as $mlItem) {
                    if ((string)$key === (string)$mlItem['XML_ID']) {
                        $matchList[] = ['ID' => $val['ID'], 'NAME' => $val['NAME'], 'XML_ID' => $key];
                        break;
                    }
                }
            }

            uasort($matchList, array($this, 'compareByXmlIdVal'));

            $message = 'Найдены совпадающие XML_ID товарных позиций:' . PHP_EOL;

            foreach ($matchList as $item) {
                $message .= "XML_ID = $item[XML_ID], ID = $item[ID], NAME = $item[NAME]" . PHP_EOL;
            }

            $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
        }
    }

    /**
     * @throws Exception
     */
    private function addOrUpdateItem($dItem, $itemSections = null)
    {
        if (empty($itemSections)) {
            $itemSections = $this->getItemSections($dItem);
        }

        $sectionGlobalName = implode($this->sectionSeparatorForHash, $itemSections);
        $sectionGlobalNameMd5 = md5($sectionGlobalName);

        $sectionId = $this->currentSectionList[$sectionGlobalNameMd5]['ID'];
        $ob = new CIBlockElement();

        $nomKey = $this->cp1251ToUtf8('Номенклатура');
        $artKey = $this->cp1251ToUtf8('Артикул');
        $priceKey = $this->cp1251ToUtf8('Цена');
        $name = $this->utf8ToCp1251($dItem[$nomKey]);
        $art = $this->utf8ToCp1251($dItem[$artKey]);
        // bugfix: цены начали передаваться с пробелом. в паттерне регулярки не два пробела, а пробел и неразрывный пробел
        $price = preg_replace($this->pricePatt, '', $this->utf8ToCp1251($dItem[$priceKey]));
        $arQuery = array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $this->iBlockId,
            "IBLOCK_SECTION_ID" => $sectionId,
            "XML_ID" => $dItem['UID'],
            "NAME" => $name,
            //"MODIFIED_BY" => $GLOBALS["USER"]->GetID(),
            "PROPERTY_VALUES" => array(
                "ARTICLE" => $art,
                "PRICE" => $price
            )
        );

        $newItem = null;

        if (isset($this->currentItemList[$dItem['UID']])) {
            $ob->Update($this->currentItemList[$dItem['UID']]['ID'], $arQuery);
            $newItem = array(
                'ID' => $this->currentItemList[$dItem['UID']]['ID'],
                'NAME' => $name,
                'IBLOCK_SECTION_ID' => $sectionId,
                'ACTIVE' => 'Y'
            );
        } else {
            $id = $ob->Add($arQuery);
            $newItem = array(
                'ID' => $id,
                'NAME' => $name,
                'IBLOCK_SECTION_ID' => $sectionId,
                'ACTIVE' => 'Y'
            );
        }

        if (!empty($newItem)) {
            $this->currentItemList[$dItem['UID']] = $newItem;
        }
    }

    /**
     * @throws Exception
     */
    private function validateItem($dItem)
    {
        $uidKey = array('cp1251' => 'UID', 'utf8' => $this->cp1251ToUtf8('UID'));
        $artKey = array('cp1251' => 'Артикул', 'utf8' => $this->cp1251ToUtf8('Артикул'));
        $nomKey = array('cp1251' => 'Номенклатура', 'utf8' => $this->cp1251ToUtf8('Номенклатура'));
        $priceKey = array('cp1251' => 'Цена', 'utf8' => $this->cp1251ToUtf8('Цена'));
        $currencyKey = array('cp1251' => 'Валюта', 'utf8' => $this->cp1251ToUtf8('Валюта'));

        $message = '';

        if (empty($dItem[$uidKey['utf8']])) {
            $message .= "Пустое значение поля $uidKey[cp1251]" . PHP_EOL;
        }

        if (empty($dItem[$artKey['utf8']])) {
            $message .= "Пустое значение поля $artKey[cp1251]" . PHP_EOL;
        }

        if (empty($dItem[$nomKey['utf8']])) {
            $message .= "Пустое значение поля $nomKey[cp1251]" . PHP_EOL;
        }

        if (empty($dItem[$priceKey['utf8']])) {
            $message .= "Пустое значение поля $priceKey[cp1251]" . PHP_EOL;
        }

        if (empty($dItem[$currencyKey['utf8']])) {
            $message .= "Пустое значение поля $currencyKey[cp1251]" . PHP_EOL;
        }

        if (!empty($message)) {
            $message = 'Встречено некорреткное значение элемента каталога' . PHP_EOL
                . (!empty($dItem[$uidKey['utf8']]) ? $uidKey['cp1251'] . ' = ' . $this->utf8ToCp1251($dItem[$uidKey['utf8']]) . PHP_EOL : '')
                . (!empty($dItem[$artKey['utf8']]) ? $artKey['cp1251'] . ' = ' . $this->utf8ToCp1251($dItem[$artKey['utf8']]) . PHP_EOL : '')
                . (!empty($dItem[$nomKey['utf8']]) ? $nomKey['cp1251'] . ' = ' . $this->utf8ToCp1251($dItem[$nomKey['utf8']]) . PHP_EOL : '')
                . $message;
            $this->stopScriptWithMessage($this->cp1251ToUtf8($message));
        }
    }

    public function getItemIdListByExcludeIdList($excludeIdList)
    {
        $arFilter = array(
            'IBLOCK_ID' => $this->iBlockId,
            '!ID' => $excludeIdList
        );

        $dbItems = CIBlockElement::GetList(
            array(),
            $arFilter,
            false,
            false,
            array('ID')
        );

        $arItemId = array();

        while ($item = $dbItems->Fetch()) {
            $arItemId[] = $item['ID'];
        }

        return $arItemId;
    }

    public function getSectionIdListByExcludeIdList($excludeIdList)
    {
        $arOrder = array(
            'DEPTH_LEVEL' => 'DESC'
        );

        $arFilter = array(
            'IBLOCK_ID' => $this->iBlockId,
            '!ID' => $excludeIdList
        );

        $dbItems = CIBlockSection::GetList(
            $arOrder,
            $arFilter,
            false,
            array('ID')
        );

        $arItemId = array();

        while ($item = $dbItems->Fetch()) {
            $arItemId[] = $item['ID'];
        }

        return $arItemId;
    }

    /**
     * @throws Exception
     */
    public function filePutContents($data, $fileAppend = false, $file = null, $json = false)
    {
        $file = is_null($file) ? $this->documentRoot . $this->debugOutFile : $this->documentRoot . $file;

        $fileAppend = $fileAppend ? FILE_APPEND : null;

        $data = $json
            ? json_encode($data)
            : print_r(
                date('Y.m.d H:i:s:u') . ' ' . print_r($data, 1) . PHP_EOL,
                1
            );

        $res = file_put_contents($file, $data, $fileAppend);

        if (!$res) {
            // нельзя использовать $this->stopScriptWithMessage из-за возникающего
            // бесконечного вызова метода $this->filePutContents
            $message = $this->cp1251ToUtf8('Ошибка записи в файл ' . $file . PHP_EOL);
            syslog(LOG_ERR, $this->buildSyslogMessage($message));
            echo $message;
            throw new Exception($message);
        }
    }

    /**
     * @throws Exception
     */
    private function stopScriptWithMessage($message)
    {
        echo $message;

        syslog(LOG_ERR, $this->buildSyslogMessage($message));

        if ($this->useDebugFile) {
            $this->filePutContents($message, true);
        }

        throw new Exception($message);
    }

    private function compareByNameVal($val1, $val2)
    {
        if ($val1['NAME'] === $val2['NAME']) {
            return 0;
        }
        return ($val1['NAME'] < $val2['NAME']) ? -1 : 1;
    }

    private function compareByXmlIdVal($val1, $val2)
    {
        if ($val1['XML_ID'] === $val2['XML_ID']) {
            return 0;
        }
        return ($val1['XML_ID'] < $val2['XML_ID']) ? -1 : 1;
    }

    private function buildSyslogMessage($message)
    {
        return "[$this->syslogFuncCode] " . $message;
    }
}