<?php





use App\Consulta;
include('../vendor/autoload.php');

$action = $_GET['action'];
$consulta = new Consulta();



switch($action){
    case 'cadastrar':
        $consulta->dentista_id = $_POST['dentista_id'];
        $consulta->data_hora = $_POST['data_hora'];
        $consulta->valor_total = $_POST['valor_total'];
        $consulta->valor_pago = $_POST['valor_pago'];
        $consulta->forma_pagamento = $_POST['forma_pagamento'];
        $consulta->procedimentos_realizados = $_POST['procedimentos_realizados'];
        $consulta->procedimentos_arealizar = $_POST['procedimentos_arealizar'];
        $consulta->descricao = $_POST['descricao'];
        $consulta->medicacao = $_POST['medicacao'];
        $consulta->cadastrar();
        
        header('location: /consultorio/view/consulta/listar.php');
    break;
    


    case 'alterar':
        $consulta = Consulta::buscarPorId($_GET['id']);
        $consulta->dentista_id = $_POST['dentista_id'];
        $consulta->data_hora = $_POST['data_hora'];
        $consulta->valor_total = $_POST['valor_total'];
        $consulta->valor_pago = $_POST['valor_pago'];
        $consulta->forma_pagamento = $_POST['forma_pagamento'];
        $consulta->procedimentos_realizados = $_POST['procedimentos_realizados'];
        $consulta->procedimentos_arealizar = $_POST['procedimentos_arealizar'];
        $consulta->descricao = $_POST['descricao'];
        $consulta->medicacao = $_POST['medicacao'];
        $consulta->alterar();
        
        header('location: /consultorio/view/consulta/listar.php');
    break;
    


    case 'excluir':
        $consulta->id = $_GET['id'];
        $consulta->excluir();
        
        header('location: /consultorio/view/consulta/listar.php');
    break;
}
?>