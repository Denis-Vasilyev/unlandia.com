        </div>
    </div>
    <div class="Page__footer Footer">
		<div class="Page__wrapper"><!--
			<div class="Footer__column FooterSocial">
				<span class="FooterSocial__text">Мы в социальных сетях:</span><a href="" class="Btn Btn--vk"></a><a href="" class="Btn Btn--insta"></a><a href="" class="Btn Btn--ok"></a>
			</div>-->
			<div class="Footer__column">
				<div class="FooterMenu"><?
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "footer",
                        array(
                            "ROOT_MENU_TYPE" => "top",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => SET_SITE_CACHE_TIME,
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "MENU_CACHE_GET_VARS" => array(
                            ),
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "COMPONENT_TEMPLATE" => "footer"
                        ),
                        false
                    );
				?></div>
				<div class="Footer__copy">Юнландия © 2018. Все товары сертифицированы, все права защищены.</div>
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