<?php




use App\Consulta;
include('../includes/cabecalho.php');
include('../includes/menu.php');
include('../includes/rodape.php');

$id = $_GET['id'];
$consulta = Consulta::buscarPorId($id);



?>



<main class="container">
    <h1>Editar Consulta</h1>
    <form method="POST" action="/consultorio/action/action_consulta.php?action=alterar&id=<?= $id ?>">
        ID do Dentista * : <input name="dentista_id" type="number" value="<?= $consulta->dentista_id ?>" class="form-control" required>
        Data e Hora * : <input name="data_hora" type="datetime-local" value="<?= date('Y-m-d\TH:i', strtotime($consulta->data_hora)) ?>" class="form-control" required>
        Valor Total * : <input name="valor_total" type="text" value="<?= $consulta->valor_total ?>" class="form-control" required>
        Valor Pago : <input name="valor_pago" type="text" value="<?= $consulta->valor_pago ?>" class="form-control">
        Forma de Pagamento : <input name="forma_pagamento" type="text" value="<?= $consulta->forma_pagamento ?>" class="form-control">
        Procedimentos Realizados : <input name="procedimentos_realizados" type="text" value="<?= $consulta->procedimentos_realizados ?>" class="form-control">
        Procedimentos a Realizar : <input name="procedimentos_arealizar" type="text" value="<?= $consulta->procedimentos_arealizar ?>" class="form-control">
        Descrição : <input name="descricao" type="text" value="<?= $consulta->descricao ?>" class="form-control">
        Medicação : <input name="medicacao" type="text" value="<?= $consulta->medicacao ?>" class="form-control">
        <br>
        <input type="submit" value="Editar" class="btn btn-primary">
    </form>
    <div class="pb-5"></div>
</main>