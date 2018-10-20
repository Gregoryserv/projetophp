<?php
require 'conexaobanco.class.php';
 class FuncionarioDAO { //DATA ACCESS OBJECT

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarFuncionario($fun){
     try{
       //statement                    //SQL --> case insensitive
       $stat=$this->conexao->prepare("insert into funcionario(idfuncionario,nome,cpf,endereco,salario,funcao) values(null,?,?,?,?,?)");
       $stat->bindValue(1, $fun->nome);
       $stat->bindValue(2, $fun->cpf);
       $stat->bindValue(3, $fun->endereco);
       $stat->bindValue(4, $fun->salario);
       $stat->bindValue(5, $fun->funcao);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao cadastrar! ".$e;
     }//fecha catch
   }//fecha cadastrar

   public function buscarFuncionarios(){
     try{
       $stat = $this->conexao->query("select * from funcionario");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'funcionario');
       return $array;
     }catch(PDOException $e){
       echo "Erro ao buscar funcionarios! ".$e;
     }//fecha catch
   }

   public function filtrar($pesquisa, $filtro){
     try{
       $query = "";
       switch($filtro){
         case "todos": $query = "";
         break;

         case "codigo": $query = "where idfuncionario = ".$pesquisa;
         break;

         case "nome": $query = "where nome like '%".$pesquisa."%'";
         break;

         case "cpf": $query = "where cpf  = ".$pesquisa;
         break;

         case "endereco": $query = "where endereco = ".$pesquisa;
         break;

         case "salario": $query = "where salario  = ".$pesquisa;
         break;

         case "funcao": $query = "where funcao like '%".$pesquisa."%'";
         break;
       }



       $stat = $this->conexao->query("select * from funcionario {$query}");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Funcionario');
       return $array;

     }catch(PDOException $e){
       echo "Erro ao filtrar funcionarios. ".$e;
     }//fecha catch
   }


   public function alterarFuncionario($fun){
     try{
       $stat = $this->conexao->prepare("update funcionario set nome=?, cpf=?, endereco=?, salario=?, funcao=? where idfuncionario=?");

       $stat->bindValue(1, $fun->nome);
       $stat->bindValue(2, $fun->cpf);
       $stat->bindValue(3, $fun->endereco);
       $stat->bindValue(4, $fun->salario);
       $stat->bindValue(5, $fun->funcao);
       $stat->bindValue(6, $fun->idFuncionario);

       $stat->execute();

     }catch(PDOException $e){
       echo "Erro ao alterar funcionario! ".$e;
     }//fecha catch
   }//

   public function deletarFuncionario($id){
     try{
       $stat = $this->conexao->prepare("delete from funcionario where idfuncionario = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao excluir funcionario! ".$e;
     }//fecha catch
   }



 }//fecha classe
