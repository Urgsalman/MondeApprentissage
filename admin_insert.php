

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter du Contenu - Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 30px;
        }
        .form-section {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        h2 {
            color: #333;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            font-weight: bold;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

    <div class="form-section">
        <h2>Ajouter une Catégorie</h2>
        <form action="traitement.php" method="POST" enctype="multipart/form-data">
            <label>Nom :</label>
            <input type="text" name="categorie_nom" required>
            
            <label>Image (facultatif) :</label>
            <input type="file" name="categorie_image">
            
            <input type="submit" name="ajouter_categorie" value="Ajouter Catégorie">
        </form>
    </div>

    <div class="form-section">
        <h2>Ajouter un Élément</h2>
        <form action="traitement.php" method="POST">
            <label>Catégorie :</label>
            <select name="categorie_id" required>
                <?php
                require_once 'Database.php';
                $db = Database::getInstance()->getConnection();
                $result = $db->query("SELECT * FROM categories");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nom']}</option>";
                }
                ?>
            </select>

            <label>Titre :</label>
            <input type="text" name="element_titre" required>

            <label>Description :</label>
            <textarea name="element_description"></textarea>

            <input type="submit" name="ajouter_element" value="Ajouter Élément">
        </form>
    </div>

    <div class="form-section">
        <h2>Ajouter un Média</h2>
        <form action="traitement.php" method="POST" enctype="multipart/form-data">
            <label>Élément :</label>
            <select name="element_id" required>
                <?php
                $result = $db->query("SELECT * FROM elements");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['titre']}</option>";
                }
                ?>
            </select>

            <label>Type :</label>
            <select name="media_typee" required>
                <option value="image">Image</option>
                <option value="audio">Audio</option>
                <option value="video">Vidéo</option>
            </select>

            <label>Fichier :</label>
            <input type="file" name="media_fichier" required>

            <label>Titre (facultatif) :</label>
            <input type="text" name="media_titre">

            <input type="submit" name="ajouter_media" value="Ajouter Média">
        </form>
    </div>

</body>
</html>
