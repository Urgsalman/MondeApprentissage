<?php 
$pageTitle = "Accueil - MondeApprentissage";
include 'client_header.php'; 
?>

<!-- Section Bienvenue -->
<section class="welcome-section">
    <div class="welcome-content">
        <h2>Bienvenue sur MondeApprentissage !</h2>
        <p>Un univers coloré où les enfants découvrent et apprennent en s'amusant !</p>
        
        <div class="welcome-actions">
            <div class="mascot">
                <img src="uploads/mascot.png" alt="Mascotte rigolote">
            </div>
            <a href="#categories" class="explore-btn">Explorer maintenant !</a>
        </div>
    </div>
</section>

<!-- Section Catégories -->
<section id="categories" class="categories-section">
    <h2>Découvre nos catégories</h2>
    
    <div class="categories-grid">
        <a href="client_categories.php" class="category-card">
            <img src="uploads/categories/animaux.jpg" alt="Animaux">
            <h3>Animaux</h3>
        </a>
        
        <a href="client_categories.php" class="category-card">
            <img src="uploads/categories/transports.jpg" alt="Transports">
            <h3>Transports</h3>
        </a>
        
        <a href="client_categories.php" class="category-card">
            <img src="uploads/categories/nombres.jpg" alt="Nombres">
            <h3>Nombres</h3>
        </a>
        
        <a href="client_categories.php" class="category-card">
            <img src="uploads/categories/couleurs.jpg" alt="Couleurs">
            <h3>Couleurs</h3>
        </a>
    </div>
    
    <div class="see-more">
        <a href="client_categories.php" class="see-more-btn">Voir toutes les catégories →</a>
    </div>
</section>

<?php include 'client_footer.php'; ?>