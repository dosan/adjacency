<?php 

class PostModel{
	
	private $db;
	
	function __construct($db, $mess) {
		$this->mess = $mess;
		try {
			$this->db = $db;
		} catch (PDOException $e) {
			exit('Database connection could not be established.');
		}
	}

	public function getPosts(){
			$sql = 
				"SELECT
					p.post_id,
					p.parent_id,
					p.post_name,
					p.post_content,
					p.user_id,
					p.created_at
				FROM
					posts AS p
				WHERE p.parent_id = 0";
		$query =  $this->querySqlWithTryCatch($sql);
		return $query->fetchAll();
	}
	public function get($id){
		$result = array();
		$sql = "SELECT
					p.post_id,
					p.parent_id,
					p.post_name,
					p.post_content,
					p.user_id,
					p.created_at,
					Count(p2.post_id) AS `comment`
				FROM
					`posts` AS p
				LEFT JOIN `posts` AS p2 ON p.post_id = p2.parent_id
				WHERE p.parent_id = 0 AND p.post_id = $id";
		$query =  $this->querySqlWithTryCatch($sql);
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
	public function getChild($post_id){
		static $i = 0; $i++;
		$result = array();
		$query = $this->querySqlWithTryCatch(
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
			WHERE parent_id = '{$post_id}'");
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$comments = $this->getChild($row['post_id']);
				if ($comments) {
					$row['comments'] = $comments;
				}
				$result[] = $row;
			}
			return $result;
	}

	public function getArrayResult($query){
		if(! $query) return false;
		$result = array();
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}
		return $result;
	}

	public function querySqlWithTryCatch($sql){
		try {
			$query = $this->db->prepare($sql);
			$query->execute();
		} catch (PDOException $e) {
			exit(CONNECTION_FAILED);
		}
		return $query;
	}
	/**
	 * [add comment function]
	 * @param [string] $post_content [comment content ]
	 * @param [int] $user_id      [sended user id ]
	 * @param [int] $parent_id    [subject id or comment id]
	 */
	public function addComment($post_content, $user_id, $parent_id){
		$current = time();
		$sql = "INSERT INTO posts(parent_id, post_name, user_id, post_content, created_at)
					VALUES ($parent_id, 'it\'s a comment', $user_id, '$post_content', $current)";
		return $this->querySqlWithTryCatch($sql);
	}
}