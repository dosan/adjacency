<?php
// show potential errors / feedback (from login object)
if (0 < count($this->message)) {
	foreach ($this->message as $message) {
		echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
	}
}
?>

<h1 class="form-header ml">Ваши регистрационные даные:</h1>
<div class='col-md-3'>
		<div class="user_profile"><?php echo Session::get('user_name') ?></div>
		<div class="user_profile"><?php echo Session::get('user_email') ?></div>
		<img class="img-avatar" width="200" height="200" src="<?= Session::get('user_img') ? IMG_PATH.Session::get('user_img') : IMG_PATH.'no-avatar.jpg'; ?>">
		<a class="ml"href="#" onClick="showUploadImage(); return false;">Reload Avatar</a>
		<div class="hide" id="showHiddenUploader">
			<form action="<?php echo URL ?>user/imageUpload/" method="post" enctype="multipart/form-data">
				<input type="file" name="filename">
				<input type="hidden" name="user_name" value="<?php echo Session::get('user_name'); ?>">
				<input type="hidden" name="item_id" value="<?php echo Session::get('user_id'); ?>">
				<input type="submit" value="загрузить">
			</form>
		</div>
</div>
<div class="col-md-4">
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut magni fugiat ipsa aspernatur distinctio! Voluptas incidunt doloribus vitae dolor. Sapiente provident placeat eveniet doloremque delectus, debitis ullam officiis, saepe eligendi.</p>
	<div class='hide' id="errUpdateInput">eaoua edd</div>
	<div class="form-group">
		<label for="user_email">Логин (email)</label>
		<input type="text" class="inputs" name="user_email" value="<?php echo Session::get('user_email') ?>" disabled/>
	</div>
	<div class="form-group">	
		<label for="user_name">Имя</label>
		<input type="text" id="update_input_username" class="inputs" name="user_name" value="<?php echo Session::get('user_name'); ?>" />
	</div>
	<div class="form-group">		
		<label for="new_pass1">Новый пароль</label>
		<input type="password" id="update_input_password_new" class="inputs" name="new_pass1" value="" />
	</div>
	<div class="form-group">
		<label for="new_pass2">Повтор пароля</label>
		<input type="password" id="update_input_password_repeat" class="inputs" name="new_pass2" value="" />
	</div>
	<div class="form-group">
		<label for="current_password">Для того чтобы сохранить данные введите текущий пароль</label>
		<input type="password" id="update_input_oldpassword" class="form-control" name="current_password" value="" />
	</div>
		<input type="button" onclick="validateUpdateForm()" class="btn btn-primary" name="updateUser" value="Сохранить изменения"/>
		<a href="<?php echo URL.'user/logout' ?>">Logout</a>
	</div>
</div>