<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "clerge1");
define("DBLOGIN", "clerge1");
define("DBPWD", "clerge1");


function getAllMovies(){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "select Movie.id, Movie.min_age,  Movie.name,  Movie.image, Category.name as label from Movie INNER JOIN Category ON Category.id = Movie.id_category ORDER BY Category.name";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function addMovie($t, $r, $y, $dur, $des, $cat, $img, $url, $age) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO Movie (name, director, year, length, description, id_category, image, trailer, min_age) 
            VALUES (:t, :r, :y, :dur, :des, :cat, :img, :url, :age)";
    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':t', $t);
    $stmt->bindParam(':r', $r);
    $stmt->bindParam(':y', $y);
    $stmt->bindParam(':dur', $dur);
    $stmt->bindParam(':des', $des);
    $stmt->bindParam(':cat', $cat);
    $stmt->bindParam(':img', $img);
    $stmt->bindParam(':url', $url);
    $stmt->bindParam(':age', $age);

    $stmt->execute();

    $res = $stmt->rowCount();
    return $res;
}

function addProfile($nom,$age,$avatar,$newnom = null){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    
    // Check if profile with this name already exists
    $checkSql = "SELECT id FROM Profile WHERE nom = :nom";
    $checkStmt = $cnx->prepare($checkSql);
    $checkStmt->bindParam(':nom', $nom);
    $checkStmt->execute();
    $existingProfile = $checkStmt->fetch(PDO::FETCH_OBJ);
    
    $isRename = false;
    
    if ($existingProfile) {
        // Profile exists
        if ($newnom && $newnom !== $nom) {
            // Rename the profile
            $sql = "UPDATE Profile SET nom = :newnom, age = :age, avatar = :avatar WHERE nom = :nom";
            $isRename = true;
        } else {
            $sql = "UPDATE Profile SET age = :age, avatar = :avatar WHERE nom = :nom";
        }
    } else {
        $sql = "INSERT INTO Profile (nom, age, avatar) VALUES (:nom, :age, :avatar)";
    }
    
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':avatar', $avatar);
    if ($isRename) {
        $stmt->bindParam(':newnom', $newnom);
    }
    $stmt->execute();
    
    $res = $stmt->rowCount();
    return array('status' => $res > 0, 'isUpdate' => (bool)$existingProfile && !$isRename, 'isRename' => $isRename);
}

function getAllProfiles(){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT * FROM Profile ORDER BY nom";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function getProfileAge($id) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT age FROM Profile WHERE id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res ? $res->age : 0; // Return 0 if not found
}

function getMovieDetail($id){
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "select Category.name as label, Movie.* from Movie INNER JOIN Category ON Category.id = Movie.id_category WHERE Movie.id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res;
}

function addFavorite($id_profile, $id_movie) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    
    $sql = "INSERT INTO Favorite (id_profile, id_movie) VALUES (:id_p, :id_m)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_p', $id_profile);
    $stmt->bindParam(':id_m', $id_movie);
    
    try {
        $stmt->execute();
        return $stmt->rowCount();
    } catch (PDOException $e) {
        return false;
    }
}

function getFavoritesByProfile($id_profile) {
    $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT Movie.*, Category.name as label 
            FROM Movie 
            INNER JOIN Favorite ON Movie.id = Favorite.id_movie 
            INNER JOIN Category ON Category.id = Movie.id_category 
            WHERE Favorite.id_profile = :id_p";
    
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id_p', $id_profile);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}