<h2><?= isset($dish) ? 'Modifier' : 'Nouveau' ?> plat</h2>

<form method="post" action="<?= isset($dish) ? '/dishes/update' : '/dishes/store' ?>">
    <?php if (isset($dish)): ?>
        <input type="hidden" name="id" value="<?= $dish['id'] ?>">
    <?php endif; ?>

    <label>Nom :
        <input type="text" name="name" value="<?= htmlspecialchars($dish['name'] ?? '') ?>" required>
    </label>

    <label>Description :
        <textarea name="description"><?= htmlspecialchars($dish['description'] ?? '') ?></textarea>
    </label>

    <label>Catégorie :
        <select name="category_id">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= isset($dish) && $dish['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Prix :
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($dish['price'] ?? '0') ?>">
    </label>

    <label>Plat configurable (bases/sauces) ?
        <input type="checkbox" name="is_configurable" value="1" <?= !empty($dish['is_configurable']) ? 'checked' : '' ?>>
    </label>

    <button type="submit">Enregistrer</button>
</form>
