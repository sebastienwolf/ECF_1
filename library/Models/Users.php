<?php

namespace Models;


class Users extends Model
{
    protected $table = "users";

    public function createUsers($usersData)
    {
        extract($usersData);

        if ($userType == "") {
            $userType = "utilisateur";
        }

        $sql = $this->pdo->prepare("INSERT INTO users (id_user, nom, prenom, mail, pwd, adress, city, cp, type) VALUES
                (DEFAULT ,:nom, :prenom, :mail, :mdp, :adress, :ville, :cp, :type) ");
        $sql->execute(["prenom" => $userPrenom, "nom" => $userNom,  "mail" => $userMail, "mdp" => $hash, "adress" => $userAdress, "ville" => $userVille, "cp" => $userCP, "type" => $userType]);
    }
}
