<?php
require 'admin.php';
$db = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    Element::supprimer($_POST['element_id']);
    echo "Élément supprimé.";
}

$result = $db->query("SELECT * FROM elements");
?>
<form method="post">
    <h2>Supprimer un élément</h2>
    <select name="element_id">
        <?php while ($el = $result->fetch_assoc()): ?>
            <option value="<?= $el['id'] ?>"><?= $el['titre'] ?></option>
        <?php endwhile; ?>
    </select>
    <input type="submit" value="Supprimer">
</form>
