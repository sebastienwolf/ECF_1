<?php

namespace Controllers;


class Article extends Controller
{

    protected $modelName = \Models\Article::class;



    // ===================================================================================================
    // ===============================        index    ===========================================
    // ===================================================================================================

    public function index()
    {
        //si pas de session lance une session
        $this->checkSession();
        //appelle les categories
        $categorie = $this->model->showAll("category");
        //appelle les articles
        $articles = $this->model->showAllTable(1);
        //s'il y a une session  cherche les retards des emprunts de l'utilisateur
        if (isset($_SESSION)) {
            $id = $_SESSION['id'];
            $alert = $this->model->alert($id);
        } else {
            $alert = "";
        }
        //s'il y a une session  cherche les retards des emprunts des utilisateurs

        if (isset($_SESSION)) {
            if ($_SESSION['userType'] == "admin") {
                $id = $_SESSION['id'];
                $alertAdmin = $this->model->alertAdmin();
            } else {
                $alertAdmin = "";
            }
        } else {
            $alertAdmin = "";
        }
        //vérifie ce qui doit être visible dans la table personnalisation
        $verif = $this->model->verifVue();
        $control = [];
        foreach ($verif as $verification) {
            array_push($control, $verification['colone']);
        }


        $pageTitle = 'Accueil';
        //avec le renderer je gere les vu la ba pour eviter de repeter le code
        \Renderer::render('articles/index', compact('pageTitle', 'articles', 'categorie', 'alert', 'alertAdmin', 'control'));
    }
    // ===================================================================================================
    // ===============================        myArticles    ===========================================
    // ===================================================================================================

    public function myArticles()
    {
        $this->checkUser();
        $id = $_SESSION['id'];
        //appelle les réservations en cours de l'utilisateur
        $articles = $this->model->showAllPre($id);

        $pageTitle = 'Mes réservations';
        \Renderer::render('articles/myArticle', compact('pageTitle', 'articles'));
    }
    // ===================================================================================================
    // ===============================        allArticle    ===========================================
    // ===================================================================================================

    public function allArticle()
    {
        $this->checkSession();
        // verifie la table personnalisation
        $verif = $this->model->verifVue();
        $control = [];
        foreach ($verif as $verification) {
            array_push($control, $verification['colone']);
        }
        //============================================
        //appelle les cards
        $articles = $this->model->showAllTable(1);
        $pageTitle = 'All articles';
        //============================================
        //appelle les categories
        $idCateg = $this->model->showCat();
        $idCat = [];
        foreach ($idCateg as $verification) {
            array_push($idCat, $verification['name']);
        }
        //============================================
        //appelle les genres
        $idFiltre = $this->model->showFiltre("genre", 1);
        $idGen = [];
        foreach ($idFiltre as $verification) {
            array_push($idGen, $verification['genre']);
        }
        //============================================
        //appelle les auteurs
        $idFiltre = $this->model->showFiltre("auteur", 1);
        $idAut = [];
        foreach ($idFiltre as $verification) {
            array_push($idAut, $verification['auteur']);
        }
        //============================================
        //appelle les collections
        $idFiltre = $this->model->showFiltre("collection", 1);
        $idCol = [];
        foreach ($idFiltre as $verification) {
            array_push($idCol, $verification['collection']);
        }
        //============================================
        //appelle les editions
        $idFiltre = $this->model->showFiltre("edition", 1);
        $idEdit = [];
        foreach ($idFiltre as $verification) {
            array_push($idEdit, $verification['edition']);
        }
        //============================================
        \Renderer::render('articles/allArticle', compact('pageTitle', 'articles', 'control', 'idCat', 'idGen', 'idAut', 'idCol', 'idEdit'));
    }
    // ===================================================================================================
    // ===============================        historique    ===========================================
    // ===================================================================================================

    public function historique()
    {
        $this->checkUser();
        $id = $_SESSION['id'];
        //appelle toutes les réservations passé
        $articles = $this->model->showHistorique($id);

        $pageTitle = 'Historique';
        \Renderer::render('articles/historique', compact('pageTitle', 'articles'));
    }
    // ===================================================================================================
    // ===============================        addArticle    ===========================================
    // ===================================================================================================

    public function addArticles()
    {
        $this->checkAdmin();
        $id = $_SESSION['id'];
        //appelle les categories
        $themes = $this->model->showAll("category");

        $pageTitle = 'Rajouter un article';
        \Renderer::render('articles/addArticle', compact('pageTitle', 'themes'));
    }

    // ===================================================================================================
    // ===============================        adminPersonalisation    ===========================================
    // ===================================================================================================

    public function adminPersonalisation()
    {
        $this->checkAdmin();

        $pageTitle = 'Personnaliser l\'affichage';
        \Renderer::render('articles/adminPersonalisation', compact('pageTitle', 'themes'));
    }

    // ===================================================================================================
    // ===============================        adminEmprunts    ===========================================
    // ===================================================================================================
    public function adminEmprunts()
    {
        $this->checkAdmin();
        //appelle tous les emprunts en cours des utilisateurs
        $pageTitle = 'Admin emprunt';
        $articles = $this->model->showAllPretAdmin("");
        \Renderer::render('articles/adminEmprunts', compact('pageTitle', 'articles'));
    }
    // ===================================================================================================
    // ===============================        adminSituation    ===========================================
    // ===================================================================================================
    public function adminSituation()
    {
        $this->checkAdmin();
        $pageTitle = 'Impression de la situation';
        $id = filter_input(INPUT_GET, 'id');
        //appelle tout les emprunt en cours de l'utilisateur
        $articles = $this->model->showAllPretAdmin($id);
        \Renderer::render('articles/adminSituation', compact('pageTitle', 'articles'));
    }

    // ===================================================================================================
    // ===============================        filtreSelection    ===========================================
    // ===================================================================================================

    public function filtreSelection()
    {
        //appelle tous les champs de chaque colonne
        $tableau = [];
        $endArray = [];
        if (isset($_POST['idCat'])) {
            //categorie
            $category = $_POST['idCat'];
        }
        if (isset($_POST['idGen'])) {
            //genre
            $genre = $_POST['idGen'];
        }
        if (isset($_POST['idAut'])) {
            //auteur
            $auteur = $_POST['idAut'];
        }
        if (isset($_POST['idCol'])) {
            //collection
            $collection = $_POST['idCol'];
        }
        if (isset($_POST['idEdit'])) {
            //edition
            $edition = $_POST['idEdit'];
        }
        //compact les variables pour les envoyer
        $endArray = compact("category", 'genre', 'auteur', 'collection', 'edition');

        $response = $this->model->filtre($endArray);

        echo json_encode($response);
    }

    // ===================================================================================================
    // ===============================        add    ==============================================
    // ===================================================================================================

    public function addArticle()
    {
        //function qui vérifie si on est administrateur sinon
        //il fait une redirection à l'accueil
        $this->checkAdmin();
        //récupere les données et les sécuriser
        $titre = htmlspecialchars(filter_input(INPUT_POST, 'titre'));
        $aut = htmlspecialchars(filter_input(INPUT_POST, 'auteur'));
        $gen = htmlspecialchars(filter_input(INPUT_POST, 'genre'));
        $coll = htmlspecialchars(filter_input(INPUT_POST, 'collection'));
        $edit = htmlspecialchars(filter_input(INPUT_POST, 'edition'));
        $desc = htmlspecialchars(filter_input(INPUT_POST, 'description'));
        $categorie = htmlspecialchars(filter_input(INPUT_POST, 'category'));
        if (
            !empty($_FILES['image']) && !empty($titre) && !empty($aut) && !empty($gen)
            && !empty($coll) && !empty($edit) && !empty($desc) && !empty($categorie)
        ) {
            $contenu = $_FILES['image']['tmp_name'];
            $size = $_FILES['image']['size'];
            $name = $_FILES['image']['name'];
            $extension = $_FILES['image']['type'];
            $error = $_FILES['image']['error'];
            $tableExtension = explode('.', $name);
            $extension = strtolower(end($tableExtension));
            $extensionAutorise = ['jpg', 'jpeg', 'png'];
            $tailleAutorise = 5000000;
            if (in_array($extension, $extensionAutorise)) {
                if ($size <= $tailleAutorise) {
                    if ($error == 0) {
                        $uniqueId = uniqid('', true);
                        $fileName = $uniqueId . "." . $extension;
                        $b = compact('titre', 'aut', 'gen', 'coll', 'edit', 'desc', 'categorie', 'fileName');
                        $this->model->insertArticle($b);
                        // move_uploaded_file = deplace le fichier la ou on le décide
                        move_uploaded_file($contenu, './upload/' . $fileName);
                        echo json_encode(1);
                        // 1 = votre fichiers est envoyé
                    } else {
                        echo json_encode(5);
                        // 5 = il y a une erreur
                    }
                } else {
                    echo json_encode(4);
                    // 4 = le fichier est trop grand il ne peut dépassé 5M
                }
            } else {
                echo json_encode(3);
                // 3 = le fichier n'est pas compatible avec notre site
            }
        } else {
            echo json_encode(2);
            // 2 = il manque des données
        }
    }

    // ===================================================================================================
    // ===============================        modifArticle    ======================================
    // ===================================================================================================

    public function modifArticle()
    {
        $this->checkAdmin();

        $id = filter_input(INPUT_GET, "id");
        //appelle les informations de l'article
        $articles = $this->model->modifArticle($id);
        //appelle les categories pour le select
        $cat = $this->model->showAll("category");

        $pageTitle = 'modifier un article';
        \Renderer::render('articles/modifArticle', compact('pageTitle', 'articles', 'cat'));
    }

    // ===================================================================================================
    // ===============================        rendre reservation    ======================================
    // ===================================================================================================
    public function back()
    {
        $this->checkUser();
        $id = filter_input(INPUT_GET, "id");
        //modification de la colone back de emprunt pour changer son status
        $this->model->udaptePret($id);
        //modification de la colonne emprunt de articles pour le remettre disponible  
        $column = "emprunt";
        $value = 0;
        $condition = "id_article";

        $this->model->udapte($column, $value, $condition, $id);
        echo json_encode($id);
    }
    // ===================================================================================================
    // ===============================        udapte reservation    ======================================
    // ===================================================================================================

    public function reservation()
    {
        $this->checkUser();
        $id = filter_input(INPUT_POST, "id");
        $bool = filter_input(INPUT_POST, "bool");
        $colomn = "emprunt";
        $value = $bool;
        $condition = "id_article";
        //enlève l'article du stock change la colonne emprunt de article
        $this->model->udapte($colomn, $value, $condition, $id);
        //ajoute la date du jour de la reservation dans articles
        $this->udapteDate($id);
        //crée les dates pour la table emprunt
        $date = $this->date();
        $idUser = $_SESSION['id'];
        $data = compact('idUser', 'id', 'date');
        //crée les dates dans emprunts
        $this->model->createPret($data);
        if ($bool !== true) {
            echo json_encode('Vous avez rendu l\'article');
        } else {
            echo json_encode('Vous avez réservé l\'article');
        }
    }

    // ===================================================================================================
    // ===============================        date    ======================================
    // ===================================================================================================

    public function date()
    {
        //crée la date du jour et rajoute 7 jours pour le retour
        $dateNow = date('Y-m-d', time());
        $nextWeek = time() + (7 * 24 * 60 * 60);
        $dateEnd = date('Y-m-d', $nextWeek);
        $test = compact('dateNow', 'dateEnd');
        return ($test);
    }
    // ===================================================================================================
    // ===============================        udaptedate    ======================================
    // ===================================================================================================

    public function udapteDate($idArticle)
    {
        $this->checkUser();
        //fait la modification des date dans articles pour l'emprunt sur la table article
        $date = $this->date();
        $colomn = "date_emprunt";
        $value = $date['dateNow'];
        $colomnDeux = "dateRetour";
        $valueDeux = $date['dateEnd'];
        $condition = "id_article";
        $id = $idArticle;
        $this->model->udapteDate($colomn, $value, $colomnDeux, $valueDeux, $condition, $id);
    }

    // ===================================================================================================
    // ===============================        Valide Article modify    ===================================
    // ===================================================================================================

    public function valideModif()
    {
        $this->checkAdmin();
        $titre = htmlspecialchars(filter_input(INPUT_POST, 'titre'));
        $aut = htmlspecialchars(filter_input(INPUT_POST, 'auteur'));
        $gen = htmlspecialchars(filter_input(INPUT_POST, 'genre'));
        $coll = htmlspecialchars(filter_input(INPUT_POST, 'collection'));
        $edit = htmlspecialchars(filter_input(INPUT_POST, 'edition'));
        $desc = htmlspecialchars(filter_input(INPUT_POST, 'description'));
        $categorie = htmlspecialchars(filter_input(INPUT_POST, 'category'));
        $idArticle = htmlspecialchars(filter_input(INPUT_POST, 'id_article'));
        $fichierDelete = htmlspecialchars(filter_input(INPUT_POST, 'del'));
        //============================================================
        // titre
        if ($titre) {
            $column = "titre";
            $value = $titre;
            $condition = "id_article";
            $id = $idArticle;
            $this->model->udapte($column, $value, $condition, $id);
        }
        //============================================================
        // auteur
        if ($aut) {
            $column = "auteur";
            $value = $aut;
            $condition = "id_article";
            $id = $idArticle;
            $this->model->udapte($column, $value, $condition, $id);
        }
        //============================================================
        // genre
        if ($gen) {
            $column = "genre";
            $value = $gen;
            $condition = "id_article";
            $id = $idArticle;
            $this->model->udapte($column, $value, $condition, $id);
        }

        //============================================================
        // categori
        if ($categorie > 0) {
            $column = "id_category";
            $value = $categorie;
            $condition = "id_article";
            $id = $idArticle;
            $this->model->udapte($column, $value, $condition, $id);
            $this->udapteDate($idArticle);
        }

        //============================================================
        // desription
        if ($desc !== "") {
            $column = "description";
            $value = $desc;
            $condition = "id_article";
            $id = $idArticle;
            $this->model->udapte($column, $value, $condition, $id);
        }
        //============================================================
        // edition
        if ($edit !== "") {
            $column = "edition";
            $value = $edit;
            $condition = "id_article";
            $id = $idArticle;
            $this->model->udapte($column, $value, $condition, $id);
        }
        //============================================================
        // collection
        if ($coll !== "") {
            $column = "collection";
            $value = $coll;
            $condition = "id_article";
            $id = $idArticle;
            $this->model->udapte($column, $value, $condition, $id);
        }
        //============================================================
        // fichier et type

        if ($_FILES['file']['name'] !== "") {

            $contenu = $_FILES['file']['tmp_name'];
            $size = $_FILES['file']['size'];
            $name = $_FILES['file']['name'];
            $extension = $_FILES['file']['type'];
            $error = $_FILES['file']['error'];
            // explode dcoupe une chaine en fonction du caractere donné exemple:
            // salon.jpg =========== [salon, jpg] 
            $tableExtension = explode('.', $name);
            // end permet de prendre le dernier élement du tableau
            // strtolower = renvoie une chaine de caractere en minuscule
            $extension = strtolower(end($tableExtension));
            // type de fichier autorisé
            $extensionAutorise = ['jpg', 'jpeg', 'png'];
            // taille de fichier autorisé
            $tailleAutorise = 5000000;

            // in_array = indique si une valeur appartient à un tableau
            $response = compact('contenu', 'size', 'name', 'extension', 'error', 'extensionAutorise', 'tailleAutorise');



            if (in_array($extension, $extensionAutorise)) {
                $type = "image";

                if ($size <= $tailleAutorise) {
                    if ($error == 0) {
                        $uniqueId = uniqid('', true);
                        $fileName = $uniqueId . "." . $extension;

                        $b = compact('typeAdd', 'titreAdd', 'description', 'fileName', 'categorie', 'idUser');
                        //========================================================
                        // changemeent du fichier
                        $column = "file";
                        $value = $fileName;
                        $condition = "id_article";
                        $id = $idArticle;
                        $this->model->udapte($column, $value, $condition, $id);

                        // move_uploaded_file = deplace le fichier la ou on le décide
                        move_uploaded_file($contenu, './upload/' . $fileName);

                        //=========================================================
                        //preparation du delete
                        $delete = "./upload/" . $fichierDelete;
                        if (file_exists($delete)) {
                            // unlin = suprime un fichier
                            unlink($delete);
                        }
                        echo json_encode(1);
                    } else {
                        echo json_encode(5);
                        // 5 = il y a une erreur

                    }
                } else {
                    echo json_encode(4);
                    // 4 = le fichier est trop grand il ne peut dépassé 5M

                }
            } else {
                echo json_encode(3);
                // 3 = le fichier n'est pas compatible avec notre site
            }
        }
        $retour = $this->model->modifArticle($idArticle);
        $cat = $this->model->showAll("category");
        $a = compact('retour', 'cat');
        echo json_encode($a);
    }

    // ===================================================================================================
    // ===============================        delete    ===================================
    // ===================================================================================================
    public function delete()
    {
        $this->checkAdmin();
        $idArticle = filter_input(INPUT_GET, 'id');
        $fileNameArticle = filter_input(INPUT_GET, 'file');
        $condition = "id_article";

        $this->model->delete($condition, $idArticle);

        $delete = "./upload/" . $fileNameArticle;
        if (file_exists($delete)) {
            unlink($delete);
            header("Location: index.php?controller=article&task=index");
        }
    }
    // ===================================================================================================
    // ===============================        filtre    ===================================
    // ===================================================================================================
    public function showFiltre()
    {
        $id = filter_input(INPUT_GET, 'id');
        $condition = "articles.idCategorie = " . $id;

        if ($id == "dateUp" || $id == "dateDown") {
            if ($id == "dateUp") {
                $condition = "1 ORDER BY articles.udapteDate DESC";
            } else {
                $condition = "1 ORDER BY articles.udapteDate ASC";
            }
        }
        if ($id == "search") {

            $search = htmlspecialchars(filter_input(INPUT_POST, 'search'));
            if ($search == "") {
                $condition = 1;
            } else {
                $condition = "users.pseudo = '$search'";
            }
        }
        if ($id == "image" || $id == "video") {

            $condition = "articles.Type = '{$id}' ";
        }
        $response = $this->model->showAllTable($condition);
        echo  json_encode($response);
    }

    // ===================================================================================================
    // ===============================        filtre  test  ===================================
    // ===================================================================================================
    public function testFiltre($id)
    {
        if ($id == "un") {
            $condition = 1;
        } else {
            $id = filter_input(INPUT_GET, 'id');
            $condition = "articles.idCategorie = " . $id;
        }

        if ($id == "dateUp" || $id == "dateDown") {
            if ($id == "dateUp") {
                $condition = "1 ORDER BY articles.udapteDate DESC";
            } else {
                $condition = "1 ORDER BY articles.udapteDate ASC";
            }
        }


        $response = $this->model->showAllTable($condition);
        echo  json_encode($response);
    }

    // ===================================================================================================
    // ===============================        personalisation    ===================================
    // ===================================================================================================
    public function personalisation()
    {
        $this->checkAdmin();
        //Fait la modification de la table personnalisation pour gérer la vue des articles
        $titre = filter_input(INPUT_POST, 'titre');
        if (!isset($titre)) {
            $titre = 0;
        }
        $this->model->persoAdmin($titre, 1);
        //==============================
        $auteur = filter_input(INPUT_POST, 'auteur');

        if (!isset($auteur)) {
            $auteur = 0;
        }
        $this->model->persoAdmin($auteur, 2);
        //=============================================
        $genre = filter_input(INPUT_POST, 'genre');

        if (!isset($genre)) {
            $genre = 0;
        }
        $this->model->persoAdmin($genre, 3);
        //==========================================
        $collection = filter_input(INPUT_POST, 'collection');

        if (!isset($collection)) {
            $collection = 0;
        }
        $this->model->persoAdmin($collection, 4);
        //======================================

        $edition = filter_input(INPUT_POST, 'edition');

        if (!isset($edition)) {
            $edition = 0;
        }
        $this->model->persoAdmin($edition, 5);


        //==========================
        $description = filter_input(INPUT_POST, 'description');

        if (!isset($description)) {
            $description = 0;
        }
        $this->model->persoAdmin($description, 6);
        //====================================
        echo  json_encode(1);
    }



    // ===================================================================================================
    // ===============================        showOne    ===========================================
    // ===================================================================================================

    public function showOne()
    {
        $id = filter_input(INPUT_GET, 'id');
        $id = "articles.id_article = $id";
        //appelle les informations pour l'article selectionné
        $articles = $this->model->showAllTable($id);
        $verif = $this->model->verifVue();
        $control = [];
        foreach ($verif as $verification) {
            array_push($control, $verification['colone']);
        }


        $pageTitle = $articles[0]['titre'];

        \Renderer::render('articles/oneArticle', compact('pageTitle', 'articles', 'control'));
    }
    // ===================================================================================================
    // ===============================        filtre1    ===========================================
    // ===================================================================================================

    public function filtre1()
    {
        //récuperer les donnée des filtres
        $cat = filter_input(INPUT_POST, 'idCat');
        $gen = filter_input(INPUT_POST, 'idGen');
        $aut = filter_input(INPUT_POST, 'idAut');
        $col = filter_input(INPUT_POST, 'idCol');
        $edit = filter_input(INPUT_POST, 'idEdit');

        //si categorie choisie va chercher les information pour les autres filtres pour faire apparaitre que ceux qui sont ses enfants
        if (!empty($cat)) {
            $idGen = $this->model->showFiltreAvence("genre", 1, $cat);
            $idAut = $this->model->showFiltreAvence("auteur", 1, $cat);
            $idCol = $this->model->showFiltreAvence("collection", 1, $cat);
            $idEdit = $this->model->showFiltreAvence("edition", 1, $cat);
            $response = compact('idGen', 'idAut', 'idCol', 'idEdit');
        }
        //si genre choisie va chercher les information pour les autres filtres pour faire apparaitre que ceux qui sont ses enfants

        if (!empty($gen)) {
            $idAut = $this->model->showFiltreAvence("auteur", 2, $gen);
            $idCol = $this->model->showFiltreAvence("collection", 2, $gen);
            $idEdit = $this->model->showFiltreAvence("edition", 2, $gen);
            $response = compact('idAut', 'idCol', 'idEdit');
        }
        //si auteur choisie va chercher les information pour les autres filtres pour faire apparaitre que ceux qui sont ses enfants

        if (!empty($aut)) {
            $idCol = $this->model->showFiltreAvence("collection", 3, $aut);
            $idEdit = $this->model->showFiltreAvence("edition", 3, $aut);
            $response = compact('idCol', 'idEdit');
        }
        //si collection choisie va chercher les information pour le dernier filtre Edition

        if (!empty($col)) {
            $idEdit = $this->model->showFiltreAvence("edition", 4, $col);
            $response = compact('idEdit');
        }

        echo json_encode($response);
    }
}
