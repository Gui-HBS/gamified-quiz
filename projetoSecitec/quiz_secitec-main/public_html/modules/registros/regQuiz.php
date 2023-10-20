<?php
require "../quiz/Quiz.php";
require "../ranking/Ranking.php";
require "../answer/Answer.php";
require "../alternatives/Alternative.php";
require "../category/Category.php";
require "../question/Question.php";
require "../user/User.php";
require "../../db/MySql.php";
$quiz = new Quiz();
$answer = new Answer();
$alternative = new Alternative();
$category = new Category();
$question = new Question();
$user = new User();
$ranking = new Ranking();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>criar quiz</title>
</head>
<body>
    <form action="" method="post">
        <label for="nomeQuiz">nome do quiz</label>
        <input type="text" name="nomeQuiz" id="">
        <label for="descricaoQuiz">descrição do quiz</label>
        <input type="text" name="descricaoQuiz" id="">
        <label for="tipoQuiz">tipo do quiz</label>
        <select name="tipoQuiz">
            <option value="valor1">formulário</option>
            <option value="valor2">prova </option>
        </select>
        <label for="valorQuiz">valor do quiz</label>
        <input type="number" name="valorQuiz" id="">
        <button type="submit" name="enviar">cadastrar quiz</button>
    </form>
    <a href='../user/menuUser/principal.php'>voltar para o menu principal</a>
</body>
</html>
<?php
if(isset($_POST["enviar"])){
    $titulo = $_POST["nomeQuiz"];
    $resumo = $_POST["descricaoQuiz"];
    $tipo = $_POST["tipoQuiz"];
    $score = $_POST["valorQuiz"];
    $publish = "data";
    $userId = $_COOKIE["userId"];
    var_dump($userId);
    $quiz->create(["titulo" => $titulo, "resumo" => $resumo, "tipo" => $tipo, "score" => $score, "publish" => $publish, "usuario_idUsuario" => $userId]);
    $quizId = $quiz->getPdo()->getConn()->lastInsertId();
    $ranking->create(["pontuacao" => 0, "Quiz_idquiz" => $quiz->pdo->getConn()->lastInsertId()]);
    setcookie("quizId", $quizId, time() + (60 * 60 * 24 * 30), "/");

    header("location: regQuestion.php");
}
