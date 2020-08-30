<?
class Route{
	public static function start(){
		$controller_name = 'User';
		$action_name = 'auth_form';
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if($routes[1] != '' && $routes[1] != 'index.php'){
			$action_name = $routes[1];
		}

		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		$model_file = strtolower($model_name).'.php';
		$model_path = "application/models/".$model_file;
		if(file_exists($model_path)){
			include_once "application/models/".$model_file;
		}

		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "application/controllers/".$controller_file;

		if(file_exists($controller_path)){
			include_once "application/controllers/".$controller_file;
			$controller = new $controller_name;
			$action = $action_name;

			if(method_exists($controller, $action)){
				$controller->$action();
			}else{
				Route::ErrorPage404();
			}
		}else{
			Route::ErrorPage404();
		}
	}

	private function ErrorPage404(){
		include "application/controllers/controller_404.php";
		$controller = new Controller_404;
		$controller->action_index();
	}
}