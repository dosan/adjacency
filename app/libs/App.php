<?php
class App{
	// home page user
	
	private $controller = 'post';
	
	// main action 	
	private $method = 'index';
	private $params = [];
	/**
	 * start the application
	 */
	public function __construct(){
		$url = $this->parseUrl();
		if (file_exists('./app/controller/' . $url[0] . '.php')) {
			$this->controller = $url[0];
			unset($url[0]);
		}
		require_once('./app/controller/'.$this->controller.'.php');
		$this->controller = new $this->controller;
		if (isset($url[1])) {
			if (isInteger($url[1]) AND method_exists($this->controller, 'getId')) {
				$this->method = 'getId';
			}else if (method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}else{
				header('location: '.URL.'404.html');
			}
		}
		$this->params = $url ? array_values($url) : [];
		call_user_func_array([$this->controller, $this->method], $this->params);
	}
	/**
	 * [parseUrl explode url )]
	 * @return [array] [$url[]]
	 */
	public function parseUrl(){
		if(isset($_GET['url'])){
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}