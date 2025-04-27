
<?php
error_reporting(E_ERROR);
require 'admin.php'; // inclut Categorie, Element, Media
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression de contenu</title>
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
		.hidden { display: none; }
    </style>
    <script>
        function showSelect(type) {
            document.getElementById('categorie-select').style.display = 'none';
            document.getElementById('element-select').style.display = 'none';
            document.getElementById('media-select').style.display = 'none';

            if (type === 'categorie') {
                document.getElementById('categorie-select').style.display = 'block';
            } else if (type === 'element') {
                document.getElementById('element-select').style.display = 'block';
            } else if (type === 'media') {
                document.getElementById('media-select').style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <form action="traitement.php" method="post">
        <h2>Supprimer un contenu</h2>

        <label for="type">Type de contenu :</label>
        <select name="type_suppression" id="type" onchange="showSelect(this.value)" required>
            <option value="">-- Choisir --</option>
            <option value="categorie">Catégorie</option>
            <option value="element">Élément</option>
            <option value="media">Média</option>
        </select>

        <!-- Sélection des catégories -->
        <div id="categorie-select" class="hidden">
            <label>Choisir une catégorie :</label>
            <select name="id_suppression_categorie">
                <?php
                $db = Database::getInstance()->getConnection();
                $res = $db->query("SELECT id, nom FROM categories");
                while ($row = $res->fetch_object()) {
                    echo "<option value='{$row->id}'>[{$row->id}] {$row->nom}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Sélection des éléments -->
        <div id="element-select" class="hidden">
            <label>Choisir un élément :</label>
            <select name="id_suppression_element">
                <?php
                $res = $db->query("SELECT id, titre FROM elements");
                while ($row = $res->fetch_object()) {
                    echo "<option value='{$row->id}'>[{$row->id}] {$row->titre}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Sélection des médias -->
		<div id="media-select" class="hidden">
			<label>Choisir un média :</label>
			<select name="id_suppression">
				<?php
				$res = $db->query("
					SELECT medias.id, medias.typee, elements.titre AS element_titre
					FROM medias
					JOIN elements ON medias.element_id = elements.id
				");
				while ($row = $res->fetch_object()) {
					$elementTitre = $row->element_titre ?: "(élément sans titre)";
					$typee = ucfirst($row->typee); // Capitalize first letter (optional)
					echo "<option value='{$row->id}'>[{$row->id}] {$elementTitre} - {$typee}</option>";
				}
				?>
			</select>
		</div>

        <button type="submit" name="supprimer">Supprimer</button>
    </form>
	<a href="admin_interface.php" class="btn btn-back">Retour à l'accueil</a>
</body>
</html>
