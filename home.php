<?php
	setlocale(LC_ALL, 'dutch');

	session_start();

	if(!isset($_SESSION['persoon_id'])){
		header("Location:index.php");
	}

	$db = new PDO('mysql:host=localhost;dbname=wall', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	require( "./Function/homeFunction.php" );
	include( "./Template/class.TemplatePower.inc.php" );
	
	$tpl = new TemplatePower("./Template/home.tpl");

	$tpl->prepare();

	$banCheck = getUser($_SESSION['persoon_id']);

	if($banCheck['status'] == 0){
		header("Location:index.php?action=banned");
	}

	$tpl->newBlock("profile");
	$tpl->assign("PROFILEID", $_SESSION['persoon_id']);

	if ($_SESSION['groep_id'] == 1){	
		$tpl->newBlock("admin");
	}
	
	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}
	else{
		$action = null;
	}

	switch($action){


		#Posts

		case "newPost":
			if(isset($_POST['submit']) && trim($_POST['post']) != NULL) {
				# Een nieuwe post wordt toegevoegd.
				newPost($_SESSION['gebruiker_id'], $_POST['post']);
				
				header("Location: home.php");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;

		case "editPost":
			if (isset($_POST['submit'])) {
				# Hier wordt de bewerking van de post uitgevoert.
				editPost($_GET['postId'], $_POST['content']);

				header("Location:home.php");
  			} 
  			elseif (isset($_GET['postId'])) {
  				# Hier kun je je post bewerken.
				$results = editGetPost($_GET['postId']);

				foreach($results as $row){

					if (!($row['persoonId'] == $_SESSION['persoon_id']) && $_SESSION['groep_id'] == 2){
						header("Location:home.php");
						echo $_SESSION['groep_id'];
					}

					echo $_SESSION['groep_id'];

					$tpl->newBlock("editPosts");

					$tpl->assign("ID", $row['id']);
					$tpl->assign("POSTID", $row['postId']);
					$tpl->assign("VOORNAAM", $row['voornaam']);
					$tpl->assign("ACHTERNAAM", $row['achternaam']);
					$tpl->assign("CONTENT", $row['content']);
					$tpl->assign("AVATAR", $row['avatar']);
				}
			} 
			else {
				# Mensen horen hier niet te zijn, dus opzouten.
		    	header("location:home.php");
		    }
		break;

		case "deletePost":
			if($_GET['gebruikerId'] == $_SESSION['gebruiker_id'] || $_SESSION['groep_id'] == 1 && $_GET['postId']){
				# De bijbehorende post word hier gedelete.
				deletePost($_GET['postId'], $_GET['gebruikerId']);

				header("Location:home.php");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;


		#Comments

		case "newComment":
			if(isset($_POST['submitComment'])) {
				# Een nieuwe comment wordt toegevoegd aan de bijbehorende post. 

				newComment($_GET['postId'], $_SESSION['gebruiker_id'], $_POST['comment']);

				header("Location:home.php");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;

		case "newReply":
			if(isset($_POST['submitComment'])) {
				# Een nieuwe reply wordt toegevoegd aan de bijbehorende comment.

				newReply($_GET['parentId'], $_SESSION['gebruiker_id'], $_POST['reply']);
				header("Location:home.php");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;

		case "editComment":
			if (isset($_POST['submit'])) {
				# Hier wordt de bewerking van de comment uitgevoert.
				editComment($_GET['commentId'], $_POST['content']);
				header("Location:home.php");
			}
			elseif (isset($_GET['postId'])) {
				# Hier kun je je comment aanpassen
				$results = editGetPost($_GET['postId']);

				foreach($results as $row){

					$tpl->newBlock("editComment");

					$content = parsesmileys(htmlspecialchars($row['content']));

					$tpl->assign("ID", $row['id']);
					$tpl->assign("VOORNAAM", $row['voornaam']);
					$tpl->assign("ACHTERNAAM", $row['achternaam']);
					$tpl->assign("CONTENT", nl2br($content));
					$tpl->assign("AVATAR", $row['avatar']);

					$commentResults = editGetComment($_GET['commentId']);

					foreach ($commentResults as $commentRow){

						
						if (!($commentRow['persoonId'] == $_SESSION['persoon_id']) && $_SESSION['groep_id'] == 2){
							header("Location:home.php");
						}

						$tpl->newBlock("editComments");

						$tpl->assign("PERSOONID", $commentRow['persoonId']);
						$tpl->assign("COMMENTID", $commentRow['commentId']);
						$tpl->assign("COMMENTVOORNAAM", $commentRow['voornaam']);
						$tpl->assign("COMMENTACHTERNAAM", $commentRow['achternaam']);
						$tpl->assign("COMMENTCONTENT", $commentRow['content']);
					}
				}
   			} 
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;

		case "editReply":
			if (isset($_POST['submit'])) {
				# Hier wordt de bewerking van de comment uitgevoert.
				editComment($_GET['commentId'], $_POST['content']);

				header("Location:home.php");
			}
			elseif (isset($_GET['postId'])) {
				# Hier kun je je comment aanpassen
				$results = editGetPost($_GET['postId']);

				foreach($results as $row){

					$tpl->newBlock("editReply");

					$content = parsesmileys(htmlspecialchars($row['content']));

					$tpl->assign("ID", $row['id']);
					$tpl->assign("VOORNAAM", $row['voornaam']);
					$tpl->assign("ACHTERNAAM", $row['achternaam']);
					$tpl->assign("CONTENT", nl2br($content));
					$tpl->assign("AVATAR", $row['avatar']);

					$commentResults = editGetComment($_GET['parentId']);
					foreach ($commentResults as $commentRow){
						$tpl->newBlock("editReplyComments");

						$content = parsesmileys(htmlspecialchars($commentRow['content']));

						$tpl->assign("COMMENTID", $commentRow['id']);
						$tpl->assign("COMMENTVOORNAAM", $commentRow['voornaam']);
						$tpl->assign("COMMENTACHTERNAAM", $commentRow['achternaam']);
						$tpl->assign("COMMENTCONTENT", nl2br($content));
					}

					$replyResults = editGetReplies($_GET['commentId']);

					foreach ($replyResults as $replyRow) {

						if (!($replyRow['persoonId'] == $_SESSION['persoon_id']) && $_SESSION['groep_id'] == 2){
							header("Location:home.php");
						}

						$tpl->newBlock("editRepliez");

						$tpl->assign("REPLYID", $replyRow['id']);
						$tpl->assign("PERSOONID", $replyRow['persoonId']);
						$tpl->assign("REPLYVOORNAAM", $replyRow['voornaam']);
						$tpl->assign("REPLYACHTERNAAM", $replyRow['achternaam']);
						$tpl->assign("REPLYCONTENT", $replyRow['content']);
					}
				}
   			} 
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;

		case "deleteComment":
			if($_GET['gebruikerId'] == $_SESSION['gebruiker_id'] || $_SESSION['groep_id'] == 1 && $_GET['commentId']){
				# Hier word je comment verwijderd.
				deleteComment($_GET['commentId'], $_GET['gebruikerId']);

				header("Location:home.php");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;


		# Likes en Dislikes

		case "like":
			if($_GET['gebruikerId'] == $_SESSION['gebruiker_id'] && $_GET['typeId'] && $_GET['type']){
				addLike($_GET['gebruikerId'], $_GET['typeId'], $_GET['type']);
				header("Location:home.php");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;

		case "relike":
			if($_GET['gebruikerId'] == $_SESSION['gebruiker_id'] && $_GET['typeId'] && $_GET['type']){
				relike($_GET['gebruikerId'], $_GET['typeId'], $_GET['type']);
				header("Location:home.php");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;

		case "dislike":
			if($_GET['gebruikerId'] == $_SESSION['gebruiker_id'] && $_GET['typeId'] && $_GET['type']){
				dislike($_GET['gebruikerId'], $_GET['typeId'], $_GET['type']);
				header("Location:home.php");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:home.php");
			}
		break;

		#Default pagina

		default:			
			$tpl->newBlock("newPostFrame");

			$row = getUser($_SESSION['persoon_id']);

			if($row){
				$tpl->assign("VOORNAAM", $row['voornaam']);
				$tpl->assign("ACHTERNAAM", $row['achternaam']);				
				$tpl->assign("AVATAR", $row['avatar']);	
			}

			$tpl->newBlock("newPost");
			$tpl->newBlock("postsFrame");
		break;
	}

	$tpl->gotoBlock("_ROOT");
	$tpl->printToScreen();
?>