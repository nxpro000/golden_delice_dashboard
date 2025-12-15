<h2>Commandes</h2>

<form method="get" action="/orders" class="filters">
    <label>Du
        <input type="date" name="from" value="<?= htmlspecialchars($filters['from'] ?? '') ?>">
    </label>
    <label>Au
        <input type="date" name="to" value="<?= htmlspecialchars($filters['to'] ?? '') ?>">
    </label>
    <label>Type
        <select name="type">
            <option value="">Tous</option>
            <option value="interne" <?= ($filters['type'] ?? '') === 'interne' ? 'selected' : '' ?>>Interne</option>
            <option value="emporter" <?= ($filters['type'] ?? '') === 'emporter' ? 'selected' : '' ?>>À emporter</option>
        </select>
    </label>
    <label>Statut
        <select name="status">
            <option value="">Tous</option>
            <option value="en_cours">En cours</option>
            <option value="envoye_cuisine">Envoyée en cuisine</option>
            <option value="pret">Prête</option>
            <option value="en_attente_paiement">En attente de paiement</option>
            <option value="paid">Payée</option>
            <option value="cancelled">Annulée</option>
        </select>
    </label>
    <button type="submit">Filtrer</button>
    <a href="/orders/create?type=interne" class="btn">+ Nouvelle commande interne</a>
    <a href="/orders/create?type=emporter" class="btn">+ Nouvelle commande à emporter</a>
</form>

<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Type</th>
        <th>Table</th>
        <th>Statut</th>
        <th>Total</th>
        <th>Créée</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= htmlspecialchars($order['type']) ?></td>
            <td><?= $order['table_id'] ?: '-' ?></td>
            <td><?= htmlspecialchars($order['status']) ?></td>
            <td><?= number_format($order['total_ttc'], 0, ',', ' ') ?> F</td>
            <td><?= htmlspecialchars($order['created_at']) ?></td>
            <td>
                <a href="/orders/edit?id=<?= $order['id'] ?>">Ouvrir</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
