/**
 * Авторизация пользователя
 * 
 */
function login(){
	var user_name = $('#input_user_name').val();
	var user_password = $('#input_user_password').val();

	var postData = {user_name: user_name, 
					user_password: user_password};
	
	$.ajax({
		type: 'POST',
		async: false,
		url: "/user/login",
		data: postData,
		dataType: 'json',
		success: function(data){
			if(data['success']){
				document.location = '/';
			}else{
				alert(data['message']);
			}
		}
	}); 
}

/**
 * Регистрация нового пользователя
 * 
 */
function registerNewUser(){
	var user_name            = $('#register_input_username').val();
	var user_email           = $('#register_input_email').val();
	var user_password_new    = $('#register_input_password_new').val();
	var user_password_repeat = $('#register_input_password_repeat').val();

	var postData = {
		user_name: user_name, 
		user_email: user_email,
		user_password_new: user_password_new, 
		user_password_repeat: user_password_repeat};
	$.ajax({
		type: 'POST',
		async: false,
		url: "/user/register",
		data: postData,
		dataType: 'json',
		success: function(data){
			if(data['success']){
				alert(data['message']);
				document.location = '/';
			} else {
				alert(data['message']);
			}
		}
	});
}
	/**
	* Обновление данных пользователя
	* 
	*/
function updateUserData(){
	var user_name         = document.getElementById("update_input_username").value;
	var user_password     = document.getElementById("update_input_password_new").value;
	var user_password_rep = document.getElementById("update_input_password_repeat").value;
	var oldpassword       = document.getElementById("update_input_oldpassword").value;
	
	var nameErr = [];
	var passErr = [];
	var passRepErr = [];
	var oldPassErr = [];	

	var postData = {new_pass1: user_password, 
					new_pass2: user_password_rep, 
					current_password: oldpassword,
					user_name: user_name};
		
	$.ajax({
		type: 'POST',
		async: false,
		url: "/user/updateuser",
		data: postData,
		dataType: 'json',
		success: function(data){
			if(data['success']){
				alert(data['message']);
				document.location.reload(true);
			} else {
				var err = 'Current password is wrong.'
				reportErrors('errUpdateInput', err, 'updateerrmessage');
			}
		}
	});
}

function changeLang() {
	var list = document.getElementById("SelectLang");
	var selLang = list.options[list.selectedIndex].value;
	var postData = {language : selLang};
	$.ajax({
		type: 'POST',
		async: false,
		url: "/user/changeLang",
		data: postData,
		dataType: 'json',
		success: function(data){
			if(data['success']){
				document.location.reload(true)
			}else{
				alert(data['message']);
			}
		}
	});
}

function validateLoginForm() {
	var user_name = document.getElementById("input_user_name").value;
	var user_password = document.getElementById("input_user_password").value;
	var nameErr = [];
	var passErr = [];
	if (user_name == "" || user_name == null) {
		nameErr.push(jsMessages['enter_your_name']);
	}
	if (user_password == "" || user_password == null) {
		passErr.push(jsMessages['enter_your_password']);
	}
	if (nameErr.length > 0 || passErr.length > 0) {
		if (nameErr.length > 0) {
			reportErrors('errUserName', nameErr);
		}else{
			hideShowedErr('errUserName');
		}
		if (passErr.length > 0) {
			reportErrors('errUserPassword', passErr);
		}else{
			hideShowedErr('errUserPassword');
		}
		return false;
	}
	function checkLength(text, min, max){
		min = min || 3;
		max = max || 1000;
		
		if (text.length < min || text.length > max) {
			return false;
		}
		return true;
	}
	function hideShowedErr(idErr){
		document.getElementById(idErr).setAttribute('class', 'hide');
	}
	function reportErrors(idErr, err){
		document.getElementById(idErr).innerHTML =  err;
		document.getElementById(idErr).setAttribute('class', 'errmessage');
	}
	return login();
}

function validateUpdateForm() {
	var user_name         = document.getElementById("update_input_username").value;
	var user_password     = document.getElementById("update_input_password_new").value;
	var user_password_rep = document.getElementById("update_input_password_repeat").value;
	var oldpassword       = document.getElementById("update_input_oldpassword").value;
	
	var err = [];
	var allerr = [];
	var regUserName = /^[a-zA-Z0-9_]+$/;

	if (user_name == "" || user_name == null) {
		err.push('name: '+jsMessages['r_enter_your_name']);
	}
	if (user_name.length < 4 || user_name.length > 64) {
		err.push('name:'+jsMessages['r_name_length']);
	}
	if (!regUserName.exec(user_name)) {
		err.push('name:'+jsMessages['r_name_letters_num']);
	}
	if (oldpassword == '' || oldpassword == null) {
		err.push('password:'+jsMessages['u_enter_oldpassword']);
	}
	if (user_password.length != 0) {
		if (user_password.length < 6 || user_password.length > 64){
			err.push('password:'+jsMessages['r_password_length']);
		}
		if (user_password_rep == '' || user_password_rep == null) {
			err.push('confirm password:'+jsMessages['r_confirm_password']);
		} else if (user_password !== user_password_rep ){
			err.push('repeat password:'+jsMessages['u_enter_same_pass']);
		}
	}
	if (err.length > 0) {
		allerr[0] = err.join('<br />');
		reportErrors('errUpdateInput', allerr, 'updateerrmessage');
		return false;
	}
	updateUserData();
}

function validateRegisterForm() {
	var user_name         = document.getElementById("register_input_username").value;
	var user_email        = document.getElementById("register_input_email").value;
	var user_password     = document.getElementById("register_input_password_new").value;
	var user_password_rep = document.getElementById("register_input_password_repeat").value;
	
	var nameErr = [];
	var emailErr = [];	
	var passErr = [];
	var passRepErr = [];
	var regUserName = /^[a-zA-Z0-9_]+$/;
	var regUserEmail = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	if (user_name == "" || user_name == null) {
		nameErr.push(jsMessages['r_enter_your_name']);
	}
	if (user_name.length < 4 || user_name.length > 64) {
		nameErr.push(jsMessages['r_name_length']);
	}
	if (!regUserName.exec(user_name)) {
		nameErr.push(jsMessages['r_name_letters_num']);
	}
	if (user_email == "" || user_email == null || user_email.length > 64) {
		emailErr.push(jsMessages['r_enter_your_email']);
	}
	if (!regUserEmail.exec(user_email)) {
		emailErr.push(jsMessages['r_valid_email']);
	}
	if (user_password == "" || user_password == null) {
		passErr.push(jsMessages['enter_your_password']);
	}
	if (!regUserName.exec(user_password)) {
		passErr.push(jsMessages['r_name_letters_num']);
	}
	if (user_password.length < 6 || user_password.length > 64){
		passErr.push(jsMessages['r_password_length']);
	}
	if (user_password_rep == "" || user_password_rep == null) {
		passRepErr.push(jsMessages['r_confirm_password']);
	}
	if (user_password !== user_password_rep) {
		passRepErr.push(jsMessages['r_enter_same_pass']);
	}
	if (nameErr.length > 0 || emailErr.length > 0 || passErr.length > 0 || passRepErr.length > 0) {
		if (nameErr.length > 0) {
			reportErrors('errUserName', nameErr, 'errmessage');
		}else{
			hideShowedErr('errUserName');
		}
		if (emailErr.length > 0) {
			reportErrors('errUserEmail', emailErr, 'errmessage');
		}else{
			hideShowedErr('errUserEmail');
		}
		if (passErr.length > 0) {
			reportErrors('errUserPassword', passErr, 'errmessage');
		}else{
			hideShowedErr('errUserPassword');
		}
		if (passRepErr.length > 0) {
			reportErrors('errUserPasswordNew', passRepErr, 'errmessage');
		}else{
			hideShowedErr('errUserPasswordNew');
		}
		return false;
	}
	return registerNewUser();
}
function hideShowedErr(idErr){
	document.getElementById(idErr).setAttribute('class', 'hide');
}
function reportErrors(idErr, err, classN){
	document.getElementById(idErr).innerHTML =  err[0];
	document.getElementById(idErr).setAttribute('class', classN);
}

function showUploadImage(){
	var showHiddenUploader = document.getElementById("showHiddenUploader");
	if( $(showHiddenUploader).attr('class') != 'show' ) {
		$(showHiddenUploader).attr('class', 'show');
	} else {
		$(showHiddenUploader).attr('class', 'hide');
	}
}
/**
 * Показывать или прятать данные о заказе
 * 
 */
function showFormAnswer(id){
	var objName = "#show_an_for_" + id;
	if( $(objName).attr('class') != 'show' ) {
		$(objName).attr('class', 'show');
	} else {
		$(objName).attr('class', 'hide');
	}
}
function sendReply(id){
	var answer = $('#answer_for_'+ id).val();
	var post_name = $('#post_name').val();
	var postData = {answer: answer, post_id: id, post_name: post_name};

	$.ajax({
		type: 'POST',
		async: false,
		url: "/post/addcomment/",
		data: postData,
		dataType: 'json',
		success: function(data){
			if (data['success']) {
				document.location.reload(true);
			}else{
				alert(data['message']);	
			}
		}
	});
}