<?php
require_once 'Database.php';
$db = Database::getInstance();
$conn = $db->getConnection();

// Requête sql simplifiée pour récupérer les catégories et les éléments
$query = "SELECT * FROM categories ORDER BY nom";
$result = $conn->query($query);

if ($result === false) die("Erreur de requête: " . $conn->error);

$categories = $result->fetch_all(MYSQLI_ASSOC);

// Comptage des éléments avec réinitialisation de la référence
foreach ($categories as &$category) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM elements WHERE categorie_id = ?");
    $stmt->bind_param("i", $category['id']);
    $stmt->execute();
    $count = $stmt->get_result()->fetch_assoc()['count'];
    $category['elements_count'] = $count;
    $stmt->close();
}
unset($category); 

include 'client_header.php';

// Définition des couleurs par catégorie
$categoryColors = [
    'Animaux' => '#FF9E7D',
    'Transports' => '#4AB1FF',
    'Nombres' => '#58D68D',
    'Couleurs' => '#F4D03F',
    'Lettres' => '#BB8FCE',
    'Formes' => '#F1948A',
    'Nature' => '#48C9B0'
];
?>
<!-- Page HTML d'accueil des catégories -->
<div class="page-banner">
    <h1>Explore toutes nos catégories</h1>
    <p>Choisis une catégorie et commence ton aventure d'apprentissage !</p>
</div>

<section class="categories-full">
    <div class="categories-grid">
        <?php foreach ($categories as $cat): 
            $color = $categoryColors[$cat['nom']] ?? '#4AB1FF'; 
            $slug = strtolower(str_replace(' ', '-', $cat['nom']));
        ?>
            <div class="category-card category-<?= $slug ?>">
    <a href="client_elements.php?categorie_id=<?= $cat['id'] ?>" class="category-link">
        <?php if (!empty($cat['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($cat['image']) ?>" alt="<?= htmlspecialchars($cat['nom']) ?>">
        <?php else: ?>
            <div class="no-image"><span><?= substr($cat['nom'], 0, 1) ?></span></div>
        <?php endif; ?>
        <div class="category-content">
            <h3 class="category-title"><?= htmlspecialchars($cat['nom']) ?></h3>
            <div class="category-stats">
                <?= $cat['elements_count'] ?> élément<?= $cat['elements_count'] > 1 ? 's' : '' ?>
            </div>
            <span class="explore-btn" style="background-color: <?= $color ?>">
                Explorer <span class="icon">→</span>
            </span>
        </div>
    </a>
</div>
        <?php endforeach; ?>
    </div>
</section>

<style>
/* Styles spécifiques pour la page des catégories */
.category-card {
    position: relative;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.category-content {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.category-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.category-card:hover img {
    transform: scale(1.05);
}

.no-image {
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    font-size: 3rem;
    font-weight: bold;
    color: #4ab1ff;
}

.category-stats {
    margin: 10px 0;
    font-size: 0.9rem;
    color: #666;
}

/* Style pour le bouton Explorer */
.explore-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    margin-top: auto;
    color: white;
    font-weight: bold;
    text-decoration: none;
    border-radius: 30px;
    transition: all 0.3s ease;
    width: fit-content;
    align-self: center;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    border: none;
    cursor: pointer;
}

.explore-btn .icon {
    margin-left: 8px;
    transition: transform 0.3s ease;
}

.category-card:hover .explore-btn .icon {
    transform: translateX(5px);
}

/* Effet de vague au survol(hover) */
.explore-btn {
    position: relative;
    overflow: hidden;
}

.explore-btn::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -60%;
    width: 200%;
    height: 200%;
    background: rgba(255,255,255,0.2);
    transform: rotate(30deg);
    transition: all 0.6s ease;
}

.category-card:hover .explore-btn::after {
    left: 100%;
}

/* Dégradés spécifiques par catégorie */
.category-animaux .explore-btn {
    background: linear-gradient(135deg, #FF9E7D 0%, #FF6B6B 100%) !important;
}

.category-transports .explore-btn {
    background: linear-gradient(135deg, #4AB1FF 0%, #2D87D3 100%) !important;
}

.category-nombres .explore-btn {
    background: linear-gradient(135deg, #58D68D 0%, #28B463 100%) !important;
}

.category-couleurs .explore-btn {
    background: linear-gradient(135deg, #F4D03F 0%, #F39C12 100%) !important;
}

.category-lettres .explore-btn {
    background: linear-gradient(135deg, #BB8FCE 0%, #9B59B6 100%) !important;
}
</style>

<?php include 'client_footer.php'; ?>