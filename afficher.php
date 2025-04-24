<?php
error_reporting(E_ERROR);
require 'admin.php'; 

$db = Database::getInstance()->getConnection();
$sql = "
    SELECT 
        m.id AS media_id,
        m.titre AS media_titre,
        m.typee,
        m.chemin_fichier,
        e.titre AS element_titre,
        c.nom AS categorie_nom,
        m.date_creation
    FROM medias m
    JOIN elements e ON m.element_id = e.id
    JOIN categories c ON e.categorie_id = c.id
    ORDER BY m.date_creation DESC
";
$result = $db->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .container {
            width: 90%;
            margin: 20px auto;
            text-align: center;
        }
        
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 100%;
            max-width: 1200px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: 500;
        }
        
        th, td {
            padding: 12px;
            border: 1px solid #dee2e6;
            font-size: 14px;
        }
        
        .btn-back {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .btn-edit, .btn-delete {
            padding: 8px 16px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-edit {
            background-color: #2196F3;
            color: white;
            text-decoration: none;
        }
        
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        
        .btn-edit:hover, .btn-delete:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin_interface.php" class="btn-back">Retour à l'accueil</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Fichier</th>
                    <th>Élément</th>
                    <th>Catégorie</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_object()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row->media_id) ?></td>
                        <td><?= htmlspecialchars($row->media_titre) ?></td>
                        <td><?= htmlspecialchars($row->typee) ?></td>
                        <td>
                            <?php if ($row->typee === 'image'): ?>
                                <img src="uploads/<?= htmlspecialchars($row->chemin_fichier) ?>" alt="media" style="width:60px;height:60px;">
                            <?php else: ?>
                                <a href="uploads/<?= htmlspecialchars($row->chemin_fichier) ?>" target="_blank">Voir</a>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row->element_titre) ?></td>
                        <td><?= htmlspecialchars($row->categorie_nom) ?></td>
                        <td><?= htmlspecialchars($row->date_creation) ?></td>
                        <td>
                            <a href="modifier.php?id=<?= htmlspecialchars($row->media_id) ?>" class="btn-edit">Modifier</a>
                            <form action="traitement.php" method="post" style="display:inline;">
                                <input type="hidden" name="id_suppression" value="<?= htmlspecialchars($row->media_id) ?>">
                                <input type="hidden" name="type_suppression" value="media">
                                <button type="submit" name="supprimer" class="btn-delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>