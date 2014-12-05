<div class="content">
	<div class="content_hedaer">
	<?php echo $this->post_index['post_name']; ?>
	</div>
	<div class="content_subject">
		<?php echo $this->post_index['post_content'];?>
		<div class="subject_footer">
			Answers (<?= $this->post_index['comment'] or '0'; ?>)
			<span class="date">
				<?php if (isset($this->post_index['created_at'])) echo date('Y-m-d, H:m:s',$this->post_index['news_time']); ?>
			</span>
			<span class="author">
				Author: <?php echo $this->post_index['user_name'] ?>
			</span>
			<?php if (Session::get('user_range') == 'admin'): ?>
				<a class='btn btn-xs btn-danger' href='<?php echo URL?>post/deletepost/<?php echo $this->post_index['post_id'] ?>'>delete</a>
			<?php endif ?>
		</div>
	</div>
		<div class="content_comment">
		<?php if ($this->post_index['comments']): ?>
		<?php $this->showComments($this->post_index['comments']) ?>
		<?php endif ?>
	</div>
<?php if (Session::get('user_range') == 'user' or Session::get('user_range') == 'admin'): ?>
		<h3>leave a comment</h3>
		<label>Your comment</label>
		<textarea class="form-control" id="answer_for_<?php echo $this->post_index['post_id']; ?>" style="width: 100%; max-width: 100%;" rows="10"></textarea><br />
		<button class="btn btn-lg btn-primary" onclick="sendReply(<?php echo $this->post_index['post_id'] ?>)">send</button>
<?php endif ?>
</div>
