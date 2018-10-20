<?php
require 'conexaobanco.class.php';
 class ClienteDAO { //DATA ACCESS OBJECT

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarCliente($cli){
     try{
       //statement                    //SQL --> case insensitive
       $stat=$this->conexao->prepare("insert into cliente(idcliente,nome,cnh,endereco,diaria,pagamento) values(null,?,?,?,?,?)");
       $stat->bindValue(1, $cli->nome);
       $stat->bindValue(2, $cli->cnh);
       $stat->bindValue(3, $cli->endereco);
       $stat->bindValue(4, $cli->diaria);
       $stat->bindValue(5, $cli->pagamento);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao cadastrar! ".$e;
     }//fecha catch
   }//fecha cadastrar

   public function buscarClientes(){
     try{
       $stat = $this->conexao->query("select * from cliente");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'cliente');
       return $array;
     }catch(PDOException $e){
       echo "Erro ao buscar clientes! ".$e;
     }//fecha catch
   }

   public function filtrar($pesquisa, $filtro){
     try{
       $query = "";
       switch($filtro){
         case "todos": $query = "";
         break;

         case "codigo": $query = "where idcliente = ".$pesquisa;
         break;

         case "nome": $query = "where nome like '%".$pesquisa."%'";
         break;

         case "cnh": $query = "where cnh  = ".$pesquisa;
         break;

         case "endereco": $query = "where endereco = ".$pesquisa;
         break;

         case "diaria": $query = "where diaria  = ".$pesquisa;
         break;

         case "pagamento": $query = "where pagamento like '%".$pesquisa."%'";
         break;
       }



       $stat = $this->conexao->query("select * from cliente {$query}");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Cliente');
       return $array;

     }catch(PDOException $e){
       echo "Erro ao filtrar clientes. ".$e;
     }//fecha catch
   }


   public function alterarCliente($cli){
     try{
       $stat = $this->conexao->prepare("update cliente set nome=?, cnh=?, endereco=?, diaria=?, pagamento=? where idcliente=?");

       $stat->bindValue(1, $cli->nome);
       $stat->bindValue(2, $cli->cnh);
       $stat->bindValue(3, $cli->endereco);
       $stat->bindValue(4, $cli->diaria);
       $stat->bindValue(5, $cli->pagamento);
       $stat->bindValue(6, $cli->idCliente);

       $stat->execute();

     }catch(PDOException $e){
       echo "Erro ao alterar Cliente! ".$e;
     }//fecha catch
   }//

   public function deletarCliente($id){
     try{
       $stat = $this->conexao->prepare("delete from cliente where idcliente = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao excluir Cliente! ".$e;
     }//fecha catch
   }



 }//fecha classe
