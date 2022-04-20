<?php

namespace Models;

use Database;

// require_once('librari/database.php');

abstract class Model
{

    protected $pdo;
    protected $table;

    public function __construct()
    {

        $this->pdo = \Database::getPdo();
    }
    // ===================================================================================================
    // ===============================        showAll   ===================================
    // ===================================================================================================
    public function showAll($i)
    {
        if ($i == "category") {
            $table = $i;
            $requete = "SELECT * FROM $table";
        } else {
            $requete = "SELECT * FROM $this->table Where $i";
        }
        $sql = $this->pdo->prepare($requete);
        $sql->execute();
        $response = $sql->fetchAll();
        // $test = $sql->errorInfo();
        return $response;
    }

    // ===================================================================================================
    // ===============================        showAllTable   ===================================
    // ===================================================================================================
    public function showAllTable($where)
    {
        $requete = "SELECT articles.*, category.* 
        FROM articles 
        LEFT JOIN category ON category.id_category = articles.id_category
        WHERE " . $where . " ORDER BY articles.id_article DESC";
        $sql = $this->pdo->prepare($requete);
        // $sql->execute(array($where));
        $sql->execute();

        $response = $sql->fetchAll();
        // $test = $sql->errorInfo();
        return $response;
    }

    // ===================================================================================================
    // ===============================        showAllPre   ===================================
    // ===================================================================================================
    public function showAllPre($id)
    {

        $requete = "SELECT pret.* , users.nom, users.prenom , articles.titre, articles.auteur, articles.genre, articles.collection, articles.edition
        FROM `pret` 
        LEFT JOIN users ON users.id_user = pret.id_user
        LEFT JOIN articles ON articles.id_article = articles.id_article
        WHERE pret.id_user = ? AND pret.id_article = articles.id_article AND pret.check = false";
        $sql = $this->pdo->prepare($requete);
        $sql->execute([$id]);
        $response = $sql->fetchAll();
        return $response;
    }
    // ===================================================================================================
    // ===============================        udapte   ===================================
    // ===================================================================================================
    public function udapte($item, $id)
    {
        $requete = "UPDATE $this->table SET " . $item . " WHERE " . $id;
        $sql = $this->pdo->prepare($requete);
        $response = $sql->execute();
        //$response = $sql->fetchAll();
        // $test = $sql->errorInfo();
        return $response;
    }
    // ===================================================================================================
    // ===============================        a tester   ===================================
    // ===================================================================================================
    // faut que je test ça
    public function test($usersData)
    {
        extract($usersData);

        $sql = $this->pdo->prepare('INSERT INTO ($this->table) VALUES (?), (?), (?), (?), (?), (?), (?)');
        $sql->execute(["DEFAULT", $userNom, $userPrenom, $userMail, $userPseudo, $hash, "DEFAULT"]);
    }

    // ===================================================================================================
    // ===============================        delete   ===================================
    // ===================================================================================================
    public function delete($condition)
    {
        $requete = "DELETE FROM $this->table WHERE " . $condition;
        $sql = $this->pdo->prepare("$requete");
        $sql->execute();
    }
}
