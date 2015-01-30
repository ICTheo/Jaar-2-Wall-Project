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

	<h1 class="adminPanel"><a href="admin.php"> Admin Panel </a></h1>

	<!-- START BLOCK : default -->

		<p><a href="admin.php?action=users">Users</a></p>
		<p><a href="admin.php?action=allPosts">All Posts</a></p>
		<p><a href="admin.php?action=allComments">All Comments</a></p>

	<!-- END BLOCK : default -->
	
	<!-- START BLOCK : userFrame -->

	<table>
		
		<tr>
			<th>Gebruikers Id</th>
			<th>Avatar</th>
			<th>Voornaam</th>
			<th>Achternaam</th>
			<th>Email</th>
			<th>Type</th>
			<th>Status</th>
			<th colspan="3">Actions</th>
		</tr>

	<!-- START BLOCK : users -->
		<tr>
			<td>{ID}</td>
			<td><img src="avatar/{AVATAR}" height="100px" width="100px"></td>
			<td>{VOORNAAM}</td>
			<td>{ACHTERNAAM}</td>
			<td>{EMAIL}</td>
			<td>{TYPE}</td>
			<td>{STATUS}</td>

			<!-- START BLOCK : ban -->
				<td><a href="admin.php?action=banUser&id={ID}&status=0">Ban</a></td>
			<!-- START BLOCK : ban -->
			<!-- START BLOCK : unBan -->
				<td><a href="admin.php?action=banUser&id={ID}&status=1">Unban</a></td>
			<!-- START BLOCK : unBan -->
				<td><a href="admin.php?action=userPosts&id={ID}">View their posts</a></td>
				<td><a href="admin.php?action=userComments&id={ID}">View their comments</a></td>
		</tr>
	<!-- END BLOCK : users -->

	</table>

	<!-- END BLOCK : userFrame -->


	<!-- START BLOCK : postFrame -->

	<h2> {VOORNAAM} {ACHTERNAAM}'s posts </h2>

	<table>
	
	<tr>
		<th>Post Id</th>
		<th>Content</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
	<!-- START BLOCK : posts -->

	<tr>
		<td>{ID}</td>
		<td>{CONTENT}</td>	
		<td>{STATUS}</td>	
		<!-- START BLOCK : delete -->
			<td><a href="admin.php?action=deletePost&loc=user&id={ID}&persoonId={PERSOONID}&status=0">Delete</a></td>
		<!-- START BLOCK : delete -->
		<!-- START BLOCK : unDelete -->
			<td><a href="admin.php?action=deletePost&loc=user&id={ID}&persoonId={PERSOONID}&status=1">Undelete</a></td>
		<!-- START BLOCK : unDelete -->
		<td><a href="admin.php?action=editPost&loc=all&id={ID}&persoonId={PERSOONID}">Bewerken</a></td>
	</tr>

	

	<!-- END BLOCK : posts -->

	</table>

	<!-- END BLOCK : postFrame -->	

	<!-- START BLOCK : commentFrame -->

	<h2> {VOORNAAM} {ACHTERNAAM}'s comment </h2>

	<table>
	
	<tr>	
		<th>Commment Id</th>
		<th>Content</th>
		<th>Status</th>
	</tr>

	<!-- START BLOCK : comments -->

	<tr>
		<td>{ID}</td>
		<td>{CONTENT}</td>	
		<td>{STATUS}</td>	
		<!-- START BLOCK : deleteC -->
			<td><a href="admin.php?action=deleteComments&loc=user&id={ID}&persoonId={PERSOONID}&status=0">Delete</a></td>
		<!-- START BLOCK : deleteC -->
		<!-- START BLOCK : unDeleteC -->
			<td><a href="admin.php?action=deleteComments&loc=user&id={ID}&persoonId={PERSOONID}&status=1">Undelete</a></td>
		<!-- START BLOCK : unDeleteC -->
		<td><a href="admin.php?action=editComment&loc=user&id={ID}&persoonId={PERSOONID}">Bewerken</a></td>
	</tr>

	

	<!-- END BLOCK : comments -->

	</table>

	<!-- END BLOCK : commentFrame -->

	<!-- START BLOCK : allPostsFrame -->

		<table>

		<tr>
			<th>Post Id</th>
			<th>Content</th>
			<th>Status</th>
		</tr>

		<!-- START BLOCK : allPosts -->

			<tr>
				<td>{ID}</td>
				<td>{CONTENT}</td>	
				<td>{STATUS}</td>
				<!-- START BLOCK : deleteAll -->
					<td><a href="admin.php?action=deletePost&loc=all&id={ID}&status=0">Delete</a></td>
				<!-- START BLOCK : deleteAll -->
				<!-- START BLOCK : unDeleteAll -->
					<td><a href="admin.php?action=deletePost&loc=all&id={ID}&status=1">Undelete</a></td>
				<!-- START BLOCK : unDeleteAll -->
				<td><a href="admin.php?action=editPost&loc=all&id={ID}">Bewerken</a></td>
			</tr>

		<!-- END BLOCK : allPosts -->

		</table>

	<!-- END BLOCK : allPostsFrame -->

	<table>

		<!-- START BLOCK : allCommentsFrame -->
		
		<tr>
			<th>Comment Id</th>
			<th>Content</th>
			<th>Status</th>
			<th>Action</th>
		</tr>

		<!-- START BLOCK : allComments -->

		<tr>
			<td>{ID}</td>
			<td>{CONTENT}</td>	
			<td>{STATUS}</td>	
			<!-- START BLOCK : deleteAllC -->
				<td><a href="admin.php?action=deleteComments&loc=all&id={ID}&status=0">Delete</a></td>
			<!-- START BLOCK : deleteAllC -->
			<!-- START BLOCK : unDeleteAllC -->
				<td><a href="admin.php?action=deleteComments&loc=all&id={ID}&status=1">Undelete</a></td>
			<!-- START BLOCK : unDeleteAllC -->
			<td><a href="admin.php?action=editComment&loc=all&id={ID}">Bewerken</a></td>
		</tr>

		

		<!-- END BLOCK : allComments -->

	</table>

	<!-- END BLOCK : allCommentsFrame -->
		
	<!-- START BLOCK : editPost -->
		<form method="post" action="admin.php?action=editPost&commentId={ID}&loc=all">
			<tr>
				<th>Post Id</th>
				<th>Content</th>
				<th>Action</th>
			</tr>

			<tr>
				<td>{ID}</td>
				<td><textarea name="content">{CONTENT}</textarea></td>
				<td><input class="button" type="submit" name="submit" value="post"></td>
			</tr>
		</form>
	<!-- END BLOCK : editPost -->	

	<!-- START BLOCK : editComment -->
		<form method="post" action="admin.php?action=editComment&commentId={ID}&loc={LOC}">
			<tr>
				<th>Comment Id</th>
				<th>Content</th>
				<th>Action</th>
			</tr>

			<tr>
				<td>{ID}</td>
				<td><textarea name="content">{CONTENT}</textarea></td>
				<td><input class="button" type="submit" name="submit" value="post"></td>
			</tr>
		</form>
	<!-- END BLOCK : editComment -->

	<div id="footerfix"></div>
		<div id="footer">
			<p>&copy; 2014 Copyright Theo Krommenhoek</p>
		</div>
	</div>
</body>
</html>