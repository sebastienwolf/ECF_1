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
        $this->checkAdmin();

        $pageTitle = 'Admin sauvegarde';
        \Renderer::render('articles/adminSauvegarde', compact('pageTitle'));
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
    // ===============================        inscriptionAdmin    =============================================
    // ===================================================================================================

    public function inscriptionAdmin()
    {
        $this->checkAdmin();
        $pageTitle = 'inscription Administrateur';
        \Renderer::render('articles/inscriptionAdmin', compact('pageTitle'));
    }

    // ===================================================================================================
    // ===============================        adminInscription    ========================================
    // ===================================================================================================
    public function adminInscription()
    {
        $this->checkAdmin();

        $pageTitle = 'Admin inscription';
        \Renderer::render('articles/adminInscription', compact('pageTitle'));
    }
    // ===================================================================================================
    // ===============================        addArticle    =============================================
    // ===================================================================================================
    public function addArticle()
    {
        $this->checkUser();
        //appelle les categories
        $themes = $this->model->showAll("categorie");
        $pageTitle = 'profil';
        \Renderer::render('articles/addArticle', compact('pageTitle', 'themes'));
    }
}
