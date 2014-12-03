<div class="content">
	<article>
		<?php foreach ($this->posts as $post) { ?>
				<a href="<?php echo URL ?>post/<?= $post->post_id;?>"><h1><?php if (isset($post->post_name)) echo $post->post_name; ?></h1></a>
				<p>
				<?php echo $this->stringCut($post->post_description); ?>
				</p>
				<p>
					<a href="<?php echo URL ?>post/<?= $post->post_id;?>" class="btn btn-info" role="button">Read more</a>
					Comments(<?php echo $post->comment; ?>)
				<span class="date">
					<?php if (isset($post->created_at)) echo date('Y-m-d, H:m:s',$post->created_at); ?>
				</span>
				</p>
	<?php }//end foreach post
	// if admin logged in,this script will connect add_post.php
	//Session::get('user_range') == 'admin' AND require 'action/add_post.php';
	?>
	</article>
	</div>
</div>