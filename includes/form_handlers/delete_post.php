<?php
    require '../../config/config.php';
    
    if(isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
 
        $query = mysqli_query($con, "UPDATE posts SET deleted='yes' WHERE id='$post_id'");
    }
 
?>