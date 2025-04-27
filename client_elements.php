<?php
require_once 'Database.php';
$db = Database::getInstance();
$conn = $db->getConnection();

$categorie_id = isset($_GET['categorie_id']) ? intval($_GET['categorie_id']) : 0;

if ($categorie_id === 0) {
    header('Location: client_categories.php');
    exit;
}

// Récupération de la catégorie à partir de l'ID
$query = "SELECT *, nom AS nom_categorie FROM categories WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $categorie_id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

if (!$category) {
    header('Location: client_categories.php');
    exit;
}

// Récupération des éléments de la catégorie
$query = "SELECT * FROM elements WHERE categorie_id = ? ORDER BY titre";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $categorie_id);
$stmt->execute();
$result = $stmt->get_result();
$elements = [];
while ($row = $result->fetch_assoc()) {
    $elements[$row['id']] = $row;
    $elements[$row['id']]['medias'] = [
        'image' => [],
        'audio' => [],
        'video' => []
    ];
}

// Récupération des médias associés à chaque élément
if (count($elements) > 0) {
    $ids_string = implode(',', array_keys($elements));
    $query = "SELECT * FROM medias WHERE element_id IN ($ids_string) ORDER BY date_creation";
    $result = $conn->query($query);

    while ($media = $result->fetch_assoc()) {
        $elements[$media['element_id']]['medias'][$media['typee']][] = $media;
    }
}

$pageTitle = $category['nom_categorie'];
include 'client_header.php';
?>
<!-- Page HTML des éléments -->
<div class="page-banner category-specific-banner" style="background-color: <?= !empty($category['color']) ? $category['color'] : '#4ab1ff'; ?>">
    <h1><?= $category['nom_categorie']; ?></h1>
    <?php if (!empty($category['description'])): ?>
        <p><?= $category['description']; ?></p>
    <?php endif; ?>
    <a href="client_categories.php" class="btn-back">← Retour aux catégories</a>
</div>

<section class="elements-container">
    <div class="elements-grid">
        <?php if (count($elements) > 0): ?>
            <?php foreach ($elements as $element): ?>
                <div class="element-card">
                    <div class="element-header">
                        <?php if (!empty($element['image'])): ?>
                            <img src="uploads/elements/<?= $element['image']; ?>" alt="<?= $element['titre']; ?>">
                        <?php elseif (!empty($element['medias']['image'])): ?>
                            <img src="uploads/<?= $element['medias']['image'][0]['chemin_fichier']; ?>" alt="<?= $element['titre']; ?>">
                        <?php else: ?>
                            <div class="no-image"><span><?= substr($element['titre'], 0, 1); ?></span></div>
                        <?php endif; ?>
                    </div>
                    <div class="element-content">
                        <h3>
                            <a href="client_media.php?element_id=<?= $element['id']; ?>">
                                <?= $element['titre']; ?>
                            </a>
                        </h3>
                        <?php if (!empty($element['description'])): ?>
                            <p class="element-description"><?= $element['description']; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-content">
                <h3>Aucun élément disponible dans cette catégorie</h3>
                <p>Reviens bientôt pour découvrir du nouveau contenu !</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'client_footer.php'; ?>
