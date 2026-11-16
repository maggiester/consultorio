<?php
use App\Consulta;
include('../includes/cabecalho.php');
include('../includes/menu.php');
include('../includes/rodape.php');
$consultas = Consulta::listar();
/*
echo "<pre><";  
    print_r($consultas); 
    echo "></pre>"; 
    exit;
*/
?>


<?php if (isset($_GET['msg']) && $_GET['msg'] === 'sucesso'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Consulta realizada com sucesso!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card card-custom p-3">
    <form method="GET">
        <div class="row my-4">
            <div class="col">
                <label>Filtrar por Data</label>
                <input type="date" name="busca" class="form-control" value="<?= $busca ?>">
            </div>
            
            <div class="col-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>

        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Data & Hora</th>
                    <th>Paciente</th>
                    <th>Dentista</th>
                    <th>Procedimentos realizados</th>
                    <th>Forma de Pagamento</th>
                    <th>Valor Total</th>
                    <th>Valor Pago</th>
                    <th>Valor a Pagar</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultas as $c): ?>
                <tr>
                    <td><?= $c->id ?></td>
                    <td><strong><?= (new DateTime($c->data_hora))->format('d/m/Y - H:i') ?></strong></td>
                    <td><?= htmlspecialchars($c->paciente->nome) ?></td>
                    <td><?= htmlspecialchars($c->dentista->nome) ?></td>
                    <td><?= htmlspecialchars($c->procedimentos_realizados) ?></td>
                    <td><?= htmlspecialchars($c->forma_pagamento) ?></td>
                    <td><span class="badge bg-success">R$ <?= number_format($c->valor_total, 2, ',', '.') ?></span></td>
                    <td><span class="badge bg-success">R$ <?= number_format($c->valor_pago, 2, ',', '.') ?></span></td>
                    <td><span class="badge bg-success">R$ <?= number_format($c->valor_total - $c->valor_pago, 2, ',', '.') ?></span></td>
                    <td class="text-end">
                            <a href="editar.php?id=<?= $c->id ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                        </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($consultas)): ?>
                <tr><td colspan="7" class="text-center text-muted py-4">Nenhuma consulta agendada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
