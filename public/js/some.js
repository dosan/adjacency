
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
			err.push('confirm password:'+jsMessages['u_enter_same_pass']);
		}
	}
	if (err.length > 0) {
		allerr[0] = err.join('<br />');
		reportErrors('errUpdateInput', allerr, 'updateerrmessage');
		return false;
	}
	if (!updateUserData()) {
		err.push(jsMessages['wrong_password']);
		reportErrors('errUpdateInput', err, 'updateerrmessage');
		return false;
	}
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
		err.push('current password:'+jsMessages['u_enter_oldpassword']);
	}
	if (user_password.length != 0) {
		if (user_password.length < 6 || user_password.length > 64){
			err.push('password:'+jsMessages['r_password_length']);
		}
		if (user_password !== user_password_rep ){
			err.push('repeat password:'+jsMessages['r_confirm_password']);
		}
		if (user_password_rep == '' || user_password_rep == null) {
			err.push('confirm password:'+jsMessages['u_enter_same_pass']);
		}
	}
	if (err.length > 0) {
		allerr = err.join('<br />');
		reportErrors('errUpdateInput', allerr, 'updateerrmessage');
		return false;
	}
	if (!updateUserData()) {
		err.push(jsMessages['wrong_password']);
		reportErrors('errUpdateInput', err, 'updateerrmessage');
		return false;
	}
}
