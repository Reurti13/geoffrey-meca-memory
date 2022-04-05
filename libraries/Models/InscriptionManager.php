<?php

namespace Models;

class InscriptionManager extends Manager
{
    protected $table = "users";
     
    public function Inscription()
    {
        session_start();

        // connexion à la base de donnée
            $bdd = $this->getPdo();

        // On vérifie que le compte n'existe pas
            $username = htmlspecialchars($_POST['username']);
            $data = $bdd->prepare("SELECT * FROM {$this->table} WHERE pseudo=?");
            $data->execute([$username]);
            $user = $data->fetch();

        // Hachage du mot de passe
            $pass_hache = password_hash(htmlspecialchars($_POST['Mot de Passe']), PASSWORD_DEFAULT);

        // Insertion
            $req = $bdd->prepare("INSERT INTO {$this->table} (pseudo, pass, email, date_inscription) VALUES(?, ?, ?, NOW())");
            $req->execute(array($_POST['username'], $pass_hache, $_POST['email']));
            $mdp = $pass_hache;
            
            $_SESSION['pseudo'] = $username;
            $_SESSION['pass'] = $mdp;

            return $user;
    }

    public function check_password($password)
    {
        $majuscule = preg_match('@[A-Z]@', $password);
        $minuscule = preg_match('@[a-z]@', $password);
        $chiffre = preg_match('@[0-9]@', $password);

        if(strlen($password) < 8)
            {
                $error = 'Votre Mot de Passe doit contenir au moins 8 caractères';
            }
        elseif(!$majuscule)
            {
                $error = 'Votre Mot de Passe doit contenir une Majuscule';
            }
        elseif(!$minuscule)
            {
                $error = 'Votre Mot de Passe doit contenir une minuscule';
            }
        elseif(!$chiffre)
            {
                $error = 'Votre Mot de Passe doit contenir au moins un chiffre';
            }
        else
            {
                $error = "Votre compte à bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
            }

        return $error;        
    }
}