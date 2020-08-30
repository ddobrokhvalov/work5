<?
class params{
	public static $params=array();
	public static function init_default_params(){
		self::$params=array(
			"db_type" => array ("value" => "mysql"),
			"db_server" => array ("value" => "localhost"),
			"db_name" => array ("value" => "u6724423_work5"),
            "db_user" => array ("value" => "u6724423_work5"),
            "db_password" => array ("value" => 'Bylecnhbz2020'),
		);
	}
}
params::init_default_params();