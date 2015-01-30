<?php
	#Informatie ophalen

	function getUser($id){
		global $db;
		
		$sql = "SELECT gebruiker.*, persoon.avatar, persoon.voornaam, persoon.achternaam
				FROM gebruiker
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE persoon_id = :id";
		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	function getPost(){
		global $db;
		
		$sql = "SELECT post.id AS postId, post.content, post.datum, persoon.id, persoon.voornaam, 
					   persoon.achternaam, persoon.avatar, gebruiker.id AS gebruikerId, post.status AS status
				FROM post
				INNER JOIN gebruiker
				ON post.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				ORDER BY post.datum DESC";

		return  $db->query($sql);
	}	


	function getComments($postId){
		global $db;

		$sql = "SELECT comment.id, comment.parent_id, persoon.voornaam, persoon.achternaam, persoon.avatar, comment.datum, comment.content, comment.status, persoon.id AS persoonId, gebruiker.id AS gebruikerId, comment.status AS status
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

	function showLikes($id, $type){
		global $db;

		$sql = "SELECT count(*)
				FROM `like`
				WHERE type = '$type' and type_id = $id and status = 1";

		$stmt = $db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchColumn();
	}

	function likesUsers($typeId, $type){
		global $db;

		$sql = "SELECT *
				FROM `like`
				INNER JOIN gebruiker
				ON `like`.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE `like`.type_id = $typeId and `like`.type = '$type' and `like`.status = 1";

		return  $db->query($sql);
	}	


	function showComments($id){
		global $db;

		$sql = "SELECT count(*)
				FROM comment
				INNER JOIN post
				ON comment.post_id = post.id
				WHERE post.id = $id";

		$stmt = $db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchColumn();
	}

	function showReplies($id){
		global $db;

		$sql = "SELECT count(*)
				FROM comment
				WHERE parent_id = $id";

		$stmt = $db->prepare($sql);
		$stmt->execute();

		return $stmt->fetchColumn();
	}

	function getLikes($id, $type, $gebruiker){
		global $db;

		$sql = "SELECT *
				FROM `like`
				WHERE type = '$type' and type_id = $id and gebruiker_id = $gebruiker";

		$stmt = $db->prepare($sql);
		$stmt->execute();

		if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  			if ($row['status'] == 1){
  				return 1;
  			}
  			elseif ($row['status'] == 0){
  				return 0;
  			}
		}
		else{
  			return 2;
  		}
	}

	function editGetPost($id){
		global $db;
		
		$sql = "SELECT post.*, persoon.*, post.id AS postId, persoon.id AS persoonId
				FROM post
				INNER JOIN gebruiker
				ON post.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE post.status = 1 and post.id=$id
				ORDER BY postId DESC";

		return  $db->query($sql);
	}

	function editGetComment($commentId){
		global $db;

		$sql = "SELECT post.*, comment.id AS commentId, comment.content AS content, persoon.*, post.id AS postId, persoon.id AS persoonId
				FROM comment
				INNER JOIN post
				ON comment.post_id = post.id
				INNER JOIN gebruiker
				ON comment.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE comment.id = $commentId and comment.status = 1";

		return  $db->query($sql);
	}

	function editGetReplies($commentId){
		global $db;

		$sql = "SELECT comment.id, comment.parent_id, persoon.voornaam, persoon.achternaam, comment.datum, comment.content, comment.status, persoon.id AS persoonId, gebruiker.id AS gebruikerId
				FROM comment
				INNER JOIN gebruiker
				ON comment.gebruiker_id = gebruiker.id
				INNER JOIN persoon
				ON gebruiker.persoon_id = persoon.id
				WHERE comment.id = $commentId
				ORDER BY comment.datum ASC";
				
		return  $db->query($sql);
	}
	

	# Nieuwe content maken

	function newPost($gebruiker_id, $content){
		$date = time();

		global $db;

		$sql = "INSERT INTO post (content, gebruiker_id, datum, status)
	        	VALUES (:content, :gebruiker_id, :datum, 1)";
	    
	    $stmt = $db->prepare($sql);
	    
	    $stmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_STR);
	    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
	    $stmt->bindParam(':datum', $date, PDO::PARAM_INT);
		$stmt->execute();
	}

	function newComment($postId, $gebruikerId, $content){
		$date = time();

		global $db;

		$sql = "INSERT INTO comment (content, post_id, gebruiker_id, datum, status)
	        	VALUES (:content, :postId, :gebruikerId, :datum, 1);";
	    
	    $stmt = $db->prepare($sql);
	    
	    $stmt->bindParam(':postId', $postId, PDO::PARAM_STR);
	    $stmt->bindParam(':gebruikerId', $gebruikerId, PDO::PARAM_STR);
	    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
	    $stmt->bindParam(':datum', $date, PDO::PARAM_INT);
		$stmt->execute();
	}

	function newReply($parentId, $gebruikerId, $content){
		$date = time();

		global $db;

		$sql = "INSERT INTO comment (content, parent_id, gebruiker_id, datum, status)
	        	VALUES (:content, :parentId, :gebruikerId, :datum, 1);";
	    
	    $stmt = $db->prepare($sql);

	    $stmt->bindParam(':parentId', $parentId, PDO::PARAM_STR);
	    $stmt->bindParam(':gebruikerId', $gebruikerId, PDO::PARAM_STR);
	    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
	    $stmt->bindParam(':datum', $date, PDO::PARAM_INT);
		$stmt->execute();
	}

	function addLike($gebruikerId, $typeId, $type){
		$date = time();

		global $db;

		$sql = "INSERT INTO `like` (gebruiker_id, type_id, type, datum, status)
	        	VALUES (:gebruikerId, :typeId, :type, :datum, 1)";
	    
	    $stmt = $db->prepare($sql);
	    
	    $stmt->bindParam(':gebruikerId', $gebruikerId, PDO::PARAM_INT);
	    $stmt->bindParam(':typeId', $typeId, PDO::PARAM_INT);
	    $stmt->bindParam(':type', $type, PDO::PARAM_STR);
	    $stmt->bindParam(':datum', $date, PDO::PARAM_INT);
		$stmt->execute();
	}

	# Content aanpassen

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


	# Content verwijderen

	function deletePost($id, $gebruikerId){
		global $db;

		$sql = "UPDATE post
				SET status = 0
				WHERE id=:id and gebruiker_id = :gebruikerId";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':gebruikerId', $gebruikerId, PDO::PARAM_STR);

		$stmt->execute();
	}

	function deleteComment($id, $gebruikerId){
		global $db;

		$sql = "UPDATE comment
				SET status = 0
				WHERE id=:id and gebruiker_id = :gebruikerId";

		$stmt = $db->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':gebruikerId', $gebruikerId, PDO::PARAM_INT);

		$stmt->execute();
	}

	function dislike($gebruiker, $id, $type){
		global $db;

		$sql = "UPDATE `like`
				SET status = 0
				WHERE type = '$type' and type_id = $id and gebruiker_id = $gebruiker";

		$stmt = $db->prepare($sql);
		$stmt->execute();
	}

	function relike($gebruiker, $id, $type){
		global $db;

		$sql = "UPDATE `like`
				SET status = 1
				WHERE type = '$type' and type_id = $id and gebruiker_id = $gebruiker";

		$stmt = $db->prepare($sql);
		$stmt->execute();
	}

	function parsesmileys($content){ 

	    $smileyList = array( 
	        ':)'     =>     '<img src="smileys/1.png" width="49" height="20" alt=":)" />', 
	        ':3'     =>     '<img src="smileys/2.png" width="49" height="20" alt=":3" />', 
	        ':('     =>     '<img src="smileys/3.png" width="49" height="20" alt=":(" />', 
	       	'D:'     =>     '<img src="smileys/4.png" width="49" height="20" alt="D:" />', 
	        'X3'     =>     '<img src="smileys/5.png" width="49" height="20" alt="X3" />', 
	        ';)'     =>     '<img src="smileys/6.png" width="49" height="20" alt=";)" />', 
	        'XD'     =>     '<img src="smileys/7.png" width="49" height="20" alt="XD" />', 
	        '-.-'     =>     '<img src="smileys/8.png" width="49" height="20" alt="-.-" />', 
	        'O.o'     =>     '<img src="smileys/9.png" width="49" height="20" alt="O.o" />', 
	        '-_-'     =>     '<img src="smileys/10.png" width="49" height="20" alt="-_-" />', 
	        '&lt;3'    =>     '<img src="smileys/heart.gif" alt="<3" />', 
	        '(heart)'    =>     '<img src="smileys/heart.gif" alt="(heart)" />', 
	    ); 
	    return str_ireplace(array_keys($smileyList),$smileyList,$content); 
	}
?>