<div class="content">
	<div class="col-md-4 col-md-offset-3">
		<h2 class="form-header"><?php echo $this->mess['header_sign_in'];?></h2>
	</div>
	<div class="l_form_input">
		<input type="text" name="user_name" id="input_user_name" class="form-control" value="" placeholder="<?php echo $this->mess['ph_email_or_login'];?>" autofocus>
	</div>
	<div class='hide' id="errUserName"></div>
	<div class="l_form_input">
		<input name="user_password" type="password" id="input_user_password" class="form-control" value="" placeholder="<?php echo $this->mess['ph_password'];?>">
	</div>
	<div class='hide' id="errUserPassword"></div>
	<div class="col-md-4 col-md-offset-3">
		<input class="btn btn-primary" type="button" onClick="return validateLoginForm()" value="<?php echo $this->mess['bt_sign_in']; ?>">
		<a href="<?php echo URL ?>user/register" title="Регистрация"><?php echo $this->mess['link_to_register'];?></a>
	</div>
</div>