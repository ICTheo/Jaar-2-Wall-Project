<?php
	setlocale(LC_ALL, 'dutch');

	session_start();

	if($_SESSION['groep_id'] == 2 || $_SESSION['status'] == 0){
		header("Location:home.php");
	}

	$db = new PDO('mysql:host=localhost;dbname=wall', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	require( "./Function/adminFunction.php" );
	include( "./Template/class.TemplatePower.inc.php" );

	$tpl = new TemplatePower("./Template/admin.tpl");

	$tpl->prepare();

	$tpl->newBlock("profile");
	$tpl->assign("PROFILEID", $_SESSION['persoon_id']);
	
	$banCheck = getUser($_SESSION['persoon_id']);

	if($banCheck['status'] == 0){
		header("Location:index.php?action=banned");
	}

	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}
	else{
		$action = null;
	}

	switch ($action) {

		# Dit laat alle users zien

		case "users":
			$tpl->newBlock("userFrame");

			$results = getUsers();
				
			foreach($results as $row){
				$tpl->newBlock("users");

				$tpl->assign("ID", $row['gebruikerId']);
				$tpl->assign("AVATAR", $row['avatar']);
				$tpl->assign("VOORNAAM", $row['voornaam']);
				$tpl->assign("ACHTERNAAM", $row['achternaam']);
				$tpl->assign("EMAIL", $row['email']);
				$tpl->assign("TYPE", $row['type']);
				if ($row['status'] == 1){
					$tpl->assign("STATUS", "Active");
					$tpl->newBlock("ban");
				}
				elseif ($row['status'] == 0) {
					$tpl->assign("STATUS", "Banned");
					$tpl->newBlock("unBan");
				}
				$tpl->assign("ID", $row['gebruikerId']);
			}
		break;

		case "userPosts":

			$results = getPost($_GET['id']);

			$tpl->newBlock("postFrame");

			foreach($results as $row){
				$tpl->assign("VOORNAAM", $row['voornaam']);
				$tpl->assign("ACHTERNAAM", $row['achternaam']);

				$tpl->newBlock("posts");

				$tpl->assign("ID", $row['postId']);
				$tpl->assign("CONTENT", $row['content']);

				if ($row['status'] == 1){
					$tpl->assign("STATUS", "Shown");
					$tpl->newBlock("delete");
				}
				elseif ($row['status'] == 0) {
					$tpl->assign("STATUS", "Deleted");
					$tpl->newBlock("unDelete");
				}
				$tpl->assign("ID", $row['postId']);
				$tpl->assign("PERSOONID", $row['id']);
			}

		break;

		case "allPosts":

			$results = getAllPosts();

			$tpl->newBlock("allPostsFrame");

			foreach($results as $row){
				$tpl->assign("VOORNAAM", $row['voornaam']);
				$tpl->assign("ACHTERNAAM", $row['achternaam']);

				$tpl->newBlock("allPosts");

				$tpl->assign("ID", $row['postId']);
				$tpl->assign("CONTENT", $row['content']);
				$tpl->assign("PERSOONID", $row['id']);

				if ($row['status'] == 1){
					$tpl->assign("STATUS", "Shown");
					$tpl->newBlock("deleteAll");
				}
				elseif ($row['status'] == 0) {
					$tpl->assign("STATUS", "Deleted");
					$tpl->newBlock("unDeleteAll");
				}
				$tpl->assign("ID", $row['postId']);
				$tpl->assign("PERSOONID", $row['id']);
			}

		break;

		case "userComments":

			$result = getComment($_GET['id']);

			$tpl->newBlock("commentFrame");

			foreach($result as $row){
				$tpl->assign("VOORNAAM", $row['voornaam']);
				$tpl->assign("ACHTERNAAM", $row['achternaam']);

				$tpl->newBlock("comments");

				$tpl->assign("ID", $row['commentId']);
				$tpl->assign("CONTENT", $row['content']);
				$tpl->assign("PERSOONID", $row['persoonId']);

				if ($row['status'] == 1){
					$tpl->assign("STATUS", "Shown");
					$tpl->newBlock("deleteC");
				}
				elseif ($row['status'] == 0) {
					$tpl->assign("STATUS", "Deleted");
					$tpl->newBlock("unDeleteC");
				}
				$tpl->assign("ID", $row['commentId']);
				$tpl->assign("PERSOONID", $row['persoonId']);
			}

		break;


		case "allComments":

			$result = getAllComments();

			$tpl->newBlock("allCommentsFrame");

			foreach($result as $row){
				$tpl->assign("VOORNAAM", $row['voornaam']);
				$tpl->assign("ACHTERNAAM", $row['achternaam']);

				$tpl->newBlock("allComments");

				$tpl->assign("ID", $row['commentId']);
				$tpl->assign("CONTENT", $row['content']);

				if ($row['status'] == 1){
					$tpl->assign("STATUS", "Shown");
					$tpl->newBlock("deleteAllC");
				}
				elseif ($row['status'] == 0) {
					$tpl->assign("STATUS", "Deleted");
					$tpl->newBlock("unDeleteAllC");
				}
				$tpl->assign("ID", $row['commentId']);
				$tpl->assign("PERSOONID", $row['persoonId']);
			}

		break;

		case "banUser":

			if($_GET['id']){

				banUser($_GET['id'], $_GET['status']);
				header("Location: admin.php?action=users");
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location: admin.php?action=users");
			}

		break;

		case "editPost":
			if(isset($_POST['submit'])){
				# Hier wordt de bewerking van de comment uitgevoert.
				editPost($_GET['id'], $_POST['content']);
				
				if ($_GET['loc'] == "user"){
					header("Location: admin.php?action=userPosts&id=" . $_GET['persoonId']);
				}
				elseif($_GET['loc'] == "all"){
					header("Location: admin.php?action=allPosts");
				}
			}
			elseif($_GET['id']){
				$results = editGetPost($_GET['id']);

				foreach($results as $row){

					$tpl->newBlock("editPost");

					$tpl->assign("ID", $row['postId']);
					$tpl->assign("CONTENT", $row['content']);
					$tpl->assign("LOC", $_GET['loc']);
				}
			}
		break;

		case "editComment":
			if(isset($_POST['submit'])){
				# Hier wordt de bewerking van de comment uitgevoert.
				editComment($_GET['commentId'], $_POST['content']);
				
				if ($_GET['loc'] == "user"){
					header("Location: admin.php?action=userComments&id=" . $_GET['persoonId']);
				}
				elseif($_GET['loc'] == "all"){
					header("Location: admin.php?action=allComments");
				}
			}
			elseif($_GET['id']){
				$results = editGetComment($_GET['id']);

				foreach($results as $row){

					$tpl->newBlock("editComment");

					$tpl->assign("ID", $row['commentId']);
					$tpl->assign("CONTENT", $row['content']);
					$tpl->assign("LOC", $_GET['loc']);
				}
			}
		break;

		case "deletePost":

			if($_GET['id']){

				deletePost($_GET['id'], $_GET['status']);
				
				if ($_GET['loc'] == "user"){
					header("Location: admin.php?action=userPosts&id=" . $_GET['persoonId']);
				}
				elseif($_GET['loc'] == "all"){
					header("Location: admin.php?action=allPosts");
				}
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location: admin.php?action=userPosts&id=" . $_GET['persoonId']);
			}

		break;

		case "deleteComments":

			if($_GET['id']){

				deleteComment($_GET['id'], $_GET['status']);

				if ($_GET['loc'] == "user"){
					header("Location: admin.php?action=userComments&id=" . $_GET['persoonId']);
				}
				elseif($_GET['loc'] == "all"){
					header("Location: admin.php?action=allComments");
				}
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location: admin.php?action=userComments&id=" . $_GET['persoonId']);
			}

		break;

		# Default pagina

		default:

			$tpl->newBlock("default");

		break;
	}

	$tpl->gotoBlock("_ROOT");
	$tpl->printToScreen();

?>