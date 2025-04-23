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
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Création de la base de données si elle n'existe pas
    $sql = "CREATE DATABASE IF NOT EXISTS kids_learnings";
    if ($conn->query($sql) === TRUE) {
        echo "Base de données créée avec succès ou existe déjà.<br>";
    } else {
        throw new Exception("Erreur création base de données: " . $conn->error);
    }

    // Sélectionner la base de données
    $conn->select_db("kids_learnings");

    // Création de la table administrateurs
    $sql = "CREATE TABLE IF NOT EXISTS administrateurs (
        nom_utilisateur VARCHAR(50) NOT NULL,
        mot_de_passe VARCHAR(255) NOT NULL,
        email VARCHAR(100),
        date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table 'administrateurs' créée avec succès.<br>";
    } else {
        throw new Exception("Erreur création table: " . $conn->error);
    }

    // Fermer la connexion
    $conn->close();

} catch (Exception $e) {
    die("Erreur lors de l'installation: " . $e->getMessage());
}

echo "Installation terminée avec succès!";
?>