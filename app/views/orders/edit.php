<h2>Commande #<?= $order['id'] ?> (<?= htmlspecialchars($order['type']) ?>)</h2>

<section class="order-header">
    <p>
        Statut : <strong><?= htmlspecialchars($order['status']) ?></strong><br>
        Table : <?= $order['table_id'] ?: '-' ?><br>
        Couverts : <?= (int)$order['covers'] ?><br>
        Total : <?= number_format($order['total_ttc'], 0, ',', ' ') ?> F
    </p>

    <form method="post" action="/orders/changeStatus">
        <input type="hidden" name="id" value="<?= $order['id'] ?>">
        <label>Changer de statut :
            <select name="status">
                <option value="en_cours">En cours</option>
                <option value="envoye_cuisine">Envoyée en cuisine</option>
                <option value="pret">Prête</option>
                <option value="en_attente_paiement">En attente de paiement</option>
                <option value="paid">Payée</option>
                <option value="cancelled">Annulée</option>
            </select>
        </label>
        <button type="submit">Mettre à jour</button>
    </form>
</section>

<section class="order-items">
    <h3>Lignes de commande</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Plat</th>
            <th>Qté</th>
            <th>PU</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= (int)$item['quantity'] ?></td>
                <td><?= number_format($item['unit_price'], 0, ',', ' ') ?> F</td>
                <td><?= number_format($item['total_price'], 0, ',', ' ') ?> F</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<section class="order-add-item">
    <h3>Ajouter un plat</h3>
    <form method="post" action="/orders/addItem">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <label>Plat :
            <select name="dish_id">
                <?php foreach ($dishes as $dish): ?>
                    <option value="<?= $dish['id'] ?>">
                        <?= htmlspecialchars($dish['category_name']) ?> – <?= htmlspecialchars($dish['name']) ?>
                        (<?= number_format($dish['price'], 0, ',', ' ') ?> F)
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Quantité :
            <input type="number" name="quantity" value="1" min="1">
        </label>
        <button type="submit">Ajouter</button>
    </form>
</section>

<section class="order-payment">
    <h3>Paiement</h3>
    <form method="post" action="/orders/pay">
        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
        <p>Total à payer : <strong><?= number_format($order['total_ttc'], 0, ',', ' ') ?> F</strong></p>
        <label>Moyen de paiement :
            <select name="payment_method">
                <option value="cash">Espèces</option>
                <option value="mobile_money">Mobile money</option>
                <option value="carte">Carte</option>
                <option value="avoir">Avoir</option>
            </select>
        </label>
        <label>Montant remis :
            <input type="number" name="amount_paid" step="0.01" required>
        </label>
        <button type="submit">Encaisser et générer facture</button>
    </form>
</section>
