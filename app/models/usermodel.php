<?php 

class UserModel{
	public $messages = array();
	public $success = array();
	public $errors = array();
	public $mess;
	private $db;

	function __construct($db, $mess) {
		$this->mess = $mess;
		try {
			$this->db = $db;
		} catch (PDOException $e) {
			exit('Database connection could not be established.');
		}
	}
	/**
	 * user login function
	 * @param  [string] $user_name     [user name or user email]
	 * @param  [string] $user_password [user's password]
	 * @return [array]                [success or error]
	 */
	public function loginUser($user_name, $user_password){
		$user_name = htmlspecialchars($user_name);
			$sql = "SELECT * FROM `users`
					WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
			$res_of_log_check = $this->db->query($sql);
			// if this user exists
			if ($res_of_log_check->rowCount() == 1) {
				// get result row (as an object)
				$res = $res_of_log_check->fetch(PDO::FETCH_OBJ);
				if (password_verify($user_password, $res->user_password_hash)) {
					// login user
					Session::set('user_id', $res->user_id);
					Session::set('user_name', $res->user_name);
					Session::set('user_email', $res->user_email);
					Session::set('user_password', $res->user_password_hash);
					Session::set('user_range', $res->user_range);
					Session::set('user_lang', $res->user_lang);
					Session::set('user_img', $res->user_img);
					Session::set('user_login_status', 1);
				} else {
					$this->messages[] = $this->mess['wrong_password'];
				}
			} else {
				$this->messages[] = $this->mess['wrong_password'];
			}
		if(0 == count($this->messages)){
			$result['success'] = 1;
		} else {
			$result['success'] = 0;
			$result['message'] =  $this->mess['wrong_password'];
		}
		return $result;
	}
	/**
	 * new user registration
	 * @return [string] [description]
	 */
	public function registerUser(){
		if (empty($_POST['user_name'])) {
			$this->messages[] = "Empty Username";
		} elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
			$this->messages[] = "Empty Password";
		} elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
			$this->messages[] = "Password and confirm password are not the same";
		} elseif (strlen($_POST['user_password_new']) < 6) {
			$this->messages[] = "Password has a minimum length of 6 characters";
		} elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 4) {
			$this->messages[] = "Username cannot be shorter than 4 or longer than 64 characters";
		} elseif (!preg_match('/^[a-z\d]{4,64}$/i', $_POST['user_name'])) {
			$this->messages[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 4 to 64 characters";
		} elseif (empty($_POST['user_email'])) {
			$this->messages[] = "Email cannot be empty";
		} elseif (strlen($_POST['user_email']) > 64) {
			$this->messages[] = "Email cannot be longer than 64 characters";
		} elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
			$this->messages[] = "Your email address is not in a valid email format";
		} elseif (!empty($_POST['user_name'])
			&& strlen($_POST['user_name']) <= 64
			&& strlen($_POST['user_name']) >= 4
			&& preg_match('/^[a-z\d]{4,64}$/i', $_POST['user_name'])
			&& !empty($_POST['user_email'])
			&& strlen($_POST['user_email']) <= 64
			&& filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
			&& !empty($_POST['user_password_new'])
			&& !empty($_POST['user_password_repeat'])
			&& ($_POST['user_password_new'] === $_POST['user_password_repeat'])
		) {
				$user_password = trim($_POST['user_password_new']);

				$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
				$user_name = trim($_POST['user_name']);
				$user_email = trim($_POST['user_email']);
				
				// check if user or email address already exists
				$sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
				$query_check_user_name = $this->db->query($sql);

				if ($query_check_user_name->rowCount() == 1) {

					$this->messages['message'] = $this->mess['already_taken'];
				} else {
					// write new user's data into database
					$sql = "INSERT INTO users (user_name, user_password_hash, user_email, time_reg)
							VALUES('" . $user_name . "', '" . $user_password_hash . "',";
						$sql .= " '" . $user_email . "',".time().");";
					
					$query_new_user_insert =  $this->db->query($sql);

					// if user has been added successfully
					if ($query_new_user_insert) {
						$this->success['message'] = $this->mess['success_created'];
					} else {
						$this->messages['message'] = $this->mess['register_failed'];
					}
				}
			} else {
				$this->messages['message'] = "Sorry, no database connection.";
		}
		if(0 < count($this->success)){
			$this->success['success'] = 1;
			return $this->success;
		}else{
			return $this->messages;
		}
	}
	/**
	 * update user's data 
	 * @return [array] [error or success]
	 */
	public function updateUserData(){
		$user_email   = Session::get('user_email');
		$user_name    = isset($_POST['user_name'])        ? $_POST['user_name']	          : null;
		$new_pass1	= isset($_POST['new_pass1'])	    ? trim($_POST['new_pass1'])       : null;
		$new_pass2	= isset($_POST['new_pass2'])	    ? trim($_POST['new_pass2'])	      : null;
		$user_password      = isset($_POST['current_password']) ? trim($_POST['current_password']): null;
		
		// проверка правильности пароля (введенный и тот под которым залогинились)
		if (password_verify($user_password, Session::get('user_password'))) {

			if($new_pass1 && ($new_pass1 == $new_pass2) ){
				$user_password = $new_pass2;
				$new_pass = password_hash($new_pass2, PASSWORD_DEFAULT);
			}elseif($new_pass1 != $new_pass2){
				$this->errors['message'] = 'Новый пароль не совпадает с второй';
			}

			$sql = "UPDATE users SET ";

			if(isset($new_pass)){
				$sql .= "`user_password_hash` = '{$new_pass}', ";
			}

			$sql .= "
						`user_name` = '{$user_name}'
					WHERE 
						`user_email` = '{$user_email}' AND `user_password_hash` = '".Session::get('user_password')."';";
			
			$res = $this->db->query($sql);
		}else{
			$this->errors['message'] = 'Текущий пароль не верный';
		}

		if(0 < count($this->errors)){
			$this->errors['success'] = 0;
			return $this->errors;
		}else{
			$this->loginUser($user_name, $user_password);
			$this->messages['success'] = 1;
			$this->messages['message'] = 'Данные успешно изменены!';
			return $this->messages;

		}
	}
	/**
	 * change user's language
	 * @param  [stirng] $user_lang [choose languange]
	 * @return [string]            [query result]
	 */
	public function changeLang($user_lang){
		$sql = "UPDATE users SET `user_lang` = '{$user_lang}' WHERE `user_id` = '{Session::get('user_id')}'";
		//set in session users's lang 
		Session::set('user_lang', $user_lang);
		return $this->db->query($sql);
	}
	/**
	 * user's avatar setter
	 * @param  [int] $user_id     [user's id]
	 * @param  [string] $newFileName [file name]
	 * @return [object] $query   [query result]
	 */
	public function uploadImage($user_id, $newFileName){
		$sql = "UPDATE `users` SET `user_img` = '{$newFileName}' WHERE `user_id` = '{$user_id}'";
		return $this->db->query($sql);
	}
}