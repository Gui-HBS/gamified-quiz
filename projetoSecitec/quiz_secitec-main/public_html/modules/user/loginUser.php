<?php
session_start();
require "../../db/MySql.php";
require "User.php";
$user = new User();
if(isset($_GET["userLoggof"])){
    $userId = $_COOKIE["userId"];
    setcookie("userId", $userId, time() - 3600, "/");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="" method="post">
        <label for="email">E-mail:</label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password:</label>
        <input type="text" name="password" id="password">
        <button type="submit" name="verifyLogin">make login </button>
    </form>
    <br>

    


<?php
if(isset($_POST["verifyLogin"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $getData = $user->select("*", ["email" => $email, "senha" => $password]);
    $results = count($getData);
    if($results == 0){
        echo "usuario ou senha invalidos!";
    }
    else{
        echo "usuario logado! ";
        echo "bem vindo, {$getData[0]["nome"]}";
        setcookie("userId", $getData[0]["idUsuario"], time() + (60 * 60 * 24 * 30), "/"); //define um cookie que armazena o id do usuario logado
        header('Refresh: 1;URL=menuUser/principal.php'); //define um temporizador de 1 segundos, e logo após redireciona para a pagina de menu do usuario
    }
}
?>
<p> não tem um login?<a href="../registros/regUser.php"> registre-se!</a></p>
</body>
</html>