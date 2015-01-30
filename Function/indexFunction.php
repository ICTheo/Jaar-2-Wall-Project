<?php
	# Inloggen

	function login($email, $paswoord){
		global $db;

		$sql = "SELECT *
				FROM gebruiker
				WHERE email = :email and paswoord = :paswoord";
		$stmt = $db->prepare($sql);

		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':paswoord', $paswoord, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);	
	}


	# Registreren

	function registerUser($email, $paswoord, $persoonID){
		global $db;

		$sql = "INSERT INTO gebruiker (email, paswoord, persoon_id, status, groep_id)
				VALUES (:email, :paswoord, :persoonID, 1, 2)";
		$stmt = $db->prepare($sql);

		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':paswoord', $paswoord, PDO::PARAM_STR);
		$stmt->bindParam(':persoonID', $persoonID, PDO::PARAM_STR);

		$stmt->execute();
	}

	function registerPerson($firstname, $lastname, $birthdate, $geslacht){
		global $db;

		$sql = "INSERT INTO persoon (voornaam, achternaam, geboortedatum, geslacht, avatar)
				VALUES (:firstname, :lastname, :birthdate, :geslacht, 'bland.png')";
		$stmt = $db->prepare($sql);

		$stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
		$stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
		$stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
		$stmt->bindParam(':geslacht', $geslacht, PDO::PARAM_STR);
		$stmt->execute();
		$personid = $db->lastInsertId();
		return $personid;
	}

?>