<!doctype html>
<!--[if lte IE 7]> <html class="ie7 ielte9 ielte8 ielte7" lang="ru"> <![endif]-->
<!--[if IE 8]> <html class="ie8 ielte9 ielte8" lang="ru"> <![endif]-->
<!--[if IE 9]> <html class="ie9 ielte9" lang="ru"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="not-oldie" lang="ru"> <!--<![endif]-->
<head>
    <meta charset="windows-1251">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <?
    CStaticFile::addBuffer(
        array(
            "/js/plugins/fancybox/jquery.fancybox.css",
            "/assets/css/main.css",
            "/assets/css/main_data.css",
        )
    );
    ?>
    <title><?=$APPLICATION->ShowTitle()?></title>
    <?$APPLICATION->ShowMeta("description");?>
    <?$APPLICATION->ShowMeta("keywords");?>
    <?$APPLICATION->ShowCSS();?>
    <?$APPLICATION->ShowHeadStrings();?>
    <?$APPLICATION->ShowHeadScripts();?>
</head>

<body class="Page">
<?=$APPLICATION->ShowPanel();?>
<div class="Page__header Header">
    <div class="Page__wrapper">
        <div class="HeaderLogo">
            <a href="/" class="HeaderLogo__link">
                <img class="HeaderLogo__img" src="/assets/img/src/interface/logo.png" alt="">
            </a>
        </div>        
        <div class="HeaderMenu">
            <?            
            $APPLICATION->IncludeComponent(
                "bitrix:menu", 
                "header", 
                array(
                    "ROOT_MENU_TYPE" => "top",
                    "MENU_CACHE_TYPE" => "A",
                    "CHILD_MENU_TYPE" => "second",
                    "MENU_CACHE_TIME" => SET_SITE_CACHE_TIME,
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "2",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "COMPONENT_TEMPLATE" => "header",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            );
            ?>
        </div>
    </div>
</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
	),
	false
);?>
<div class="Page__main <?$APPLICATION->ShowProperty('MAIN_CLASS')?>">
    <div class="Page__wrapper">
<?
$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	".default", 
	array(
		"START_FROM" => "0",
		"PATH" => "",
		"SITE_ID" => "ul",
		"COMPONENT_TEMPLATE" => ".default",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);