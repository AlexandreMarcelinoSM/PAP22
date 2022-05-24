<?php
$email = $_POST["email"];
$password = $_POST["password"];

mysql_connect("localhost", "root","");
mysql_select_bd("tlimtlim");

$result = mysql_query("SELECT * FROM equipa WHERE email = '$email' and password = '$password'");

$row = mysql_fetch_array($result);
if ($row['email'] == $email && $row['password'] == $password){
    echo "teste" .$row['email'];
} else{
    echo "meh";
}

?>
