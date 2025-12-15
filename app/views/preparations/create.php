<h2>Nouvelle préparation</h2>

<form method="post" action="/preparations/create">
    <label>Nom de la préparation :
        <input type="text" name="name" placeholder="Riz cuit, Sauce graine, Foutou..." required>
    </label>

    <label>Nombre de portions produites :
        <input type="number" name="total_portions" required>
    </label>

    <button type="submit">Enregistrer</button>
</form>
