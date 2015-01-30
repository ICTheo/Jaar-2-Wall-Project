<?php
	
	#Informatie ophalen

	function getUsers(){
		global $db;
		
		$sql = "SELECT *, gebruiker.id AS gebruikerId
				FROM gebruiker
				INNER JOIN persoon 
				ON gebruiker.persoon_id = persoon.id
				INNER JOIN groep
				ON gebruiker.groep_id = groep.id";

		return $db->query($sql);
	}

	function getUser($id){
		global $db;
		
		$sql = "SELECT *
				FROM gebruiker
				WHERE persoon_id = :id";
		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	
	function getPost($id){
		global $db;
		
		$sql = "SELECT post.id AS postId, post.content, post.datum, persoon.id, persoon.voornaam, persoon.achternaam, persoon.avatar, gebruiker.id AS gebruikerId, post.status AS status
				FROM post
				INNER JOIN gebruiker
				ON post.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE persoon.id = $id
				ORDER BY post.datum DESC";

		return  $db->query($sql);
	}

		function editGetPost($id){
		global $db;
		
		$sql = "SELECT post.id AS postId, post.content, post.datum, persoon.id, persoon.voornaam, persoon.achternaam, persoon.avatar, gebruiker.id AS gebruikerId, post.status AS status
				FROM post
				INNER JOIN gebruiker
				ON post.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE post.id = $id
				ORDER BY post.datum DESC";

		return  $db->query($sql);
	}

	function getAllPosts(){
		global $db;
		
		$sql = "SELECT post.id AS postId, post.content, post.datum, persoon.id, persoon.voornaam, persoon.achternaam, persoon.avatar, gebruiker.id AS gebruikerId, post.status AS status
				FROM post
				INNER JOIN gebruiker
				ON post.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				ORDER BY post.datum DESC";

		return  $db->query($sql);
	}	

	function getComment($id){
		global $db;

		$sql = "SELECT *, persoon.id AS persoonId, comment.id AS commentId, comment.status
				FROM comment
				INNER JOIN gebruiker
				ON comment.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE persoon.id = $id
				ORDER BY comment.datum DESC";

		return  $db->query($sql);
	}	
	
	function editGetComment($id){
		global $db;

		$sql = "SELECT *, persoon.id AS persoonId, comment.id AS commentId, comment.status
				FROM comment
				INNER JOIN gebruiker
				ON comment.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE comment.id = $id
				ORDER BY comment.datum DESC";

		return  $db->query($sql);
	}	

	function getAllComments(){
		global $db;

		$sql = "SELECT *, persoon.id AS persoonId, comment.id AS commentId, comment.status
				FROM comment
				INNER JOIN gebruiker
				ON comment.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				ORDER BY comment.datum DESC";

		return  $db->query($sql);
	}

	# Informatie aanpassen

	function banUser($id, $status){
		global $db;

		$sql = "UPDATE gebruiker
				SET status = :status
				WHERE id = :id";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->bindParam(":status", $status, PDO::PARAM_INT);

		$stmt->execute();
	}

	function editPost($id, $content){
		global $db;

		$sql = "UPDATE post
				SET content = :content
				WHERE id = :id";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':content', $content, PDO::PARAM_STR);

		$stmt->execute();
	}	

	function editComment($id, $content){
		global $db;

		$sql = "UPDATE comment
				SET content = :content
				WHERE id = :id";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':content', $content, PDO::PARAM_STR);

		$stmt->execute();
	}

	function deletePost($id, $status){
		global $db;

		$sql = "UPDATE post
				SET status = :status
				WHERE id = :id";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->bindParam(":status", $status, PDO::PARAM_INT);

		$stmt->execute();
	}

	function deleteComment($id, $status){
		global $db;

		$sql = "UPDATE comment
				SET status = :status
				WHERE id = :id";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);
		$stmt->bindParam(":status", $status, PDO::PARAM_INT);

		$stmt->execute();
	}

?>