<?php

class Lang{
	public $lang;
	/**
	 * constructor Lang choose language
	 * @param string $lang tiny language name has only 2 letter, default language = 'en'
	 */
	public function __construct($lang = 'en'){
		$langs = $this->langs();
		if (array_key_exists($lang, $langs)) {
			$this->lang = $langs[$lang];
			return $this->lang;
		}
		return 'Sorry, We don\'t have this language';
	}
	/**
	 * langs in array
	 * @return [array] [data of langs]
	 */
	public function langs(){
		$langs = array(
			'ru' => array(
				'name'                => 'Русский',
				'error'               => 'ошибка!',
				'wrong_password'      => 'Неверный пароль или имя. Пожалуйста, попробуйте еще раз.',
				'ph_email_or_login'   => 'Электронная почта или Имя',
				'ph_password'         => 'введите пароль',
				'bt_sign_in'          => 'войти',
				'header_sign_in'      => 'Войти',
				'link_to_register'    => 'Регистрация',
				'success_created'     => 'Ваша учетная запись была успешно создана. Теперь вы можете войти',
				'register_failed'     => 'Ваша регистрация не удалась. Пожалуйста вернитесь и попробуйте снова.',
				'already_taken'       => 'Извините, это имя пользователя / адрес электронной почты уже занято.',
				########### page register #############
				'header_sign_up'      => 'Регистрация пользователя',
				'r_ph_username'       => 'Ваше имя',
				'r_ph_email'          => 'Ваша электронная почта',
				'r_ph_password'       => 'Пароль (минимум 6 символов)',
				'r_ph_rep_password'   => 'Повторите пароль',
				'btn_register'        => 'Регистрация',
				'back_to_login'       => 'Назад на страницу входа',
				############### js validator messages ###############
				'enter_your_name'     => 'Пожалуйста введите имя/e-mail',
				'enter_your_password' => 'Пожалуйста, введите пароль',
				'u_enter_oldpassword' => 'Введите старый пароль',
				'r_enter_your_name'   => 'Введите имя пользователя',
				'r_name_length'       => 'Имя должно быть длиной от 4 до 64',
				'r_name_letters_num'  => 'Только цифры и латинские буквы',
				'r_enter_your_email'  => 'Введите ваш электронный адресс',
				'r_valid_email'       => 'Должно быть действующий email адресс',
				'r_confirm_password'  => 'Подтвердите пароль',
				'r_password_length'   => 'Пароль должен иметь длину от 6 до 64',
				'r_enter_same_pass'   => 'Введите тот же пароль, что и выше',
				'u_enter_same_pass'   => 'Пароль и подтверждение пароля не совпадают',
			),
			'en' => array(
				'name'                => 'English',
				'error'               => 'error!',
				'wrong_password'      => 'Wrong password or Name. Please try again!',
				'header_sign_in'      => 'Please sign in',
				'ph_email_or_login'   => 'Email or Name',
				'ph_password'         => 'enter your password',
				'bt_sign_in'          => 'sign in',
				'link_to_register'    => 'Registration',
				'success_created'     => 'Your account has been created successfully. You can now log in.',
				'register_failed'     => 'Sorry, your registration failed. Please go back and try again.',
				'already_taken'       => 'Sorry, that username / email address is already taken',
				########### page register #############
				'header_sign_up'      => 'User Registration',
				'r_ph_username'       => 'User name',
				'r_ph_email'          => 'Your E-mail address',
				'r_ph_password'       => 'Password (min. 6 characters)',
				'r_ph_rep_password'   => 'Confirm password',
				'btn_register'        => 'Sign up',
				'back_to_login'       => 'Back to Login Page',
				############### js validator messages ###############
				'enter_your_name'     => 'Please, enter your E-mail/login',
				'enter_your_password' => 'Please, enter your password',
				'u_enter_oldpassword' => 'Enter the old password',
				'r_enter_your_name'   => 'Enter a username',
				'r_name_length'       => 'Name must be of length 4 to 64',
				'r_name_letters_num'  => 'Letters and numbers only',
				'r_enter_your_email'  => 'Email cannot be empty',
				'r_valid_email'       => 'Must be valid Email',
				'r_confirm_password'  => 'Confirm password',
				'r_password_length'   => 'Password must be of length 6 to 64',
				'r_enter_same_pass'   => 'Enter the same password as above',
				'u_enter_same_pass'   => 'Password and confirm password are not the same',
				
			)
		);
		return $langs;
	}
}