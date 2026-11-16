<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Entity\Agenda;
use App\Entity\Consulta;
$action = $_GET['action'] ?? '';

$consulta = new Consulta();
if ($action === 'cadastrar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $agenda = Agenda::buscarPorId($_GET['agenda_id']);    
    $consulta->paciente = $agenda->paciente;
    $consulta->dentista = $agenda->dentista;
    $consulta->descricao = $_POST['descricao'];
    $consulta->medicacao = $_POST['medicacao'];
    $consulta->procedimentos_realizados = $_POST['procedimentos_realizados'];
    $consulta->procedimentos_arealizar = $_POST['procedimentos_arealizar'];
    $consulta->valor_total = $_POST['valor_total'];
    $consulta->valor_pago = $_POST['valor_pago'];
    $consulta->forma_pagamento = $_POST['forma_pagamento'];
    $consulta->agenda_id = $agenda->id;
    
    $consulta->cadastrar();
    header('Location: /odontosys/home.php?msg=sucesso');
    exit;
}
if ($action === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $consulta = Consulta::buscarPorId($_GET['id']);
    $consulta->descricao = $_POST['descricao'];
    $consulta->medicacao = $_POST['medicacao'];
    $consulta->procedimentos_realizados = $_POST['procedimentos_realizados'];
    $consulta->procedimentos_arealizar = $_POST['procedimentos_arealizar'];
    $consulta->valor_total = $_POST['valor_total'];
    $consulta->valor_pago = $_POST['valor_pago'];
    $consulta->forma_pagamento = $_POST['forma_pagamento'];
    /*
    echo "<pre>";  
                print_r($consulta); 
                echo "</pre>";
                */ 
    $consulta->atualizar();
    header('Location: ../views/consultas/index.php?msg=sucesso');
    exit;
}

if ($action === 'deletar') {
    $consulta->id = $_GET['id'];
    $consulta->excluir();
    header('Location: ../views/consultas/index.php?msg=deletado');
    exit;
}
