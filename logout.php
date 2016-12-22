<?php
	if(!session_id()) session_start();
	session_destroy();
	unset($_SESSION['uID']);
	unset($_SESSION['uType']);
	header("Location:./index.php");
	exit();