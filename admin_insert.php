<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter du contenu</title>
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

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .form-section {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-section h2 {
            color: #2196F3;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        form div {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }

        input[type="text"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2196F3;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            background-color: #2196F3;
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }

        .btn-back {
            background-color: #4CAF50;
            display: block;
            width: fit-content;
            margin: 2rem auto;
        }

        .btn-back:hover {
            background-color: #45a049;
        }

        select {
            background-color: white;
            cursor: pointer;
        }

        input[type="file"] {
            padding: 0.5rem;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .form-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
<a href="admin_interface.php" class="btn btn-back">Retour à l'accueil</a>
<h1>Ajouter du contenu</h1>

<div class="form-section">
    <h2>Ajouter une Catégorie</h2>
    <form action="traitement.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="categorie_nom">Nom :</label>
            <input type="text" id="categorie_nom" name="categorie_nom" required>
        </div>
        
        <div>
            <label for="categorie_image">Image (facultatif) :</label>
            <input type="file" id="categorie_image" name="categorie_image">
        </div>
        
        <input type="submit" name="ajouter_categorie" value="Ajouter Catégorie" class="btn">
    </form>
</div>

<div class="form-section">
    <h2>Ajouter un Élément</h2>
    <form action="traitement.php" method="POST">
        <div>
            <label for="categorie_id">Catégorie :</label>
            <select id="categorie_id" name="categorie_id" required>
                <?php
				require_once 'Database.php';
                $db = Database::getInstance()->getConnection();
                $result = $db->query("SELECT * FROM categories");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nom']}</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <label for="element_titre">Titre :</label>
            <input type="text" id="element_titre" name="element_titre" required>
        </div>

        <div>
            <label for="element_description">Description :</label>
            <textarea id="element_description" name="element_description"></textarea>
        </div>

        <input type="submit" name="ajouter_element" value="Ajouter Élément" class="btn">
    </form>
</div>

<div class="form-section">
    <h2>Ajouter un Média</h2>
    <form action="traitement.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="element_id">Élément :</label>
            <select id="element_id" name="element_id" required>
                <?php
                $result = $db->query("SELECT * FROM elements");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['titre']}</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <label for="media_typee">Type :</label>
            <select id="media_typee" name="media_typee" required>
                <option value="image">Image</option>
                <option value="audio">Audio</option>
                <option value="video">Vidéo</option>
            </select>
        </div>

        <div>
            <label for="media_fichier">Fichier :</label>
            <input type="file" id="media_fichier" name="media_fichier" required>
        </div>

        <div>
            <label for="media_titre">Titre (facultatif) :</label>
            <input type="text" id="media_titre" name="media_titre">
        </div>

        <input type="submit" name="ajouter_media" value="Ajouter Média" class="btn">
    </form>
</div>

</body>
</html>
