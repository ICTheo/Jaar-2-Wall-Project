<?php
	setlocale(LC_ALL, 'dutch');

	session_start();

	if(!isset($_SESSION['persoon_id'])){
		header("Location:index.php");
	}

	$db = new PDO('mysql:host=localhost;dbname=wall', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	require( "./Function/profileFunction.php" );
	include( "./Template/class.TemplatePower.inc.php" );

	$tpl = new TemplatePower("./Template/profile.tpl");

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

		case "edit":
			if($_GET['id'] == $_SESSION['persoon_id']){
				# Hier kun je je profiel gegevens aanpassen.
				$row = getProfile($_GET['id']);

				if ($row){
					$tpl->newBlock("profielEdit");

					$tpl->assign("VOORNAAM", $row['voornaam']);
					$tpl->assign("ACHTERNAAM", $row['achternaam']);
					$tpl->assign("ADRES", $row['adres']);
					$tpl->assign("POSTCODE", $row['postcode']);
					$tpl->assign("WOONPLAATS", $row['woonplaats']);
					$tpl->assign("TELEFOON", $row['telefoon']);
					$tpl->assign("MOBIEL", $row['mobiel']);
					$tpl->assign("GESLACHT", $row['geslacht']);
					$tpl->assign("ID", $_GET['id']);

				}

				if($row['geslacht'] == "Man"){
					$tpl->assign("MSELECT", "selected='1'");
				}
				elseif($row['geslacht'] == "Vrouw"){
					$tpl->assign("VSELECT", 'selected="1"');
				}
				elseif($row['geslacht'] == "Non-Binary"){
					$tpl->assign("BSELECT", 'selected="1"');
				}
			}
			elseif(isset($_POST['submit'])){
				# Dit past je profiel gegevens aan.
				profileEdit($_SESSION['persoon_id'], $_POST["voornaam"], $_POST["achternaam"], $_POST["adres"], $_POST["postcode"], $_POST["woonplaats"], $_POST["telefoon"], $_POST["mobiel"]);

				header("Location: profile.php?id=" . $_SESSION['persoon_id']);
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location: index.php");
			}

		break;

		case "upload":

		if($_GET['id'] == $_SESSION['persoon_id']){
			$target_dir = "avatar/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			    if($check !== false) {
			        echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 1000000) {
			    echo "Sorry, your file is too large.";
			    $uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
			
			if ($uploadOk == 0) {
				# Check if $uploadOk is set to 0 by an error
			    echo "Sorry, your file was not uploaded.";
			} 
			else {
				# if everything is ok, try to upload file
			    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			        avatarUpload($_SESSION['persoon_id'], basename( $_FILES["fileToUpload"]["name"]));
			      	header("Location: profile.php?id=" . $_SESSION['persoon_id']);
			    } 
			    else {
			        echo "Sorry, there was an error uploading your file.";
			    }
			}
		}
		else{
			header("Location: home.php");
		}

		break;

		default:
			# Hierdoor kun je je eigen profiel gegevens zien.
			if ($_GET['id']){
				$row = getProfile($_GET['id']);

				if ($row){
					$tpl->newBlock("profielInfo");

					$tpl->assign("VOORNAAM", $row['voornaam']);
					$tpl->assign("ACHTERNAAM", $row['achternaam']);
					$tpl->assign("DATUM", date("F j Y", $row['geboortedatum'])); 
					$tpl->assign("ADRES", $row['adres']);
					$tpl->assign("POSTCODE", $row['postcode']);
					$tpl->assign("WOONPLAATS", $row['woonplaats']);
					$tpl->assign("TELEFOON", $row['telefoon']);
					$tpl->assign("MOBIEL", $row['mobiel']);
					$tpl->assign("GESLACHT", $row['geslacht']);
				}

				#Als je op je eigen profiel zit, kun je deze met deze knop aanpassen.
				if ($_GET['id'] == $_SESSION['persoon_id']){
					$tpl->newBlock("editProfile");

					$tpl->assign("PERSOONID", $_SESSION['persoon_id']);
				}

				# Dit laat je eigen posts zien en de bijbehorende comments.
				$results = getPost($_GET['id']);

				foreach($results as $row){
					$tpl->newBlock("posts");

					$tpl->assign("ID", $row['id']);
					$tpl->assign("POSTID", $row['postId']);
					$tpl->assign("VOORNAAM", $row['voornaam']);
					$tpl->assign("ACHTERNAAM", $row['achternaam']);
					$tpl->assign("CONTENT", nl2br($row['content']));
					$tpl->assign("AVATAR", $row['avatar']);
					$tpl->assign("DATE", date("F j Y \o\m G:i", $row['datum'])); 

					$commentResults = getComments($row['postId']);
					foreach ($commentResults as $commentRow){
						$tpl->newBlock("comments");

						$tpl->assign("COMMENTID", $commentRow['persoonId']);
						$tpl->assign("COMMENTVOORNAAM", $commentRow['voornaam']);
						$tpl->assign("COMMENTACHTERNAAM", $commentRow['achternaam']);
						$tpl->assign("COMMENTIDZ", $commentRow['id']);
						$tpl->assign("AVATAR", $commentRow['avatar']);

						if($commentRow['status'] == 1){
							$tpl->assign("COMMENTCONTENT", $commentRow['content']);
						}
						else{
							$tpl->assign("COMMENTCONTENT", "Deze comment is verwijderd");
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
								$tpl->assign("REPLYCONTENT", $replyRow['content']);
							}
							else{
								$tpl->assign("REPLYCONTENT", "Deze comment is verwijderd");
							}
						}
					}
				}
			}
			else{
				header("Location:home.php");
			}

		break;
	}

	$tpl->gotoBlock("_ROOT");
	$tpl->printToScreen();

?>