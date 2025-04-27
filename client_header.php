<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . " | MondeApprentissage" : "MondeApprentissage - Apprendre en s'amusant"; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    
    <!-- Polices -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/client.css">
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <!-- Logo et slogan -->
            <div class="branding">
                <a href="index.php" class="logo-link">
                    <div class="logo-text">
                        <h1>MondeApprentissage</h1>
                        <p class="slogan">Explorer • Découvrir • Apprendre</p>
                    </div>
                </a>
            </div>
            
            <!-- Navigation principale -->
            <nav class="primary-nav">
                <ul>
                    <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <span class="nav-text">Accueil</span>
                    </a></li>
                    <li><a href="client_categories.php" class="<?= basename($_SERVER['PHP_SELF']) == 'client_categories.php' ? 'active' : '' ?>">
                        <span class="nav-text">Catégories</span>
                    </a></li>
                    <li><a href="client_quiz.php" class="<?= basename($_SERVER['PHP_SELF']) == 'client_quiz.php' ? 'active' : '' ?>">
                        <span class="nav-text">Quiz</span>
                    </a></li>
                </ul>
            </nav>
            
            <!-- Bouton Admin -->
            <div class="admin-access">
                <a href="admin_interface.php" class="admin-btn">
                    <span class="admin-text">Espace Admin</span>
                </a>
            </div>
            
            <!-- Menu mobile -->
            <button class="mobile-menu-toggle" aria-label="Menu">
                <span class="hamburger"></span>
            </button>
        </div>
    </header>
    
    <main>