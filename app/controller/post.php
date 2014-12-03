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
		d($this->post_index);
	/*	require VIEWS_PATH.'layouts/header.php';
		require VIEWS_PATH.'posts/post_index.php';
		require VIEWS_PATH.'layouts/footer.php';*/
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
	public function leaveAComment(){
		// simple message to show where you are
		//echo 'Message from Controller: You are in the Controller: News, using the method leaveAComment().';
		if (Session::get('user_login_status') == 1) {
			if (isset($_POST["submit_add_post"])) {
				// load model, perform an action on the model
				$news_model = $this->model('NewsModel');
				$news_model->leaveAComment($_POST["comment_content"],
										Session::get("user_id"),
										$_POST["news_id"]);
				// where to go after news has been added
				header('location: ' . URL . "news/index/{$_POST['news_url']}");
			}
		}
	}
	public function deletePost($news_id)
	{
		//only admin have access to the function deletePost
		if (Session::get('user_range') == 'admin') {
			// if we have an id of a new that should be deleted
			if (isset($news_id)) {
				// load model, perform an action on the model
				$news_model = $this->model('NewsModel');
				$news_model->deletePost($news_id);
			}
		}
		header('location: ' . URL . 'news/index');
	}
}
?>