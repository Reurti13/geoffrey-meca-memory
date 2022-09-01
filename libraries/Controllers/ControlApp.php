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
    // Affiche la Page des difficulter
    public function difficultPage()
    {
        $title = 'Difficulté';
        session_start();

        \Renderer::render('views/difficultView', compact('title'));
    }

    // Affiche la Page des jeux
    public function gamesPage()
    {
        $title = 'Games';
        session_start();
        @$idUser    = $_SESSION['id'];

        $manager   = new UserManager();
        $usersList = $manager->findAll('points ASC');


        \Renderer::render('views/gamesView', compact('title', 'usersList'));
    }

    // Affiche la Page du jeu Memory
    public function memoryPage()
    {
        $title = 'Jeu';
        session_start();

        $idUser    = $_SESSION['id'];
        $manager   = new UserManager();
        @$userInfo = $manager->reqUserById($idUser);

        if ($_GET['difficult'] == 'facile') {
            $usersList = $manager->findAll('scoresfacile ASC');
        } else if ($_GET['difficult'] == 'moyen') {
            $usersList = $manager->findAll('scoresmoyen ASC');
        } else {
            $usersList = $manager->findAll('scoresdifficile ASC');
        }

        $form                = new Form();
        $formManager         = new FormManager($_POST);
        @$reqScoreUser       = $formManager->selectScore($idUser);
        @$scoreUserFacile    = $reqScoreUser['scoresfacile'];
        @$scoreUserMoyen     = $reqScoreUser['scoresmoyen'];
        @$scoreUserDifficile = $reqScoreUser['scoresdifficile'];
        @$pointUser          = $reqScoreUser['points'];

        if (empty($scoreUserFacile) and empty($scoreUserMoyen) and empty($scoreUserDifficile) and empty($pointUser)) {
            $formManager->addScore($idUser);
        } else {
            if ($_GET['difficult'] == 'facile') {
                $formManager->updateScore($idUser, $scoreUserFacile, $pointUser);
            } else if ($_GET['difficult'] == 'moyen') {
                $formManager->updateScore($idUser, $scoreUserMoyen, $pointUser);
            } else {
                $formManager->updateScore($idUser, $scoreUserDifficile, $pointUser);
            }
        }

        \Renderer::render('views/memory', compact('title', 'usersList', 'userInfo', 'form'));
    }

    //Affiche la page du jeu Snake
    public function snakePage()
    {
        $title = 'Snake';
        session_start();
        $idUser        = $_SESSION['id'];
        $form          = new Form();
        $manager       = new UserManager();
        $formManager   = new FormManager($_POST);
        $usersList     = $manager->findAll('points ASC');
        @$userInfo     = $manager->reqUserById($idUser);
        @$reqScoreUser = $formManager->selectScore($idUser);
        @$pointUser    = $reqScoreUser['points'];
        $formManager->updatePoint($idUser, $pointUser);

        \Renderer::render('views/snake', compact('title', 'form', 'userInfo', 'usersList'));
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
