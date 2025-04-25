<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MondeApprentissage - Pour les enfants curieux</title>
    <link rel="stylesheet" href="css/client.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>MondeApprentissage</h1>
            <p class="slogan">Apprendre en s'amusant !</p>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" class="active">Accueil</a></li>
                <li><a href="client_categories.php">Catégories</a></li>
                <li><a href="client_jeux.php">Quiz</a></li>
                <li><a href="client_contact.php">Contact</a></li>
            </ul>
        </nav>
        <div class="admin-link">
            <a href="admin_interface.php" class="btn-admin">Espace Admin</a>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h2>Bienvenue sur MondeApprentissage !</h2>
            <p>Un univers coloré où les enfants découvrent et apprennent en s'amusant</p>
        </div>
    </section>
    
    <section class="categories-preview">
        <h2>Découvre nos catégories</h2>
        <div class="categories-container">

            <div class="category-card">
                <img src="uploads/categories/animaux.jpg" alt="Animaux">
                <h3>Animaux</h3>
            </div>
            <div class="category-card">
                <img src="uploads/categories/transports.jpg" alt="Transports">
                <h3>Transports</h3>
            </div>
            <div class="category-card">
                <img src="uploads/categories/nombres.jpg" alt="Nombres">
                <h3>Nombres</h3>
            </div>
            <div class="category-card">
                <img src="uploads/categories/couleurs.jpg" alt="Couleurs">
                <h3>Couleurs</h3>
            </div>
        </div>
        <div class="voir-plus">
            <a href="client_categories.php" class="btn-voir">Voir toutes les catégories</a>
        </div>
    </section>

    <section class="featured">
        <h2>Contenu populaire</h2>
        <div class="featured-container">
            <div class="element-card">
                <img src="uploads/elements/lion.jpg" alt="Lion">
                <h3>Le Lion</h3>
                <p>Découvre le roi de la savane</p>
                <div class="media-controls">
                    <button class="audio-btn">Écouter</button>
                </div>
            </div>
            <div class="element-card">
                <img src="uploads/elements/train.jpg" alt="Train">
                <h3>Le Train</h3>
                <p>Comment fonctionne un train ?</p>
                <div class="media-controls">
                    <button class="video-btn">Regarder</button>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-logo">
                <h2>MondeApprentissage</h2>
                <p>© MondeApprentissage</p>
            </div>
            <div class="footer-links">
                <h3>Liens utiles</h3>
                <ul>
                    <li><a href="client_apropos.php">À propos</a></li>
                    <li><a href="client_contact.php">Contact</a></li>
                    <li><a href="client_mentions.php">Mentions légales</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="client_script.js"></script>
</body>
</html>