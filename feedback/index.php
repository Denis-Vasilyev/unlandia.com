<?php
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty('keywords', 'Sonnen, Обратная связь');
$APPLICATION->SetPageProperty('description', 'Sonnen, Обратная связь');

$pageTitle = "Обратная связь";
$APPLICATION->SetTitle($pageTitle);

$APPLICATION->IncludeComponent("bitrix:form.result.new", ".default", array(
	"WEB_FORM_ID" => ID_FORM_FEEDBACK,
	"IGNORE_CUSTOM_TEMPLATE" => "N",
	"USE_EXTENDED_ERRORS" => "Y",
	"SEF_MODE" => "N",
	"SEF_FOLDER" => "/feedback/",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"LIST_URL" => "",
	"EDIT_URL" => "",
	"SUCCESS_URL" => "index.php",
	"CHAIN_ITEM_TEXT" => "",
	"CHAIN_ITEM_LINK" => "",
	"VARIABLE_ALIASES" => array(
		"WEB_FORM_ID" => "WEB_FORM_ID",
		"RESULT_ID" => "RESULT_ID",
	)
	),
	false
);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>
