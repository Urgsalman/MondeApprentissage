<?php
error_reporting(E_ERROR);
require 'admin.php'; // classes Media, Element, Categorie

$db = Database::getInstance()->getConnection();
$sql = "
    SELECT 
        m.id AS media_id,
        m.titre AS media_titre,
        m.typee,
        m.chemin_fichier,
        e.titre AS element_titre,
        c.nom AS categorie_nom
    FROM medias m
    JOIN elements e ON m.element_id = e.id
    JOIN categories c ON e.categorie_id = c.id
    ORDER BY m.date_creation DESC
";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface Admin</title>
    <style>
        body { font-family: sans-serif; background: #f9f9f9; padding: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #f0f0f0; }
        img { width: 60px; height: 60px; object-fit: cover; }
        .btns button {
            padding: 6px 12px;
            margin-right: 5px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
        .delete-btn { background: #e74c3c; color: white; }
        .edit-btn { background: #3498db; color: white; }
    </style>
</head>
<body>
    <h1>Tableau de gestion des médias</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Type</th>
                <th>Fichier</th>
                <th>Élément</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_object()): ?>
                <tr>
                    <td><?= $row->media_id ?></td>
                    <td><?= $row->media_titre ?></td>
                    <td><?= $row->typee ?></td>
                    <td>
                        <?php if ($row->typee === 'image'): ?>
                            <img src="uploads/<?= $row->chemin_fichier ?>" alt="media">
                        <?php else: ?>
                            <a href="uploads/<?= $row->chemin_fichier ?>" target="_blank">Voir</a>
                        <?php endif; ?>
                    </td>
                    <td><?= $row->element_titre ?></td>
                    <td><?= $row->categorie_nom ?></td>
                    <td class="btns">
                        <form action="traitement.php" method="post" style="display:inline;">
                            <input type="hidden" name="id_suppression" value="<?= $row->media_id ?>">
                            <input type="hidden" name="type_suppression" value="media">
                            <button type="submit" name="supprimer" class="delete-btn">Supprimer</button>
                        </form>
                        <form action="modifier.php" method="get" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row->media_id ?>">
                            <button type="submit" class="edit-btn">Modifier</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
