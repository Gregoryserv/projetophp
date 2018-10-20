<?php
session_start();
ob_start();
include_once 'util/helper.class.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>Cadastro de Funcionarios</title>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
  <body>
      <div class="container">
        <h1 class="jumbotron bg-info">Cadastro de Funcionarios</h1>
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

        <form name="cadcarro" method="post" action="">
          <div class="form-group">
            <input type="text" name="txtnome" placeholder="Nome" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtcpf" placeholder="CPF" class="form-control">
          </div>
          <div class="form-group">
            <input type="text" name="txtendereco" placeholder="Endereço" class="form-control">
          </div>
          <div class="form-group">
            <input type="number" name="txtsalario" placeholder="Salario" class="form-control">
          </div>
          <div class="form-group">
            <select name="selfuncao" class="form-control">
              <option value="Vendedor">Vendedor</option>
              <option value="Gerente">Gerente</option>
              <option value="Faxineiro">Faxineiro</option>
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
            include 'modelo/funcionario.class.php';
            include 'dao/funcionariodao.class.php';
            include 'util/padronizacao.class.php';

            $fun = new Funcionario();
            $fun->nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
            $fun->cpf = Padronizacao::padronizarMaiMin($_POST['txtcpf']);
            $fun->endereco = Padronizacao::padronizarMaiMin($_POST['txtendereco']);
            $fun->salario = $_POST['txtsalario'];
            $fun->funcao = $_POST['selfuncao'];

            $funDAO = new FuncionarioDAO();
            $funDAO->cadastrarFuncionario($fun);

            Helper::alert("Funcionario cadastrado com sucesso!");

          }
        ?>
      </div>
  </body>
</html>
