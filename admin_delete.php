<?php
require 'admin.php';
$db = Database::getInstance()->getConnection();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer du contenu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            padding: 2rem;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }

        select {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
            text-align: center;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
            margin-top: 1rem;
        }

        .btn-back {
            background-color: #2196F3;
            color: white;
            margin-top: 1rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Suppression de contenu</h1>

        <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
            <div class="success-message">Le contenu a été supprimé avec succès.</div>
        <?php endif; ?>

        <form action="traitement.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">
            <h2>Sélectionnez le type de contenu à supprimer</h2>

            <div>
                <label for="type">Type de contenu :</label>
                <select name="type_suppression" id="type" onchange="showSelect(this.value)" required>
                    <option value="">-- Choisir --</option>
                    <option value="categorie">Catégorie</option>
                    <option value="element">Élément</option>
                    <option value="media">Média</option>
                </select>
            </div>

            <div id="categorie-select" style="display: none;">
                <label>Choisir une catégorie :</label>
                <select name="id_suppression" required>
                    <?php
                    $res = $db->query("SELECT id, nom FROM categories ORDER BY nom");
                    while ($row = $res->fetch_object()) {
                        echo "<option value='" . htmlspecialchars($row->id) . "'>" . 
                             htmlspecialchars("[{$row->id}] {$row->nom}") . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div id="element-select" style="display: none;">
                <label>Choisir un élément :</label>
                <select name="id_suppression" required>
                    <?php
                    $res = $db->query("SELECT id, titre FROM elements ORDER BY titre");
                    while ($row = $res->fetch_object()) {
                        echo "<option value='" . htmlspecialchars($row->id) . "'>" . 
                             htmlspecialchars("[{$row->id}] {$row->titre}") . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div id="media-select" style="display: none;">
                <label>Choisir un média :</label>
                <select name="id_suppression" required>
                    <?php
                    $res = $db->query("SELECT id, titre FROM medias ORDER BY titre");
                    while ($row = $res->fetch_object()) {
                        $titre = $row->titre ?: "(sans titre)";
                        echo "<option value='" . htmlspecialchars($row->id) . "'>" . 
                             htmlspecialchars("[{$row->id}] {$titre}") . "</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="supprimer" class="btn btn-delete">Supprimer</button>
        </form>
        <a href="index.php" class="btn btn-back">Retour à l'accueil</a>
    </div>

    <script>
    function showSelect(type) {
        const selects = ['categorie-select', 'element-select', 'media-select'];
        selects.forEach(id => {
            document.getElementById(id).style.display = 'none';
        });
        
        if (type) {
            document.getElementById(type + '-select').style.display = 'block';
        }
    }
    </script>
</body>
</html>