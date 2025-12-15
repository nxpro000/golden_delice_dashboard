<h2>Préparations du jour</h2>

<a href="/preparations/create" class="btn">+ Nouvelle préparation</a>

<table class="table">
    <thead>
    <tr>
        <th>Préparation</th>
        <th>Portions totales</th>
        <th>Portions restantes</th>
        <th>Créée le</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($preparations as $prep): ?>
        <tr>
            <td><?= htmlspecialchars($prep['name']) ?></td>
            <td><?= (int)$prep['total_portions'] ?></td>
            <td><?= (int)$prep['portions_remaining'] ?></td>
            <td><?= htmlspecialchars($prep['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
