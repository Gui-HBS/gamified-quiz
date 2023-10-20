<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Enviando CSV </title>
</head>
<body>
    <h3> Enviando arquivo CSV </h3>
    <form method="post" action="processa.php" enctype="multipart/form-data">
        <label for="arquivo"> Arquivo: </label>
        <input type="file" name="arquivo">
        <br><br>

        <button type="submit" name="enviar"> Enviar </button>
    </form>
</body>
</html>