<?php 
class Controller{
	private $db = null;
	/**
	 * @var $mess messages for pages
	 */
	public $mess;
	public $languages;
	public function __construct(){
		$this->dbconnect();
		if (Session::get('user_lang')) {
			$user_lang = Session::get('user_lang');
			$lang = new Lang($user_lang);
		}else{
			//get the default language, in this case 'en'
			$lang = new Lang();
		}
			$this->mess = $lang->lang;
		$this->languages = $lang->langs();
	}
	/**
	 * simple model loader
	 * @param  [string] $model [model name]
	 * @return [object]    [models object with connected to database]
	 */
	protected function model($model)
	{
		require 'app/models/' . strtolower($model) . '.php';
		return new $model($this->db, $this->mess);
	}
	/**
	 * connect to db
	 */
	private function dbconnect()
	{
		$options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
		
		$this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
		//default charset utf8
		$this->db->exec("set names utf8");
	}
	/**
	 * check the  php version
	 * @return [type] [description]
	 */
	public function versionPhp(){
		if (version_compare(PHP_VERSION, '5.3.7', '<')) {
			exit("Sorry,Your PHP version smaller than 5.3.7 !");
		} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
			return true;
		}
	}
	/**
	* Truncate string, make sure it ends in a word so assassinate doesn't become ass...
	* @param string $string for cut
	* @param integer $intLess default = 500 
	**/
	public function stringCut($string, $intLess = 500){
		if (strlen($string) > $intLess) {
			// truncate string
			$stringCut = substr($string, 0, $intLess);
			// make sure it ends in a word so assassinate doesn't become ass...
			$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
		}
		return $string;
		
	}
}