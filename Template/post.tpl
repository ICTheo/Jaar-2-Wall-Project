<!-- Alle posts laten zien -->

	<!-- START BLOCK : showPosts -->
		<div class = "posts">
			<div class="postHeader">
				<img class="avatar" src="avatar/{AVATAR}" height="60px" width="60px">
				<p class="postDate">{DATE}</p>
				<h3 class="postOwner"><a href='profile.php?id={PERSOONID}'>{VOORNAAM} {ACHTERNAAM}</a> </h3>
				
				<div class="postMenu" onclick="showMore('postMenu{POSTID}')"><img src="css/arrow-down.png"></div>
				<div id="postMenu{POSTID}" class="postMenuItems" style="display : none;" >
					<!-- START BLOCK : editDeletePost -->
						<p><a href="home.php?action=editPost&postId={POSTID}">bewerken</a></p>
						<p><a href="home.php?action=deletePost&postId={POSTID}&gebruikerId={GEBRUIKERID}">delete</a></p>
					<!-- END BLOCK : editDeletePost -->
				</div>

			</div>

			<div class="postWrap">
				<p class="postContent">{CONTENT}</p>
				
				<p style="display : inline-block" class="postOther">
				<!-- START BLOCK : postLikes -->

					<!-- START BLOCK : like -->
						<a class="postLikes" href="home.php?action=like&gebruikerId={GEBRUIKERID}&typeId={POSTID}&type=post">like</a>
					<!-- END BLOCK : like -->
					<!-- START BLOCK : relike -->
						<a class="postLikes" href="home.php?action=relike&gebruikerId={GEBRUIKERID}&typeId={POSTID}&type=post">like</a>
					<!-- END BLOCK : relike -->
					<!-- START BLOCK : dislike -->
						<a class="postDislikes" href="home.php?action=dislike&gebruikerId={GEBRUIKERID}&typeId={POSTID}&type=post">unlike</a>
					<!-- END BLOCK : dislike -->

					 • 

						<span class="mouseCursor" onclick="showMore('likePostMenu{POSTID}')"> {POSTLIKES} likes</span>
						<div id="likePostMenu{POSTID}" class="postMenuItems" style="display : none;" >
							Deze post is geliked door: </br>

							<!-- START BLOCK : userLikes -->
		
								<a href='profile.php?id={PERSOONID}'>{LIKESVOORNAAM} {LIKESACHTERNAAM}</a></br>

							<!-- END BLOCK : userLikes -->
						</div>
					<!-- END BLOCK : postLikes -->

					 •

					<!-- START BLOCK : commentAmount -->
						 {COMMENTAMOUNT} comments
					<!-- END BLOCK : commentAmount -->
				</p>

				<!-- Comment plaatsen -->

				<div class="commentContent">

					<p><span class="mouseCursor" onclick="showMore('postComment{POSTID}')">Comment</span>

						<!-- START BLOCK : love -->
							<a class="love" href="home.php?action=like&gebruikerId={GEBRUIKERID}&typeId={POSTID}&type=love">♥</a>
						<!-- END BLOCK : love -->
						<!-- START BLOCK : relove -->
							<a class="love" href="home.php?action=relike&gebruikerId={GEBRUIKERID}&typeId={POSTID}&type=love">♥</a>
						<!-- END BLOCK : relove -->
						<!-- START BLOCK : unlove -->
							<a class="unlove" href="home.php?action=dislike&gebruikerId={GEBRUIKERID}&typeId={POSTID}&type=love">♥</a>
						<!-- END BLOCK : unlove -->

					</p>

					<div id="postComment{POSTID}" style="display : none;" >
 
						<form method="post" action="home.php?action=newComment&postId={POSTID}">

							<textarea name="comment" rows="2"></textarea>
							<input onclick="disable();" id="addComment" class="button" type="submit" name="submitComment" value="post">
						
						</form>

						
						<!-- Alle bijbehorende comments laten zien. -->

						<!-- START BLOCK : showComments -->
							<p class="comment"><img class="avatar" src="avatar/{AVATAR}" height="40px" width="40px"><a class="namez" href='profile.php?id={COMMENTID}'>
								{COMMENTVOORNAAM} {COMMENTACHTERNAAM}</a>: {COMMENTCONTENT}</p>
								
								<p>
				

									<div class="postMenu" onclick="showMore('commentMenu{COMMENTIDZ}')"><img src="css/arrow-down.png"></div>
									<div id="commentMenu{COMMENTIDZ}" class="postMenuItems" style="display : none;" >
										<!-- START BLOCK : editDeleteComment -->
											<p><a href="home.php?action=editComment&commentId={COMMENTIDZ}&postId={POSTID}">bewerken</a></p>
											<p><a href="home.php?action=deleteComment&commentId={COMMENTIDZ}&gebruikerId={GEBRUIKERID}">delete</a></p>
										<!-- END BLOCK : editDeleteComment -->									
									</div>
									
									<!-- START BLOCK : commentLike -->
										<a class="commentLikes" href="home.php?action=like&gebruikerId={GEBRUIKERID}&typeId={COMMENTID}&type=comment">like</a>
									<!-- END BLOCK : commentLike -->
									<!-- START BLOCK : commentRelike -->
										<a class="commentLikes" href="home.php?action=relike&gebruikerId={GEBRUIKERID}&typeId={COMMENTID}&type=comment">like</a>
									<!-- END BLOCK : commentRelike -->
									<!-- START BLOCK : commentDislike -->
										<a class="commentDislikes" href="home.php?action=dislike&gebruikerId={GEBRUIKERID}&typeId={COMMENTID}&type=comment">unlike</a>
									<!-- END BLOCK : commentDislike -->

									 • 

									<!-- START BLOCK : commentLikes -->
										
										<!-- Dit laat zien wie de posts geliked hebben. Wanneer er op likes geklikt word, showed die de gebruikers. s-->
										<span class="mouseCursor" onclick="showMore('likeCommentMenu{COMMENTIDZ}')"> {COMMENTLIKES} likes</span>
										<div id="likeCommentMenu{COMMENTIDZ}" class="postMenuItems" style="display : none;" >
											Deze comment is geliked door: </br>

											<!-- START BLOCK : userCommentLikes -->
												<a href='profile.php?id={PERSOONID}'>{LIKESVOORNAAM} {LIKESACHTERNAAM}</a></br>
											<!-- END BLOCK : userCommentLikes -->
										</div>

									<!-- END BLOCK : commentLikes -->

									 • 

									<!-- START BLOCK : replyAmount -->
										{REPLYAMOUNT} replies
									<!-- END BLOCK : replyAmount -->

								</p>


								<!-- Reply plaatsen -->

								<div class="replyContent">

									<p class="mouseCursor" onclick="showMore('postReply{COMMENTIDZ}')">Reply</p>
									<div id="postReply{COMMENTIDZ}" style="display : none;" >

										<form method="post" action="home.php?action=newReply&parentId={COMMENTIDZ}">

											<textarea name="reply"></textarea>
											<input onclick="disable();" id="addReply" class="button" type="submit" name="submitComment" value="post">
										
										</form>


										<!-- START BLOCK : showReplies -->
											<div>
												<p class="reply"><img class="avatar" src="avatar/{AVATAR}" height="40px" width="40px"><a class="namez" href='profile.php?id={PERSOONID}'>
													{REPLYVOORNAAM} {REPLYACHTERNAAM}</a>: {REPLYCONTENT} 	

													<div class="postMenu" onclick="showMore('replyMenu{REPLYID}')"><img src="css/arrow-down.png"></div>
													<div id="replyMenu{REPLYID}" class="postMenuItems" style="display : none;" >
														<!-- START BLOCK : editDeleteReplies -->
															<a href="home.php?action=editReply&commentId={REPLYID}&postId={POSTID}&parentId={PARENTID}">bewerken</a>
															<a href="home.php?action=deleteComment&commentId={REPLYID}&gebruikerId={GEBRUIKERID}">delete</a>
														<!-- END BLOCK : editDeleteReplies -->									
													</div>	

													<!-- START BLOCK : replyLike -->
														<a class="replyLikes" href="home.php?action=like&gebruikerId={GEBRUIKERID}&typeId={REPLYID}&type=comment">like</a>
													<!-- END BLOCK : replyLike -->
													<!-- START BLOCK : replyRelike -->
														<a class="replyLikes" href="home.php?action=relike&gebruikerId={GEBRUIKERID}&typeId={REPLYID}&type=comment">like</a>
													<!-- END BLOCK : replyRelike -->
													<!-- START BLOCK : replyDislike -->
														<a class="replyDislikes" href="home.php?action=dislike&gebruikerId={GEBRUIKERID}&typeId={REPLYID}&type=comment">unlike</a>
													<!-- END BLOCK : replyDislike -->

													 • 

													<!-- START BLOCK : replyLikes -->

														<!-- Dit laat zien wie de posts geliked hebben. Wanneer er op likes geklikt word, showed die de gebruikers. s-->
														<span class="mouseCursor" onclick="showMore('likeReplyMenu{REPLYID}')"> {REPLYLIKES} likes</span>
														<div id="likeReplyMenu{REPLYID}" class="postMenuItems" style="display : none;" >
															Deze reply is geliked door: </br>

															<!-- START BLOCK : userReplyLikes -->
																<a href='profile.php?id={PERSOONID}'>{LIKESVOORNAAM} {LIKESACHTERNAAM}</a></br>
															<!-- END BLOCK : userReplyLikes -->
														</div>

													<!-- END BLOCK : replyLikes -->

												</p>
											</div>
										<!-- END BLOCK : showReplies -->

									</div>
								</div>
							</p>
						<!-- END BLOCK : showComments -->
					</div>
				</div>
			</div>
			
			<div class="lowerBorder">
			</div>

		</div>
	<!-- END BLOCK : showPosts -->