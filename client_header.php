<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . " - MondeApprentissage" : "MondeApprentissage - Pour les enfants curieux"; ?></title>
    <link rel="stylesheet" href="css/client.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php">  <!-- Lien vers la page d'accueil -->
                <h1>MondeApprentissage</h1>
                <p class="slogan">Apprendre en s'amusant !</p>
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : ''; ?>>Accueil</a></li>
                <li><a href="client_categories.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'client_categories.php') ? 'class="active"' : ''; ?>>Catégories</a></li>
                <li><a href="client_jeux.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'client_jeux.php') ? 'class="active"' : ''; ?>>Quiz</a></li>
                <li><a href="client_contact.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'client_contact.php') ? 'class="active"' : ''; ?>>Contact</a></li>
            </ul>
        </nav>
        <div class="admin-link">
            <a href="admin_interface.php" class="btn-admin">Espace Admin</a>  <!-- Lien vers l'interface admin -->
        </div>
    </header>
    
    <main>