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
        if (!isset($_SESSION)) {
            session_start();
        }
        $categorie = $this->model->showAll("category");
        $articles = $this->model->showAllTable(1);

        if (!isset($_SESSION)) {
            $id = $_SESSION['id'];
            $alert = $this->model->alert($id);
        } else {
            $alert = "";
        }
        $verif = $this->model->verifVue();
        $control = [];
        foreach ($verif as $verification) {
            array_push($control, $verification['colone']);
        }


        $pageTitle = 'Accueil';
        //avec le renderer je gere les vu la ba pour eviter de repeter le code
        \Renderer::render('articles/index', compact('pageTitle', 'articles', 'categorie', 'alert', 'control'));
    }
    // ===================================================================================================
    // ===============================        myArticles    ===========================================
    // ===================================================================================================

    public function myArticles()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {
            $id = $_SESSION['id'];
            $articles = $this->model->showAllPre($id);

            $pageTitle = 'mes réservations';
            \Renderer::render('articles/myArticle', compact('pageTitle', 'articles'));
        }
    }
    // ===================================================================================================
    // ===============================        allArticle    ===========================================
    // ===================================================================================================

    public function allArticle()
    {
        if (!isset($_SESSION)) {

            session_start();
        }
        $verif = $this->model->verifVue();
        $control = [];
        foreach ($verif as $verification) {
            array_push($control, $verification['colone']);
        }
        $articles = $this->model->showAllTable(1);
        $pageTitle = 'all articles';


        \Renderer::render('articles/allArticle', compact('pageTitle', 'articles', 'control'));
    }
    // ===================================================================================================
    // ===============================        historique    ===========================================
    // ===================================================================================================

    public function historique()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {
            $id = $_SESSION['id'];
            $articles = $this->model->showHistorique($id);

            $pageTitle = 'Historique';
            \Renderer::render('articles/historique', compact('pageTitle', 'articles'));
        }
    }
    // ===================================================================================================
    // ===============================        addArticle    ===========================================
    // ===================================================================================================

    public function addArticle()
    {
        if (($_SESSION['userType'] !== "admin")) {
            header('Location: index.php?controller=article&task=index');
        } else {
            $id = $_SESSION['id'];
            $themes = $this->model->showAll("category");

            $pageTitle = 'Rajouter un article';
            \Renderer::render('articles/addArticle', compact('pageTitle', 'themes'));
        }
    }

    // ===================================================================================================
    // ===============================        adminPersonalisation    ===========================================
    // ===================================================================================================

    public function adminPersonalisation()
    {
        if (($_SESSION['userType'] !== "admin")) {
            header('Location: index.php?controller=article&task=index');
        } else {

            $pageTitle = 'Personnaliser l\'affichage';
            \Renderer::render('articles/adminPersonalisation', compact('pageTitle', 'themes'));
        }
    }

    // ===================================================================================================
    // ===============================        adminEmprunts    ===========================================
    // ===================================================================================================
    public function adminEmprunts()
    {
        if ($_SESSION['userType'] !== "admin") {
            header('Location: index.php?controller=article&task=index');
        } else {
            $pageTitle = 'Admin emprunt';
            $articles = $this->model->showAllPretAdmin("");
            \Renderer::render('articles/adminEmprunts', compact('pageTitle', 'articles'));
        }
    }
    // ===================================================================================================
    // ===============================        adminSituation    ===========================================
    // ===================================================================================================
    public function adminSituation()
    {
        if ($_SESSION['userType'] !== "admin") {
            header('Location: index.php?controller=article&task=index');
        } else {
            $pageTitle = 'Impression de la situation';
            $id = filter_input(INPUT_GET, 'id');
            $articles = $this->model->showAllPretAdmin($id);
            \Renderer::render('articles/adminSituation', compact('pageTitle', 'articles'));
        }
    }

    // ===================================================================================================
    // ===============================        filtreSelection    ===========================================
    // ===================================================================================================

    public function filtreSelection()
    {
        $tableau = [];
        $endArray = [];
        if (isset($_POST['category'])) {
            $category = $_POST['category'];
        }
        if (isset($_POST['genre'])) {
            $genre = $_POST['genre'];
        }
        if (isset($_POST['auteur'])) {
            $auteur = $_POST['auteur'];
        }
        if (isset($_POST['collection'])) {
            $collection = $_POST['collection'];
        }
        if (isset($_POST['edition'])) {
            $edition = $_POST['edition'];
        }
        $endArray = compact("category", 'genre', 'auteur', 'collection', 'edition');

        $response = $this->model->filtre($endArray);

        echo json_encode($response);
    }

    // ===================================================================================================
    // ===============================        add    ==============================================
    // ===================================================================================================

    public function add()
    {
        if (($_SESSION['userType'] !== "admin")) {
            header('Location: index.php?controller=article&task=index');
        } else {

            //$typeAdd = htmlspecialchars(filter_input(INPUT_POST, 'type'));
            $titre = htmlspecialchars(filter_input(INPUT_POST, 'titre'));
            $aut = htmlspecialchars(filter_input(INPUT_POST, 'auteur'));
            $gen = htmlspecialchars(filter_input(INPUT_POST, 'genre'));
            $coll = htmlspecialchars(filter_input(INPUT_POST, 'collection'));
            $edit = htmlspecialchars(filter_input(INPUT_POST, 'edition'));
            $desc = htmlspecialchars(filter_input(INPUT_POST, 'description'));
            $categorie = htmlspecialchars(filter_input(INPUT_POST, 'category'));

            //=================================================

            //====================================================

            if (!empty($_FILES['image']) && !empty($titre) && !empty($aut) && !empty($gen) && !empty($coll) && !empty($edit) && !empty($desc) && !empty($categorie)) {

                $contenu = $_FILES['image']['tmp_name'];
                $size = $_FILES['image']['size'];
                $name = $_FILES['image']['name'];
                $extension = $_FILES['image']['type'];
                $error = $_FILES['image']['error'];
                // explode dcoupe une chaine en fonction du caractere donné exemple:
                // salon.jpg =========== [salon, jpg] 
                $tableExtension = explode('.', $name);

                // end permet de prendre le dernier élement du tableau
                // strtolower = renvoie une chaine de caractere en minuscule
                $extension = strtolower(end($tableExtension));

                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
                    $typeAdd = "image";
                }


                // type de fichier autorisé
                $extensionAutorise = ['jpg', 'jpeg', 'png'];
                // taille de fichier autorisé
                $tailleAutorise = 5000000;

                // in_array = indique si une valeur appartient à un tableau
                $response = compact('contenu', 'size', 'name', 'extension', 'error', 'extensionAutorise', 'tailleAutorise');

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
    }

    // ===================================================================================================
    // ===============================        modifArticle    ======================================
    // ===================================================================================================

    public function modifArticle()
    {
        if ($_SESSION['userType'] !== "admin") {
            header('Location: index.php?controller=article&task=index');
        } else {

            $id = filter_input(INPUT_GET, "id");
            $articles = $this->model->modifArticle($id);
            $cat = $this->model->showAll("category");

            $pageTitle = 'modifier un article';
            \Renderer::render('articles/modifArticle', compact('pageTitle', 'articles', 'cat'));
        }
    }

    // ===================================================================================================
    // ===============================        rendre reservation    ======================================
    // ===================================================================================================
    public function back()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {
            $id = filter_input(INPUT_GET, "id");
            //$table = "pret";
            //$col = "back";
            // $reponse = 1;
            //$condition = "id_pret";
            $this->model->udaptePret($id);
            $this->model->udapte("emprunt = 0", "id_article = $id");
            echo json_encode($id);
        }
    }
    // ===================================================================================================
    // ===============================        udapte reservation    ======================================
    // ===================================================================================================

    public function reservation()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {

            $id = filter_input(INPUT_POST, "id");
            $bool = filter_input(INPUT_POST, "bool");
            $item = "emprunt = $bool";
            $condition = "id_article = {$id}";
            $this->model->udapte($item, $condition);
            $this->udapteDate($id);
            $date = $this->date();
            $idUser = $_SESSION['id'];
            $data = compact('idUser', 'id', 'date');
            $this->model->createPret($data);
            if ($bool == true) {
                echo json_encode('Vous avez rendu l\'article');
            } else {
                echo json_encode('Vous avez réservé l\'article');
            }
        }
    }

    // ===================================================================================================
    // ===============================        date    ======================================
    // ===================================================================================================

    public function date()
    {
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
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {

            $date = $this->date();
            $item = "date_emprunt = '{$date['dateNow']}', dateRetour = '{$date['dateEnd']}'";
            $condition = "id_article = '{$idArticle}'";
            $this->model->udapte($item, $condition);
        }
    }

    // ===================================================================================================
    // ===============================        Valide Article modify    ===================================
    // ===================================================================================================

    public function valideModif()
    {
        if ($_SESSION['userType'] !== "admin") {
            header('Location: index.php?controller=article&task=index');
        } else {

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
            if ($titre !== "") {
                $item = "titre = '{$titre}'";
                $condition = "id_article = '{$idArticle}'";
                $this->model->udapte($item, $condition);
            }
            //============================================================
            // auteur
            if ($aut !== "") {
                $item = "auteur = '{$aut}'";
                $condition = "id_article = '{$idArticle}'";
                $this->model->udapte($item, $condition);
            }
            //============================================================
            // genre
            if ($gen !== "") {
                $item = "genre = '{$gen}'";
                $condition = "id_article = '{$idArticle}'";
                $this->model->udapte($item, $condition);
            }

            //============================================================
            // categori
            if ($categorie > 0) {
                $item = "id_category = {$categorie}";
                $condition = "id_article = {$idArticle}";
                $this->model->udapte($item, $condition);
                $this->udapteDate($idArticle);
            }

            //============================================================
            // desription
            if ($desc !== "") {
                $item = "description = '{$desc}'";
                $condition = "id_article = '{$idArticle}'";
                $this->model->udapte($item, $condition);
            }
            //============================================================
            // edition
            if ($edit !== "") {
                $item = "edition = '{$edit}'";
                $condition = "id_article = '{$idArticle}'";
                $this->model->udapte($item, $condition);
            }
            //============================================================
            // collection
            if ($coll !== "") {
                $item = "collection = '{$coll}'";
                $condition = "id_article = '{$idArticle}'";
                $this->model->udapte($item, $condition);
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
                            $item = "file = '{$fileName}'";
                            $condition = "id_article = '{$idArticle}'";
                            $this->model->udapte($item, $condition);

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
    }

    // ===================================================================================================
    // ===============================        delete    ===================================
    // ===================================================================================================
    public function delete()
    {
        if ($_SESSION['userType'] !== "admin") {
            header('Location: index.php?controller=article&task=index');
        } else {

            $id = filter_input(INPUT_GET, 'id');
            $condition = "id_article = " . $id;
            $fileName = filter_input(INPUT_GET, 'file');

            $this->model->delete($condition);

            $delete = "./upload/" . $fileName;
            if (file_exists($delete)) {
                // unlink = suprime un fichier
                unlink($delete);
            }

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
        $articles = $this->model->showAllTable($id);
        $verif = $this->model->verifVue();
        $control = [];
        foreach ($verif as $verification) {
            array_push($control, $verification['colone']);
        }


        $pageTitle = $articles[0]['titre'];

        \Renderer::render('articles/oneArticle', compact('pageTitle', 'articles', 'control'));
    }
}
