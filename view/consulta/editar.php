<?php

use App\Entity\Agenda;
use App\Entity\Consulta;
use App\Entity\Funcionario;
use App\Entity\Paciente;
require __DIR__ . '/../../vendor/autoload.php';
include __DIR__ . '/../includes/header.php';
$consulta = Consulta::buscarPorId($_GET['id']);
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom p-4">
            <h3 class="mb-4 text-primary"><i class="fa-solid fa-calendar-plus me-2"></i> Editar Consulta</h3>
            <form action="../../actions/consulta_action.php?action=editar&id=<?= $consulta->id ?>" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Paciente *</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($consulta->paciente->nome) ?> (CPF: <?= $consulta->paciente->cpf ?>)" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dentista *</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($consulta->dentista->nome) ?>" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Descrição da consulta *</label>
                        <textarea name="descricao" rows="4" class="form-control" required><?= $consulta->descricao ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Medicação prescrita </label>
                        <textarea name="medicacao" rows="4" class="form-control"><?= $consulta->medicacao ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Procedimentos Realizados *</label>
                        <textarea name="procedimentos_realizados" rows="4" class="form-control" required><?= $consulta->procedimentos_realizados ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Procedimentos a Realizar </label>
                        <textarea name="procedimentos_arealizar" rows="4" class="form-control"><?= $consulta->procedimentos_arealizar ?></textarea>
                    </div>
                    <div class="col-md-6">
                            <label class="form-label">Forma de Pagamento</label>
                            <input type="text" name="forma_pagamento" class="form-control" value="<?= $consulta->forma_pagamento ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Valor da consulta *</label>
                            <input type="text" name="valor_total" class="form-control" value="<?= $consulta->valor_total ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Valor Pago *</label>
                            <input type="text" name="valor_pago" class="form-control" <?= $consulta->valor_pago ?> required>
                        </div>
                    <div class="col-12 text-end mt-4">
                        <a href="index.php" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check me-1"></i> Remarcar agenda</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
