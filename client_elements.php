<?php
require_once 'Database.php';
$db = Database::getInstance();
$conn = $db->getConnection();

$categorie_id = isset($_GET['categorie_id']) ? intval($_GET['categorie_id']) : 0;

if ($categorie_id === 0) {
    header('Location: client_categories.php');
    exit;
}

// Récupération des informations de la catégorie
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

// Si nous avons des éléments, récupérons leurs médias associés
if (count($elements) > 0) {
    $element_ids = array_keys($elements);
    $ids_string = implode(',', $element_ids);
    
    $query = "SELECT * FROM medias WHERE element_id IN ($ids_string) ORDER BY date_creation";
    $result = $conn->query($query);
    
    while ($media = $result->fetch_assoc()) {
        $element_id = $media['element_id'];
        $type = $media['typee']; // Utilisation du champ 'typee' de la table medias
        $elements[$element_id]['medias'][$type][] = $media;
    }
}

$pageTitle = $category['nom_categorie'];
include 'client_header.php';
?>

<div class="page-banner category-specific-banner" style="background-color: <?php echo !empty($category['color']) ? $category['color'] : '#4ab1ff'; ?>">
    <h1><?php echo $category['nom_categorie']; ?></h1>
    <?php if (!empty($category['description'])): ?>
        <p><?php echo $category['description']; ?></p>
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
                            <img src="uploads/elements/<?php echo $element['image']; ?>" alt="<?php echo $element['titre']; ?>">
                        <?php elseif (!empty($element['medias']['image'])): ?>
                            <img src="uploads/<?php echo $element['medias']['image'][0]['chemin_fichier']; ?>" alt="<?php echo $element['titre']; ?>">
                        <?php else: ?>
                            <div class="no-image">
                                <span><?php echo substr($element['titre'], 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="element-content">
                        <h3><?php echo $element['titre']; ?></h3>
                        
                        <?php if (!empty($element['description'])): ?>
                            <p class="element-description"><?php echo $element['description']; ?></p>
                        <?php endif; ?>
                        
                        <div class="element-media">
                            <?php if (!empty($element['medias']['audio'])): ?>
                                <div class="audio-players">
                                    <h4>Écoute :</h4>
                                    <?php foreach($element['medias']['audio'] as $index => $audio): ?>
                                        <div class="audio-player">
                                            <?php if (!empty($audio['titre'])): ?>
                                                <p class="media-title"><?php echo $audio['titre']; ?></p>
                                            <?php endif; ?>
                                            <audio controls>
                                                <source src="uploads/<?php echo $audio['chemin_fichier']; ?>" type="audio/mpeg">
                                                Ton navigateur ne supporte pas l'audio.
                                            </audio>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($element['medias']['video'])): ?>
                                <div class="video-players">
                                    <h4>Regarde :</h4>
                                    <?php foreach($element['medias']['video'] as $index => $video): ?>
                                        <div class="video-player">
                                            <?php if (!empty($video['titre'])): ?>
                                                <p class="media-title"><?php echo $video['titre']; ?></p>
                                            <?php endif; ?>
                                            <video controls width="100%">
                                                <source src="uploads/<?php echo $video['chemin_fichier']; ?>" type="video/mp4">
                                                Ton navigateur ne supporte pas la vidéo.
                                            </video>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($element['medias']['image']) && count($element['medias']['image']) > 1): ?>
                                <div class="image-gallery">
                                    <h4>Images :</h4>
                                    <div class="gallery-grid">
                                        <?php foreach($element['medias']['image'] as $index => $image): ?>
                                            <div class="gallery-item">
                                                <img src="uploads/<?php echo $image['chemin_fichier']; ?>" 
                                                     alt="<?php echo !empty($image['titre']) ? $image['titre'] : $element['titre']; ?>">
                                                <?php if (!empty($image['titre'])): ?>
                                                    <p class="media-title"><?php echo $image['titre']; ?></p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
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

<?php
include 'client_footer.php';
?>