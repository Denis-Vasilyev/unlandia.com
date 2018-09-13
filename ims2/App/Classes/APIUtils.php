<?
class APIUtils
{	
	private $apiConfigFile;
	public $uploadCatalog;
	public  $enableAuthorization;
	
	public $dbConnect;
	
	function __construct(){
		$this->apiConfigFile = $_SERVER['DOCUMENT_ROOT'] . "/api/api.config";
		$this->uploadCatalog = $_SERVER['DOCUMENT_ROOT'] . $this->getAPIConfigItemByKey("upload_catalog");
		$this->enableAuthorization = (bool)$this->getAPIConfigItemByKey("enable_authorization");
		$host = $username = $password = $db = null; 
		defined('HostName') ? $host 	= HostName :
							  $host 	= $this->getAPIConfigItemByKey("hostname");
		defined('UserName') ? $username = UserName :
							  $username = $this->getAPIConfigItemByKey("username");
		defined('Password') ? $password = Password :
							  $password = $this->getAPIConfigItemByKey("password");
		defined('DBName') 	? $db 		= DBName :
							  $db 		= $this->getAPIConfigItemByKey("dbname");
		$this->dbConnect = new PDO(	"mysql:dbname=$db;host=$host;charset=UTF8",
									$username, 
									$password, 
									array(PDO::MYSQL_ATTR_LOCAL_INFILE => true)
									);
		/*$this->dbConnect = new mysqli(  $host,
										$username,
										$password,
										$db 
									);
		$this->dbConnect = mysql_connect("$host :3307", $username, $password);
		mysql_select_db("ims",$this->dbConnect);*/
	}
	
	public function getSecretKey(){
		return $this->getAPIConfigItemByKey("secret_key");
	}
	
	public function executeMethod($name = null, $params = null/**/){
		if(method_exists($this, $name)) $this->$name($params);
	}
	
	public function import($data = null){
		$query .= 	"START TRANSACTION;";
		$query .= 	"SET FOREIGN_KEY_CHECKS = 0;";
		$query .= 	"SET UNIQUE_CHECKS = 0;";
		$query .= 	"SET AUTOCOMMIT = 0;";
		
		foreach($_FILES as $file){
			
			$tmp_name = $name = $error = null;
			
			is_array($file['tmp_name'])	? $tmp_name = $file['tmp_name'][0]	: $tmp_name = $file['tmp_name'];
			is_array($file['name'])		? $name 	= $file['name'][0]		: $name 	= $file['name'];
			is_array($file['error'])	? $error 	= $file['name'][0]		: $error 	= $file['name'];
			
			$uploadfile =  $this->uploadCatalog . basename($name);
			
			if(!move_uploaded_file($tmp_name, $uploadfile)){
				echo $error;
				continue;
			}
			
			$zip = new ZipArchive;
			$tname = explode('.',basename($name))[0];
			
			if ($zip->open($uploadfile) === TRUE) {
				for ($i = 0; $i < $zip->numFiles; $i++) {
					$importFile = $zip->getNameIndex($i);
					$zip->extractTo($this->uploadCatalog, [$importFile]);
					$fname = $this->uploadCatalog . $zip->getNameIndex($i);					
					$query .= 	"TRUNCATE $tname;";/**/
					$query .= 	"LOAD DATA LOCAL INFILE '$fname' ";
					$query .= 	"INTO TABLE $tname ";
					$query .= 	"LINES TERMINATED BY '(|)';";
				}
				$zip->close();
			} else {
				continue;
			}			
		}
		$query .= 	"SET UNIQUE_CHECKS = 1;";
		$query .= 	"SET FOREIGN_KEY_CHECKS = 1;";
		$query .= 	"COMMIT;";
		$query .= 	"SET AUTOCOMMIT = 1;";/**/
		$qresult = null;
		try {
			$qresult = $this->dbConnect->exec($query);
			file_put_contents($this->uploadCatalog . "api_var_dump.txt", print_r($qresult,1));
			return($qresult);/**/
		} catch (PDOException $e) {
			//добавить вывод в лог
			echo $e->getMessage(); 
		}
		return true;
	}/**/
	
	private function getAPIConfigItemByKey($needKey){
		$file = $this->apiConfigFile;
		$content = explode("\n",file_get_contents($file));
		for($i=0; $i<count($content); $i++){
			$key = explode(":",$content[$i])[0];
			if($key == $needKey){
				$value = trim(explode(":",$content[$i])[1]);				
				if(strlen($value) < 3) return null;
				return substr($value,1,strlen($value)-2);
			}
		}
		return null;
	}
	
	public function getZUPPassportData($data = null){
		$query 		= "select * from managers_passport_data where passport_data_approved = 1 and deleted <> 1;";
		$qresult 	= $this->dbConnect->query($query)->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($qresult);
		
	}
	
	public function getNewZUPPassportData($data = null){
		$query 		= "select * from managers_passport_data where passport_data_approved = 1 and is_loaded = 0 and deleted <> 1;";
		$qresult 	= $this->dbConnect->query($query)->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($qresult);
	}
	
	public function confirmLoadingZupPassportDataById($data = null){
		if(	!isset($data['idArr']) || 
			(	isset($data['idArr']) && 
				count($data['idArr']) == 0) ) 
				return "Не передан массив с id";
		$wrongIdStr = null;
		$query = "update managers_passport_data set is_loaded=1 where id in (";
		foreach($data['idArr'] as $id){
			if(!is_numeric($id))
				$wrongIdStr .= "{" . $id . "} ";
			else
				$query .= "'" . $id . "',";
		}		
		if($wrongIdStr) return "Не верно переданы id " . $wrongIdStr;		
		$query = substr($query,0,-1); //удаляем лишнюю запятую в конце
		$query .= ")";
		$qresult = $this->dbConnect->query($query);
		return json_encode($qresult);/**/
	}

	public function ExportData($data = null){
		$query 		= "select * from managers_passport_data where passport_data_approved = 1 and deleted <> 1;";
		$qresult 	= $this->dbConnect->query($query)->fetchAll(PDO::FETCH_ASSOC);
		return json_encode($qresult);

	}
}
?>