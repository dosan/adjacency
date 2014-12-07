<?php
class Post extends Controller{
	/**
	 * posts list data
	 * @var [array]
	 */
	public $posts;
	/**
	 * post data
	 * @var [array]
	 */
	public $post_index;

	/**
	 * index action main post page
	 * @return [view] [list of posts]
	 */
	public function index(){
		$posts = $this->model('PostModel');
		$this->posts = $posts->getPosts();
		require VIEWS_PATH.'layouts/header.php';
		require VIEWS_PATH.'posts/index.php';
		require VIEWS_PATH.'layouts/footer.php';
	}
	/**
	 * get page post id something like that http://localhost/post/22
	 * @param  [int] $id [id post]
	 * @return [view]     [view page post/$id]
	 */
	public function getId($id){
		$posts = $this->model('PostModel');
		$this->post_index = $posts->get($id);
		if ($this->post_index) {
		require VIEWS_PATH.'layouts/header.php';
		require VIEWS_PATH.'posts/post_index.php';
		require VIEWS_PATH.'layouts/footer.php';
		}
	}
	/**
	 * function for leave comments or answers
	 * @return  array json data result
	 */
	public function addcomment(){
		if (Session::get('user_login_status') == 1) {
			if ($_POST['answer'] AND isset($_POST['post_id'])) {
				$user = intval(Session::get('user_id'));
				$post_id = intval($_POST['post_id']);
				$comment = addslashes(nl2br($_POST['answer']));
				$post_name = isset($_POST['post_name']) ? addslashes($_POST['post_name']) : 'its just comment';
				// load model, perform an action on the model
				$model = $this->model('PostModel');
				$result = $model->addComment($comment, $user, $post_id, $post_name);
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
	/**
	 * delete post
	 * @param  [int] $post_id [post id ]
	 * @return [nothing]
	 */
	public function deletePost($post_id)
	{
		//only admin have access to the function deletePost
		if (Session::get('user_range') == 'admin') {
			// if we have an id of a new that should be deleted
			if (isset($post_id)) {
				// load model, perform an action on the model
				$model = $this->model('PostModel');
				$model->deletePost($post_id);
			}
		}
		header('location: ' . URL . 'news/index');
	}
	/**
	 * print comments(I know is wrong way to store view in controller)
	 * @param  [array] $postData [data of comments to print]
	 * @return [view]
	 */
	public function showComments($postData){
		foreach ($postData as $key => $value) {
			//constraint for protect from infinity cycle
			static $i; $i++;
			echo '<div class="comments">';
			echo '<div class="comment_hedaer">';
			echo $value['user_name'].' at '.date('Y-m-d, H:m', $value['created_at']);
			if (Session::get('user_login_status') == 1 AND $i < 10) {
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