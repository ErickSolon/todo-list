<!doctype html>
<html lang="en">

<head>
  <title>TODO List</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.0.2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
  <form method="POST">
    <input type="text" name="tarefa" maxlength="200" placeholder="Adicione TO DO" required>
    <input type="submit" value="Salvar">
  </form>

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
</body>

</html>

<?php
    //iniciar banco de dados automaticamente
    shell_exec("/etc/init.d/mysql start");

    //Conexão com o banco de dados
    require_once("conn.php");

    //Formulário
    $tarefa = $_POST["tarefa"];

    // INSERIR
    $stmt = $conn->prepare("INSERT INTO Lista (tarefa) VALUES (:TAREFA)");
    $stmt->bindParam(":TAREFA", $tarefa);

    if(isset($tarefa)) {
      $stmt->execute();
    }

    // MOSTRAR LISTA
    $stmt = $conn->prepare("SELECT * FROM Lista");
    $stmt->execute();
    $Resultado = $stmt->fetchAll();


    foreach ($Resultado as $resultado) {
        for($maximo = 1; $maximo <= $resultado["id"]; $maximo++) {
        if($resultado["id"] == $maximo) {
          echo $resultado["tarefa"]." ";
          echo $botao = "<a href=\"index.php?id=".$resultado["id"]."\">X</a>"."<br>";

          if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conn->prepare("DELETE FROM Lista WHERE id=$id");
            header('location:/');
            $stmt-> execute();
          }
        }
      }
    }
?>