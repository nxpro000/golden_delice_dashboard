<h2>Plats</h2>

<a href="/dishes/create" class="btn">+ Nouveau plat</a>

<table class="table">
    <thead>
    <tr>
        <th>Nom</th>
        <th>Catégorie</th>
        <th>Prix</th>
        <th>Configurable</th>
        <th>Actif</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dishes as $dish): ?>
        <tr>
            <td><?= htmlspecialchars($dish['name']) ?></td>
            <td><?= htmlspecialchars($dish['category_name']) ?></td>
            <td><?= number_format($dish['price'], 0, ',', ' ') ?> F</td>
            <td><?= $dish['is_configurable'] ? 'Oui' : 'Non' ?></td>
            <td><?= $dish['is_active'] ? 'Oui' : 'Non' ?></td>
            <td>
                <a href="/dishes/edit?id=<?= $dish['id'] ?>">Modifier</a> |
                <a href="/dishes/options?id=<?= $dish['id'] ?>">Options</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
