<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wall</title>
	<link rel="stylesheet" type="text/css" href="css/Wall.css"/>
	<script type="text/javascript">
	function disable() {
		setTimeout("document.getElementById('addpost').disabled=true;",0);
		setTimeout("document.getElementById('addcomment').disabled=true;",0);
		setTimeout("document.getElementById('addcommentoncomment').disabled=true;",0);
	}

	function showMore(id)
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
	<script src="jquery.js"> </script>
	<script src="javascript.js"> </script>
	<script type="text/javascript" src="//use.typekit.net/vue1oix.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

	<style type="text/css">

	</style>
	<script>

	$(document).ready(function() {

		$('#content').scrollPagination({

			nop     : 3, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : 'No More Posts!', // When the user reaches the end this is the message that is
			                            // displayed. You can change this if you want.
			delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
			               // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
			               // but will still load if the user clicks.
			
		});
		
	});
</script>
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
				<!-- START BLOCK : admin -->
					<div class="button"><a href="admin.php">Admin</a></div>
				<!-- END BLOCK : admin -->
			</div>
		</div>

		<div id="frame">


			<!-- Nieuwe post maken -->

			<!-- START BLOCK : newPostFrame -->

				<div id="newPostFrame">

					<img class="avatar" src="avatar/{AVATAR}" height="100px" width="100px">

					<!-- START BLOCK : newPost -->
						<div class = "newPost">

							<h2>Maak een nieuwe post</h2>

							<form method="post" action="home.php?action=newPost">
								<label>
									<p>
										<textarea name="post" rows="5"></textarea>
									</p>
								</label>
								<input onclick="disable();" id="addPost" class="postButton" type="submit" name="submit" value="post">
						
							</form>

						</div>
					<!-- END BLOCK : newPost -->

				</div>

			<!-- END BLOCK : newPostFrame -->


			<!-- Alle posts laten zien -->
			
			<!-- START BLOCK : postsFrame -->
		
			<div id="postsFrame">

			<div id="content">


			</div>

			</div>

			<!-- END BLOCK : postsFrame -->


			<!-- De post die geedit word-->

			<!-- START BLOCK : editPosts -->
				<div class = "posts">
					<img src="avatar/{AVATAR}" height="100px" width="100px">
					<h3>Gepost door : <a href='profile.php?id={ID}'>{VOORNAAM} {ACHTERNAAM}</a> </h3>
					<form method="post" action="home.php?action=editPost&postId={POSTID}">
						<textarea name="content">{CONTENT}</textarea>
						<input class="button" type="submit" name="submit" value="post">
					</form>
				</div>
			<!-- END BLOCK : editPosts -->


			<!-- De comment die geedit word-->

			<!-- START BLOCK : editComment -->
				<div class = "posts">
					<img src="avatar/{AVATAR}" height="100px" width="100px">
					<h3>Gepost door : <a href='profile.php?id={ID}'>{VOORNAAM} {ACHTERNAAM}</a> </h3>
					<p>{CONTENT}</p>
				
					<div>
					
						<!-- START BLOCK : editComments -->
							<form method="post" action="home.php?action=editComment&commentId={COMMENTID}">
								<p id="comment"><a href='profile.php?id={PERSOONID}'>
									{COMMENTVOORNAAM} {COMMENTACHTERNAAM}</a>: 
								</p>
								<textarea name="content">{COMMENTCONTENT}</textarea>
								<input class="button" type="submit" name="submit" value="post">
							</form>
						<!-- END BLOCK : editComments -->

					</div>
				</div>
			<!-- END BLOCK : editComment -->


			<!-- De reply die geedit word -->

			<!-- START BLOCK : editReply -->
				<div class = "posts">
					<img src="avatar/{AVATAR}" height="100px" width="100px">
					<h3>Gepost door : <a href='profile.php?id={ID}'>{VOORNAAM} {ACHTERNAAM}</a> </h3>
					<p>{CONTENT}</p>
				
					<div>
					
						<!-- START BLOCK : editReplyComments -->
								<p id="comment"><a href='profile.php?id={COMMENTID}'>
									{COMMENTVOORNAAM} {COMMENTACHTERNAAM}</a>: {COMMENTCONTENT}
								</p>
							<!-- START BLOCK : editRepliez -->
										
										<form method="post" action="home.php?action=editReply&commentId={REPLYID}">
											<div>
												<p class="reply"><a href='profile.php?id={PERSOONID}'>
													{REPLYVOORNAAM} {REPLYACHTERNAAM}</a>: <textarea name="content">{REPLYCONTENT}</textarea>	
												</p>
											</div>
											<input class="button" type="submit" name="submit" value="post">
										</form>
									<!-- END BLOCK : editRepliez -->
						<!-- END BLOCK : editReplyComments -->

					</div>
				</div>
			<!-- END BLOCK : editReply -->

		</div>

		<div id="footerfix"></div>
		<div id="footer">
			<p>&copy; 2014 Copyright Theo Krommenhoek</p>
		</div>
	</div>
</body>
</html>