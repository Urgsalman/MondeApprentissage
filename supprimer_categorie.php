<?php
require 'admin.php';
$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    Categorie::supprimer($_POST['categorie_id']);
    echo "Catégorie supprimée.";
}

$result = $db->query("SELECT * FROM categories");
?>
<form method="post">
    <h2>Supprimer une catégorie</h2>
    <select name="categorie_id">
        <?php while ($cat = $result->fetch_assoc()): ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['nom'] ?></option>
        <?php endwhile; ?>
    </select>
    <input type="submit" value="Supprimer">
</form>
