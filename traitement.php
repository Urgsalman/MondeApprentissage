

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
    $id = (int)$_POST['id_suppression'];

    switch ($type) {
		case 'categorie':
			$id = (int)$_POST['id_suppression_categorie'];
			Categorie::supprimer($id);
			echo "Catégorie supprimée.";
			break;
		case 'element':
			$id = (int)$_POST['id_suppression_element'];
			Element::supprimer($id);
			echo "Élément supprimé.";
			break;
		case 'media':
			$id = (int)$_POST['id_suppression_media'];
			Media::supprimer($id);
			echo "Média supprimé.";
			break;
		default:
			echo "Type de suppression invalide.";
	}
} else {
    echo "<p style='color: red;'>Aucune action à effectuer.</p>";
}

?>
