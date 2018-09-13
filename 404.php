<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus('404 Not Found');
@define('ERROR_404', 'Y');

$APPLICATION->SetTitle('404 Not Found');
?>
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

<body class="Page Page--error">
<?=$APPLICATION->ShowPanel();?>
<div class="Page__main <?$APPLICATION->ShowProperty('MAIN_CLASS')?>">
    <div class="Page__wrapper">
        <div class="Error Error--picture Error--404">
            <div class="Error__picture"></div>
            <h1 class="Error__title">Страницу похитили инопланетяне</h1>
            <div class="Error__message">Попробуйте ввести адрес заново или воспользуйтесь меню</div>
        </div>
        <div class="Page__footer Footer  Footer--light">
            <div class="Page__wrapper">
                <div class="Footer__column Footer__column--logo">
                    <a href="/" class="Logo Logo--icon"></a>
                    <span class=""></span>
                </div>
                <div class="Footer__column">
                    <div class="FooterMenu">
                        <ul class="FooterMenu__list">
                            <li class="FooterMenu__item">
                                <a href="/info/about/" class="FooterMenu__link">О бренде</a>
                            </li><!--<li class="FooterMenu__item">
                                <a href="" class="FooterMenu__link">Конкурсы</a>
                            </li>--><li class="FooterMenu__item">
                                <a href="/gallery/" class="FooterMenu__link">Галерея</a>
                            </li><li class="FooterMenu__item">
                                <a href="/catalog/" class="FooterMenu__link">Каталог</a>
                            </li><li class="FooterMenu__item">
                                <a href="/info/shop/" class="FooterMenu__link">Где купить</a>
                            </li><li class="FooterMenu__item">
                                <a href="/feedback/" class="FooterMenu__link">Обратная связь</a>
                            </li>
                        </ul>
                    </div>
                    <div class="Footer__copy">Юнландия © 2018. Все товары сертифицированы, все права защищены.</div>
                </div>
            </div>
        </div>
    </div>    
    <?
    CStaticFile::addBuffer(
        array(
            "/js/jquery/jquery.js",
            "/js/plugins/fancybox/jquery.fancybox.js",
            "/js/main.js",
        )
    );
    ?>
</body>
</html>