<?php

use App\Entity\Consulta;
use App\Entity\Agenda;
require __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../includes/header.php';
$agenda = Agenda::buscarPorId($_GET['id']);
$cpr = Consulta::listar("paciente_id=$agenda->paciente_id"); 

/*echo "<pre>";  
                print_r($agenda); 
                echo "</pre>";*/
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom p-4">
            <h3 class="mb-4 text-primary"><i class="fa-solid fa-calendar-plus me-2"></i> Realizar Consulta</h3>
            <form action="../../actions/consulta_action.php?action=cadastrar&agenda_id=<?= $agenda->id ?>" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Paciente *</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($agenda->paciente->nome) ?> (CPF: <?= $agenda->paciente->cpf ?>)" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dentista *</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($agenda->dentista->nome) ?>" disabled>
                    </div>
                    <div class="container bg-light mt-3">
                        <label class="form-label text-center">Histórico Médico</label>
                        <table class="table">
                            <tr>
                                <th>Data</th>
                                <th>Procedimento</th>
                            </tr>

                            <?php
                            foreach ($cpr as $pr) {
                                if($pr->procedimentos_realizados != null){
                                echo "<tr>
                                        <td>" . (new DateTime($pr->data_hora))->format("d/m/Y") . "</td>
                                        <td>" . $pr->procedimentos_realizados . "</td>
                                    </tr>";
                                }
                            }
                            foreach ($cpr as $pr) {
                                if($pr->procedimentos_arealizar != null){
                                echo "<tr>
                                        <td></td>
                                        <td>" . $pr->procedimentos_arealizar . " -> A realizar</td>
                                    </tr>";
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Descrição da consulta *</label>
                        <textarea name="descricao" rows="4" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Medicação prescrita </label>
                        <textarea name="medicacao" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Procedimentos Realizados *</label>
                        <textarea name="procedimentos_realizados" rows="4" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Procedimentos a Realizar </label>
                        <textarea name="procedimentos_arealizar" rows="4" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label">Forma de Pagamento</label>
                            <select name="forma_pagamento" class="form-select" required>
                                <option value="">Selecione a forma de pagamento...</option>
                                <option value="PIX">PIX</option>
                                <option value="PIX">DINHEIRO</option>
                                <option value="PIX">CARTÃO DE CREDITO</option>
                                <option value="PIX">CARTÃO DE DEBITO</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Valor da consulta *</label>
                            <input type="text" name="valor_total" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Valor Pago *</label>
                            <input type="text" name="valor_pago" class="form-control" required>
                        </div>
                        
                    <div class="col-12 text-end mt-4">
                        <a href="index.php" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i> Finalizar Consulta</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
