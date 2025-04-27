

# 🌟 Site Dynamique d'Apprentissage des Enfants

## 📚 Sujet
Développement d'un site web interactif pour l'apprentissage des enfants.

## 👨‍💻 Réalisé par
Projet en groupe de 3 à 4 personnes dans le cadre du module de Programmation Web en PHP.

---

## 📋 Fonctionnalités

### 🛠 Côté Administrateur
- Gestion de la base de données **MySQL**.
- Ajout, modification et suppression de :
  - **Catégories** (ex : Animaux, Moyens de transport, etc.)
  - **Éléments** (Textes descriptifs associés aux catégories)
  - **Images**
  - **Audios**
  - **Vidéos**
  
### 👀 Côté Client
- Affichage public de toutes les catégories, éléments, images, audios et vidéos.
- Lecture de médias associés aux éléments.

---

## ⚙️ Installation

1. Clonez ou téléchargez ce dépôt.
2. Placez tous les fichiers du projet dans le dossier `htdocs` de votre serveur local XAMPP.
3. **Important :**
   - Le dossier **`data`** doit être copié dans le dossier **`mysql`** (habituellement situé dans `xampp/mysql/`).
   - Cela permet d'avoir la base de données correctement restaurée pour utiliser le projet.
4. Assurez-vous que le dossier **`uploads`** existe et contient vos médias (images, audios, vidéos).
5. Lancez **Apache** et **MySQL** depuis le panneau de contrôle XAMPP.
6. Importez la base de données si nécessaire à partir du fichier `fix_database.php` (prévu pour corriger ou initialiser la structure).
7. Accédez au projet via [http://localhost/nom_du_projet](http://localhost/nom_du_projet).

---

## 📂 Structure du projet

- **admin_interface.php** : Interface de connexion et d'administration
- **admin_insert.php / admin_delete.php** : Insertion et suppression de données
- **client_categories.php** : Affichage des catégories pour les utilisateurs
- **client_elements.php** : Affichage des éléments et médias associés
- **client_quiz.php** : Quiz généré à partir des catégories
- **uploads/** : Contient les médias (images, audios, vidéos)
- **data/** : Dossier à copier dans `mysql` pour restaurer la base de données
- **css/**, **js/** : Fichiers de style et scripts éventuels

---

## 🔥 Bonus
- LARAVEL n'a pas été utilisé dans ce project.

---

## ✅ Notes
- Vous pouvez créer des administrateurs via database phpmyadmin.

