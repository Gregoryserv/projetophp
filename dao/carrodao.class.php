<?php
require 'conexaobanco.class.php';
 class CarroDAO { //DATA ACCESS OBJECT

   private $conexao = null;

   public function __construct(){
     $this->conexao = ConexaoBanco::getInstance();
   }

   public function __destruct(){}

   public function cadastrarCarro($car){
     try{
       //statement                    //SQL --> case insensitive
       $stat=$this->conexao->prepare("insert into carro(idcarro,marca,modelo,ano,valor,cor) values(null,?,?,?,?,?)");
       $stat->bindValue(1, $car->marca);
       $stat->bindValue(2, $car->modelo);
       $stat->bindValue(3, $car->ano);
       $stat->bindValue(4, $car->valor);
       $stat->bindValue(5, $car->cor);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao cadastrar! ".$e;
     }//fecha catch
   }//fecha cadastrar

   public function buscarCarros(){
     try{
       $stat = $this->conexao->query("select * from carro");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'carro');
       return $array;
     }catch(PDOException $e){
       echo "Erro ao buscar carros! ".$e;
     }//fecha catch
   }

   public function filtrar($pesquisa, $filtro){
     try{
       $query = "";
       switch($filtro){
         case "todos": $query = "";
         break;

         case "codigo": $query = "where idcarro = ".$pesquisa;
         break;

         case "Marca": $query = "where marca like '%".$pesquisa."%'";
         break;

         case "Modelo": $query = "where modelo like '%".$pesquisa."%'";
         break;

         case "Ano": $query = "where ano = ".$pesquisa;
         break;

         case "Valor": $query = "where valor like '%".$pesquisa."%'";
         break;

         case "Cor": $query = "where cor like '%".$pesquisa."%'";
         break;
       }



       $stat = $this->conexao->query("select * from carro {$query}");
       $array = $stat->fetchAll(PDO::FETCH_CLASS, 'Carro');
       return $array;

     }catch(PDOException $e){
       echo "Erro ao filtrar carros. ".$e;
     }//fecha catch
   }


   public function alterarCarro($car){
     try{
       $stat = $this->conexao->prepare("update carro set marca=?, modelo=?, ano=?, valor=?, cor=? where idcarro=?");

       $stat->bindValue(1, $car->marca);
       $stat->bindValue(2, $car->modelo);
       $stat->bindValue(3, $car->ano);
       $stat->bindValue(4, $car->valor);
       $stat->bindValue(5, $car->cor);
       $stat->bindValue(6, $car->idCarro);

       $stat->execute();

     }catch(PDOException $e){
       echo "Erro ao alterar Carro! ".$e;
     }//fecha catch
   }//fecha alterarCarros

   public function deletarCarro($id){
     try{
       $stat = $this->conexao->prepare("delete from carro where idcarro = ?");
       $stat->bindValue(1, $id);
       $stat->execute();
     }catch(PDOException $e){
       echo "Erro ao excluir carro! ".$e;
     }//fecha catch
   }



 }//fecha classe
