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
            $requete = "SELECT * FROM $this->table WHERE $i";
        }
        $sql = $this->pdo->prepare($requete);
        $sql->execute();
        $response = $sql->fetchAll();
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
        $sql->execute();

        $response = $sql->fetchAll();
        return $response;
    }

    // ===================================================================================================
    // ===============================        showCat   ===================================
    // ===================================================================================================
    public function showCat()
    {

        $requete = "SELECT category.name 
        FROM articles 
        LEFT JOIN category ON articles.id_category = category.id_category
        group BY category.name";

        $sql = $this->pdo->prepare($requete);
        $sql->execute();
        $response = $sql->fetchAll();
        return $response;
    }

    // ===================================================================================================
    // ===============================        showFiltre   ===================================
    // ===================================================================================================
    public function showFiltre($table, $condition)
    {

        $requete = "SELECT ";
        if ($table == "genre") {
            $requete .= "genre ";
        }
        if ($table == "auteur") {
            $requete .= "auteur ";
        }
        if ($table == "collection") {
            $requete .= "collection ";
        }
        if ($table == "edition") {
            $requete .= "edition ";
        }
        //====================================
        $requete .= "FROM articles 
        group BY ";
        //===================================
        if ($table == "genre") {
            $requete .= "genre";
        }
        if ($table == "auteur") {
            $requete .= "auteur ";
        }
        if ($table == "collection") {
            $requete .= "collection ";
        }
        if ($table == "edition") {
            $requete .= "edition ";
        }

        $sql = $this->pdo->prepare($requete);
        $sql->execute([$condition]);
        $response = $sql->fetchAll();
        return $response;
    }

    // ===================================================================================================
    // ===============================        showFiltre   ===================================
    // ===================================================================================================
    public function showFiltreAvence($table, $where, $condition)
    {

        $requete = "SELECT ";
        if ($table == "genre") {
            $requete .= "genre ";
        }
        if ($table == "auteur") {
            $requete .= "auteur ";
        }
        if ($table == "collection") {
            $requete .= "collection ";
        }
        if ($table == "edition") {
            $requete .= "edition ";
        }
        //====================================
        $requete .= "FROM articles WHERE ";
        //===================================
        if ($where == "1") {
            $requete .= "articles.id_category = ? ";
        }
        if ($where == "2") {
            $requete .= "articles.genre = ? ";
        }
        if ($where == "3") {
            $requete .= "articles.auteur = ? ";
        }
        if ($where == "4") {
            $requete .= "articles.collection = ? ";
        }

        $sql = $this->pdo->prepare($requete);
        $sql->execute([$condition]);
        $response = $sql->fetchAll();

        $tableau = [];
        foreach ($response as $verification) {
            array_push($tableau, $verification[$table]);
        }

        return $tableau;
    }
    // ===================================================================================================
    // ===============================        showAllPre   ===================================
    // ===================================================================================================
    public function showAllPre($id)
    {

        $requete = "SELECT pret.id_pret, articles.titre, articles.auteur, articles.genre, articles.collection, articles.edition,  DATE_FORMAT(pret.date_depart, '%d/%m/%Y') as date_depart, DATE_FORMAT(pret.date_retour, '%d/%m/%Y') as date_retour, articles.id_article
        FROM `pret` 
        LEFT JOIN users ON users.id_user = pret.id_user
        LEFT JOIN articles ON articles.id_article = articles.id_article
        WHERE pret.id_user = ? AND pret.id_article = articles.id_article AND pret.back = false";
        $sql = $this->pdo->prepare($requete);
        $sql->execute([$id]);
        $response = $sql->fetchAll();
        return $response;
    }
    // ===================================================================================================
    // ===============================        show pret admin   ===================================
    // ===================================================================================================
    public function showAllPretAdmin($id)
    {

        $requete = "SELECT pret.id_pret, pret.id_user, users.prenom, users.nom, articles.titre, articles.auteur, DATE_FORMAT(pret.date_depart, '%d/%m/%Y') as date_depart, DATE_FORMAT(pret.date_retour, '%d/%m/%Y') as date_retour, DATEDIFF(pret.date_retour, CURRENT_DATE()) AS reste, pret.id_article 
        FROM `pret` 
        LEFT JOIN users ON users.id_user = pret.id_user
        LEFT JOIN articles ON articles.id_article = articles.id_article
        WHERE pret.id_article = articles.id_article AND pret.back = false";

        if (!empty($id)) {
            $requete .= " AND pret.id_user = ?";
        }

        $sql = $this->pdo->prepare($requete);
        $sql->execute([$id]);
        $response = $sql->fetchAll();
        return $response;
    }

    // ===================================================================================================
    // ===============================        historique Show   ===================================
    // ===================================================================================================
    public function showHistorique($id)
    {

        $requete = "SELECT pret.id_pret, articles.titre, articles.auteur, articles.genre, articles.collection, articles.edition, DATE_FORMAT(pret.rendu, '%d/%m/%Y') as rendu
        FROM `pret` 
        LEFT JOIN users ON users.id_user = pret.id_user
        LEFT JOIN articles ON articles.id_article = articles.id_article
        WHERE pret.id_user = ? AND pret.id_article = articles.id_article ORDER BY pret.id_pret DESC";
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

        return $response;
    }
    // ===================================================================================================
    // ===============================        udapte Pret  ===================================
    // ===================================================================================================

    public function udaptePret($id)
    {
        $dateNow = date('Y-m-d', time());
        $requete = "UPDATE pret SET back = 1, rendu = ? WHERE id_article = ?";
        $sql = $this->pdo->prepare($requete);
        $response = $sql->execute([$dateNow, $id]);

        return $response;
    }
    // ===================================================================================================
    // ===============================        alert   ===================================
    // ===================================================================================================

    public function alert($id)
    {
        $requete = "SELECT id_pret, articles.titre, DATEDIFF(date_retour, CURRENT_DATE()) AS reste FROM pret 
        LEFT JOIN articles ON articles.id_article = pret.id_article 
        WHERE pret.id_user = ? AND pret.back = 0 AND DATEDIFF(date_retour, CURRENT_DATE()) < 0 ";
        $sql = $this->pdo->prepare($requete);
        $sql->execute([$id]);
        $response = $sql->fetchAll();


        return $response;
    }
    // ===================================================================================================
    // ===============================        alertAdmin   ===================================
    // ===================================================================================================

    public function alertAdmin()
    {
        $requete = "SELECT id_pret, articles.titre, DATEDIFF(date_retour, CURRENT_DATE()) AS reste FROM pret 
        LEFT JOIN articles ON articles.id_article = pret.id_article 
        WHERE pret.back = 0 AND DATEDIFF(date_retour, CURRENT_DATE()) < 0 ";
        $sql = $this->pdo->prepare($requete);
        $sql->execute();
        $response = $sql->fetchAll();


        return $response;
    }
    // ===================================================================================================
    // ===============================        filtre   ===================================
    // ===================================================================================================

    public function filtre($tableau)
    {
        $requete = "SELECT articles.*, category.name FROM articles
        LEFT JOIN category ON articles.id_category = category.id_category WHERE ";
        $end = end(end($tableau));
        extract($tableau);


        if (isset($category)) {
            foreach ($tableau['category'] as $a) {
                if ($a !== $end) {
                    $requete .= "category.name LIKE '$a' AND ";
                } else {
                    $requete .= "category.name LIKE '$end'";
                }
            }
        }
        if (isset($genre)) {
            foreach ($tableau['genre'] as $a) {
                if ($a !== $end) {
                    $requete .= "articles.genre LIKE '$a' AND ";
                } else {
                    $requete .= "articles.genre LIKE '$end'";
                }
            }
        }
        if (isset($auteur)) {
            foreach ($auteur as $a) {
                if ($a !== $end) {
                    $requete .= "articles.auteur LIKE '$a' AND ";
                } else {
                    $requete .= "articles.auteur LIKE '$end'";
                }
            }
        }
        if (isset($collection)) {
            foreach ($collection as $a) {
                if ($a !== $end) {
                    $requete .= "articles.collection LIKE '$a' AND ";
                } else {
                    $requete .= "articles.collection LIKE '$end'";
                }
            }
        }
        if (isset($edition)) {
            foreach ($edition as $a) {
                if ($a !== $end) {
                    $requete .= "articles.edition LIKE '$a' AND ";
                } else {
                    $requete .= "articles.edition LIKE '$end'";
                }
            }
        }
        if (empty($tableau)) {
            $requete .= 1;
        }


        $sql = $this->pdo->prepare($requete);
        $sql->execute();
        $response = $sql->fetchAll();


        return $response;
    }

    // ===================================================================================================
    // ===============================        delete   ===================================
    // ===================================================================================================
    public function delete($condition)
    {
        $requete = "DELETE FROM $this->table WHERE $condition";
        $sql = $this->pdo->prepare("$requete");
        $sql->execute();
    }
    // ===================================================================================================
    // ===============================         persoAdmin   ===================================
    // ===================================================================================================
    public function  persoAdmin($id, $condition)
    {
        $requete = "UPDATE personnalisation SET verif = ? WHERE id_personnalisation = ?";
        $sql = $this->pdo->prepare("$requete");
        $sql->execute([$id, $condition]);
    }
    // ===================================================================================================
    // ===============================         verifVue   ===================================
    // ===================================================================================================
    public function  verifVue()
    {
        $requete = "SELECT colone FROM `personnalisation` WHERE verif = 1";
        $sql = $this->pdo->prepare("$requete");
        $sql->execute();
        $response = $sql->fetchAll();
        return $response;
    }
}
