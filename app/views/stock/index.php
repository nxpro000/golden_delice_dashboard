<h2>Stock ingrédients</h2>

<a href="/stock/entry" class="btn">+ Entrée de stock</a>
<a href="/stock/exit" class="btn">- Sortie de stock</a>

<table class="table">
    <thead>
    <tr>
        <th>Ingrédient</th>
        <th>Stock actuel</th>
        <th>Unité</th>
        <th>Seuil alerte</th>
        <th>Statut</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($ingredients as $ing): ?>
        <?php
        $status = 'OK';
        if ($ing['stock_current'] <= $ing['alert_threshold']) {
            $status = 'Alerte';
        }
        ?>
        <tr>
            <td><?= htmlspecialchars($ing['name']) ?></td>
            <td><?= (float)$ing['stock_current'] ?></td>
            <td><?= htmlspecialchars($ing['unit']) ?></td>
            <td><?= (float)$ing['alert_threshold'] ?></td>
            <td><?= $status ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
