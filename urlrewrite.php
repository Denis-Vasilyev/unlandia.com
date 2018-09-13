<?php
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/catalog/([0-9a-z\\-_]+)/([0-9]+)(/)?(index\\.php)?(\\?.*)?#",
		"RULE" => "XML_ID=\$2",
		"PATH" => "/catalog/detail.php",
	),
	array(
		"CONDITION" => "#^/catalog/([0-9a-z\\-_]+)(/)?(index\\.php)?(\\?.*)?#",
		"RULE" => "SECTION_CODE=\$1",
		"PATH" => "/catalog/index.php",
    ),
    array(
        "CONDITION" => "#^/info/([0-9a-z\\-_]+)(/)?(index\\.php)?(\\?.*)?#",
        "RULE" => "CODE=\$1",
        "PATH" => "/info/index.php"
    ),
    array(
        "CONDITION" => "#^/gallery/master-classes/([a-zA-Z0-9\\.\\-_]+)/?.*#",
        "RULE" => "ELEMENT_CODE=\$1",
        "PATH" => "/gallery/master-classes/detail.php"
    ),
);
