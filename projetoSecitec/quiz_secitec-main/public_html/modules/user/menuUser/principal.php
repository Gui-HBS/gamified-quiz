<?php
require "../../quiz/Quiz.php";
require "../../quiz/Quiz_has_question.php";

require "../../alternatives/Alternative.php";
require "../../alternatives/Alternative_has_answer.php";

require "../../question/Question.php";
require "../../question/Question_has_alternative.php";

require "../../answer/Answer.php";
require "../../category/Category.php";
require "../../../db/MySql.php";
require "../User.php";

$quiz = new Quiz();
$alternative = new Alternative();
$category = new Category();
$answer = new Answer();
$question = new Question();
$quiz_has_question = new Quiz_has_question();
$question_has_alternative = new Question_has_alternative();
$alternative_has_answer = new Alternative_has_answer();
$user = new User();
if(isset($_COOKIE["userId"])){?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>menu User</title>
    </head>
    <body>
    <?php
   $arrayIdQuiz = $quiz->select("idQuiz", ["Usuario_IdUsuario" => $_COOKIE["userId"]]);
    $loggedUser = $user->select("nome", ["IdUsuario" => $_COOKIE["userId"]]);
    echo "<h1> Que bom te ver, {$loggedUser[0]["nome"]}!</h1>";
    echo "<a href='../loginUser.php?userLoggof'> Sair </a>";
    echo "<h3>Seus Quizzes:</h3>";
    foreach($arrayIdQuiz as $key => $value){
        echo "<div class='viewQuiz'>";
        $idQuiz = $value["idQuiz"];
        $quizNameArray = $quiz->select("titulo", ["idQuiz" => $idQuiz]);
        $quizNameString = $quizNameArray[0]["titulo"];
        echo "<a href='viewQuiz.php?idQuiz={$idQuiz}'>{$quizNameString}</a>";
        echo "</div>";
    } 
    ?>
    <br><br>
    <br><br>
    <a href="../../registros/regQuiz.php">create Quiz</a>

</body>
</html>
<?php
} else{
    echo "Ops! você precisa de um login para acessar essa página :/";
    echo "<br>";
    echo "<a href='../loginUser.php'>fazer login</a>";
}
?>


<style>
    .viewQuiz{
        border: 0.5px solid black;
        border-radius: 5px;
        margin-bottom: 10px;
        max-width: fit-content;
        padding: 3px;
    }
</style>
