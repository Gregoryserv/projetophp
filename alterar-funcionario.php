<?php
session_start();
ob_start();
include_once 'util/helper.class.php';

if (isset($_GET['id'])) {
  include_once "dao/funcionariodao.class.php";
  include_once "modelo/funcionario.class.php";

  $funcionarioDAO = new FuncionarioDAO();
  $array = $funcionarioDAO->filtrar($_GET['id'], "codigo");


  $funcionario = $array[0];

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro de Funcionário</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Cadastro de Funcionário</h1>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="cadastro-pet.php">Cadastro de Pet</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="consulta-pets.php">Consulta de Pets</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cadastro-cliente.php">Cadastro de Cliente</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="consulta-clientes.php">Consulta de Clientes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="cadastro-funcionario.php">Cadastro de Funcionário</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="consulta-funcionarios.php">Consulta de Clientes</a>
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
            <input type="text" name="txtnome" placeholder="Nome do funcionário" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->nome; }?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtendereco" placeholder="Endereco" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->endereco; }?>">
          </div>
          <div class="form-group">
            <input type="text" name="txtfuncao" placeholder="Complemento" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->funcao; }?>">
          </div>
          <div class="form-group">
            <input type="number" name="txtcpf" placeholder="CPF" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->cpf; }?>">
          </div>
          <div class="form-group">
            <input type="number" name="txtsalario" placeholder="Salário" class="form-control" value="<?php if(isset($funcionario)){ echo $funcionario->salario; }?>">
          </div>
          <div class="form-group">
            <input type="submit" name="Alterar" value="Alterar" class="btn btn-primary">
            <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
          </div>
        </form>
        <?php
        if(isset($_POST['Alterar'])){
          include_once 'modelo/funcionario.class.php';
          include_once 'dao/funcionariodao.class.php';
          include 'util/padronizacao.class.php';

          $funcionario = new Funcionario();
          $funcionario->id = $_GET['id'];
          $funcionario->nome = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtnome']));
          $funcionario->endereco = Padronizacao::antiXSS(Padronizacao::padronizarMaiMin($_POST['txtendereco']));
          $funcionario->funcao = Padronizacao::antiXSS(Padronizacao::padronizarMai($_POST['txtfuncao']));
          $funcionario->cpf = Padronizacao::antiXSS($_POST['txtcpf']);
          $funcionario->salario = Padronizacao::antiXSS($_POST['txtsalario']);

          $funcionarioDAO = new FuncionarioDAO();
          $funcionarioDAO->cadastrarFuncionario($funcionario);

          $_SESSION['msg'] = "Funcionário cadastrado com sucesso!";
          header("location:consulta-funcionarios.php");
          ob_end_flush();
          }
        ?>
      </div>
  </body>
</html>
