<?php
class Cliente{

  private $idCliente;
  private $nome;
  private $idade;
  private $endereco;
  private $diaria;
  private $pagamento;

  public function __construct(){}
  public function __destruct(){}

  public function __get($a){return $this->$a;}
  public function __set($a, $v){$this->$a = $v;}

  public function __toString(){
    return nl2br("Nome: $this->nome
                  Idade: $this->idade
                  Endereço: $this->endereco
                  Diaria: $this->diaria
                  Método de pagament: $this->pagamento");
  }
}
