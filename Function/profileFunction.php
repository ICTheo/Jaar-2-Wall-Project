<?php
	#Informatie ophalen

	function getProfile($id){
		global $db;
		
		$sql = "SELECT *
				FROM persoon
				WHERE id = :id";
		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
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
		
		$sql = "SELECT persoon.*, post.*, post.id AS postId
				FROM post
				INNER JOIN gebruiker
				ON post.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE persoon.id = $id
				ORDER BY post.id";;

		return  $db->query($sql);
	}

	function getComments($postId){
		global $db;

		$sql = "SELECT comment.id, comment.status, persoon.voornaam, persoon.achternaam, comment.datum, comment.content, persoon.avatar, persoon.id as persoonId
				FROM comment
				INNER JOIN post
				ON comment.post_id = post.id
				INNER JOIN gebruiker
				ON comment.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE post.id = $postId
				ORDER BY comment.datum ASC";

		return  $db->query($sql);
	}

	function getReplies($commentId){
		global $db;

		$sql = "SELECT comment.id, comment.parent_id, persoon.avatar, persoon.voornaam, persoon.achternaam, comment.datum, comment.content, comment.status, persoon.id AS persoonId, gebruiker.id AS gebruikerId
				FROM comment
				INNER JOIN gebruiker
				ON comment.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE comment.parent_id = $commentId
				ORDER BY comment.datum ASC";
				
		return  $db->query($sql);
	}
	

	# Content aanpassen

	function profileEdit($id, $voornaam, $achternaam, $adres, $postcode, $woonplaats, $telefoon, $mobiel){
		global $db;

		$sql = "UPDATE persoon
		SET voornaam = :voornaam, achternaam = :achternaam, adres = :adres, postcode = :postcode, woonplaats = :woonplaats, telefoon = :telefoon, mobiel = :mobiel
		WHERE id = :id";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':voornaam', $voornaam, PDO::PARAM_STR);
		$stmt->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
		$stmt->bindParam(':adres', $adres, PDO::PARAM_STR);
		$stmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
		$stmt->bindParam(':woonplaats', $woonplaats, PDO::PARAM_STR);
		$stmt->bindParam(':telefoon', $telefoon, PDO::PARAM_STR);
		$stmt->bindParam(':mobiel', $mobiel, PDO::PARAM_STR);

		$stmt->execute();
	}

	function avatarUpload($id, $avatar){
		global $db;

		$sql = "UPDATE persoon
		SET avatar = :avatar
		WHERE id = :id";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':avatar', $avatar, PDO::PARAM_INT);

		$stmt->execute();
	}

?>