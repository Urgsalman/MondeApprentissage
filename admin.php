<?php
require 'Database.php';

class administrateurs {
	public $nom_utilisateur ;
	public $mot_de_passe ;
	public $email ;
	public $date_creation ;
	
	public function __construct($nom_utilisateur, $mot_de_passe, $email, $date_creation){
		$this->nom_utilisateur = $nom_utilisateur;
		$this->mot_de_passe = $mot_de_passe;
		$this->email = $email;
		$this->date_creation = $date_creation;
	}
}
	
	
	function inserer($nom_utilisateur, $mot_de_passe, $email){
		$db = Database::getInstance();
		$connexion = $db->getConnection();
		$sql = "INSERT INTO administrateurs (nom_utilisateur, mot_de_passe, email) VALUES ('$nom_utilisateur', '$mot_de_passe', '$email')";
		$result = $connexion->query($sql) ;
	}
	
	function supprimer($nom_utilisateur,$mot_de_passe){
		$db = Database::getInstance();
		$connexion = $db->getConnection();
		$sql= "DELETE FROM administrateurs WHERE nom_utilisateur = '$nom_utilisateur' AND mot_de_passe= '$mot_de_passe' ";
		$result = $connexion->query($sql) ;
		echo "supprimer $nom_utilisateur" . "<br>";
	}
	
	function miseajour($nom_utilisateur, $mot_de_passe, $email){
		$db = Database::getInstance();
		$connexion = $db->getConnection();
		if ($mot_de_passe!=""){
			$sql= "UPDATE administrateurs SET mot_de_passe='$mot_de_passe' WHERE nom_utilisateur = '$nom_utilisateur' ";
			$result = $connexion->query($sql) ;
			echo "mot_de_passe updated". "<br>";
		}
		if ($email!=""){
			$sql= "UPDATE administrateurs SET email='$email' WHERE nom_utilisateur = '$nom_utilisateur' ";
			$result = $connexion->query($sql) ;
			echo "email updated". "<br>";
		}
	}
	
	
?>