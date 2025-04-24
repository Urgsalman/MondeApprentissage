

<?php
error_reporting(E_ERROR);
require_once 'admin.php';

if (isset($_POST['ajouter_categorie'])) {
    $nom = $_POST['categorie_nom'];
    $image = null;

    if (isset($_FILES['categorie_image']) && $_FILES['categorie_image']['error'] === 0) {
        $tmp = $_FILES['categorie_image']['tmp_name'];
        $fichier = basename($_FILES['categorie_image']['name']);
        $destination = "uploads/" . $fichier;
        move_uploaded_file($tmp, $destination);
        $image = $fichier;
    }

    $cat = new Categorie($nom, $image);
    $cat->inserer();
    header("Location: admin_insert.php");
    exit;
}

if (isset($_POST['ajouter_element'])) {
    $categorie_id = $_POST['categorie_id'];
    $titre = $_POST['element_titre'];
    $description = $_POST['element_description'];

    $element = new Element($categorie_id, $titre, $description);
    $element->inserer();
    header("Location: admin_insert.php");
    exit;
}

if (isset($_POST['ajouter_media'])) {
    $element_id = $_POST['element_id'];
    $typee = $_POST['media_typee'];
    $titre = $_POST['media_titre'];
    $fichier = null;

    if (isset($_FILES['media_fichier']) && $_FILES['media_fichier']['error'] === 0) {
        $tmp = $_FILES['media_fichier']['tmp_name'];
        $fichier = basename($_FILES['media_fichier']['name']);
        $destination = "uploads/" . $fichier;
        move_uploaded_file($tmp, $destination);
    }

    if ($fichier) {
        $media = new Media($element_id, $typee, $fichier, $titre);
        $media->inserer();
    }

    header("Location: admin_insert.php");
    exit;
}

if (isset($_POST['supprimer'])) {
    $type = $_POST['type_suppression'];
    $id = intval($_POST['id_suppression']);

    if ($type === 'categorie') {
        Categorie::supprimer($id);
    } elseif ($type === 'element') {
        Element::supprimer($id);
    } elseif ($type === 'media') {
        Media::supprimer($id);
    }

    header("Location: admin_delete.php?deleted=1");
    exit;
}

?>
