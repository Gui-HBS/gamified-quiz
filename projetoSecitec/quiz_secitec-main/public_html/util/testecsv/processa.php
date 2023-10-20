<?php 
require 'funcao.php';
session_start();
if (isset($_POST["enviar"])) {

    $arquivo = $_FILES["arquivo"];
    // var_dump($arquivo);

    if ($arquivo['type'] == "text/csv") {              //fopen é uma função para ler o arquivo, "r" usado também como parâmetro para leitura
        $dados_arquivo = fopen($arquivo['tmp_name'], "r");      //o parâmetro desta função é o arquivo que está sendo lido e o nome do seu  local temporário
        echo "<br/>dados arquivo: ";
        print_r($arquivo);
        echo "<br/>";
        echo "<br/>";
        
        $arquivoInteiro = array();
        //usado um laço de repetição para ler cada linha do arquivo
        while ($linha = fgetcsv($dados_arquivo, 1000, ";")) {   //função fgetcsv para ler o arquivo csv
            $linha = implode(";", $linha);         //transformando o vetor em string e separando as posições por ' ; '
            echo "<br/> arquivo em formato csv: ";
            print_r($linha);
            echo "<br/>";
            $f = sanitizar_utf8($linha);       //usando a função de conversão que tá no arquivo funcao.php
            $linha_vetor = explode(";", $f);      //transformando novamente em vetor
            $arquivoInteiro[] = $linha_vetor;
            print_r($linha_vetor);             //printando
            echo "<br/>";

        }
        $_SESSION["arquivoInteiro"] = $arquivoInteiro;
        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        print_r($arquivoInteiro);
        echo "<br/>";
        echo "<br/>";
        echo "<br/>";
        // echo "<table>
        // <tr>
        // <th>" . 
        echo $arquivoInteiro[0][0];
        
    }
    else {
        echo "</br></br> Necessário enviar arquivo csv!";
    }
}
?>