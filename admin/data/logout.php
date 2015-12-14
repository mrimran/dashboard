<?php
session_start();
if(isset($_SESSION['lm_auth'])){
	unset($_SESSION['lm_auth']);
        //session_destroy();
	$msg=base64_encode("You have successfully logged out.");
	header("Location: index.php?msg=$msg");
	exit;
}
?>