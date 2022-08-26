<?php

namespace Controllers;

use Models\Form;
use Models\FormManager;
use Models\UserManager;

class ControlUser extends Controller
{
    protected $modelName = UserManager::class;

    // Affiche la Page Home
    public function homePage()
    {
        $title = 'Home';
        session_start();
        $idUser      = $_SESSION['id'];
        $userManager = $this->model;
        $userInfo    = $userManager->reqUserById($idUser);

        \Renderer::render('views/homeView', compact('title', 'userInfo'));
    }

    // Affiche la Page Mes infos
    public function readUser()
    {
        $title = "Mes Infos";
        session_start();

        $idUser      = $_SESSION['id'];
        $userManager = $this->model;
        $manager     = new FormManager();

        @$userInfo   = $userManager->reqUserById($idUser);
        $scoreUser   = $manager->selectScore($idUser);

        \Renderer::render('views/readUserView', compact('title', 'userInfo', 'scoreUser'));
    }

    // Affiche la Page Mon profil
    public function editPage()
    {
        $title = 'Mon Profil';
        session_start();
        $userManager = $this->model;
        $idUser      = $_SESSION['id'];
        $form        = new Form($_POST);
        @$error      = $userManager->editProfil();

        if (!empty($_GET['id'])) {
            $id = $_REQUEST['id'];
        }
        if (empty($_POST['envoyer'])) {

            @$userInfo = $userManager->reqUserById($idUser);
            @$id     = $userInfo['id'];
            @$avatar = $userInfo['avatar'];
        }

        \Renderer::render('views/editView', compact(
            'title',
            'form',
            'id',
            'avatar',
            'error'
        ));
    }
}
