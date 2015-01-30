<?php
	setlocale(LC_ALL, 'dutch');

	session_start();

	if(isset($_SESSION['persoon_id'])){
		if($_SESSION['status'] == 1){
			header("Location:home.php");
		}
	}

	$db = new PDO('mysql:host=localhost;dbname=wall', 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	require( "./Function/indexFunction.php" );
	include( "./Template/class.TemplatePower.inc.php" );

	$tpl = new TemplatePower("./Template/index.tpl");

	$tpl->prepare();

	if(isset($_GET['action'])){
		$action = $_GET['action'];
	}
	else{
		$action = null;
	}

	switch ($action) {

		case "login":
			if(isset($_POST['submit'])) {

				# Hier word je ingelogd
				$row = login($_POST['email'], $_POST['paswoord']);

				if($row){
					$_SESSION['groep_id'] = $row['groep_id'];
					$_SESSION['persoon_id'] = $row['persoon_id'];
					$_SESSION['gebruiker_id'] = $row['id'];
					$_SESSION['status'] = $row['status'];
					
					if($_SESSION['status'] == 0){
						header("Location:index.php?action=banned");
					}
					elseif($_SESSION['groep_id'] == 1){
						header("Location:admin.php");
					}
					else{
						header("Location:home.php");
					}
				}
				else{
					echo "<script type='text/javascript'>
						 	alert('De email en wachtwoord matchen niet');
						 	location.href = 'index.php';
						  </script>";
				}
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:index.php");
			}
		break;

		case "register":
			if(isset($_POST['submit'])) {
				# Hier laat die het login formulier zien.
				$tpl->newBlock("login");

				# Hier maak je een nieuw account aan.

				$tpl->newBlock("register");

				$tpl->assign("FIRSTNAME", $_POST['firstname']);
				$tpl->assign("LASTNAME", $_POST['lastname']);
				$tpl->assign("EMAIL", $_POST['email']);
				$tpl->assign("EMAILAGAIN", $_POST['emailAgain']);
				$tpl->assign("PASWOORD", $_POST['paswoord']);
				$tpl->assign("PASWOORDAGAIN", $_POST['paswoordAgain']);

				if($_POST['sex'] == "Man"){
					$tpl->assign("MCHECKED", "checked");
				}
				elseif($_POST['sex'] == "Vrouw"){
					$tpl->assign("VCHECKED", "checked");
				}
				elseif($_POST['sex'] == "Non-Binary"){
					$tpl->assign("BCHECKED", "checked");
				}

				for ($day = 1; $day < 32; $day++) { 
	    			$tpl->newBlock("day");
	    			$tpl->assign("DAY", $day);
	    			if($_POST['birthdayDay'] == $day){
	    				$tpl->assign("SELECTED", "selected=1");
	    			}
	   			}

	   			for($iM = 1;$iM<=12;$iM++) {
	   				$month = strftime('%B', strtotime("$iM/12/10"));
	    			$tpl->newBlock("month");
	     			$tpl->assign("MONTH", $month);
	     			$tpl->assign('VALUE', $iM);
					if($_POST['birthdayMonth'] == $iM){
	    				$tpl->assign("SELECTED", "selected=1");
	    			}	     			
	     		}

	     		for ($year = 2014; $year >= 1905; $year--) { 
	    			$tpl->newBlock("year");
	    			$tpl->assign("YEAR", $year);
	    			if($_POST['birthdayYear'] == $year){
	    				$tpl->assign("SELECTED", "selected=1");
	    			}	 
				}

				$error = 'noError';
				if(!checkdate($_POST['birthdayMonth'], $_POST['birthdayDay'], $_POST['birthdayYear'])){
					$tpl->newBlock("badDate");
					$error = 'ERROR';
				}

				if(!($_POST['paswoord'] == $_POST['paswoordAgain'])){
					$tpl->newBlock("wrongKey");
					$error = 'ERROR';
				}

				if(!($_POST['email'] == $_POST['emailAgain'])){
					$tpl->newBlock("wrongAddress");
					$error = 'ERROR';
				}
				else{
					if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
						$tpl->newBlock("badAddress");
						$error = 'ERROR';
					}
				}

				if ($error == 'noError'){
					$personId = registerPerson($_POST['firstname'],$_POST['lastname'], mktime(2, 0, 0, $_POST['birthdayMonth'], $_POST['birthdayDay'], $_POST['birthdayYear']), $_POST['sex']); 
					registerUser($_POST['email'], $_POST['paswoord'], $personId);	
					header("Location:index.php");
				}
			}
			else{
				# Mensen horen hier niet te zijn, dus opzouten.
				header("Location:index.php");
			}
		break;

		case "logout":
			# Hier word je uitgelogd.
			session_start();
			session_destroy();
			header("Location:index.php");
		break;

		case "banned":
			?>
				<script type="text/javascript">
					alert("You've been banned");
				</script>
			<?php
			session_destroy();
			?>
				<script type="text/javascript">
					location.href = 'index.php';
				</script>
			<?php
		break;

		# Default pagina

		default:

			# Hier laat die het login formulier zien.
			$tpl->newBlock("login");

			# Hier laat die het register formulier zien.
			$tpl->newBlock("register");

			for ($day = 1; $day < 32; $day++) { 
    			$tpl->newBlock("day");
    			$tpl->assign("DAY", $day);
   			}

   			for($iM = 1;$iM<=12;$iM++) {
   				$month = strftime('%B', strtotime("$iM/12/10"));
    			$tpl->newBlock("month");
     			$tpl->assign("MONTH", $month);
     			$tpl->assign('VALUE', $iM);
     		}

     		for ($year = 2014; $year >= 1905; $year--) { 
    			$tpl->newBlock("year");
    			$tpl->assign("YEAR", $year);
			}

		break;
	}

	$tpl->gotoBlock("_ROOT");
	$tpl->printToScreen();

?>