<?php
require 'admin.php';

$media = null;
$elements = [];
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $db = Database::getInstance()->getConnection();
    $result = $db->query("SELECT * FROM medias WHERE id = $id");
    $media = $result->fetch_assoc();

    if (!$media) {
        echo "Aucun média trouvé avec l'ID : " . $id;
        exit;
    }
    $res = $db->query("SELECT id, titre FROM elements");
    while ($row = $res->fetch_assoc()) {
        $elements[] = $row;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $element_id = intval($_POST['element_id']);
    $typee = $_POST['typee'];
    $titre = $_POST['titre'];
    $chemin_fichier = $_POST['chemin_fichier_existant'];
    if (isset($_FILES['chemin_fichier']) && $_FILES['chemin_fichier']['error'] == 0) {
        $chemin_fichier = basename($_FILES['chemin_fichier']['name']);
        move_uploaded_file($_FILES['chemin_fichier']['tmp_name'], $chemin_fichier);
    }

    $media_obj = new Media($element_id, $typee, $chemin_fichier, $titre);
    $media_obj->miseajour($id);

    header("Location: admin_interface.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Média</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h2, h3 {
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        h3 {
            color: #666;
            font-size: 0.9rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        select {
            appearance: none;
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M8 11l-4-4h8l-4 4z'/%3E%3C/svg%3E") no-repeat right 1rem center;
        }

        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #2196F3;
        }

        input[type="file"] {
            padding: 0.5rem;
            background-color: #f8f9fa;
            border: 1px dashed #ddd;
            border-radius: 5px;
            width: 100%;
        }

        small {
            color: #666;
            font-size: 0.8rem;
            display: block;
            margin-top: 0.5rem;
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.8rem;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        input[type="submit"]:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>ID à mettre à jour : <?= htmlspecialchars($media['id']) ?></h3>
        <h2>Modifier Média</h2>
        <form method="post" enctype="multipart/form-data">
            </head>
			<body>
				<h3>ID à mettre à jour : <?= htmlspecialchars($media['id']) ?></h3>
				<h2>Modifier Média</h2>
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?= htmlspecialchars($media['id']) ?>">
					<input type="hidden" name="chemin_fichier_existant" value="<?= htmlspecialchars($media['chemin_fichier']) ?>">

					<label>Élément :
						<select name="element_id">
							<?php foreach ($elements as $el): ?>
								<option value="<?= $el['id'] ?>" <?= $el['id'] == $media['element_id'] ? 'selected' : '' ?>>
									<?= htmlspecialchars($el['titre']) ?>
								</option>
							<?php endforeach; ?>
						</select>
					</label><br><br>

					<label>Type :
						<select name="typee">
							<option value="image" <?= $media['typee'] == 'image' ? 'selected' : '' ?>>Image</option>
							<option value="audio" <?= $media['typee'] == 'audio' ? 'selected' : '' ?>>Audio</option>
							<option value="video" <?= $media['typee'] == 'video' ? 'selected' : '' ?>>Vidéo</option>
						</select>
					</label><br><br>

					<label>Titre : <input type="text" name="titre" value="<?= htmlspecialchars($media['titre']) ?>"></label><br><br>

					<label>Fichier : <input type="file" name="chemin_fichier"></label><br>
					<small>Fichier actuel : <?= htmlspecialchars($media['chemin_fichier']) ?></small><br><br>

					<input type="submit" value="Mettre à jour">
				</form>
			</body>
			</html>
        </form>
    </div>
</body>
</html>