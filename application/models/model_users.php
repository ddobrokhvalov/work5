<?
class Model_Users extends Model{
	protected $db;

	function __construct()
	{
		$this->db =new db;
	}

	public function get_by_login($user_login){
		$user = $this->db->sql_select("select * from users where login = :login", array("login"=>$user_login));
		return $user;
	}

	public function get_by_id($user_id){
		$user = $this->db->sql_select("select * from users where id = :user_id", array("user_id"=>$user_id));
		return $user;
	}

	public function get_list(){
		$sql = "select * from users";
		$users = $this->db->sql_select($sql);
		return $users;
	}

	public function update($fields){
		unset($fields['repassword']);
		unset($fields['submit']);
		if(isset($fields['password'])){
			$fields['password'] = md5($fields['password']);
		}
		$user_id = $_SESSION['user']['id'];
		$this->db->update_record('users', $fields, null, ['id'=>$user_id]);
	}

	public function register($fields){
		unset($fields['repassword']);
		unset($fields['submit']);
		$fields['password'] = md5($fields['password']);
		$this->db->insert_record('users', $fields);
	}

	public function login_exist($login){
		$user = $this->get_by_login($login);
		if(count($user)){
			return true;
		}else{
			return false;
		}
	}

}