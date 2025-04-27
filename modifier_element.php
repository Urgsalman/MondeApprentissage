<?php
require 'admin.php';
$db = Database::getInstance()->getConnection();

// Nouveau code pour précharger les données existantes
$element_data = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['element_id'])) {
    $stmt = $db->prepare("SELECT * FROM elements WHERE id = ?");
    $stmt->bind_param("i", $_GET['element_id']);
    $stmt->execute();
    $element_data = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $element_id = intval($_POST['element_id']);
    $categorie_id = intval($_POST['categorie_id']);
    $titre = $_POST['titre'];
    $description = $_POST['description'];

    $element = new Element($categorie_id, $titre, $description);
    if ($element->miseajour($element_id)) {
        $message = "Élément mis à jour avec succès !";
        header("Location: modifier_element.php?element_id=" . $element_id); // Recharger les nouvelles données
        exit;
    } else {
        $message = "Erreur : " . $db->error;
    }
}

// Récupération des données actualisées
$elements = $db->query("SELECT * FROM elements");
$categories = $db->query("SELECT * FROM categories");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un élément</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        form {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            color: #333;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        label {
            display: block;
            margin-bottom: 1rem;
            color: #555;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 0.8rem;
            margin-top: 0.3rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        select {
            appearance: none;
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M8 11l-4-4h8l-4 4z'/%3E%3C/svg%3E") no-repeat right 1rem center;
        }

        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
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
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #1976D2;
            transform: translateY(-2px);
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .btn-back {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
            min-width: 200px;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #45a049;
            transform: translateX(-50%) translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        @media (max-width: 768px) {
            form {
                padding: 1.5rem;
            }

            .btn-back {
                position: static;
                display: block;
                transform: none;
                margin: 20px auto;
                width: fit-content;
            }

            .btn-back:hover {
                transform: translateY(-2px);
            }
        }
        
        @media (max-width: 768px) {
            form {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <a href="admin_interface.php" class="btn btn-back">Retour à l'accueil</a>
    <form method="post">
		<h2>Modifier un élément</h2>
		
		<label>
			Sélectionner l'élément à modifier :
			<select name="element_id" id="element-select" required 
					onchange="location = 'modifier_element.php?element_id=' + this.value">
				<option value="">-- Choisir un élément --</option>
				<?php while ($el = $elements->fetch_assoc()): ?>
					<option value="<?= $el['id'] ?>" 
						<?= isset($_GET['element_id']) && $_GET['element_id'] == $el['id'] ? 'selected' : '' ?>>
						<?= htmlspecialchars($el['titre']) ?>
					</option>
				<?php endwhile; ?>
			</select>
		</label>

		<?php if ($element_data): ?>
			<input type="hidden" name="element_id" value="<?= $element_data['id'] ?>">
			
			<label>
				Nouveau titre :
				<input type="text" name="titre" value="<?= htmlspecialchars($element_data['titre']) ?>" required>
			</label>

			<label>
				Description :
				<textarea name="description"><?= htmlspecialchars($element_data['description']) ?></textarea>
			</label>

			<label>
				Catégorie :
				<select name="categorie_id" required>
					<?php while ($cat = $categories->fetch_assoc()): ?>
						<option value="<?= $cat['id'] ?>" 
							<?= $cat['id'] == $element_data['categorie_id'] ? 'selected' : '' ?>>
							<?= htmlspecialchars($cat['nom']) ?>
						</option>
					<?php endwhile; ?>
				</select>
			</label>
			
			<input type="submit" value="Mettre à jour">
		<?php endif; ?>
	</form>
</body>
</html>