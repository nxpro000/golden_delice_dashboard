<h2>Facture <?= htmlspecialchars($invoice['number']) ?></h2>

<p>
    Commande #<?= $order['id'] ?><br>
    Date : <?= htmlspecialchars($invoice['paid_at']) ?><br>
    Moyen de paiement : <?= htmlspecialchars($invoice['payment_method']) ?><br>
</p>

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

<p style="text-align:right; font-size:1.1rem;">
    Total TTC : <strong><?= number_format($invoice['total_ttc'], 0, ',', ' ') ?> F</strong>
</p>

<button onclick="window.print()">Imprimer</button>
