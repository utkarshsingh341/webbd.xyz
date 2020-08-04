<?php 

include "includes/header.php";

if(isset($_GET['id']))
{
	$id = $_GET['id'];
}else{
	$id=0;
}

?>
<div class="container">
	<div class="row">
		<div class="col-sm-6" style="margin: 10px auto;">
				
				<div class="posts_area">
					<?php 
						$post = new Post($con,$userLoggedIn);
						$post->getSinglePost($id);
					?>
				</div>
		</div>
	</div>
</div>
</body>
</html>

