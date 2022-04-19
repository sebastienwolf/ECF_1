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

        $sql = $this->pdo->prepare("INSERT INTO $this->table (Type, titre, contenu, imageArticle, idCategorie, idusers) VALUES (?, ?, ?, ?, ?, ?)");

        $sql->execute(array($typeAdd, $titreAdd, $description, $fileName, $categorie, $idUser));
    }
}
