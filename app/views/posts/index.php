<div class="content">
	<article>
		<?php foreach ($this->posts as $post) { ?>
			<a href="<?php echo URL ?>post/<?= $post->post_id;?>"><h1><?php if (isset($post->post_name)) echo $post->post_name; ?></h1></a>
			<p>
			<?php echo $this->stringCut($post->post_content); ?>
			</p>
			<p>
				<a href="<?php echo URL ?>post/<?= $post->post_id;?>" class="btn btn-info" role="button">Read more</a>
				Comments(<?php echo $post->comments; ?>)
			<span class="date">
				<?php if (isset($post->created_at)) echo date('Y-m-d, H:m:s',$post->created_at); ?>
			</span>
			<span class="author">
				Author: <?php echo $post->user_name ?>
			</span>
			</p>
	<?php }//end foreach post?>
	</article>
	<?php if (Session::get('user_login_status') == 1): ?>
		
		<h3>Add the new post</h3>
			<label>Post name</label>
			<input type="text" class="form-control" id="post_name" name="post_name" value="" required />
			<label>Post content</label>
			<textarea class="form-control" id="answer_for_0" style="width: 100%; max-width: 100%;" rows="10"></textarea><br />
			<button class="btn btn-lg btn-primary" onclick="sendReply(0)">send</button>
	<?php else: ?>
	[ <a href="<?php echo URL?>user/register">Регистрация</a> | <a href="<?php echo URL ?>user">Вход</a> ]
	<?php endif ?>
</div>