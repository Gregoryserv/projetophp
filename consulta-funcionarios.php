<?php
session_start();
ob_start();

include_once 'dao/funcionariodao.class.php';
include_once 'modelo/funcionario.class.php';
include_once 'util/helper.class.php';

$funDAO = new FuncionarioDAO();
$array = $funDAO->buscarFuncionarios();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Consulta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="vendor/components/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
  <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
    <h1 class="jumbotron bg-info">Consulta de Funcionarios</h1>

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

    <h2>Consulta do funcionario!</h2>
    <?php
    if(isset($_SESSION['msg'])){
      Helper::alert($_SESSION['msg']);
      unset($_SESSION['msg']);
    }

    if(count($array) == 0){
        echo "<h2>Não há nenhum funcionario no banco!</h2>";
        return;
    }

    ?>

    <form name="filtrar" method="post" action="">

      <div class="row">
        <div class="form-group col-md-6">
          <input type="text" name="txtfiltro"
                 placeholder="Digite a sua pesquisa" class="form-control">
        </div>

        <div class="form-group col-md-6">
          <select name="selfiltro" class="form-control">
            <option value="todos">Todos</option>
            <option value="nome">Nome</option>
            <option value="cpf">CPF</option>
            <option value="endereco">Endereço</option>
            <option value="salario">Salario</option>
            <option value="funcao">Função</option>
          </select>
        </div>
      </div> <!-- fecha row -->

      <div class="form-group">
        <input type="submit" name="filtrar" value="Filtrar" class="btn btn-primary btn-block">
      </div>
    </form>
    <?php
    if(isset($_POST['filtrar'])){
      $pesquisa = $_POST['txtfiltro'];
      $filtro = $_POST['selfiltro'];

      if(!empty($pesquisa)){
        $funDAO = new FuncionarioDAO();
        $array = $funDAO->filtrar($pesquisa,$filtro);

        //var_dump($array);

        if(count($array) == 0){
          echo "<h3>Sua pesquisa não retornou nenhum Funcionario!</h3>";
          return;
        }

      }else{
        echo "Digite uma pesquisa!";
      }//fecha else

    }
    ?>

    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th>Código</th>
            <th>nome</th>
            <th>cpf</th>
            <th>endereco</th>
            <th>salario</th>
            <th>funcao</th>
            <th>Excluir</th>
            <th>Alterar</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Código</th>
            <th>nome</th>
            <th>cpf</th>
            <th>endereco</th>
            <th>salario</th>
            <th>funcao</th>
            <th>Excluir</th>
            <th>Alterar</th>
          </tr>
        </tfoot>
        <tbody>
          <?php
          foreach($array as $f){
            echo "<tr>";
              echo "<td>$f->idFuncionario</td>";
              echo "<td>$f->nome</td>";
              echo "<td>$f->cpf</td>";
              echo "<td>$f->endereco</td>";
              echo "<td>$f->salario</td>";
              echo "<td>$f->funcao</td>";
              echo "<td><a href='consulta-funcionarios.php?id=$f->idFuncionario' class='btn btn-danger'>Excluir</a></td>";
              echo "<td><a href='alterar-funcionario.php?id=$f->idFuncionario' class='btn btn-warning'>Alterar</a></td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div><!-- table responsive -->
  </div>
  <?php
  if(isset($_GET['id'])){
    $funDAO->deletarFuncionario($_GET['id']);
    $_SESSION['msg'] = "Funcionario excluído com sucesso!";
    header("location:consulta-funcionarios.php");
    ob_end_flush();
  }
  ?>
</body>
</html>
