<!DOCTYPE html>
<html>
<head>
<title>Tutorial de Alert em JavaScript - Linha de Código</title>
</head>
<body>

<p>Clique no botão para exibir a caixa de confirmação.</p>

<button onclick="funcao1()">Clique aqui</button>

<p id="demo"></p>

<script>
function funcao1(){
var x;
var r=confirm("ctz man?");
if (r==true)
  {
  x="você pressionou OK!";
  }
else
  {
  x="Você pressionou Cancelar!";
  }
document.getElementById("demo").innerHTML=x;
}
</script>

</body>
</html>