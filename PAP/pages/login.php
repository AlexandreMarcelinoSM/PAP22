<?php 
session_start(); 
include "config.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$email = validate($_POST['email']);
	$pass = validate($_POST['password']);

	if (empty($email)) {
		header("Location: index.php?error=Tem que preencher o email");
	    exit();
	}else if(empty($pass)){
        header("Location: index.php?error=Tem que preencher a password");
	    exit();
	}else{
		$sql = "SELECT * FROM equipa WHERE email='$email' AND password='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['email'] === $email && $row['password'] === $pass) {
            	$_SESSION['email'] = $row['email'];
            	$_SESSION['nome'] = $row['nome'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: /pap/event/index.php");
		        exit();
            }else{
				header("Location: index.php?error=Email ou senha errada");
		        exit();
			}
		}else{
			header("Location: index.php?error=Email ou senha errada");
	        exit();
		}
	}
	
}else{
	header("Location: index.php");
	exit();
}