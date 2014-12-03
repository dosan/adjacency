CREATE TABLE posts (
	post_id      INT(11) NOT NULL AUTO_INCREMENT,
	parent_id    INT(11) NOT NULL DEFAULT '0',
	post_name    TEXT NOT NULL,
	post_content TEXT NOT NULL,
	user_id      INT(11) NOT NULL,
	created_at   INT(11) NOT NULL,
	PRIMARY KEY (post_id),
	FOREIGN KEY (user_id) REFERENCES users(user_id)
)ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='post data';