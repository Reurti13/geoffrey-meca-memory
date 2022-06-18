<?php

namespace Controllers;

use Models\Form;
use Models\FormManager;
use Models\UserManager;

class ControlApp
{
    // Affiche la page d'Accueil
    public function accueil()
    {
        $title = "Accueil";

        \Renderer::render('views/accueil', compact('title'));
    }

    // Affiche la Page Inscription et gère le Formulaire Inscription
    public function inscriptionPage()
    {
        $title = 'Inscription';
        session_start();
        // On instancie les classes Form et FormManager
        // On récupère les données de la méthode post du formulaire
        $form = new Form($_POST);
        $formManager = new FormManager($_POST);
        // On fait appel a la méthode verifForm() de la classe FormManager
        // On récupère les erreurs de la méthode verifForm dans $error
        @$error = $formManager->verifForm();
        // On indique la vue et on lui retourne les informations dont elle a besoin
        \Renderer::render('views/inscriptionView', compact('title', 'form', 'error'));
    }

    // Affiche la Page du resultat de l'Inscription
    public function resultInscrPage()
    {
        $title = 'ResultInscription';
        session_start();

        if (empty($_SESSION['pseudo'])) {
            die("Ho ?! Tu n'as pas précisé de Pseudo !");
        }
        $pseudo = $_SESSION['pseudo'];

        \Renderer::render('views/resultInscriptionView', compact('title', 'pseudo'));
    }

    // Affiche la Page Login
    public function loginPage()
    {
        $title = 'Login';
        session_start();  // démarrage d'une session
        $form = new Form($_POST);
        $formManager = new FormManager($_POST);
        @$error = $formManager->login();

        \Renderer::render('views/loginView', compact('title', 'form', 'error'));
    }

    // Affiche la Page de confirmation du compte
    public function confirmPage()
    {
        $title = 'Confirmation Compte';
        session_start();
        $confirmManager = new FormManager();

        $id = $_SESSION['id'];
        $confirmManager->confirmation($id);
        @$error = $confirmManager->confirmByMail();
        @$pseudo = $_SESSION['pseudo'];

        \Renderer::render('views/confirmView', compact('title', 'pseudo'));
    }
    // Affiche la Page du jeu Memory
    public function difficultPage()
    {
        $title = 'Difficulté';
        session_start();

        \Renderer::render('views/difficultView', compact('title'));
    }

    // Affiche la Page du jeu Memory
    public function memoryPage()
    {
        $title = 'Jeu';
        session_start();
        $idUser = $_SESSION['id'];
        $manager = new UserManager();
        @$userInfo = $manager->reqUserById();
        $usersList = $manager->findAll();

        $form = new Form();
        $formManager = new FormManager($_POST);
        $formManager->addScore($idUser);

        \Renderer::render('views/memory', compact('title', 'usersList', 'userInfo', 'form'));
    }

    // Déconnexion
    public function logOut()
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        setcookie('login', '');
        setcookie('pass_hache', '');
        \Http::redirect('./index.php');
        exit();
    }
}
