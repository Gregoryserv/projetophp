<?php
session_start();
ob_start();
include_once 'util/helper.class.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro dos Carros</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Cadastro de Carros</h1>
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
                <a class="nav-link" href="cadastro-carro.php">Cad. Carros</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="consulta-carros.php">Cons. Carros <span class="sr-only">(current)</span></a>
              </li>
            </ul>
          </div>
        </nav>

        <form name="cadcarro" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtmarca" placeholder="Marca" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtmodelo" placeholder="Modelo" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtano" placeholder="Ano" class="form-control">
          </div>
          <div class="form-group">
            <input type="number" name="txtvalor" placeholder="valor" class="form-control">
          </div>
          <div class="form-group">
            <select name="selcor" class="form-control">
              <option value="Preto">Preto</option>
              <option value="Vermelho">Vermelho</option>
              <option value="Prata">Prata</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>
        <?php
          //falta código
          if(isset($_POST['cadastrar'])){
            include 'modelo/carro.class.php';
            include 'dao/carrodao.class.php';
            include 'util/padronizacao.class.php';

            $c = new Carro();
            $c->marca = Padronizacao::padronizarMaiMin($_POST['txtmarca']);
            $c->modelo = Padronizacao::padronizarMaiMin($_POST['txtmodelo']);
            $c->ano = Padronizacao::padronizarMaiMin($_POST['txtano']);
            $c->valor = $_POST['txtvalor'];
            $c->cor = $_POST['selcor'];

            $carDAO = new CarroDAO();
            $carDAO->cadastrarCarro($c);

            Helper::alert("Carro cadastrado com sucesso!");

          }
        ?>
      </div>
  </body>
</html>
