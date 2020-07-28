<?php 
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");


if(isset($_POST['post']))
{
	$post = new Post($con, $userLoggedIn);
	$post->submitPost($_POST['post_text'],'none');
	header("Location:index.php");
}

?>

	<div class="container">
		<div class="row">
	    	<div class="col-sm">
	      		<div class="user_details column">
					<a href="<?php echo $userLoggedIn ?>"> <img src="<?php echo $user['profile_pic']; ?>" class="main_profile_pic"></a>
					<h4 class="card-title" style="font-weight: bold; margin-bottom: 8px;"><a style="color: #444;" href="<?php echo $userLoggedIn ?>"><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></a></h5>
	    			<h6 class="card-subtitle mb-2 text-muted">@<?php echo $user['username']; ?></h6>
	    			<div class="wh-sp"></div>
	    			<table class="count_table">
	    				<thead><tr>
	    					<th style="border-right: 1px solid #000;">
	    						Posts
	    					</th>
	    					<th>
	    						Likes
	    					</th>
	    				</tr></thead>
	    				<tr>
	    					<td style="border-right: 1px solid #000;">
	    						<?php echo $user['num_posts']; ?> 
	    					</td>
	    					<td>
	    						<?php echo $user['num_likes']; ?> 
	    					</td>
	    				</tr>
	    			</table>
				</div>
				<div class="card">
				  <div class="card-body" style="padding: 20px;">
				    <span style = "font-size: 17px;">About</span> &middot <a href="" style="font-size: 12px;">Edit</a>
				    <table class="about-style-tab">
				    	<tr>
				    		<td> <i class="fas fa-school"></i></td>
				    		<td> Studies at <a href="#">R.V.C.E.</a> </td>
				    	</tr>
				    	<tr>
				    		<td> <i class="fas fa-graduation-cap"></i></td>
				    		<td> Went to <a href="#">Carmel School</a></td>

				    	</tr>
				    	<tr>
				    		<td><i class="fas fa-map-marker-alt"></i></td>
				    		<td>Lives in <a href="#">Bangalore, India</a></td>

				    	</tr>
				    	<tr>
				    		<td><i class="fas fa-home"></i></td>
				    		<td>From <a href="#">Jamshedpur, India</a></td>

				    	</tr>
				    	<tr>
				    		<td><i class="far fa-clock"></i></td>
				    		<td>Joined <a href="#">July, 2019</a></td>

				    	</tr>
				    </table>
				  </div>
				</div>
	    	</div>
	    	<div class="col-sm-6">
	      		<div class="main_column column">
	      			<form class="post_form" action="index.php" method="post">
	      				<textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
	      				<button type="submit" name="post" id="post_button"><i class="fa fa-send-o" style="font-size:21px"></i></button>
	      			</form>
				</div>

				<div class="wh-sp"></div>

				<div class="posts_area"></div>
				<img src="assests/images/misc/loading.gif" id="loading" height="20" width="20" align="center">

				<script>
					var userLoggedIn = '<?php echo $userLoggedIn; ?>';
					$(document).ready(function() {
						$('#loading').show();

						//Original ajax request for loading first posts 
						$.ajax({
							url: "includes/handlers/ajax_load_posts.php",
							type: "POST",
							data: "page=1&userLoggedIn=" + userLoggedIn,
							cache:false,

							success: function(data) {
								$('#loading').hide();
								$('.posts_area').html(data);
							}
						});

						$(window).scroll(function() {
							var height = $(".posts_area").height(); //Div containing posts
							var scroll_top = $(this).scrollTop();
							var page = $(".posts_area").find(".nextPage").val();
							var noMorePosts = $(".posts_area").find(".noMorePosts").val();

							if (($(window).scrollTop() + $(window).height() >= $(document).height()) && noMorePosts == 'false') {
								$('#loading').show();

								var ajaxReq = $.ajax({
									url: "includes/handlers/ajax_load_posts.php",
									type: "POST",
									data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
									cache:false,

									success: function(response) {
										$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
										$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

										$('#loading').hide();
										$('.posts_area').append(response);
									}
								});

							} //End if 

							return false;

						}); //End (window).scroll(function())


					});

					</script>
	    	</div>

	    	<div class="col-sm">
	      		<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Welcome to Webbd!</h5>
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				    <a href="#" class="card-link">Card link</a>
				    <a href="#" class="card-link">Another link</a>
				  </div>
				</div>
				<div class="wh-sp"></div>
	    		<div class="card">
				  <img src="assests/images/misc/desktop.jpg" class="card-img-top" alt="...">
				  <div class="card-body">
				    <h6 class="card-subtitle mb-2 text-muted" style="letter-spacing: 2px; font-size: 14px;">SPONSORED</h6>
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				    <a href="#" class="btn btn-primary stretched-link">Go somewhere &thinsp; <i class="fas fa-sign-out-alt"></i></a>
				  </div>
				</div>
	      		<div class="wh-sp"></div>
	    		<div class="card">
					<ul class="footer-style">
						<li>Webbd.xyz &copy; 2019</li>&bull;
						<li><a href="#">About</a></li> &middot;
						<li><a href="#">Help</a></li>&middot;
						<li><a href="#">Terms</a></li>&middot;
						<li><a href="#">Privacy</a></li>&middot;
						<li><a href="#">Cookies</a></li>&middot;
						<li><a href="#">Advertise</a></li>&middot;
						<li><a href="#">Info</a></li>&middot;
						<li><a href="#">Feeeback</a></li>
					</ul>
				</div>
	    	</div>
		</div>
	</div>
		

</div>


</body>
</html>