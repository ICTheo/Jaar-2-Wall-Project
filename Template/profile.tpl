<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wall</title>
	<link rel="stylesheet" type="text/css" href="css/Wall.css"/>
	<?php include "/tinyMCE.php" ?>
</head>
<body>

<div id="wrapper">	

		<!-- Menu Bar --> 

		<div id="menuBar">
			<div id="menuItems">
				<h1 id="menuTitle"><a href="home.php">Wall</a></h1>

				<div class="button"><a href="index.php?action=logout" >logout</a></div>
				<!-- START BLOCK : profile -->
					<div class="button"><a href="profile.php?id={PROFILEID}" >profiel</a></div>
				<!-- END BLOCK : profile -->

			</div>
		</div>

		<div id="frame">


			<!-- Dit laat je profiel gegevens zien -->

			<!-- START BLOCK : profielInfo -->
				<p>Naam : {VOORNAAM} {ACHTERNAAM}</p>
				<p>Geslacht: {GESLACHT}</p>
				<p>Geboortedatum: {DATUM}</p>
				<p>Adres : {ADRES}</p>
				<p>Postcode : {POSTCODE}</p>
				<p>Woonplaats : {WOONPLAATS}</p>
				<p>Telefoonnummer : {TELEFOON}</p>
				<p>Mobielenummer : {MOBIEL}</p>

				<!-- START BLOCK : editProfile -->
					<a href="profile.php?action=edit&id={PERSOONID}">edit</a>
				<!-- END BLOCK : editProfile -->
			
			<!-- END BLOCK : profielInfo -->


			<!-- Hier kun je je profielgegevens aanpassen -->
			
			<!-- START BLOCK : profielEdit -->
				<form action="profile.php?action=edit" method="post">

					<p>
						<label>Naam: </label>
						<input type="text" name="voornaam" value="{VOORNAAM}" required>
						<input type="text" name="achternaam" value="{ACHTERNAAM}" required>
					</p>

					<p>
						<label>Geslacht: </label>
						<select name="birthdayDay" required>
					     	<option {MSELECT} value="Man">Man</option>
					     	<option {VSELECT} value="Vrouw">Vrouw</option>
					     	<option {BSELECT} value="Non-Binary">Non-Binary</option>
					      	
					    </select>
					</p>
					
					<p>
						<label>Adres: </label>
						<input type="text" name="adres" value="{ADRES}" required>
					</p>
					
					<p>
						<label>Postcode: </label>
						<input type="text" name="postcode" value="{POSTCODE}" required>
					</p>
					
					<p>
						<label>Woonplaats: </label>
						<input type="text" name="woonplaats" value="{WOONPLAATS}" required>
					</p>

					<p>
						<label>Telefoonnummer: </label>
						<input type="text" name="telefoon" value="{TELEFOON}" required>
					</p>

					<p>
						<label>Mobielenummer: </label>
						<input type="text" name="mobiel" value="{MOBIEL}" required>
					</p>

					<input class="button" type="submit" name="submit" value="Opslaan">

				</form>

			<form action="profile.php?action=upload&id={ID}" method="post" enctype="multipart/form-data">
			    Select image to upload:
			    <input type="file" name="fileToUpload" id="fileToUpload">
			    <input type="submit" value="image" name="submit">
			</form>
			<!-- END BLOCK : profielEdit -->


			<!-- Hier kun je je posts zien en de bijbehorende comments -->

			<div id="postsFrame">

				<!-- START BLOCK : posts -->
					<div class = "posts">
						<div class="postHeader">
							<img class="avatar" src="avatar/{AVATAR}" height="60px" width="60px">
							<p class="postDate">{DATE}</p>
							<h3 class="postOwner"><a href='profile.php?id={PERSOONID}'>{VOORNAAM} {ACHTERNAAM}</a> </h3>
						</div>
						<p>{CONTENT}</p>

						<!-- START BLOCK : comments -->
							<div>
								<p id="comment"><a href='profile.php?id={COMMENTID}'>{COMMENTVOORNAAM} {COMMENTACHTERNAAM}</a>: {COMMENTCONTENT}</p>
								
								<!-- START BLOCK : showReplies -->
								<div class="replyContent">

									<div>
										<p class="reply"><img class="avatar" src="avatar/{AVATAR}" height="40px" width="40px"><a class="namez" href='profile.php?id={PERSOONID}'>
											{REPLYVOORNAAM} {REPLYACHTERNAAM}</a>: {REPLYCONTENT} </p>
									</div>
								</div>
								<!-- START BLOCK : showReplies -->
							</div>
						<!-- END BLOCK : comments -->
						</div>
						<div class="lowerBorder">
					</div>
				<!-- END BLOCK : posts -->

			</div>

		</div>
	<div id="footerfix"></div>
			<div id="footer">
				<p>&copy; 2014 Copyright Theo Krommenhoek</p>
		</div>
	</div>
</body>
</html>