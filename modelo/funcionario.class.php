<?php
class Funcionario{

    private $idFuncionario;
    private $nome;
    private $cpf;
    private $endereco;
    private $salario;
    private $funcao;

    public function __construct(){}
    public function __destruct(){}

    public function __get($a){return $this->$a;}
    public function __set($a, $v){$this->$a = $v;}

    public function __toString(){
      return nl2br("Nome: $this->nome
                    CPF: $this->cpf
                    Endereço: $this->endereco
                    Salário: $this->salario
                    Função: $this->funcao");
    }



}
