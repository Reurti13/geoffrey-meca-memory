<?php

namespace Controllers;

use Models\Form;
use Models\PersonnagesManager;
use Models\UserManager;

class Fokemon extends Controller
{
    protected $modelName = PersonnagesManager::class;

    // Affiche le Formulaire de création
    public function createPerso()
    {
        $title = "Creer ton perso";
        session_start();
        $manager = $this->model;
        $idUser = $_SESSION['id'];
        $nomUser = $_SESSION['pseudo'];
        $fokemon = $_SESSION['perso'];

        $form = new Form($_POST);
        $persoManager = new PersonnagesManager($_POST);
        $count = $persoManager->countPersoByUser($idUser);
        $nbrsFokemon = $count->fetchColumn();
        @$error = $manager->createPersoById($idUser, $nomUser);


        \Renderer::render('views/createView', compact('title', 'fokemon', 'form', 'error', 'errors', 'nbrsFokemon'));
    }

    // Affiche la page Ton Perso
    public function tonPerso()
    {
        $title = "Ton Perso";
        session_start();

        $perso = $_SESSION['perso'];
        $manager = $this->model;
        $persos = $manager->getList($perso->nom());

        \Renderer::render('views/ton_Perso', compact('title', 'perso', 'manager'));
    }

    // Affiche les informations d'un personnage
    public function infoPerso()
    {
        $title = 'InfosPerso';
        session_start();

        $manager = $this->model;
        $id = intval($_GET['id']);
        $fokemon = $manager->reqPersoById($id);;

        \Renderer::render('views/infoPersoView', compact('title', 'fokemon'));
    }

    // Affiche un Fokemon
    public function choisirPerso()
    {
        $title = "Perso";
        session_start();
        $manager = $this->model;
        $idUser = $_SESSION['id'];
        $fokemon = $manager->reqPersoByUser($idUser);

        \Renderer::render('views/choisirPerso', compact('title', 'fokemon'));
    }

    // Affiche un Adversaire
    public function choisirAdvs()
    {
        $title = "Perso";
        session_start();
        $idMonPerso = intval($_GET['id']);
        $_SESSION['idMonPerso'] = $idMonPerso;
        $manager = $this->model;
        $monPerso = $manager->reqPersoById($idMonPerso);

        $fokemons = $manager->listAdvs($monPerso->nom(), $monPerso->idUser());

        \Renderer::render('views/choisirAdvs', compact('title', 'fokemons'));
    }

    // Affiche la page Fight
    public function fight()
    {
        $title = "Fight";
        session_start();
        $manager = $this->model;
        $idMonPerso = $_SESSION['idMonPerso'];
        $monPerso = $manager->reqPersoById($idMonPerso);

        $id = intval($_GET['idAdvs']);
        $Advs = $manager->reqPersoById($id);

        $frapper = new \Controllers\Fokemon();
        @$error = $frapper->att($manager, $monPerso);
        \Renderer::render('views/fight', compact('title', 'monPerso', 'Advs', 'error'));
    }

    //Frapper un Personnage
    private function att($manager, $perso)
    {
        if (isset($_GET['frapper'])) // Si on a cliqué sur un personnage pour le frapper.
        {
            $persoAFrapper = $manager->get((int) $_GET['frapper']);

            $retour = $perso->frapper($persoAFrapper);
            switch ($retour) {   // On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.
                case \Models\Personnage::CEST_MOI:
                    $error = 'Mais... pourquoi voulez-vous vous frapper ???';
                    break;

                case \Models\Personnage::PERSONNAGE_FRAPPE:
                    $error = 'Le personnage a bien été frappé !';
                    $manager->update($perso);
                    $manager->update($persoAFrapper);
                    break;

                case \Models\Personnage::PERSONNAGE_TUE:
                    $error = 'Vous avez tué ce personnage !';
                    $manager->update($perso);
                    $manager->delete($persoAFrapper);
                    break;

                case \Models\Personnage::XP_UP:
                    $error = 'Gain dEXP !';
                    break;

                case \Models\Personnage::LEVEL_UP:
                    $error = 'Bingo !';
                    break;
            }
        }
        return $error;
    }

    //Supprimer UN Fokemon
    public function deletes()
    {
        /**
         * 1. On vérifie que le GET possède bien un paramètre "id" (delete.php?id=202) et que c'est bien un nombre
         */
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ?! Tu n'as pas précisé l'id du Fokemon !");
        }
        $id = $_GET['id'];
        /**
         * 2. Vérification que l'article existe bel et bien
         */
        $fokemon = $this->model->find($id);
        if (!$fokemon) {
            die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
        }
        /**
         * 3. Réelle suppression de l'article
         */
        $this->model->delete($id);
        /**
         * 4. Redirection vers la page d'accueil
         */
        \Http::redirect('index.php');
    }
}
