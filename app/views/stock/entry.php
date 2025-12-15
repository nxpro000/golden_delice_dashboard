<h2>Entrée de stock</h2>

<form method="post" action="/stock/entry">
    <label>Ingrédient :
        <select name="ingredient_id">
            <?php foreach ($ingredients as $ing): ?>
                <option value="<?= $ing['id'] ?>"><?= htmlspecialchars($ing['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Quantité :
        <input type="number" step="0.01" name="quantity" required>
    </label>

    <label>Motif :
        <input type="text" name="reason" value="Achat fournisseur">
    </label>

    <button type="submit">Valider</button>
</form>
