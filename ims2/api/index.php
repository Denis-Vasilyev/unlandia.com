<?

require_once $_SERVER['DOCUMENT_ROOT'] . "/init.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/App/libs/PHP-Simple-JWT-Auth-master/jwt_helper.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/App/Classes/APIUtils.php";

//header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization');

function getNginxAllheaders()
{
        if (!is_array($_SERVER)) {
            return array();
        }
        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $key = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$key] = $value;
            }
        }
        return $headers;
}

$headers = getNginxAllheaders();

$token = null;
$au = new APIUtils();
if($au->enableAuthorization){
	try{
		$key = $headers['Authorization'];
		$secretKey = $au->getSecretKey();
		if( !$secretKey )
			throw new Exception("Не удалось получить секретный ключ.");
		$token = JWT::decode( $key, $secretKey, $verify = true );
		if((int)$token->exp < (int)time())
			throw new Exception("Токен просрочен.");
	} catch(Exception $e) {
		die($e->getMessage());
	}
}

$requestData = explode("/",$_SERVER["REQUEST_URI"]);
if(	count($requestData) < 3 	||
	$requestData[1] != "api" )
	die("Некорректное обращение к API.");
$method = explode("?",$requestData[2])[0];
if(!method_exists($au, $method))
	die("Некорректное обращение к API.");
$debug = $au->$method($_REQUEST);
echo $debug;