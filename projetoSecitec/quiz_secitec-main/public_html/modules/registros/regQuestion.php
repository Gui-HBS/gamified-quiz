<?php
session_start();
require "../quiz/Quiz.php";
require "../quiz/Quiz_has_question.php";

require "../alternatives/Alternative.php";
require "../alternatives/Alternative_has_answer.php";

require "../question/Question.php";
require "../question/Question_has_alternative.php";

require "../answer/Answer.php";
require "../category/Category.php";
require "../../db/MySql.php";

$quiz = new Quiz();
$alternative = new Alternative();
$category = new Category();
$answer = new Answer();
$question = new Question();
$quiz_has_question = new Quiz_has_question();
$question_has_alternative = new Question_has_alternative();
$alternative_has_answer = new Alternative_has_answer();
if(isset($_GET["questionId"]) != null){ // comçeo do código de editar pergunta
    $idQuestion = $_GET["questionId"];
    
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro de Perguntas</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/loginUser/estilo.css" media="screen" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body{
            /* background-image: url("../../assets/images/loginUser/fundo3.png"); */
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
        }
    </style>
</head>
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
    <!-- Button para acionar o  modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Criar pergunta
    </button>
    
     <!-- Modal -->
     <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Criar pergunta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" id="questionForm">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md text-center">
                                    <div class="mb-3">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descricaoPergunta" placeholder="Descrição da pergunta" required></textarea>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col">
                                    <div><h6>Quantidade de alternativas<h6></div>
                                    <select class="form-select" aria-label="Default select example" name="qtdAlternativa" id="qtdAlternativa" required>
                                        <option value="2" selected>2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="col ms-auto">
                                    <div><h6>Categoria<h6></div>
                                    <select class="form-select" aria-label="Default select example" name="categoria" id="categoria" required>
                                        <option value="1" selected>fácil</option>
                                        <option value="2">médio</option>
                                        <option value="3">difícil</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md text-center">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10 text-center alternativas-container"></div>
                                            <div class="col-md-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md text-center">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6 text-center">
                                            <div><h6>Resposta correta<h6></div>
                                                <select class="form-select" aria-label="Default select example" name="respCerta" id="respCerta" required>
                                                    <!-- Options will be added dynamically -->
                                                </select>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Submit button -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="salvar">Salvar</button>
        </div>
    </form>

                <!-- JavaScript -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const qtdAlternativaSelect = document.querySelector('#qtdAlternativa');
                        const respCertaSelect = document.querySelector('#respCerta');
                        const alternativasContainer = document.querySelector('.alternativas-container');

                        function populateOptions(qtdAlt) {
                            alternativasContainer.innerHTML = '';

                            for (let i = 1; i <= qtdAlt; i++) {
                                const textarea = document.createElement('textarea');
                                textarea.className = 'form-control';
                                textarea.rows = '2';
                                textarea.name = 'alternative[]';
                                textarea.placeholder = 'Alternativa ' + i;
                                textarea.required = true;
                                alternativasContainer.appendChild(textarea);
                            }

                            respCertaSelect.innerHTML = '';
                            for (let i = 1; i <= qtdAlt; i++) {
                                const option = document.createElement('option');
                                option.value = i.toString();
                                option.textContent = String.fromCharCode(96 + i);
                                respCertaSelect.appendChild(option);
                            }
                            respCertaSelect.required = true;
                        }

                        qtdAlternativaSelect.addEventListener('change', function() {
                            const qtdAlt = parseInt(qtdAlternativaSelect.value);
                            populateOptions(qtdAlt);
                        });

                        // Default behavior with 2 alternatives
                        populateOptions(2);
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Import do js do bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>

<?php
if(isset($_POST["salvar"])){
    $descricao = $_POST["descricaoPergunta"];
    $category = $_POST["categoria"];
    $quizId = $_COOKIE["quizId"];
    if(isset($_GET["idQuiz"])){
        $quizId = $_GET["idQuiz"];
    }
    $arrayAlternative = $_POST["alternative"];
    $qtdAlternativa = $_POST["qtdAlternativa"];
    $correctAnswer = $_POST["respCerta"];

    $question->create(["descricao" => $descricao, "Categoria_idCategorias" => $category]);
    $answer->create(["correctAnswer" => $correctAnswer]);
    for($i = 0; $i < $qtdAlternativa; $i++) {
        $alternative->create(["descricao" => $arrayAlternative[$i]]);

        $question_has_alternative->create(["Pergunta_idPergunta" => $question->getPdo()->getConn()->lastInsertId(),
        "Alternativa_idAlternativas" => $alternative->getPdo()->getConn()->lastInsertId()]);

        $alternative_has_answer->create(["Alternativa_idAlternativas" => $alternative->getPdo()->getConn()->lastInsertId(),
        "RespostaCerta_idRespostas" => $answer->getPdo()->getConn()->lastInsertId()]);
    }
    $quiz_has_question->create(["quiz_idquiz" => $quizId,
    "Pergunta_idPergunta" => $question->getPdo()->getConn()->lastInsertId()]);
}
?>
<br><a href='../user/menuUser/principal.php'> voltar ao menu principal</a>