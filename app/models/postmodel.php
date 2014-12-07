<?php 

class PostModel{
	
	private $db;
	public $mess;
	/**
	 * 
	 * @param [type] $db   [description]
	 * @param [type] $mess [description]
	 */
	function __construct($db, $mess) {
		$this->mess = $mess;
		try {
			$this->db = $db;
		} catch (PDOException $e) {
			exit('Database connection could not be established.');
		}
	}
	/**
	 * get posts where parnet id = 0 main post, subject
	 * @return object all main posts
	 */
	public function getPosts(){
			$sql = 
				"SELECT
					p.post_id,
					p.parent_id,
					p.post_name,
					p.post_content,
					p.user_id,
					p.created_at,
					u.user_name,
					count(p2.post_id) as comments
				FROM
					`posts` AS p
				LEFT JOIN `users` AS u ON p.user_id = u.user_id
				LEFT JOIN `posts` AS p2 ON p.post_id = p2.parent_id
				WHERE p.parent_id = 0
				GROUP BY p.post_id
				";
		$query =  $this->db->query($sql);
		return $query->fetchAll();
	}
	/**
	 * get post where post_id = $id
	 * @param  int $id  id post
	 * @return [array] post data
	 */
	public function get($id){
		$result = array();
		$sql = "SELECT
					p.post_id,
					p.parent_id,
					p.post_name,
					p.post_content,
					p.user_id,
					p.created_at,
					u.user_name,
					count(p2.post_id) as count_comment
				FROM
					`posts` AS p
				LEFT JOIN `users` AS u ON p.user_id = u.user_id
				LEFT JOIN `posts` AS p2 ON p.post_id = p2.parent_id
				WHERE p.post_id = {$id} AND p.parent_id = 0
				GROUP BY p.post_id
				";
		$query =  $this->db->query($sql);
		$row = $query->fetch(PDO::FETCH_ASSOC);
		if ($row['post_id']) {
			$comments = $this->getChild($row['post_id']);
			if ($comments) {
				$row['comments'] = $comments;
			}
			return $row;
		}
		return false;
	}
	/**
	 * get child comments with recursion
	 * @param  [int] $post_id [post_id where parent_id]
	 * @return [array] [all comments child comments]
	 */
	public function getChild($post_id){
		//constraint for protect from infinity cycle
		static $i = 0; $i++;
		if ($i > 10) {
			return false;
		}
		$result = array();
		$query = $this->db->query(
			"SELECT
				p.post_id,
				p.parent_id,
				p.post_name,
				p.post_content,
				p.user_id,
				p.created_at,
				u.user_name
			FROM `posts` AS p
			LEFT JOIN `users` AS u ON p.user_id = u.user_id
			WHERE parent_id = '{$post_id}' ORDER BY p.post_id DESC");
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$comments = $this->getChild($row['post_id']);
				if ($comments) {
					$row['comments'] = $comments;
				}
				$result[] = $row;
			}
			return $result;
	}
	/**
	 * [delete post where post_id = $post_id]
	 * @param  [int] $post_id [post id ]
	 * @return [nothing]
	 */
	public function deletePost($post_id)
	{
		$sql = "DELETE FROM posts WHERE post_id = :post_id";
		$query = $this->db->prepare($sql);
		$query->execute(array(':post_id' => $post_id));
	}
	/**
	 * [add comment function]
	 * @param [string] $post_content [comment content ]
	 * @param [int] $user_id      [sended user id ]
	 * @param [int] $parent_id    [subject id or comment id]
	 */
	public function addComment($post_content, $user_id, $parent_id, $post_name){
		$current = time();
		$sql = "INSERT INTO posts(parent_id, post_name, user_id, post_content, created_at)
					VALUES ($parent_id, '{$post_name}', {$user_id}, '{$post_content}', $current)";
		return $this->db->query($sql);
	}
}