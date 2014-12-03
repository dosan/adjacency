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
					p.created_at,
					Count(p2.post_id) AS `comment`
				FROM
					posts AS p
				LEFT JOIN posts AS p2 ON p.post_id = p2.parent_id";
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
					posts AS p
				LEFT JOIN posts AS p2 ON p.post_id = p2.parent_id
				WHERE p.post_id = '$id'";
		$query =  $this->querySqlWithTryCatch($sql);
		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$comments = $this->getChild($row['post_id']);
			if ($comments) {
				$row['comments'] = $comments;
			}
			$result[] = $row;
		}
		return $result;
	}
	public function getChild($post_id){
		$result = array();
		$query = $this->querySqlWithTryCatch("SELECT * FROM `posts` WHERE parent_id = '{$post_id}'");
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
}