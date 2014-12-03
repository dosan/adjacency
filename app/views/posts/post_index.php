<div class="content">
	<article>
	<h1><?php echo $this->post_index['post_name']; ?></h1>
		<p>
			<?php echo $this->post_index['post_content'];?>
		</p>
		<hr>
		<p>
			<?php
			if (Session::get('user_range') == 'admin') {
				// script for delete this post
				print "<a  class='btn btn-sm btn-danger' href='".URL."news/deletenews/".$this->post_index['news_id']."'>delete</a>";
			}
			?>
			Comments (<?= $this->post_index['comment'] != null ? $this->post_index['comment'] : '0'; ?>)
			<span class="date">
				<?php if (isset($this->post_index['news_time'])) echo date('Y-m-d, H:m:s',$this->post_index['news_time']); ?>
			</span>
		</p>
		<hr>
<?php foreach ($this->post_index['comments'] as $key) { ?>
 <h3><?php echo $key['user_name'] ?></h3>
      <p><?php echo $key['comment_content'] ?></p>
	<hr>
<?php 
} //end while post_index ?>
<?php if (Session::get('user_range') == 'user' or Session::get('user_range') == 'admin'): ?>
		<div>
			<h3>leave a comment</h3>
			<p>
				<form action="<?php echo URL; ?>news/leaveAComment" method="post">
					<p>
					<label>Your comment</label>
					<textarea class="form-control" maxlength="555" name="comment_content"></textarea><br />
					<input type="hidden" name="news_id" value="<?php echo $this->post_index['news_id']; ?>">
					<input type="hidden" name="news_url" value="<?php echo $this->post_index['news_url']; ?>">
					<input class="btn btn-lg btn-primary" type="submit" name="submit_add_post" value="Submit" /></p>
				</form>
			</p>
		</div>
<?php endif ?>
</article>
</div>