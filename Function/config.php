<?php

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
	
?>