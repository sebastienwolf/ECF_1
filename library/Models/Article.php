<?php

namespace Models;



class Article extends Model
{

    protected $table = "articles";


    // retourne la lisrte de articles classé par date de création
    public function insertArticle($data)
    {
        extract($data);
        $default = "DEFAULT";

        $sql = $this->pdo->prepare("INSERT INTO $this->table 
        (id_article, titre, auteur, genre, collection, edition, id_category, file, emprunt, description) 
        VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, ?, DEFAULT, ?)");

        $sql->execute(array($titre, $aut, $gen, $coll, $edit, $categorie, $fileName, $desc,));
    }

    public function createPret($data)
    {
        extract($data);
        $a = $date['dateNow'];
        $b = $date['dateEnd'];

        //{$date['dateNow']}'
        $sql = $this->pdo->prepare("INSERT INTO pret (id_user, id_article, date_retour, date_depart, back) Values (?, ?, ?, ?, ?)");
        $sql->execute(array($idUser, $id, $b, $a, 0));
    }



    public function modifArticle($data)
    {
        $requete = "SELECT articles.id_article, articles.titre, articles.auteur, articles.genre, articles.collection, articles.edition, category.name,  articles.description, articles.file  
        FROM articles 
        LEFT JOIN category ON category.id_category = articles.id_category
        WHERE articles.id_article = ?";
        $sql = $this->pdo->prepare($requete);
        // $sql->execute(array($where));
        $sql->execute([$data]);

        $response = $sql->fetchAll();
        // $test = $sql->errorInfo();
        return $response;
    }

    public function udapteDate($colomn, $value, $colomnDeux, $valueDeux, $condition, $id)
    {
        $requete = "UPDATE $this->table SET $colomn = ? , $colomnDeux = ? WHERE $condition = ?";
        $sql = $this->pdo->prepare($requete);
        $response = $sql->execute([$value, $valueDeux, $id]);
        return $response;
    }
}
