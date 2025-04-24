<?php
require 'admin.php';

$media = null;
$elements = [];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $db = Database::getInstance()->getConnection();

    // Récupération du média
    $result = $db->query("SELECT * FROM medias WHERE id = $id");
    $media = $result->fetch_assoc();

    if (!$media) {
        echo "Aucun média trouvé avec l'ID : " . $id;
        exit;
    }

    // Récupération des éléments pour le menu déroulant
    $res = $db->query("SELECT id, titre FROM elements");
    while ($row = $res->fetch_assoc()) {
        $elements[] = $row;
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $element_id = intval($_POST['element_id']);
    $typee = $_POST['typee'];
    $titre = $_POST['titre'];

    // Gestion du fichier uploadé
    $chemin_fichier = $_POST['chemin_fichier_existant']; // Par défaut
    if (isset($_FILES['chemin_fichier']) && $_FILES['chemin_fichier']['error'] == 0) {
        $chemin_fichier = 'uploads/' . basename($_FILES['chemin_fichier']['name']);
        move_uploaded_file($_FILES['chemin_fichier']['tmp_name'], $chemin_fichier);
    }

    $media_obj = new Media($element_id, $typee, $chemin_fichier, $titre);
    $media_obj->miseajour($id);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Média</title>
</head>
<body>
    <h3>ID à mettre à jour : <?= htmlspecialchars($media['id']) ?></h3>
    <h2>Modifier Média</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($media['id']) ?>">
        <input type="hidden" name="chemin_fichier_existant" value="<?= htmlspecialchars($media['chemin_fichier']) ?>">

        <label>Élément :
            <select name="element_id">
                <?php foreach ($elements as $el): ?>
                    <option value="<?= $el['id'] ?>" <?= $el['id'] == $media['element_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($el['titre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <label>Type :
            <select name="typee">
                <option value="image" <?= $media['typee'] == 'image' ? 'selected' : '' ?>>Image</option>
                <option value="audio" <?= $media['typee'] == 'audio' ? 'selected' : '' ?>>Audio</option>
                <option value="video" <?= $media['typee'] == 'video' ? 'selected' : '' ?>>Vidéo</option>
            </select>
        </label><br><br>

        <label>Titre : <input type="text" name="titre" value="<?= htmlspecialchars($media['titre']) ?>"></label><br><br>

        <label>Fichier : <input type="file" name="chemin_fichier"></label><br>
        <small>Fichier actuel : <?= htmlspecialchars($media['chemin_fichier']) ?></small><br><br>

        <input type="submit" value="Mettre à jour">
    </form>
</body>
</html>
