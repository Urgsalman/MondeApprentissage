<?php 
$pageTitle = "Accueil - MondeApprentissage";
include 'client_header.php'; 

require_once 'Database.php';
$db = Database::getInstance();
$conn = $db->getConnection();

// Récupération des catégories
$query = "SELECT id, nom FROM categories WHERE nom IN ('Animaux', 'Transports', 'Nombres', 'Couleurs')";
$result = $conn->query($query);
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[$row['nom']] = $row['id'];
}

// Récupération des éléments populaires
$popularQuery = "SELECT e.id, e.titre, e.categorie_id, c.nom as categorie_nom 
                 FROM elements e
                 JOIN categories c ON e.categorie_id = c.id
                 ORDER BY RAND() LIMIT 4"; // Vous pouvez remplacer par votre propre logique de popularité
$popularResult = $conn->query($popularQuery);
$popularItems = $popularResult->fetch_all(MYSQLI_ASSOC);
?>

<?php 
$pageTitle = "Accueil - MondeApprentissage";

// Define category IDs (you should replace these with your actual category IDs)
$categoryIds = [
    'Animaux' => 2,       // Replace with actual ID from your database
    'Transports' => 4,    // Replace with actual ID from your database
    'Nombres' => 3,       // Replace with actual ID from your database
    'Couleurs' => 5       // Replace with actual ID from your database
];
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
        <a href="client_elements.php?categorie_id=<?= $categoryIds['Animaux'] ?>" class="category-card">
            <img src="uploads/categories/animaux.jpg" alt="Animaux">
            <h3>Animaux</h3>
        </a>
        
        <a href="client_elements.php?categorie_id=<?= $categoryIds['Transports'] ?>" class="category-card">
            <img src="uploads/categories/transports.jpg" alt="Transports">
            <h3>Transports</h3>
        </a>
        
        <a href="client_elements.php?categorie_id=<?= $categoryIds['Nombres'] ?>" class="category-card">
            <img src="uploads/categories/nombres.jpg" alt="Nombres">
            <h3>Nombres</h3>
        </a>
        
        <a href="client_elements.php?categorie_id=<?= $categoryIds['Couleurs'] ?>" class="category-card">
            <img src="uploads/categories/couleurs.jpg" alt="Couleurs">
            <h3>Couleurs</h3>
        </a>
    </div>
    
    <div class="see-more">
        <a href="client_categories.php" class="see-more-btn">Voir toutes les catégories →</a>
    </div>
</section>



<!-- Nouvelle Section Contenus populaires -->
<section class="popular-section">
    <h2>Contenus populaires</h2>
    <p>Découvre les éléments les plus appréciés par nos petits explorateurs !</p>
    
    <div class="popular-grid">
        <?php foreach ($popularItems as $item): ?>
            <a href="client_media.php?element_id=<?= $item['id'] ?>" class="popular-card">
                <div class="popular-badge">Populaire</div>
                <?php 
                // Vous devrez adapter ce chemin selon votre structure de fichiers
                $imagePath = "uploads/elements/" . strtolower(str_replace(' ', '-', $item['titre'])) . ".jpg";
                ?>
                <img src="<?= file_exists($imagePath) ? $imagePath : 'uploads/default-element.gif' ?>" alt="<?= $item['titre'] ?>">
                <div class="popular-content">
                    <h3><?= $item['titre'] ?></h3>
                    <span class="popular-category"><?= $item['categorie_nom'] ?></span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'client_footer.php'; ?> 

<style>
/* Styles pour la nouvelle section populaire */
.popular-section {
    padding: 40px 20px;
    background-color: #f9f9f9;
    text-align: center;
}

.popular-section h2 {
    font-size: 2rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.popular-section p {
    color: #7f8c8d;
    margin-bottom: 30px;
}

.popular-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.popular-card {
    position: relative;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.popular-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.popular-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.popular-content {
    padding: 15px;
    text-align: left;
}

.popular-content h3 {
    margin: 0 0 5px 0;
    font-size: 1.2rem;
    color: #2c3e50;
}

.popular-category {
    display: inline-block;
    padding: 3px 8px;
    background-color: #e1f5fe;
    color: #0288d1;
    border-radius: 12px;
    font-size: 0.8rem;
}

.popular-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #ff5722;
    color: white;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: bold;
}

@media (max-width: 768px) {
    .popular-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .popular-grid {
        grid-template-columns: 1fr;
    }
}
</style>
