<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

$arComponentDescription = array(
    "NAME" => GetMessage("IBLOCK_WTBUY_TEMPLATE_NAME"),
    "DESCRIPTION" => GetMessage("IBLOCK_WTBUY_TEMPLATE_DESCRIPTION"),
    "CACHE_PATH" => "Y",
    "SORT" => 1,
    "PATH" => array(
        "ID" => "utility",
    ),
);