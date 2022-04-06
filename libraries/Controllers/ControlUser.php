<?php

namespace Controllers;

use Models\Form;
use Models\UserManager;

class ControlUser extends Controller
{
    protected $modelName = UserManager::class;

    // Affiche la Page Home
    public function homePage()
    {
        $title = 'Home';
        session_start();
        @$idUser = $_SESSION['id'];
        $userManager = new UserManager();
        @$userInfo = $userManager->reqUserById();

        \Renderer::render('views/homeView', compact('title', 'userInfo'));
    }

    // Affiche la Page Mes infos
    public function readUser()
    {
        $title = "Mes Infos";
        session_start();

        $idUser = $_SESSION['id'];
        $userManager = $this->model;

        @$userInfo = $userManager->reqUserById();

        \Renderer::render('views/readUserView', compact('title', 'userInfo'));
    }

    // Affiche la Page Mon profil
    public function editPage()
    {
        $title = 'Mon Profil';
        session_start();
        $userManager = $this->model;

        if (!empty($_GET['id'])) {
            $id = $_REQUEST['id'];
        }
        if (empty($_POST['envoyer'])) {
            $data = $userManager->reqUserById();

            $id = $data['id'];
            $nom = $data['nom'];
            $prenom = $data['prenom'];
            $Pseudo = $data['pseudo'];
            $age = $data['age'];
            $email = $data['email'];
            $avatar = $data['avatar'];
        }

        $form = new Form($_POST);
        @$userInfo = $userManager->reqUserById();
        @$error = $userManager->editProfil();

        \Renderer::render('views/editView', compact(
            'title',
            'form',
            'id',
            'nom',
            'nameError',
            'prenom',
            'Pseudo',
            'age',
            'email',
            'emailError',
            'avatar',
            'avatarError',
            'error',
            'userInfo'
        ));
    }
}
