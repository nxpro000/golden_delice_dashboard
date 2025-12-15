<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? htmlspecialchars($title) : APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>

<header class="main-header">
    <nav class="navbar">
        <div class="navbar-brand">Golden Délice</div>
        <ul class="navbar-links">
            <li><a href="<?= BASE_URL ?>dashboard">Dashboard</a></li>
            <li><a href="<?= BASE_URL ?>orders">Commandes</a></li>
            <li><a href="<?= BASE_URL ?>tables">Tables</a></li>
            <li><a href="<?= BASE_URL ?>dishes">Plats</a></li>
            <li><a href="<?= BASE_URL ?>stock">Stock</a></li>
            <li><a href="<?= BASE_URL ?>preparations">Préparations</a></li>
            <li><a href="<?= BASE_URL ?>reports">Stats</a></li>
        </ul>
        <form class="navbar-search" action="<?= BASE_URL ?>search" method="get">
            <input type="text" name="q" placeholder="Rechercher (plat, commande...)">
        </form>
    </nav>
</header>

<main class="main-content">
    <?php require $viewFile; ?>
</main>

</body>
</html>
