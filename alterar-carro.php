<?php
session_start();
ob_start();
include_once 'util/helper.class.php';

if(isset($_GET['id'])){
  include_once "dao/carrodao.class.php";
  include_once "modelo/carro.class.php";

  $carDAO = new CarroDAO();
  $array = $carDAO->filtrar($_GET['id'], "codigo");



  $car = $array[0];


}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Edição de Carro</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Edição de carro</h1>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Sistema</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cadastro-carro.php">Cad. Carros <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="consulta-carros.php">Cons. Carros</a>
              </li>
            </ul>
          </div>
        </nav>
        <?php
        echo isset($_SESSION['msg']) ? Helper::alert($_SESSION['msg']) : "";
        unset($_SESSION['msg']);
        ?>
        <form name="cadcarro" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtmarca" placeholder="Marca" class="form-control"
                   value="<?php if(isset($car)){ echo $car->marca; }?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtmodelo" placeholder="Modelo" class="form-control"
                   value="<?php if(isset($car)){ echo $car->modelo; }?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtano" placeholder="Ano" class="form-control"
                   value="<?php if(isset($car)){ echo $car->ano; }?>">
          </div>
          <div class="form-group">
            <input type="number" name="txtvalor" placeholder="Valor" class="form-control"
            value="<?php if(isset($car)){ echo $car->valor; }?>">
          </div>
          <div class="form-group">
            <select name="selcor" class="form-control">
              <option value="Preto" <?php
                                     if(isset($car)){
                                        if($car->cor == "Preto"){
                                          echo "selected='selected'";
                                        }
                                     }
                                     ?>
                                     >Preto</option>
              <option value="Vermelho" <?php if(isset($car)){if($car->cor == "Vermelho"){echo "selected='selected'";}} ?>>Vermelho</option>
              <option value="Prata" <?php if(isset($car)){if($car->cor == "Prata"){echo "selected='selected'";}} ?>>Prata</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>
        <?php

          if(isset($_POST['alterar'])){
            include_once 'modelo/carro.class.php';
            include_once 'dao/carrodao.class.php';
            include 'util/padronizacao.class.php';

            $car = new Carro();
            $car->idCarro = $_GET['id'];
            $car->marca = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtmarca']));
            $car->modelo = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtmodelo']));
            $car->ano = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtano']));
            $car->valor = $_POST['txtvalor']; //n precisa é int
            $car->cor = Padronizacao::antiXSS($_POST['selcor']);
            $carDAO = new CarroDAO();
            $carDAO->alterarCarro($car);

            $_SESSION['msg'] = "Carro alterado com sucesso!";
            header("location:consulta-carros.php");

            //echo "<h2>Carro cadastrado com sucesso!</h2>";
            //Helper::alert("Carro cadastrado com sucesso!");
            //echo $car;
            ob_end_flush();
          }
        ?>
      </div>
  </body>
</html>
