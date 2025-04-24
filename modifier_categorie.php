<?php
require 'admin.php';
$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
	$chemin_fichier = $_POST['chemin_fichier_existant']; // Par défaut
	$chemin_fichier = $_POST['chemin_fichier_existant']; // Par défaut
	if (isset($_FILES['chemin_fichier']) && $_FILES['chemin_fichier']['error'] == 0) {
		// Sécuriser le nom du fichier et définir le chemin d'upload
		$target_dir = 'uploads/';
		$file_info = pathinfo($_FILES['chemin_fichier']['name']);
		$chemin_fichier = $target_dir . basename($file_info['basename']);
		
		// Déplacer le fichier dans le répertoire 'uploads'
		if (move_uploaded_file($_FILES['chemin_fichier']['tmp_name'], $chemin_fichier)) {
			// Le fichier a bien été téléchargé
			$image = $chemin_fichier;
		} else {
			// Gestion d'erreur si le fichier n'a pas pu être déplacé
			echo 'Erreur lors de l\'upload du fichier.';
		}
	} else {
		// Si aucun fichier n'est envoyé, conserver le chemin par défaut
		$image = $chemin_fichier;
	}
    $categorie_id = $_POST['categorie_id'];
    $categorie = new Categorie($nom, $image);
    $categorie->miseajour($categorie_id);
    echo "Catégorie mise à jour.";
}

$result = $db->query("SELECT * FROM categories");
?>
<form method="post">
    <h2>Modifier une catégorie</h2>
    <label>Catégorie :
        <select name="categorie_id">
            <?php while ($cat = $result->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>
    <label>Nouveau nom : <input type="text" name="nom"></label><br>
    <label>Nouvelle image : <input type="file" name="image"></label><br>
    <input type="submit" value="Mettre à jour">
</form>
