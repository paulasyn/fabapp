<?php

if (isset($_POST['submit'])){
	include_once 'add.php';
	
	$r_id = mysqli_real_escape_string($con, $_POST['r_id']);
	$operator = mysqli_real_escape_string($con, $_POST['operator']);
	$icon = mysqli_real_escape_string($con, $_POST['icon']);
	$notes = mysqli_real_escape_string($con, $_POST['notes']);
	
	# Error handling
	if(empty($r_id)||empty($operator)||empty($notes)){
		header("Location: ../manageUsers/createUser.php?field=empty");
		exit();
	}else{
		#Discuss other inputs with Jon, default expecting specific characters
		if(!preg_match("/^[a-zA-Z]*$/", $notes)||!preg_match("/^[0-9]*$/", $r_id)||
		!preg_match("/^[0-9]*$/", $operator)||!preg_match("/^[a-zA-Z]*$/", $icon)){
			header("Location: ../manageUsers/createUser.php?field=invalid");
			exit();
		}else{
			#Make sure you're not entering a user with a repat 1000s number
			$sql = "SELECT * FROM users WHERE operator = '$operator'";
			$result = mysqli_query($con, $sql);
			$resultCheck = mysqli_num_rows($result);
			
			if($resultCheck>0){ 
				#if it's a repeat 1000s number, return to create user page with error message
				header("Location: ../manageUsers/createUser.php?preexisting100s");
				exit();
			}else {
				#else, add the user and return to create user page.
				$sql = "INSERT INTO users (operator, r_id, icon, notes) VALUES ('$operator', 
				'$r_id', '$icon', '$notes');";
				mysqli_query($con, $sql);
				header("Location: ../manageUsers/createUser.php?Addition=success");
				exit();
			}
		}
	}
	
} else{
	header("Location: ../index.php");
	exit();
}