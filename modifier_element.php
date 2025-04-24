<?php
require 'admin.php';
$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $element_id = $_POST['element_id'];
    $categorie_id = $_POST['categorie_id'];
    $element = new Element($categorie_id, $titre, $description);
    $element->miseajour($element_id);
    echo "Élément mis à jour.";
}

$elements = $db->query("SELECT * FROM elements");
$categories = $db->query("SELECT * FROM categories");
?>
<form method="post">
    <h2>Modifier un élément</h2>
    <label>Élément :
        <select name="element_id">
            <?php while ($el = $elements->fetch_assoc()): ?>
                <option value="<?= $el['id'] ?>"><?= $el['titre'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>
    <label>Nouveau titre : <input type="text" name="titre"></label><br>
    <label>Description : <input type="text" name="description"></label><br>
    <label>Catégorie :
        <select name="categorie_id">
            <?php while ($cat = $categories->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>
    <input type="submit" value="Mettre à jour">
</form>
