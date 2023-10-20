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


if(isset($_GET["apagarQuestao"])){
    $idQuiz = $_GET["idQuiz"];
    $question->delete(["idPergunta" => $_GET["questionId"]]);
    header("location:");
}
$idQuiz = $_GET["idQuiz"];
$quizData = $quiz->select("titulo, resumo, tipo, score", ["idQuiz" => $idQuiz]);

echo "<div class='quiz-info'>";
foreach($quizData as $data){
    foreach($data as $key => $value){
        echo "{$key}: {$value}<br>"; // exibe os dados do quiz
    }
}
echo "</div>";
$alphabet = array(
    0 => "a",
    1 => "b",
    2 => "c",
    3 => "d",
    4 => "e"
);
$arrayIdQuestions = $quiz_has_question->select("pergunta_idPergunta", ["quiz_idQuiz" => $idQuiz]);
foreach ($arrayIdQuestions as $questionData) { // foreach para buscar as perguntas 
    $questionInfo = $question->select("descricao, categoria_IdCAtegorias", ["idPergunta" => $questionData["pergunta_idPergunta"]])[0];
    $questionId = $questionData["pergunta_idPergunta"];
    echo "<div class='viewQuestion'>";
    echo $questionInfo["descricao"] . "<br>"; // exibe a pergunta
    $IdLevel = $questionInfo["categoria_IdCAtegorias"];
    $level = $category->select("nomeCat", ["idCategorias" => $IdLevel]);
    echo "nivel {$level[0]["nomeCat"]}";
    echo "<br>";

    // Buscando as alternativas para essa pergunta
    $qha = $question_has_alternative->select("alternativa_idAlternativas", ["pergunta_idPergunta" => $questionData["pergunta_idPergunta"]]);

    $correctAnswerCount = 0;
    $correctAnswersDescriptions = [];

    foreach ($qha as $key => $altData) { // foreach para buscar as alternativas
        $alternativeInfo = $alternative->select("descricao", ["idAlternativas" => $altData["alternativa_idAlternativas"]])[0];
        echo "{$alphabet[$key]}) " . $alternativeInfo["descricao"] . "<br>"; // exibe a alternativa

        // Verifica se essa alternativa é uma resposta correta
        $answerData = $alternative_has_answer->select("RespostaCerta_idRespostas", ["Alternativa_IdAlternativas" => $altData["alternativa_idAlternativas"]]);
        if ($answerData) {
            $correctAnswerCount++;
            $correctAnswerDescription = $answer->select("correctAnswer", ["idRespostas" => $answerData[0]["RespostaCerta_idRespostas"]])[0]["correctAnswer"];
        }
    } 
    echo "Resposta certa: {$alphabet[$correctAnswerDescription - 1]} <br>";
    echo "<a href='editQuestion.php?questionId = $questionId'>editar</a>";
    echo "<br><a href='?apagarQuestao=true&idQuiz={$idQuiz}&questionId={$questionId}'> apagar questão </a>";
    echo "</div>";
}
echo "<br> <a href='../../registros/regQuestion.php?idQuiz=$idQuiz'> registrar nova pergunta</a>";
echo "<br><a href='principal.php'>voltar para o menu principal</a>";

?>

<style>
.quiz-info {
    border: solid #eee 1px;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 20px;
    max-width: fit-content;
}

.viewQuestion {
    border: solid black 0.5px;
    border-radius: 5px;
    margin-bottom: 10px;
    max-width: fit-content;
    padding: 3px;
}
</style>

