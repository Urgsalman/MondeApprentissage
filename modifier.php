<?php
error_reporting(E_ERROR);
require 'admin.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = intval($_GET['id']);
    $db = Database::getInstance()->getConnection();

    if ($type == 'media') {
        $query = "SELECT * FROM medias WHERE id = $id";
        $result = $db->query($query);
        $media = $result->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'media') {
        $media = new Media($_POST['element_id'], $_POST['typee'], $_POST['chemin_fichier'], $_POST['titre']);
        $media->miseajour($_POST['id']);
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Média</title>
</head>
<body>
<h2>Modifier Média</h2>
<form method="post">
    <input type="hidden" name="id" value="<?= $media['id'] ?>">
    <input type="hidden" name="type" value="media">
    <label>Element ID: <input type="number" name="element_id" value="<?= $media['element_id'] ?>"></label><br>
    <label>Type: 
        <select name="typee">
            <option value="image" <?= $media['typee'] == 'image' ? 'selected' : '' ?>>Image</option>
            <option value="audio" <?= $media['typee'] == 'audio' ? 'selected' : '' ?>>Audio</option>
            <option value="video" <?= $media['typee'] == 'video' ? 'selected' : '' ?>>Video</option>
        </select>
    </label><br>
    <label>Chemin du fichier: <input type="text" name="chemin_fichier" value="<?= $media['chemin_fichier'] ?>"></label><br>
    <label>Titre: <input type="text" name="titre" value="<?= $media['titre'] ?>"></label><br>
    <input type="submit" value="Mettre à jour">
</form>
</body>
</html>
