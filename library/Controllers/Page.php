<?php

namespace Controllers;


class Page extends Controller
{

    protected $modelName = \Models\Page::class;
    // ===================================================================================================
    // ===============================        adminSauvegarde    =========================================
    // ===================================================================================================
    public function adminSauvegarde()
    {
        if (($_SESSION['userType'] == "admin")) {
            header('Location: index.php?controller=article&task=index');
        } else {
            $pageTitle = 'Admin sauvegarde';
            \Renderer::render('articles/adminSauvegarde', compact('pageTitle'));
        }
    }
    // ===================================================================================================
    // ===============================        connexion    ===============================================
    // ===================================================================================================

    public function connexion()
    {
        $pageTitle = 'connexion';
        \Renderer::render('articles/connexion', compact('pageTitle'));
    }
    // ===================================================================================================
    // ===============================        inscription    =============================================
    // ===================================================================================================

    public function inscription()
    {
        $pageTitle = 'inscription';
        \Renderer::render('articles/inscription', compact('pageTitle'));
    }

    // ===================================================================================================
    // ===============================        adminInscription    ========================================
    // ===================================================================================================
    public function adminInscription()
    {
        if (($_SESSION['userType'] !== "admin")) {
            header('Location: index.php?controller=article&task=index');
        } else {
            $pageTitle = 'Admin inscription';
            \Renderer::render('articles/adminInscription', compact('pageTitle'));
        }
    }
    // ===================================================================================================
    // ===============================        addArticle    =============================================
    // ===================================================================================================
    public function addArticle()
    {
        if (!isset($_SESSION['userType'])) {
            header('Location: index.php?controller=article&task=index');
        } else {
            $themes = $this->model->showAll("categorie");
            $pageTitle = 'profil';
            \Renderer::render('articles/addArticle', compact('pageTitle', 'themes'));
        }
    }
}
