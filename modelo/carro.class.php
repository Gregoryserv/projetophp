<?php
class Carro{

  private $idCarro;
  private $marca;
  private $modelo;
  private $ano;
  private $valor;
  private $cor;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a, $v){$this->$a = $v;}

  public function __toString(){
    return nl2br("Marca: $this->marca
                  Modelo: $this->modelo
                  Ano: $this->ano
                  Valor: $this->valor
                  Cor: $this->cor");
  }
}
