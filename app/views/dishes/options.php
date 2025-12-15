<h2>Options pour le plat : <?= htmlspecialchars($dish['name']) ?></h2>

<section class="dish-options">
    <div>
        <h3>Bases</h3>
        <ul>
            <?php foreach ($bases as $opt): ?>
                <li><?= htmlspecialchars($opt['name']) ?> (<?= number_format($opt['price'], 0, ',', ' ') ?> F)</li>
            <?php endforeach; ?>
        </ul>
        <form method="post" action="/dishes/addOption">
            <input type="hidden" name="dish_id" value="<?= $dish['id'] ?>">
            <input type="hidden" name="type" value="base">
            <label>Nouvelle base :
                <input type="text" name="name" required>
            </label>
            <label>Supplément prix :
                <input type="number" step="0.01" name="price" value="0">
            </label>
            <button type="submit">Ajouter</button>
        </form>
    </div>

    <div>
        <h3>Accompagnements</h3>
        <ul>
            <?php foreach ($accompagnements as $opt): ?>
                <li><?= htmlspecialchars($opt['name']) ?> (<?= number_format($opt['price'], 0, ',', ' ') ?> F)</li>
            <?php endforeach; ?>
        </ul>
        <form method="post" action="/dishes/addOption">
            <input type="hidden" name="dish_id" value="<?= $dish['id'] ?>">
            <input type="hidden" name="type" value="accompagnement">
            <label>Nouvel accompagnement :
                <input type="text" name="name" required>
            </label>
            <label>Supplément prix :
                <input type="number" step="0.01" name="price" value="0">
            </label>
            <button type="submit">Ajouter</button>
        </form>
    </div>

    <div>
        <h3>Sauces</h3>
        <ul>
            <?php foreach ($sauces as $opt): ?>
                <li><?= htmlspecialchars($opt['name']) ?> (<?= number_format($opt['price'], 0, ',', ' ') ?> F)</li>
            <?php endforeach; ?>
        </ul>
        <form method="post" action="/dishes/addOption">
            <input type="hidden" name="dish_id" value="<?= $dish['id'] ?>">
            <input type="hidden" name="type" value="sauce">
            <label>Nouvelle sauce :
                <input type="text" name="name" required>
            </label>
            <label>Supplément prix :
                <input type="number" step="0.01" name="price" value="0">
            </label>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</section>
