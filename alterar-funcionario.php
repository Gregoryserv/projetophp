<?php
session_start();
ob_start();
include_once 'util/helper.class.php';

if(isset($_GET['id'])){
  include_once "dao/funcionariodao.class.php";
  include_once "modelo/funcionario.class.php";

  $funDAO = new FuncionarioDAO();
  $array = $funDAO->filtrar($_GET['id'], "codigo");



  $fun = $array[0];


}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Edição dos Funcionarios</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Edição dos Funcionarios</h1>

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
        <form name="cadfuncionario" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control"
                   value="<?php if(isset($fun)){ echo $fun->nome; }?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtcpf" placeholder="CPF" class="form-control"
                   value="<?php if(isset($fun)){ echo $fun->cpf; }?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtendereco" placeholder="Endereco" class="form-control"
                   value="<?php if(isset$fun)){ echo $fun->endereco; }?>">
          </div>
          <div class="form-group">
            <input type="number" name="txtsalario" placeholder="Salario" class="form-control"
            value="<?php if(isset($fun)){ echo $fun->salario; }?>">
          </div>
          <div class="form-group">
            <select name="selfuncao" class="form-control">
              <option value="Vendedor" <?php
                                     if(isset($fun)){
                                        if($fun->funcao == "Vendedor"){
                                          echo "selected='selected'";
                                        }
                                     }
                                     ?>
                                     >Vendedor</option>
              <option value="Gerente" <?php if(isset($fun)){if($fun->funcao == "Gerente"){echo "selected='selected'";}} ?>>Gerente</option>
              <option value="Faxineiro" <?php if(isset($fun)){if($fun->funcao == "Faxineiro"){echo "selected='selected'";}} ?>>Faxineiro</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>
        <?php

          if(isset($_POST['alterar'])){
            include_once 'modelo/funcionario.class.php';
            include_once 'dao/funcionariodao.class.php';
            include 'util/padronizacao.class.php';

            $fun = new Funcionario();
            $fun->idCliente = $_GET['id'];
            $fun->nome = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtnome']));
            $fun->cpF = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtcpf']));
            $fun->endereco = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtendereco']));
            $fun->salario = $_POST['txtsalario'];
            $fun->funcao = Padronizacao::antiXSS($_POST['selfuncao']);
            $funDAO = new FuncionarioDAO();
            $funDAO->alterarFuncionario($fun);

            $_SESSION['msg'] = "Funcionario alterado com sucesso!";
            header("location:consulta-funcionarios.php");

            //echo "<h2>Funcionarios cadastrado com sucesso!</h2>";
            //Helper::alert("Funcionario cadastrado com sucesso!");
            //echo $fun;
            ob_end_flush();
          }
        ?>
      </div>
  </body>
</html>
