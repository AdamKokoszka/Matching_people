<?php

	session_start();
	
	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");
	
		if ($result = @$connection->query(
		sprintf("SELECT * FROM admin_access WHERE login='%s' AND password='%s'",
		mysqli_real_escape_string($connection,$login),
		mysqli_real_escape_string($connection,$password))))
		{
			$all_user = $result->num_rows;
			if($all_user>0)
			{
				$_SESSION['login'] = true;
				
				$row = $result->fetch_assoc();
				$_SESSION['user'] = $row['user'];
				
				unset($_SESSION['error']);
				$result->free_result();
				header('Location: admin_panel.php');
				
			} else {
				
				$_SESSION['error'] = '<span class="span_e">Nieprawidłowy login lub hasło!</span>';
				header('Location: index.php');
				
			}
			
		}
		
		$connection->close();
	}
	
?>