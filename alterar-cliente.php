<?php
session_start();
ob_start();
include_once 'util/helper.class.php';

if(isset($_GET['id'])){
  include_once "dao/clientedao.class.php";
  include_once "modelo/cliente.class.php";

  $cliDAO = new ClienteDAO();
  $array = $cliDAO->filtrar($_GET['id'], "codigo");



  $car = $array[0];


}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Edição de Cliente</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Edição de Cliente</h1>

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
              <li class="nav-item">
                <a class="nav-link" href="cadastro-cliente.php">Cad. Clientes <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="consulta-clientes.php">Cons. Clientes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cadastro-funcionario.php">Cad. Funcionarios <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="consulta-funcionarios.php">Cons. Funcionarios</a>
              </li>
            </ul>
          </div>
        </nav>
        <?php
        echo isset($_SESSION['msg']) ? Helper::alert($_SESSION['msg']) : "";
        unset($_SESSION['msg']);
        ?>
        <form name="cadcliente" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control"
                   value="<?php if(isset($cli)){ echo $cli->nome; }?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtcnh" placeholder="CNH" class="form-control"
                   value="<?php if(isset($cli)){ echo $cli->cnh; }?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtendereco" placeholder="Endereco" class="form-control"
                   value="<?php if(isset($cli)){ echo $cli->endereco; }?>">
          </div>
          <div class="form-group">
            <input type="number" name="txtdiaria" placeholder="Diaria" class="form-control"
            value="<?php if(isset($cli)){ echo $cli->diaria; }?>">
          </div>
          <div class="form-group">
            <select name="selpagamento" class="form-control">
              <option value="Dinheiro" <?php
                                     if(isset($cli)){
                                        if($cli->pagemento == "Dinheiro"){
                                          echo "selected='selected'";
                                        }
                                     }
                                     ?>
                                     >Dinheiro</option>
              <option value="Cartão de Crédito" <?php if(isset($cli)){if($cli->pagamento == "Cartao de credito"){echo "selected='selected'";}} ?>>Cartão de crédito</option>
              <option value="Cartão de Débito" <?php if(isset($cli)){if($cli->pagamento == "Cartao de debito"){echo "selected='selected'";}} ?>>Cartão de Débito</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>
        <?php

          if(isset($_POST['alterar'])){
            include_once 'modelo/cliente.class.php';
            include_once 'dao/clientedao.class.php';
            include 'util/padronizacao.class.php';

            $cli = new Cliente();
            $cli->idCliente = $_GET['id'];
            $cli->nome = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtnome']));
            $cli->cnh = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtcnh']));
            $cli->endereco = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtendereco']));
            $cli->diaria = $_POST['txtdiaria'];
            $cli->pagamento = Padronizacao::antiXSS($_POST['selpagamento']);
            $cliDAO = new ClienteDAO();
            $cliDAO->alterarCliente($cli);

            $_SESSION['msg'] = "Cliente alterado com sucesso!";
            header("location:consulta-clientes.php");

            //echo "<h2>Cliente cadastrado com sucesso!</h2>";
            //Helper::alert("Cliente cadastrado com sucesso!");
            //echo $cli;
            ob_end_flush();
          }
        ?>
      </div>
  </body>
</html>
