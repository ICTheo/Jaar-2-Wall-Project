<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wall</title>
	<link rel="stylesheet" type="text/css" href="css/wall.css"/>
	<script>
		function showMenu(id)
		{
			var element = document.getElementById(id);
			if (element.style.display == 'none')
			{
				element.style.display = 'block';
			}
			else
			{
				element.style.display = 'none';
			}
		}
	</script>
</head>
<body>

	<div id="wrapper">	


		<!-- Menu Bar --> 

		<div id="menuBar">
			<div id="menuItems">
				<h1 id="menuTitle">Wall</h1>

				<!-- START BLOCK : login -->
					<div class="loginMenu">
						<div class="button" onclick="showMenu('login')"><p>login<p></div>
						<div id="login" style="display : none;" >
							<form method="post" action="index.php?action=login">
								<h1>Login</h1>
								<p>
									<label>Email: </label>
									<input type="text" name="email">
								</p>
								
								<p>
									<label>Password: </label>
									<input type="password" name="paswoord">
								</p>

								<input type="submit" value="Login" name="submit"> 
							</form>
						</div>
					</div>
					<!-- END BLOCK : login -->

			</div>
		</div>

		<div id="frame">

			<!-- START BLOCK : register -->
				<div class="register">
					<form method="post" action="index.php?action=register">
						<h1>Registreren</h1>
						
						<p>
							<input type="text" placeholder="Voornaam" name="firstname" value="{FIRSTNAME}" required>
							<input type="text" placeholder="Achternaam" name="lastname" value="{LASTNAME}" required>
						</p>

						<p>
							<input type="text" placeholder="Email" name="email" value="{EMAIL}" required>
						</p>

						<p>
							<input type="text" placeholder="Herhaal Email" name="emailAgain" value="{EMAILAGAIN}" required>
						</p>

						<!-- START BLOCK : wrongAddress -->
					     	<p>Deze emails zijn niet hetzelfde.</p>
					  	<!-- END BLOCK : wrongAddress -->
					  	<!-- START BLOCK : badAddress -->
					     	<p>Deze email is niet correct.</p>
					  	<!-- END BLOCK : badAddress -->
						
						<p>
							<input type="password" placeholder="Wachtwoord" name="paswoord" value="{PASWOORD}" required>
							<input type="password" placeholder="Herhaal wachtwoord"name="paswoordAgain" value="{PASWOORDAGAIN}" required>
						</p>

						<!-- START BLOCK : wrongKey -->
					     	<p>Deze wachtwoorden zijn niet hetzelfde.</p>
					  	<!-- END BLOCK : wrongKey -->

						<select name="birthdayDay">
					    	<option value="0" selected="1">Dag</option>
					  		
					  		<!-- START BLOCK : day -->
					     		<option {SELECTED} value="{DAY}">{DAY}</option>
					 		<!-- END BLOCK : day -->
					      	
					    </select>
					   
					    <select name="birthdayMonth">
					    	<option value="0" selected="1">Maand</option>
					  			
					  		<!-- START BLOCK : month -->
					     		<option {SELECTED} value="{VALUE}">{MONTH}</option>
					  		<!-- END BLOCK : month -->

					  	</select>

					  	<select name="birthdayYear">
					    	<option value="0" selected="1">Jaar</option>
					  			
					  		<!-- START BLOCK : year -->
					     		<option {SELECTED} value="{YEAR}">{YEAR}</option>
					  		<!-- END BLOCK : year -->

					  	</select>

					  	<!-- START BLOCK : badDate -->
					     	<p>Deze datum bestaat niet.</p>
					  	<!-- END BLOCK : badDate -->

						<p>
							<input type="radio" name="sex" value="Man" {MCHECKED} required>
							<label>Man</label>
							<input type="radio" name="sex" value="Vrouw" {VCHECKED} required>
							<label>Vrouw</label>
							<input type="radio" name="sex" value="Non-Binary" {BCHECKED} required>
							<label>Non-Binary</label>
						</p>	
													
						<input type="submit" value="Registreren" name="submit"> 

					</form>
				</div>
			<!-- END BLOCK : register -->

		</div>
		<div id="footerfix"></div>
			<div id="footer">
				<p>&copy; 2014 Copyright Theo Krommenhoek</p>
		</div>
	</div>
</body>
</html>