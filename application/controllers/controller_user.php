<?
class Controller_user extends Controller
{
	function __construct()
	{
		$this->model = new Model_Users();
		$this->view = new View();
	}

	public function action_index()
	{
		$data = $this->model->get_by_id($_SESSION['user']['id']);
		if(!count($data)){
			$this->logout();
			header("Location: /index.php");
		}
		$this->view->generate('userinfo_view.php', 'template_view.php', $data[0]);
	}

	public function authorized(){
		if(isset($_SESSION['user'])){
			return true;
		}else{
			return false;
		}
	}

	public function authorize($login, $password){
		$users = $this->model->get_by_login($login);

		$authorized = false;
		if(count($users)){
			foreach($users as $user){
				if($user["password"] == md5($password)){
					$authorized = true;
					$_SESSION["user"] = $user;
				}
			}
		}
		return $authorized;
	}

	public function logout(){
		unset($_SESSION["user"]);
	}

	public function action_logout(){
		$this->logout();
		header("Location: /index.php");
	}

	public function action_auth_form(){
		if($this->authorized()){
			return $this->action_index();
		}
		$data["error"] = "";
		if(isset($_POST["submit"]) && $_POST["submit"]){
			if(!$_POST["login"]){
				$data["error"] .= "Не указан логин. ";
			}
			if(!$_POST["password"]){
				$data["error"] .= "Не указан пароль. ";
			}
			if($_POST["login"] && $_POST["password"]){
				$auth_result = $this->authorize($_POST["login"], $_POST["password"]);
				if(!$auth_result){
					$data["error"] .= "Не верно указан логин или пароль";
				}else{
					header("Location: /index.php");
				}
			}
		}

		$this->view->generate('auth_form_view.php', 'template_view.php', $data);
	}

	public function action_register(){
		if($this->authorized()){
			header("Location: /index.php");
		}

		$data["error"] = "";
		if(isset($_POST["submit"]) && $_POST["submit"]){
			foreach ($_POST as $key=>$val){
				if(!$val){
					$data["error"] = "Заполните все поля";
				}
			}
			if(!$data["error"]){
				if($this->model->login_exist($_POST['login'])){
					$data["error"] = 'Пользователь с таким логином уже существует';
				}
				if($_POST['password'] != $_POST['repassword']){
					$data["error"] = 'Пароли не совпадают';
				}
			}
			if(!$data["error"]){
				$this->model->register($_POST);
				$this->authorize($_POST["login"], $_POST["password"]);
				header("Location: /index.php");
			}
		}

		$this->view->generate('register_form_view.php', 'template_view.php', $data);
	}

	public function action_edit(){
		$data = $this->model->get_by_id($_SESSION['user']['id']);
		if(!count($data)){
			$this->logout();
			header("Location: /index.php");
		}

		$data["error"] = "";
		if(isset($_POST["submit"]) && $_POST["submit"]){
			if(!$_POST["password"] && !$_POST["repassword"]){
				unset($_POST["password"]);
				unset($_POST["repassword"]);
			}

			foreach ($_POST as $key=>$val){
				if(!$val){
					$data["error"] = "Заполните все поля";
				}
			}
			if(!$data["error"]){
				if($this->model->login_exist($_POST['login']) && $_POST['login'] != $data[0]['login']){
					$data["error"] = 'Пользователь с таким логином уже существует';
				}
				if($_POST['password'] != $_POST['repassword']){
					$data["error"] = 'Пароли не совпадают';
				}
			}
			if(!$data["error"]){
				$this->model->update($_POST);
				$this->authorize($_POST["login"], $_POST["password"]);
				header("Location: /index.php");
			}
		}
		$this->view->generate('edit_form_view.php', 'template_view.php', $data);
	}
}