<?php
require_once 'Database.php';
$db = Database::getInstance();
$conn = $db->getConnection();

// Récupération de toutes les catégories
$query = "SELECT *, nom AS nom_categorie FROM categories ORDER BY nom";
$result = $conn->query($query);

if ($result === false) {
    die("Erreur de requête: " . $conn->error);
}

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

// Pour chaque catégorie, compter le nombre d'éléments
foreach ($categories as &$category) {
    $query = "SELECT COUNT(*) as count FROM elements WHERE categorie_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc();
    $category['elements_count'] = $count['count'];
}

$pageTitle = "Toutes les catégories";
include 'client_header.php';
?>

<div class="page-banner">
    <h1>Explore toutes nos catégories</h1>
    <p>Choisis une catégorie et commence ton aventure d'apprentissage !</p>
</div>

<!-- Code de débogage temporaire - À supprimer après résolution du problème -->
<div style="background-color: #f8f9fa; padding: 10px; margin: 10px 0; border: 1px solid #ddd; display: none;">
    <h3>Débogage des images de catégories</h3>
    <?php foreach ($categories as $cat): ?>
        <p>Catégorie: <?php echo $cat['nom_categorie']; ?>, 
           Image: '<?php echo $cat['image']; ?>', 
           Chemin complet: <?php echo file_exists('uploads/'.$cat['image']) ? 'Existe' : 'N\'existe pas'; ?>
        </p>
    <?php endforeach; ?>
</div>
<!-- Fin du code de débogage -->

<section class="categories-full">
    <div class="categories-grid">
        <?php if (count($categories) > 0): ?>
            <?php foreach ($categories as $category): ?>
                <div class="category-card">
                    <a href="client_elements.php?categorie_id=<?php echo $category['id']; ?>">
                        <?php if (!empty($category['image']) && file_exists('uploads/'.$category['image'])): ?>
                            <img src="uploads/<?php echo $category['image']; ?>" alt="<?php echo $category['nom_categorie']; ?>">
                        <?php else: ?>
                            <div class="no-image" style="background-color: <?php echo !empty($category['color']) ? $category['color'] : '#4ab1ff'; ?>">
                                <span><?php echo substr($category['nom_categorie'], 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                        <h3><?php echo $category['nom_categorie']; ?></h3>
                        <?php if (!empty($category['description'])): ?>
                            <p class="category-description"><?php echo $category['description']; ?></p>
                        <?php endif; ?>
                        <div class="category-stats">
                            <span class="elements-count"><?php echo $category['elements_count']; ?> élément<?php echo $category['elements_count'] > 1 ? 's' : ''; ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-content">
                <h3>Aucune catégorie disponible pour le moment</h3>
                <p>Reviens bientôt pour découvrir du nouveau contenu !</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
include 'client_footer.php';
?>