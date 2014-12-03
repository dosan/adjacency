<!DOCTYPE html>
<html lang="en">
<head>
	<title>Test task</title>
	<link rel="stylesheet" href="<?php echo CSS_PATH ?>style.css" type="text/css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" type="text/css">
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="<?php echo URL; ?>public/js/main.js"></script>
	<script>
	<?php
		$jsMessages = json_encode($this->mess);
		echo "var jsMessages = ". $jsMessages . ";\n";
	?>
	</script>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<?php if (Session::get('user_login_status') == 1): ?>
							<ul class="nav navbar-nav navbar-right">
								<li><a href="<?php echo URL ?>user"> <?php echo Session::get('user_name') ?></a></li>
								<li><a href="<?php echo URL ?>user/logout">Log Out</a></li>
								<li>
									<div class="selectContainer">
										<select class="form-control" id="SelectLang" onchange="changeLang()">
											<?php foreach ($this->languages as $key => $value): ?>
												<option value="<?php echo $key ?>" id="lang_<?php echo $key ?>"
													<?php if (Session::get('user_lang') == $key): ?>
														selected
													<?php endif ?>
													>
													<?php echo $value['name'] ?>
												</option>
											<?php endforeach ?>
										</select>
									</div>
								</li>
							</ul>
						<?php else: ?>
								<ul class="nav navbar-nav navbar-right">
									<li>
									<div class="selectContainer">
										<select class="form-control" id="SelectLang" onchange="changeLang()">
											<?php foreach ($this->languages as $key => $index): ?>
											<?php if (Session::get('user_lang')): ?>
												<option value="<?php echo $key ?>" id="lang_<?php echo $key ?>"
													<?= Session::get('user_lang') == $key ? 'selected' : ''?>
													>
													<?php echo $index['name'] ?>
												</option>
											<?php else: ?>
											<option value="<?php echo $key ?>" id="lang_<?php echo $key ?>"	<?= $key == 'en' ? 'selected' : '' ?>>
											<?php echo $index['name'] ?></option>
											<?php endif ?>
											<?php endforeach ?>
										</select>
									</div>
									</li>
								</ul>
						<?php endif ?>
				</div>
			</div>
		</nav>