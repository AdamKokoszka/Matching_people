<?php

	session_start();
	
	session_unset();
	
	header('Location: admin_panel.php');

?>