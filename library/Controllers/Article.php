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
        session_start();
        $categorie = $this->model->showAll("category");
        $articles = $this->model->showAllTable(1);
        $alert = $this->model->alert($_SESSION['id']);
        $pageTitle = 'Accueil';
        //avec le renderer je gere les vu la ba pour eviter de repeter le code
        \Renderer::render('articles/index', compact('pageTitle', 'articles', 'categorie', 'alert'));
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
        session_start();
        // $categorie = $this->model->showAll("category");
        $articles = $this->model->showAllTable(1);
        $pageTitle = 'all articles';
        //avec le renderer je gere les vu la ba pour eviter de repeter le code
        \Renderer::render('articles/allArticle', compact('pageTitle', 'articles'));
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
    // ===============================        addArticle    ==============================================
    // ===================================================================================================

    public function addArticle()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {

            //$typeAdd = htmlspecialchars(filter_input(INPUT_POST, 'type'));
            $titreAdd = htmlspecialchars(filter_input(INPUT_POST, 'titre'));
            $categorie = filter_input(INPUT_POST, 'categorie');
            $idUser = $_SESSION['id'];
            $description = htmlspecialchars(filter_input(INPUT_POST, 'description'));


            //=================================================

            //====================================================

            if (!empty($_FILES['fichier']) && !empty($description) && !empty($titreAdd) && !empty($categorie) && !empty($idUser)) {

                $contenu = $_FILES['fichier']['tmp_name'];
                $size = $_FILES['fichier']['size'];
                $name = $_FILES['fichier']['name'];
                $extension = $_FILES['fichier']['type'];
                $error = $_FILES['fichier']['error'];
                // explode dcoupe une chaine en fonction du caractere donné exemple:
                // salon.jpg =========== [salon, jpg] 
                $tableExtension = explode('.', $name);

                // end permet de prendre le dernier élement du tableau
                // strtolower = renvoie une chaine de caractere en minuscule
                $extension = strtolower(end($tableExtension));

                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'bmp' || $extension == 'tif') {
                    $typeAdd = "image";
                } else {
                    $typeAdd = "video";
                }


                // type de fichier autorisé
                $extensionAutorise = ['jpg', 'jpeg', 'png', 'bmp', 'tif', 'mp4', 'mov', 'avi', 'wmv'];
                // taille de fichier autorisé
                $tailleAutorise = 5000000;

                // in_array = indique si une valeur appartient à un tableau
                $response = compact('contenu', 'size', 'name', 'extension', 'error', 'extensionAutorise', 'tailleAutorise');

                if (in_array($extension, $extensionAutorise)) {
                    if ($size <= $tailleAutorise) {
                        if ($error == 0) {
                            $uniqueId = uniqid('', true);
                            $fileName = $uniqueId . "." . $extension;

                            $b = compact('typeAdd', 'titreAdd', 'description', 'fileName', 'categorie', 'idUser');
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
    // ===============================        one Article modify    ======================================
    // ===================================================================================================

    public function modifArticle()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {

            $id = filter_input(INPUT_GET, "id");
            $i = "articles.idArticle = $id";
            $articles = $this->model->showAllTable($i);
            $themes = $this->model->showAll("categorie");


            $pageTitle = 'modifier un article';
            // ob_start();
            // require_once('templates/articles/modifArticle.html.php');
            // $pageContent = ob_get_clean();
            // require_once('templates/layout.html.php');
            \Renderer::render('articles/modifArticle', compact('pageTitle', 'articles', 'i', 'themes'));
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
            $table = "pret";
            $col = "back";
            $reponse = 1;
            $condition = "id_pret";
            $this->model->udaptePret($table, $col, $reponse, $condition, $id);
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
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {

            // $typeAdd = htmlspecialchars(filter_input(INPUT_POST, 'type'));
            $titreAdd = htmlspecialchars(filter_input(INPUT_POST, 'titre'));
            $categorie = filter_input(INPUT_POST, 'categorie');
            $idArticle = filter_input(INPUT_POST, 'id');
            $description = htmlspecialchars(filter_input(INPUT_POST, 'description'));
            $fichierDelete = htmlspecialchars(filter_input(INPUT_POST, 'deleteFichier'));

            //============================================================
            // titre
            if ($titreAdd !== "") {
                $item = "titre = '{$titreAdd}'";
                $condition = "idArticle = '{$idArticle}'";
                $this->model->udapte($item, $condition);
                $this->udapteDate($idArticle);
                echo json_encode(1);
            }

            //============================================================
            // categori
            if ($categorie > 0) {
                $item = "idCategorie = '{$categorie}'";
                $condition = "idArticle = '{$idArticle}'";
                $this->model->udapte($item, $condition);
                $this->udapteDate($idArticle);
                echo json_encode(1);
            }

            //============================================================
            // desription
            if ($description !== "") {
                $item = "contenu = '{$description}'";
                $condition = "idArticle = '{$idArticle}'";
                $this->model->udapte($item, $condition);
                $this->udapteDate($idArticle);
                echo json_encode(1);
            }
            //============================================================
            // fichier et type

            if ($_FILES['fichier']['name'] !== "") {

                $contenu = $_FILES['fichier']['tmp_name'];
                $size = $_FILES['fichier']['size'];
                $name = $_FILES['fichier']['name'];
                $extension = $_FILES['fichier']['type'];
                $error = $_FILES['fichier']['error'];
                // explode dcoupe une chaine en fonction du caractere donné exemple:
                // salon.jpg =========== [salon, jpg] 
                $tableExtension = explode('.', $name);
                // end permet de prendre le dernier élement du tableau
                // strtolower = renvoie une chaine de caractere en minuscule
                $extension = strtolower(end($tableExtension));
                // type de fichier autorisé
                $extensionAutorise = ['jpg', 'jpeg', 'png', 'bmp', 'tif', 'mp4', 'mov', 'avi', 'wmv'];
                // taille de fichier autorisé
                $tailleAutorise = 5000000;

                // in_array = indique si une valeur appartient à un tableau
                $response = compact('contenu', 'size', 'name', 'extension', 'error', 'extensionAutorise', 'tailleAutorise');



                if (in_array($extension, $extensionAutorise)) {
                    if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'bmp' || $extension == 'tif') {
                        $type = "image";
                    } else {
                        $type = "video";
                    }

                    if ($size <= $tailleAutorise) {
                        if ($error == 0) {
                            $uniqueId = uniqid('', true);
                            $fileName = $uniqueId . "." . $extension;

                            $b = compact('typeAdd', 'titreAdd', 'description', 'fileName', 'categorie', 'idUser');
                            //========================================================
                            // changemeent du type
                            $item = "Type = '{$type}'";
                            $condition = "idArticle = '{$idArticle}'";
                            $this->model->udapte($item, $condition);
                            //========================================================
                            // changemeent du fichier
                            $item = "imageArticle = '{$fileName}'";
                            $condition = "idArticle = '{$idArticle}'";
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
                            $this->udapteDate($idArticle);
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
        }
    }

    // ===================================================================================================
    // ===============================        delete    ===================================
    // ===================================================================================================
    public function delete()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {

            $id = filter_input(INPUT_GET, 'id');
            $condition = "idarticle = " . $id;
            $this->model->delete($condition);
            $fileName = $_POST['fichier'];

            $delete = "./upload/" . $fileName;
            if (file_exists($delete)) {
                // unlin = suprime un fichier
                unlink($delete);
            }

            header("Location: index.php?controller=article&Task=myArticles");
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
    // ===============================        showOne    ===========================================
    // ===================================================================================================

    public function showOne()
    {
        $id = filter_input(INPUT_GET, 'id');
        $id = "articles.id_article = $id";
        $articles = $this->model->showAllTable($id);

        $pageTitle = $articles[0]['titre'];

        \Renderer::render('articles/oneArticle', compact('pageTitle', 'articles'));
    }
}
