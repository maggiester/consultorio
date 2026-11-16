<?php




use App\Consulta;
include('../includes/cabecalho.php');
include('../includes/menu.php');
include('../includes/rodape.php');

$consultas = Consulta::listar();



?>



<main class="container">
    <h1 class="text-center">Lista de Consultas</h1>
    <div class="text-end my-2">
        <a href="/consultorio/view/consulta/cadastrar.php">
            <button class="btn btn-success">Nova Consulta</button>
        </a>
    </div>
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>Dentista ID</th>
                <th>Data e Hora</th>
                <th>Valor Total</th>
                <th>Valor Pago</th>
                <th>Forma Pgto</th>
                <th>Proc. Realizados</th>
                <th>Proc. a Realizar</th>
                <th>Descrição</th>
                <th>Medicação</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($consultas as $consulta) {
                echo "<tr>
                    <td>" . $consulta->dentista_id . "</td>
                    <td>" . date("d/m/Y H:i", strtotime($consulta->data_hora)) . "</td>
                    <td>R$ " . number_format($consulta->valor_total, 2, ',', '.') . "</td>
                    <td>R$ " . number_format($consulta->valor_pago, 2, ',', '.') . "</td>
                    <td>" . $consulta->forma_pagamento . "</td>
                    <td>" . $consulta->procedimentos_realizados . "</td>
                    <td>" . $consulta->procedimentos_arealizar . "</td>
                    <td>" . $consulta->descricao . "</td>
                    <td>" . $consulta->medicacao . "</td>
                    <td><a href='editar.php?id=" . $consulta->id . "'>
                        <button class='btn btn-primary'>Editar</button></a></td>
                    <td><a href='/consultorio/action/action_consulta.php?action=excluir&id=" . $consulta->id . "'>
                        <button class='btn btn-danger'>Excluir</button></a></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="pb-5"></div>
</main>