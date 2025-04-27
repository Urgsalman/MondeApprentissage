<?php
require_once 'Database.php';
$db = Database::getInstance();
$conn = $db->getConnection();

$element_id = isset($_GET['element_id']) ? intval($_GET['element_id']) : 0;

if ($element_id === 0) {
    header('Location: client_categories.php');
    exit;
}

// Récupération de l'élément à partir de l'ID
$query = "SELECT * FROM elements WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $element_id);
$stmt->execute();
$result = $stmt->get_result();
$element = $result->fetch_assoc();

if (!$element) {
    header('Location: client_categories.php');
    exit;
}

// Récupération des médias associés à l'élément
$query = "SELECT * FROM medias WHERE element_id = ? ORDER BY date_creation";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $element_id);
$stmt->execute();
$result = $stmt->get_result();

$medias = ['image' => [], 'audio' => [], 'video' => []];
while ($media = $result->fetch_assoc()) {
    $medias[$media['typee']][] = $media;
}

$pageTitle = $element['titre'];
include 'client_header.php';
?>

<style>
.media-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(8px);
    background-color: rgba(0, 0, 0, 0.4);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
}
.media-iframe {
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    max-width: 800px;
    width: 90%;
    max-height: 90%;
    overflow-y: auto;
}
.media-iframe h2 {
    margin-top: 0;
}
.media-iframe audio,
.media-iframe video {
    width: 100%;
    margin-bottom: 20px;
}
.media-iframe img {
    max-width: 100%;
    display: block;
    margin-bottom: 10px;
}
.back-btn {
    display: inline-block;
    margin-bottom: 15px;
    background-color: #4ab1ff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 12px;
}
</style>

<div class="media-overlay">
    <div class="media-iframe">
        <a class="back-btn" href="javascript:history.back()">← Retour</a>
        <h2><?= $element['titre']; ?></h2>
        <?php if (!empty($element['description'])): ?>
            <p><?= $element['description']; ?></p>
        <?php endif; ?>

        <?php foreach ($medias['image'] as $img): ?>
            <img src="uploads/<?= $img['chemin_fichier']; ?>" alt="<?= $img['titre']; ?>">
        <?php endforeach; ?>

        <?php foreach ($medias['audio'] as $audio): ?>
            <audio controls>
                <source src="uploads/<?= $audio['chemin_fichier']; ?>" type="audio/mpeg">
                Ton navigateur ne supporte pas l'audio.
            </audio>
            <?php if (!empty($audio['titre'])): ?><p><?= $audio['titre']; ?></p><?php endif; ?>
        <?php endforeach; ?>

        <?php foreach ($medias['video'] as $video): ?>
            <video controls>
                <source src="uploads/<?= $video['chemin_fichier']; ?>" type="video/mp4">
                Ton navigateur ne supporte pas la vidéo.
            </video>
            <?php if (!empty($video['titre'])): ?><p><?= $video['titre']; ?></p><?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'client_footer.php'; ?>
