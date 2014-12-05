<?php
class Post extends Controller{
	public $posts;
	public $post_index;

	public function index(){
		$posts = $this->model('PostModel');
		$this->posts = $posts->getPosts();
		require VIEWS_PATH.'layouts/header.php';
		require VIEWS_PATH.'posts/index.php';
		require VIEWS_PATH.'layouts/footer.php';
	}
	public function getId($id){
		$posts = $this->model('PostModel');
		$this->post_index = $posts->get($id);
		if ($this->post_index) {
		require VIEWS_PATH.'layouts/header.php';
		require VIEWS_PATH.'posts/post_index.php';
		require VIEWS_PATH.'layouts/footer.php';
		}
	}
	public function addPost(){
		if (Session::get('user_login_status') == 1) {
			// if we have POST data to create a new song entry
			if (isset($_POST["submit_add_news"])) {
				// load model, perform an action on the model
				$news_model = $this->model('NewsModel');
				$news_model->addPost( strip_tags(trim($_POST["news_name"])), $_POST["news_description"], Session::get("user_id"));
			}
			header('location: ' . URL . 'news/index');
		}
	}
	/**
	 * function for leave comments or answers
	 */
	public function addcomment(){
		if (Session::get('user_login_status') == 1) {
			if ($_POST['answer'] AND $_POST['post_id']) {
				$user = Session::get('user_id');
				$post_id = intval($_POST['post_id']);
				$comment = addslashes(nl2br($_POST['answer']));
				// load model, perform an action on the model
				$model = $this->model('PostModel');
				$result = $model->addComment($comment, $user, $post_id);
				$resData = array();
				if ($result) {
					$resData['success'] = 1;
					$resData['message'] = 'Comment added succesfully';
				}else{
					$resData['message'] = 'something went wrong';
				}
				echo json_encode($resData);
			}
		}
	}
	public function deletePost($post_id)
	{
		//only admin have access to the function deletePost
		if (Session::get('user_range') == 'admin') {
			// if we have an id of a new that should be deleted
			if (isset($post_id)) {
				// load model, perform an action on the model
				$news_model = $this->model('NewsModel');
				$news_model->deletePost($post_id);
			}
		}
		header('location: ' . URL . 'news/index');
	}
	public function showComments($postData){
		foreach ($postData as $key => $value) {
			echo '<div class="comments">';
			echo '<div class="comment_hedaer">';
			echo $value['user_name'].' at '.date('Y-m-d, H:m', $value['created_at']);
			if (Session::get('user_login_status') == 1) {
				echo ' <a href="#" onclick="showFormAnswer('.$value['post_id'].'); return false;">Reply</a>';
			}
			echo '<br></div>';
			echo '<div class="comment_content">'.$value['post_content'];
			echo '<div class="hide" id="show_an_for_'.$value['post_id'].'">';
			echo '<textarea id="answer_for_'.$value['post_id'].'" style="width: 100%; max-width: 100%;" rows="10"></textarea>';
			echo '<button onclick="sendReply('.$value['post_id'].')">send</button></div>';
			echo '</div>';
			if ($value['comments']) {
				$this->showComments($value['comments']);
			}
			echo '</div>';
		}
	}
}
?>