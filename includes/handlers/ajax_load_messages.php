<?php 

include("../../config/config.php");
include("../classes/User.php");
include("../classes/Message.php");

$limit = 1000;//Number of messages to load
$message = new Message($con, $_REQUEST['userLoggedIn']);
echo $message->getConvosDropDown($_REQUEST,$limit);

?>