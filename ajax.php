<?php
	session_start();

	$db = new PDO('mysql:host=localhost;dbname=wall', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	include( "./Template/class.TemplatePower.inc.php" );
	
	
	require( "./Function/homeFunction.php" );
	$tpl = new TemplatePower("./Template/post.tpl");

	$tpl->prepare();

	$offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
	$postnumbers = is_numeric($_POST['number']) ? $_POST['number'] : die();

	$sql = "SELECT post.id AS postId, post.content, post.datum, persoon.id, persoon.voornaam, persoon.achternaam, persoon.avatar, gebruiker.id AS gebruikerId, post.status AS status
			FROM post
			INNER JOIN gebruiker
			ON post.gebruiker_id = gebruiker.id
			INNER JOIN persoon
			ON gebruiker.persoon_id = persoon.id
			ORDER BY post.datum 
			DESC LIMIT $postnumbers OFFSET $offset";

	foreach ($db->query($sql) as $row) {
		$tpl->newBlock("showPosts");

		$tpl->assign("POSTID", $row['postId']);
		$tpl->assign("DATE", date("F j Y \o\m G:i", $row['datum'])); 
		$tpl->assign("PERSOONID", $row['id']);
		$tpl->assign("VOORNAAM", $row['voornaam']);
		$tpl->assign("ACHTERNAAM", $row['achternaam']);
		$tpl->assign("AVATAR", $row['avatar']);

		if($row['status'] == 1){
			$content = parsesmileys(htmlspecialchars($row['content']));

			$tpl->assign("CONTENT", nl2br($content));

			if ($row['id'] == $_SESSION['persoon_id']  || $_SESSION['groep_id'] == 1){
				$tpl->newBlock("editDeletePost");
				
				$tpl->assign("POSTID", $row['postId']);
				$tpl->assign("GEBRUIKERID", $row['gebruikerId']);
			}
		}
		else{
			$tpl->assign("CONTENT", "Deze post is verwijderd");
		}

		# Dit laat zien hoeveel likes er zijn op de post.
		$postLikes = showLikes($row['postId'], "post");

		$tpl->newBlock("postLikes");
		if($postLikes > 0){
			$tpl->assign("POSTLIKES", $postLikes);
		}
		else{
			$tpl->assign("POSTLIKES", 0);
		}

		# Dit laat zien wie de post geliked heeft.
		$tpl->assign("POSTID", $row['postId']);

		$userLikes = likesUsers($row['postId'], "post");

		foreach ($userLikes as $likesRow) {
			$tpl->newBlock("userLikes");
			$tpl->assign("PERSOONID", $likesRow['persoon_id']);
			$tpl->assign("LIKESVOORNAAM", $likesRow['voornaam']);
			$tpl->assign("LIKESACHTERNAAM", $likesRow['achternaam']);
		}

		# Hier kijkt die of je een post al geliked hebt.
		if (getLikes($row['postId'], "post", $_SESSION['gebruiker_id']) == 1) {
			$tpl->newBlock("dislike");
		}
		elseif (getLikes($row['postId'], "post", $_SESSION['gebruiker_id']) == 0){
			$tpl->newBlock("relike");
		}
		else{
			$tpl->newBlock("like");
		}

		$tpl->assign("POSTID", $row['postId']);
		$tpl->assign("GEBRUIKERID", $_SESSION['gebruiker_id']);

		# Hier kijkt die of je een post al geliked hebt.
		if (getLikes($row['postId'], "love", $_SESSION['gebruiker_id']) == 1) {
			$tpl->newBlock("unlove");
		}
		elseif (getLikes($row['postId'], "love", $_SESSION['gebruiker_id']) == 0){
			$tpl->newBlock("relove");
		}
		else{
			$tpl->newBlock("love");
		}

		$tpl->assign("POSTID", $row['postId']);
		$tpl->assign("GEBRUIKERID", $_SESSION['gebruiker_id']);

		# Dit laat zien hoeveel comments er zijn op de post.
		$commentAmount = showComments($row['postId']);

		$tpl->newBlock("commentAmount");
		if($commentAmount > 0){
			$tpl->assign("COMMENTAMOUNT", $commentAmount);
		}
		else{
			$tpl->assign("COMMENTAMOUNT", 0);
		}

		# De comments die bij de bijbehorende posts horen worden hier uit de database gehaald en geplaatst.
		$commentResults = getComments($row['postId']);
		foreach ($commentResults as $commentRow){
			$tpl->newBlock("showComments");

			$tpl->assign("COMMENTID", $commentRow['persoonId']);
			$tpl->assign("COMMENTVOORNAAM", $commentRow['voornaam']);
			$tpl->assign("COMMENTACHTERNAAM", $commentRow['achternaam']);
			$tpl->assign("COMMENTIDZ", $commentRow['id']);
			$tpl->assign("AVATAR", $commentRow['avatar']);

			if($commentRow['status'] == 1){
				$content = parsesmileys(htmlspecialchars($commentRow['content']));

				$tpl->assign("COMMENTCONTENT", nl2br($content));

				if ($commentRow['persoonId'] == $_SESSION['persoon_id'] || $_SESSION['groep_id'] == 1){
					$tpl->newBlock("editDeleteComment");

					$tpl->assign("POSTID", $row['postId']);
					$tpl->assign("COMMENTIDZ", $commentRow['id']);
					$tpl->assign("GEBRUIKERID", $commentRow['gebruikerId']);
				}
			}
			else{
				$tpl->assign("COMMENTCONTENT", "Deze comment is verwijderd");
			}

			# Dit laat zien hoeveel likes er zijn op de comment.
			$commentLikes = showLikes($commentRow['id'], "comment");

			$tpl->newBlock("commentLikes");
			if($commentLikes > 0){
				$tpl->assign("COMMENTLIKES", $commentLikes);
			}
			else{
				$tpl->assign("COMMENTLIKES", 0);
			}


			# Dit laat zien wie de post geliked heeft.
			$tpl->assign("COMMENTIDZ", $commentRow['id']);

			$userLikes = likesUsers($commentRow['id'], "comment");

			foreach ($userLikes as $commentLikesRow) {
				$tpl->newBlock("userCommentLikes");
				$tpl->assign("PERSOONID", $commentLikesRow['persoon_id']);
				$tpl->assign("LIKESVOORNAAM", $commentLikesRow['voornaam']);
				$tpl->assign("LIKESACHTERNAAM", $commentLikesRow['achternaam']);
			}

			# Hier kijkt die of je een post al geliked hebt.
				
			if (getLikes($commentRow['id'], "comment", $_SESSION['gebruiker_id']) == 1) {
			$tpl->newBlock("commentDislike");
			}
			elseif (getLikes($commentRow['id'], "comment", $_SESSION['gebruiker_id']) == 0){
				$tpl->newBlock("commentRelike");
			}
			else{
				$tpl->newBlock("commentLike");
			}

			$tpl->assign("COMMENTID", $commentRow['id']);
			$tpl->assign("GEBRUIKERID", $_SESSION['gebruiker_id']);

			# Dit laat zien hoeveel comments er zijn op de post.
			$replyAmount = showReplies($commentRow['id']);

			$tpl->newBlock("replyAmount");
			if($replyAmount > 0){
				$tpl->assign("REPLYAMOUNT", $replyAmount);
			}
			else{
				$tpl->assign("REPLYAMOUNT", 0);
			}

			# Hier laat hij de replies op de comments zien.
			$replyResults = getReplies($commentRow['id']);

			foreach ($replyResults as $replyRow) {
				$tpl->newBlock("showReplies");

				$tpl->assign("PERSOONID", $replyRow['persoonId']);
				$tpl->assign("REPLYVOORNAAM", $replyRow['voornaam']);
				$tpl->assign("REPLYACHTERNAAM", $replyRow['achternaam']);
				$tpl->assign("REPLYID", $replyRow['id']);
				$tpl->assign("AVATAR", $replyRow['avatar']);
				
				if($replyRow['status'] == 1){
					$content = parsesmileys(htmlspecialchars($replyRow['content']));

					$tpl->assign("REPLYCONTENT", nl2br($content));

					if ($replyRow['persoonId'] == $_SESSION['persoon_id'] || $_SESSION['groep_id'] == 1){
						$tpl->newBlock("editDeleteReplies");

						$tpl->assign("PARENTID", $replyRow['parent_id']);
						$tpl->assign("POSTID", $row['postId']);
						$tpl->assign("REPLYID", $replyRow['id']);
						$tpl->assign("GEBRUIKERID", $replyRow['gebruikerId']);
					}
				}
				else{
					$tpl->assign("REPLYCONTENT", "Deze comment is verwijderd");
				}

				# Dit laat zien hoeveel replies er zijn op de comment.
				$replyLikes = showLikes($replyRow['id'], "comment");

				$tpl->newBlock("replyLikes");
				if($replyLikes > 0){
					$tpl->assign("REPLYLIKES", $replyLikes);
				}
				else{
					$tpl->assign("REPLYLIKES", 0);
				}

				# Dit laat zien wie de reply geliked heeft.
				$tpl->assign("REPLYID", $replyRow['id']);

				$userLikes = likesUsers($replyRow['id'], "comment");

				foreach ($userLikes as $replyLikesRow) {
					$tpl->newBlock("userReplyLikes");
					$tpl->assign("PERSOONID", $replyLikesRow['persoon_id']);
					$tpl->assign("LIKESVOORNAAM", $replyLikesRow['voornaam']);
					$tpl->assign("LIKESACHTERNAAM", $replyLikesRow['achternaam']);
				}

				# Hier kijkt die of je een reply al geliked hebt.
  				if (getLikes($replyRow['id'], "comment", $_SESSION['gebruiker_id']) == 1) {
					$tpl->newBlock("replyDislike");
  				}
  				elseif (getLikes($replyRow['id'], "comment", $_SESSION['gebruiker_id']) == 0){
  					$tpl->newBlock("replyRelike");
  				}
  				else{
  					$tpl->newBlock("replyLike");
  				}

  				$tpl->assign("REPLYID", $replyRow['id']);
					$tpl->assign("GEBRUIKERID", $_SESSION['gebruiker_id']);
			}
		}
	}

	$tpl->printToScreen();

?>