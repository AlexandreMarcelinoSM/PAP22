<?php
require_once "config.php";

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email)){
        $error .= '<p class="error">Por favor escreva um email válido.</p>';
    }
    if(empty($password)){
        $password .= '<p class="error">Por favor escreva uma password válida.</p>';
    }

    if(empty($error)){
        if($query = $db->prepare("SELECT * FROM equipa WHERE email = ?")){
            $query->bind_param("s",$email);
            $query->execute();
            $row = $query->fetch();
            if($row){
                if (password_verify($password, $row['password'])){
                    $_SESSION["userid"] = $row['id_utilizador'];
                    $_SESSION["user"] = $row;

                    header("location: index.html");
                    exit;
                } else{
                    $error .= '<p class="error">A password não é válida.</p>';
                }
            } else{
                $error .= '<p class="error">Não existe nenhum utilizador com esse email.</p>';
            }
        }
        $query->close();
    }
    mysqli_close($db);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    
    <!--CSS-->
    <link rel="stylesheet" href="assets/css/login.css">

</head>
<body>

    <form action="" method="POST">        
        <div class="container"> 
            <img src="./assets/images/logo-v1.png" alt="avatar" class="avatar">            
            <center> <h1> LOGIN DE ACESSO </h1> </center> 
            <?php echo $error;?>
            <div class="form-group">
            <label>Email : </label> 
            <input type="email" placeholder="Escreva o seu e-mail" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password : </label> 
            <input type="password" placeholder="Escreva a sua password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
           <input type="submit" name="submit" class="btn btn-primary" value="Entrar">
</div>
        
        </div> 
    </form>   
</body>
</html>