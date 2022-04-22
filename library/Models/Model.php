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
    // ===============================        historique Show   ===================================
    // ===================================================================================================
    public function showHistorique($id)
    {

        $requete = "SELECT pret.id_pret, articles.titre, articles.auteur, articles.genre, articles.collection, articles.edition, DATE_FORMAT(pret.rendu, '%d/%m/%Y') as rendu
        FROM `pret` 
        LEFT JOIN users ON users.id_user = pret.id_user
        LEFT JOIN articles ON articles.id_article = articles.id_article
        WHERE pret.id_user = ? AND pret.id_article = articles.id_article AND pret.back = true";
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

    public function udaptePret($table, $item, $reponse, $condition, $id)
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
        $requete = "SELECT id_pret, articles.titre, DATEDIFF(date_retour, date_depart) AS reste FROM pret 
        LEFT JOIN articles ON articles.id_article = pret.id_article 
        WHERE pret.id_user = ? AND pret.back = 0 ";
        $sql = $this->pdo->prepare($requete);
        $sql->execute([$id]);
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
        // $endCat = end($tableau['category']);
        // $endGenre = end($tableau['genre']);
        // $endAut = end($tableau['auteur']);
        // $endColl = end($tableau['collection']);
        // $endEdi = end($tableau['edition']);




        if (isset($category)) {
            foreach ($tableau['category'] as $a) {
                if ($a !== $end) {
                    $requete .= "category.name LIKE '$a' OR ";
                } else {
                    $requete .= "category.name LIKE '$end'";
                }
            }
        }
        if (isset($genre)) {
            foreach ($tableau['genre'] as $a) {
                if ($a !== $end) {
                    $requete .= "articles.genre LIKE '$a' OR ";
                } else {
                    $requete .= "articles.genre LIKE '$end'";
                }
            }
        }
        if (isset($auteur)) {
            foreach ($auteur as $a) {
                if ($a !== $end) {
                    $requete .= "articles.auteur LIKE '$a' OR ";
                } else {
                    $requete .= "articles.auteur LIKE '$end'";
                }
            }
        }
        if (isset($collection)) {
            foreach ($collection as $a) {
                if ($a !== $end) {
                    $requete .= "articles.collection LIKE '$a' OR ";
                } else {
                    $requete .= "articles.collection LIKE '$end'";
                }
            }
        }
        if (isset($edition)) {
            foreach ($edition as $a) {
                if ($a !== $end) {
                    $requete .= "articles.edition LIKE '$a' OR ";
                } else {
                    $requete .= "articles.edition LIKE '$end'";
                }
            }
        }
        // } else {
        //     switch ($end) {
        //         case $endCat:
        //             $requete .= "category.name LIKE " . $end;
        //             break;
        //         case $endGenre:
        //             $requete .= "articles.genre LIKE " . $end;
        //             break;
        //         case $endAut:
        //             $requete .= "articles.auteur LIKE " . $end;
        //             break;
        //         case $endColl:
        //             $requete .= "articles.collection LIKE " . $end;
        //             break;
        //         case $endEdi:
        //             $requete .= "articles.edition LIKE " . $end;
        //             break;
        //     }
        // }
        //}

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
        $requete = "DELETE FROM $this->table WHERE " . $condition;
        $sql = $this->pdo->prepare("$requete");
        $sql->execute();
    }
}
