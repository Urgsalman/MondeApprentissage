<?php
// Configuration de la connexion MySQL
$servername = "localhost";
$username = "root"; // Remplacez par votre nom d'utilisateur MySQL
$password = "";     // Remplacez par votre mot de passe MySQL

try {
    // Connexion au serveur MySQL
    $conn = new mysqli($servername, $username, $password);
    
    // Vérifier la connexion
    if ($conn->connect_error) {
        throw new Exception("Échec de la connexion : " . $conn->connect_error);
    }

    // Création de la base de données si elle n'existe pas
    $sql = "CREATE DATABASE IF NOT EXISTS kids_learnings";
    if ($conn->query($sql) === TRUE) {
        echo "Base de données créée/existe déjà ✔️<br>";
    } else {
        throw new Exception("Erreur création base : " . $conn->error);
    }

    // Sélectionner la base de données
    $conn->select_db("kids_learnings");

    // Liste des tables à créer dans l'ordre
    $tables = [
        'administrateurs' => "
            CREATE TABLE IF NOT EXISTS administrateurs (
                nom_utilisateur VARCHAR(50) NOT NULL,
                mot_de_passe VARCHAR(255) NOT NULL,
                email VARCHAR(100),
                date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ",

        'categories' => "
            CREATE TABLE IF NOT EXISTS categories (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                image VARCHAR(255), 
                date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ",

        'elements' => "
            CREATE TABLE IF NOT EXISTS elements (
                id INT AUTO_INCREMENT PRIMARY KEY,
                categorie_id INT NOT NULL,
                titre VARCHAR(255) NOT NULL,
                description TEXT,
                date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (categorie_id) REFERENCES categories(id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB;
        ",

        'medias' => "
            CREATE TABLE IF NOT EXISTS medias (
                id INT AUTO_INCREMENT PRIMARY KEY,
                element_id INT NOT NULL,
                typee ENUM('image','audio','video') NOT NULL,
                chemin_fichier VARCHAR(255) NOT NULL,
                titre VARCHAR(100),
                date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (element_id) REFERENCES elements(id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB;
        "
    ];

    // Création des tables
    foreach ($tables as $name => $sql) {
        if ($conn->query($sql) === TRUE) {
            echo "Table '$name' créée ✔️<br>";
        } else {
            throw new Exception("Erreur table $name : " . $conn->error);
        }
    }

    // Fermer la connexion
    $conn->close();

} catch (Exception $e) {
    die("<div style='color:red'>ERREUR : " . $e->getMessage() . "</div>");
}

echo "<h3 style='color:green'>Installation terminée avec succès ! 🎉</h3>";
?>