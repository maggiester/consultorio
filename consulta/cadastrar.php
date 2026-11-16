<?php




include('../includes/cabecalho.php');
include('../includes/menu.php');
include('../includes/rodape.php');


?>





<main class="container">
    <h1>Cadastrar Consulta</h1>
    <form method="POST" action="/consultorio/action/action_consulta.php?action=cadastrar">
        ID do Dentista * : <input name="dentista_id" type="number" class="form-control" required>
        Data e Hora * : <input name="data_hora" type="datetime-local" class="form-control" required>
        Valor Total * : <input name="valor_total" type="text" class="form-control" required>
        Valor Pago : <input name="valor_pago" type="text" class="form-control">
        Forma de Pagamento : <input name="forma_pagamento" type="text" class="form-control">
        Procedimentos Realizados : <input name="procedimentos_realizados" type="text" class="form-control">
        Procedimentos a Realizar : <input name="procedimentos_arealizar" type="text" class="form-control">
        Descrição : <input name="descricao" type="text" class="form-control">
        Medicação : <input name="medicacao" type="text" class="form-control">
        <br>
        <input type="submit" value="Cadastrar" class="btn btn-primary">
    </form>
    <div class="pb-5"></div>
</main>