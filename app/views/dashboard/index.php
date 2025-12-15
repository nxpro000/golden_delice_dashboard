<?php
// Variables disponibles :
// $from, $to
// $salesTotal, $ordersCount, $coversCount, $avgBasket
// $ongoingOrders, $tablesStatus
// $lowStock, $preparations, $availableDishes
// $topDishes, $cancelledOrders, $paymentsSummary
?>

<h2>Tableau de bord – Golden Délice</h2>

<form method="get" action="/dashboard" class="filters">
    <label>Du
        <input type="date" name="from" value="<?= htmlspecialchars($from) ?>">
    </label>
    <label>Au
        <input type="date" name="to" value="<?= htmlspecialchars($to) ?>">
    </label>
    <button type="submit">Filtrer</button>
</form>

<section class="kpis">
    <div class="kpi">
        <h3>CA (période)</h3>
        <p><?= number_format($salesTotal, 0, ',', ' ') ?> F CFA</p>
    </div>
    <div class="kpi">
        <h3>Commandes</h3>
        <p><?= (int)$ordersCount ?></p>
    </div>
    <div class="kpi">
        <h3>Couverts (sur place)</h3>
        <p><?= (int)$coversCount ?></p>
    </div>
    <div class="kpi">
        <h3>Panier moyen</h3>
        <p><?= number_format($avgBasket, 0, ',', ' ') ?> F CFA</p>
    </div>
</section>

<section class="dashboard-grid">

    <div class="card">
        <h3>Commandes en cours</h3>
        <ul class="list">
            <?php if (!empty($ongoingOrders)): ?>
                <?php foreach ($ongoingOrders as $order): ?>
                    <li>
                        #<?= $order['id'] ?>
                        – <?= htmlspecialchars($order['type']) ?>
                        <?php if (!empty($order['table_name'])): ?>
                            – Table <?= htmlspecialchars($order['table_name']) ?>
                        <?php endif; ?>
                        – <?= htmlspecialchars($order['status']) ?>
                        – <?= date('H:i', strtotime($order['created_at'])) ?>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune commande en cours.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card">
        <h3>Statut des tables</h3>
        <div class="tables-grid">
            <?php foreach ($tablesStatus as $table): ?>
                <div class="table-box status-<?= htmlspecialchars($table['status']) ?>">
                    <strong><?= htmlspecialchars($table['name']) ?></strong><br>
                    <small><?= htmlspecialchars($table['status']) ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card">
        <h3>Top plats vendus</h3>
        <ol class="list">
            <?php if (!empty($topDishes)): ?>
                <?php foreach ($topDishes as $dish): ?>
                    <li>
                        <?= htmlspecialchars($dish['name']) ?>
                        (<?= (int)$dish['qty'] ?>)
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune donnée pour cette période.</li>
            <?php endif; ?>
        </ol>
    </div>

    <div class="card">
        <h3>Alertes stock</h3>
        <ul class="list">
            <?php if (!empty($lowStock)): ?>
                <?php foreach ($lowStock as $item): ?>
                    <li>
                        <?= htmlspecialchars($item['name']) ?> :
                        <?= (float)$item['stock_current'] . ' ' . htmlspecialchars($item['unit']) ?>
                        (seuil <?= (float)$item['alert_threshold'] ?>)
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune alerte stock.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card">
        <h3>Préparations du jour</h3>
        <ul class="list">
            <?php if (!empty($preparations)): ?>
                <?php foreach ($preparations as $prep): ?>
                    <li>
                        <?= htmlspecialchars($prep['name']) ?> :
                        <?= (int)$prep['portions_remaining'] ?> / <?= (int)$prep['total_portions'] ?> portions
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune préparation enregistrée pour aujourd’hui.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card">
        <h3>Plats disponibles</h3>
        <ul class="list">
            <?php if (!empty($availableDishes)): ?>
                <?php foreach ($availableDishes as $dish): ?>
                    <li>
                        <?= htmlspecialchars($dish['name']) ?> –
                        <?= number_format($dish['price'], 0, ',', ' ') ?> F
                        (<?=
                            max(0, (int)floor($dish['max_portions']))
                        ?> portions possibles)
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucun plat disponible (vérifier les préparations).</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card">
        <h3>Paiements (période)</h3>
        <ul class="list">
            <?php if (!empty($paymentsSummary)): ?>
                <?php foreach ($paymentsSummary as $pay): ?>
                    <li>
                        <?= htmlspecialchars(ucfirst($pay['payment_method'])) ?> :
                        <?= number_format($pay['total'], 0, ',', ' ') ?> F
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucun paiement sur cette période.</li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="card">
        <h3>Commandes annulées</h3>
        <ul class="list">
            <?php if (!empty($cancelledOrders)): ?>
                <?php foreach ($cancelledOrders as $order): ?>
                    <li>
                        #<?= $order['id'] ?> –
                        <?= date('d/m H:i', strtotime($order['created_at'])) ?> –
                        <?= number_format($order['total_ttc'], 0, ',', ' ') ?> F
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune commande annulée sur cette période.</li>
            <?php endif; ?>
        </ul>
    </div>

</section>