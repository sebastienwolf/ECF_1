<?php

namespace Controllers;


class Users extends Controller
{
    protected $modelName = \Models\Users::class;


    // ===================================================================================================
    // ===============================        deconnexion    ===========================================
    // ===================================================================================================

    public function logOut()
    {
        $this->checkSession();
        $a = $_COOKIE['PHPSESSID'];
        //selectionne le cookie et le supprime
        //puis détruit la session
        setcookie($a);
        session_unset();
        session_destroy();

        header('location: index.php?controller=article&task=index');
    }
    // ===================================================================================================
    // ===============================        connexion    ===========================================
    // ===================================================================================================

    // connexion user
    public function connexion()
    {
        $mail = filter_input(INPUT_POST, 'mail');
        //-----------------------------------------
        $a = filter_input(INPUT_POST, 'password');
        //------------------------
        $password = htmlspecialchars(filter_input(INPUT_POST, 'password'));
        if ($mail && $password) {
            //verifie si le mail existe
            $userLog = $this->model->showAll("mail = '{$mail}'");
            //vérifie si le mot de passe correspond
            $verifPassword = password_verify($password, $userLog[0]['pwd']);
            if ($verifPassword == true && ($mail == $userLog[0]['mail'])) // nom d'utilisateur et mot de passe correctes
            {
                if (!isset($_SESSION)) {
                    session_start();
                }
                //entre les information dans la session
                $_SESSION['id'] = $userLog[0]['id_user'];
                $_SESSION['nom'] = $userLog[0]['nom'];
                $_SESSION['prenom'] = $userLog[0]['prenom'];
                $_SESSION['mail'] = $userLog[0]['mail'];
                $_SESSION['adress'] = $userLog[0]['adress'];
                $_SESSION['ville'] = $userLog[0]['city'];
                $_SESSION['cp'] = $userLog[0]['cp'];
                $_SESSION['userType'] = $userLog[0]['type'];

                //connecter
                echo json_encode("1");
            } else {
                echo json_encode("2");
            }
        } else {
            echo json_encode("3");
        }
    }

    // ===================================================================================================
    // ===============================        profil    ===========================================
    // ===================================================================================================
    public function profil()
    {
        $this->checkUser();

        $pageTitle = 'profil';
        \Renderer::render('articles/profil', compact('pageTitle'));
    }
    // ===================================================================================================
    // ===============================        adminProfil    ===========================================
    // ===================================================================================================
    public function adminProfil()
    {
        $this->checkAdmin();

        $pageTitle = 'Admin modif user';
        $id = filter_input(INPUT_GET, 'id');
        //appelle les informations de l'utilisateur
        $users = $this->model->showAll("id_user = $id");
        \Renderer::render('articles/adminProfil', compact('pageTitle', 'users'));
    }

    // ===================================================================================================
    // ===============================        adminUsers    ===========================================
    // ===================================================================================================
    public function adminUsers()
    {
        $this->checkAdmin();

        //appelle les informations des utilisateurs
        $allUsers = $this->model->showAll(1);
        $pageTitle = 'Admin Utilisateur';
        \Renderer::render('articles/adminUser', compact('pageTitle', 'allUsers'));
    }
    // ===================================================================================================
    // ===============================        admin imprim    ===========================================
    // ===================================================================================================
    public function adminImprim()
    {
        $this->checkAdmin();

        //affiche les information de l'utilisateur pour imprimer la carte adhérent
        $id = filter_input(INPUT_GET, 'id');
        $condition = "id_user = {$id}";
        $user = $this->model->showAll($condition);
        $pageTitle = 'Admin Utilisateur';
        \Renderer::render('articles/adminImprim', compact('pageTitle', 'user'));
    }

    // ===================================================================================================
    // ===============================        inscription    ===========================================
    // ===================================================================================================
    // inscription new user
    public function inscription()
    {
        //prend les informations du formulaire inscription
        $userNom = htmlspecialchars(filter_input(INPUT_POST, 'nom'));
        $userPrenom = htmlspecialchars(filter_input(INPUT_POST, 'prenom'));
        $userMail = filter_input(INPUT_POST, 'mail');
        $userPassword = htmlspecialchars(filter_input(INPUT_POST, 'password'));
        $userAdress = htmlspecialchars(filter_input(INPUT_POST, 'adresse'));
        $userVille = htmlspecialchars(filter_input(INPUT_POST, 'ville'));
        $userCP = htmlspecialchars(filter_input(INPUT_POST, 'cp'));
        $userType = htmlspecialchars(filter_input(INPUT_POST, 'type'));

        //hash le mot de passe à stocker
        $option = ['cost' => 12,];
        $hash = password_hash($userPassword, PASSWORD_BCRYPT, $option);

        if ($userNom && $userPrenom && $userMail && $hash && $userAdress && $userVille && $userCP) {
            //vérifie si le mail existe si oui il s'arrete et envoie une erreur
            $verifMail = $this->model->showAll("mail =" . "'{$userMail}'");

            if ($verifMail['0']['mail'] == $userMail) {
                echo json_encode(("2"));
            } else {

                $usersData = compact("userNom", "userPrenom", "userMail", "hash", "userAdress", "userVille", "userCP", "userType");
                $sql = $this->model->createUsers($usersData);
                if ($_SESSION['userType'] == 'admin') {
                    echo json_encode(("5"));
                } else {
                    echo json_encode(("1"));
                }
            }
        } else {
            echo json_encode(("3"));
        }
    }
    // ===================================================================================================
    // ===============================        modify    ===========================================
    // ===================================================================================================
    // modifier les donnée user

    public function modify()
    {
        $this->checkUser();

        //prend les informations du formulaire puis va vérifier un par un les informations à modifier en fonction des entrées
        $userNom = htmlspecialchars(filter_input(INPUT_POST, 'nom'));
        $userPrenom = htmlspecialchars(filter_input(INPUT_POST, 'prenom'));
        $userMail = filter_input(INPUT_POST, 'mail');
        $userAdress = htmlspecialchars(filter_input(INPUT_POST, 'adress'));
        $userVille = htmlspecialchars(filter_input(INPUT_POST, 'ville'));
        $userCp = htmlspecialchars(filter_input(INPUT_POST, 'cp'));
        $userPassword = htmlspecialchars(filter_input(INPUT_POST, 'password'));
        $userType = htmlspecialchars(filter_input(INPUT_POST, 'type'));
        $idUsers = $_SESSION['id'];
        //=======================================
        //Nom
        if ($userNom !== "") {
            $item = "nom = '{$userNom}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
            $_SESSION['nom'] = $userNom;
        }
        //=======================================
        //Prenom
        if ($userPrenom !== "") {
            $item = "prenom = '{$userPrenom}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
            $_SESSION['prenom'] = $userPrenom;
        }
        //=======================================
        //Mail
        if ($userMail !== "") {
            $item = "mail = '{$userMail}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
            $_SESSION['mail'] = $userMail;
        }
        //=======================================
        // Adresse
        if ($userAdress !== "") {
            $item = "adress = '{$userAdress}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
            $_SESSION['adress'] = $userAdress;
        }

        //=======================================
        // Ville
        if ($userVille !== "") {
            $item = "city = '{$userVille}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
            $_SESSION['ville'] = $userVille;
        }
        //=======================================
        // CP
        if ($userCp !== "") {
            $item = "cp = '{$userCp}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
            $_SESSION['cp'] = $userCp;
        }
        //=======================================
        // mot de passe
        if ($userPassword !== "") {
            $option = ['cost' => 12,];
            $hash = password_hash($userPassword, PASSWORD_BCRYPT, $option);

            $item = "pwd = '{$hash}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }
        //=======================================
        //=======================================
        // userType
        if ($userType !== "") {
            if ($userType !== $_SESSION['userType']) {
                $item = "type = '{$userType}'";
                $condition = "id_user = '{$idUsers}'";
                $this->model->udapte($item, $condition);
                $_SESSION['userType'] = $userType;
            }
        }
        echo json_encode('utilisateur');
    }

    // ===================================================================================================
    // ===============================        modifyAdmin    ===========================================
    // ===================================================================================================
    // modifier les donnée user

    public function modifyAdmin()
    {
        $this->checkAdmin();


        //prend les informations du formulaire puis va vérifier un par un les informations à modifier en fonction des entrées

        $userNom = htmlspecialchars(filter_input(INPUT_POST, 'nom'));
        $userPrenom = htmlspecialchars(filter_input(INPUT_POST, 'prenom'));
        $userMail = filter_input(INPUT_POST, 'mail');
        $userAdress = htmlspecialchars(filter_input(INPUT_POST, 'adress'));
        $userVille = htmlspecialchars(filter_input(INPUT_POST, 'city'));
        $userCp = htmlspecialchars(filter_input(INPUT_POST, 'cp'));
        $userPassword = htmlspecialchars(filter_input(INPUT_POST, 'pwd'));
        $userType = htmlspecialchars(filter_input(INPUT_POST, 'type'));
        $idUsers = filter_input(INPUT_POST, 'id_user');
        //=======================================
        //Nom
        if ($userNom !== "") {
            $item = "nom = '{$userNom}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }
        //=======================================
        //Prenom
        if ($userPrenom !== "") {
            $item = "prenom = '{$userPrenom}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }
        //=======================================
        //Mail
        if ($userMail !== "") {
            $item = "mail = '{$userMail}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }
        //=======================================
        // Adresse
        if ($userAdress !== "") {
            $item = "adress = '{$userAdress}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }

        //=======================================
        // Ville
        if ($userVille !== "") {
            $item = "city = '{$userVille}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }
        //=======================================
        // CP
        if ($userCp !== "") {
            $item = "cp = '{$userCp}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }
        //=======================================
        // mot de passe
        if ($userPassword !== "") {
            $option = ['cost' => 12,];
            $hash = password_hash($userPassword, PASSWORD_BCRYPT, $option);

            $item = "pwd = '{$hash}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }
        //=======================================
        //=======================================
        // userType
        if ($userType !== "") {

            $item = "type = '{$userType}'";
            $condition = "id_user = '{$idUsers}'";
            $this->model->udapte($item, $condition);
        }
        $utilisateur = $this->model->showAll("id_user = $idUsers");
        echo json_encode($utilisateur);
    }

    // ===================================================================================================
    // ===============================        delete    ===================================
    // ===================================================================================================
    public function delete()
    {
        $this->checkAdmin();

        //supprime un utilisateur
        $id = filter_input(INPUT_GET, 'id');
        $condition = "id_user = " . $id;
        $this->model->delete($condition);

        echo json_encode($id);
    }
}
