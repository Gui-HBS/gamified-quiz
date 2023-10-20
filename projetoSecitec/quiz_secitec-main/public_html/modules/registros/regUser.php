<?php
session_start();
require "../user/User.php";
require "../../db/MySql.php";
$user = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/loginUser/estilo.css" media="screen" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<style>
    body{
        background-image: url("../../assets/images/loginUser/fundo3.png");
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
    }
</style>
<body>
    <header>
        <div class="container" id="nav-container">
            <nav class="navbar navbar-expand-lg">
                <a href="#" class="navbar-brand">
                    <h1 class="logo">Quiz</h1>
                </a>
                <button class="navbar-toggler" type="botton" data-toggle="collapse" data-target="#navbar-links" aria-controls="navbar-links" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbar-links">
                    <div class="navbar-nav">
                        <a href="nav-item nav-link" id="home-menu">Home</a>
                        <a href="nav-item nav-link" id="home2-menu">Home2</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <div class="container mt-4">
        <div class="row align-items-center">
            <div class="col-md-10 mx-auto col-lg-5">
                <form action="" class="p-4 p-md-5 border rounded-3 bg-light" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="inputNome" name="nome" placeholder="Nome" required>
                        <label for="inputNome">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="E-mail" required>
                        <label for="inputEmail">E-mail</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="inputSenha" name="senha" placeholder="Senha" required>
                        <label for="inputSenha">Senha</label>
                    </div>
                    <div class="checkbox mb-3">
                        <label for="">
                            <input type="checkbox" value="lembrar">Lembrar-me
                        </label>
                    </div>
                    <button class="w-100 btn btn-lg btn-success" type="submit" name="entrar">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
if(isset($_POST["entrar"])){
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $user->create(["nome" => $nome, "email" => $email, "senha" => $senha]);
    $userId = $user->getPdo()->getConn()->lastInsertId();
    setcookie("userId", $userId, time() + (60 * 60 * 24 * 30), "/");
    header("location: regQuiz.php");
}
?>