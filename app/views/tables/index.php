<div class="container tables-page">
    <h1 class="page-title">Gestion des tables</h1>

    <div class="actions">
        <a href="/tables/create" class="btn btn-primary">➕ Nouvelle table</a>
    </div>

    <table class="table table-tables">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Places</th>
                <th>Statut</th>
                <th style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tables)): ?>
                <?php foreach ($tables as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['name']) ?></td>
                        <td><?= (int)$t['seats'] ?></td>

                        <td>
                            <?php
                                $status = $t['status'];
                                $class = match ($status) {
                                    'libre'      => 'status-free',
                                    'occupée'    => 'status-busy',
                                    'réservée'   => 'status-reserved',
                                    'nettoyage'  => 'status-cleaning',
                                    default      => 'status-unknown'
                                };
                            ?>
                            <span class="status <?= $class ?>">
                                <?= ucfirst($status) ?>
                            </span>
                        </td>

                        <td>
                            <a href="/tables/edit?id=<?= $t['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="/tables/delete?id=<?= $t['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Supprimer cette table ?')">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Aucune table enregistrée</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>