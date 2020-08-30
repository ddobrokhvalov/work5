<?
require_once "config.php";
class db{
	protected $dbh;

	function __construct(){
		$db_server = params::$params["db_server"]["value"];
		$db_type = params::$params["db_type"]["value"];
		$db_name = params::$params["db_name"]["value"];
		$db_user = params::$params["db_user"]["value"];
		$db_password = params::$params["db_password"]["value"];
		try{
			$charset="utf8";
			$this->dbh=new PDO("{$db_type}:host={$db_server};dbname={$db_name}", $db_user, $db_password);
			$this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$sth=$this->dbh->prepare("SET CHARACTER SET {$charset}");
			$sth->execute();
			$sth=$this->dbh->prepare("SET NAMES '{$charset}'");
			$sth->execute();
		}catch(PDOException $e){
			echo "Connection failed: ".$e->getMessage();
			exit();
		}
	}

	public function sql_select($query, $fields=array(), $special=array()){
		$sth=$this->execute_query($query, $fields, $special);
		$all = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $all;
	}

	public function sql_query($query, $fields=array(), $special=array()){
		$sth=$this->execute_query($query, $fields, $special);
		return $sth->rowCount();
	}

	public function insert_record($table, $fields=array(), $special=array()){
		$columns=array();
		$values=array();
		foreach($fields as $key=>$value){
			$columns[]=$key;
			if ($special[$key]=='pure')
				$values[] = $value;
			else
				$values[]=$this->set_parameter_colon($key);
		}
		$columns=join(", ",$columns);
		$values=join(", ",$values);

		$query="INSERT INTO {$table} ({$columns}) VALUES ({$values})";
		$sth=$this->execute_query($query, $fields, $special);
	}

	public function last_insert_id($sequence_name){
		return $this->dbh->lastInsertId($sequence_name);
	}

	public function update_record($table, $fields=array(), $special=array(), $where=array()){
		if ( !is_array( $fields ) || !count( $fields ) ||
			!is_array( $where ) || !count( $where ) ) return;

		foreach($fields as $key=>$value){
			if ($special[$key]=='pure')
				$pairs[]="{$key}=$value";
			else
				$pairs[]="{$key}=".$this->set_parameter_colon($key);
		}
		$pairs=join(", ",$pairs);

		foreach($where as $key=>$value){
			$ands[]="{$key}=:ands_{$key}";
			$fields["ands_".$key]=$value;
		}
		$ands=join(" AND ",$ands);

		$query="UPDATE {$table} SET {$pairs} WHERE {$ands}";
		$sth=$this->execute_query($query, $fields, $special);
		return $sth->rowCount();
	}

	public function delete_record($table, $where=array()){
		if ( !is_array( $where ) || !count( $where ) ) return 0;

		foreach($where as $key=>$value){
			$ands[]="{$key}=:ands_{$key}";
			$fields["ands_".$key]=$value;
		}
		$ands=join(" AND ",$ands);

		$query="DELETE FROM {$table} WHERE {$ands}";
		$sth=$this->execute_query($query, $fields, array());
		return $sth->rowCount();
	}

	protected function execute_query($query, $fields, $special){
		$sth=$this->prepare_query($query);
		$params = array();
		foreach($fields as $key=>$value){
			if (is_int($special[$key]))
				$sth->bindValue($this->set_parameter_colon($key), $value, $special[$key]);
			else
				$sth->bindValue($this->set_parameter_colon($key), $value);
			$params[$key] = htmlspecialchars(mb_substr($value, 0, 10, "utf-8"));
			if (mb_strlen($value, "utf-8")>10)
				$params[$key] .= '...';
		}

		try {
			$sth->execute();
		}
		catch (Exception $e) {
			throw new DBDebugException ($e->getMessage(), "\n".$query."\n ".preg_replace('/Array\s*\((.*)\)/s', '\1', print_r($params, 1)));
		}
		return $sth;
	}

	protected function prepare_query($query) {
		return $this->dbh->prepare($query);
	}

	public function set_parameter_colon($param) {
		return ':'.$param;
	}
}

class DBDebugException extends Exception {

	private $debug_message;

	function __construct ($message, $debug_message, $code=0) {
		parent::__construct($message, $code);
		$this->debug_message = $debug_message;
	}

	public function getDebugMessage() {
		return $this->debug_message;
	}
}