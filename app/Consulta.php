<?php
namespace App;
use App\DataBase;
use PDO;

class Consulta
{
        public $id;
        public $paciente;
        public $dentista;
        public $data_hora;
        public $valor_total;
        public $valor_pago;
        public $forma_pagamento;
        public $descricao;
        public $medicacao;
        public $procedimentos_realizados;
        public $procedimentos_arealizar;
        

    public function cadastrar(){
        //INSERIR O ALUNO NO BANCO
        $db = new DataBase('consulta');
        
        $this->id = $db->insert([
                                            'paciente_id'  => $this->paciente->id,
                                            'dentista_id'  => $this->dentista->id,
                                            'valor_total'  => $this->valor_total,
                                            'valor_pago'  => $this->valor_pago,
                                            'forma_pagamento' => $this->forma_pagamento,
                                            'descricao' => $this->descricao,
                                            'medicacao' => $this->medicacao,
                                            'procedimentos_realizados' => $this->procedimentos_realizados,
                                            'procedimentos_arealizar' => $this->procedimentos_arealizar
                                        ]);
        (new DataBase('agenda'))->update('id = '. $this->agenda_id,['status' => 'REALIZADA']);

        //RETORNAR SUCESSO 
        return true;
    }
    public function atualizar(){
                
        return (new DataBase('consulta'))->update('id = '. $this->id,[
                                            'paciente_id'  => $this->paciente_id,
                                            'dentista_id'  => $this->dentista_id,
                                            'valor_total'  => $this->valor_total,
                                            'valor_pago'  => $this->valor_pago,
                                            'forma_pagamento' => $this->forma_pagamento,
                                            'descricao' => $this->descricao,
                                            'medicacao' => $this->medicacao,
                                            'procedimentos_realizados' => $this->procedimentos_realizados,
                                            'procedimentos_arealizar' => $this->procedimentos_arealizar
                                        ]);
    }
    public function excluir()
    {
        return (new DataBase('consulta'))->delete('id = ' . $this->id);
    }


    public static function listar($where = null, $order = null, $limit = null){
ch
        $consultas = (new DataBase('consulta'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
        foreach ($consultas as $consulta) {
            $consulta->paciente = Paciente::buscarPorId($consulta->paciente_id);
            $consulta->dentista = Funcionario::buscarPorId($consulta->dentista_id);            
        }
        return $consultas;
    }
    public static function buscarPorId($id)
    {
        $consulta = (new DataBase('consulta'))->select('id = ' . $id)->fetchObject(self::class);
        $consulta->paciente = Paciente::buscarPorId($consulta->paciente_id);
        $consulta->dentista = Funcionario::buscarPorId($consulta->dentista_id);
        return $consulta;
    }
    public static function getQuantidade($where = null)
    {
        return (new DataBase('consulta'))->select($where, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;
    }
}
