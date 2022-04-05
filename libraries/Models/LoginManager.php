<?php

namespace Models;

class LoginManager extends Manager
{

    public function login()
    {
        $bdd = $this->getPdo();
        // on vérifie que les données du formulaire sont présentes

        if (isset($_POST['Pseudo']) && isset($_POST['Mot de Passe']))
            {
                session_start();  // démarrage d'une session

        // récupérer l'utilisateur depuis la BD

                $bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $requete = "SELECT * FROM {$this->table} WHERE pseudo = ? ";
                $resultat = $bdd->prepare($requete);
                $resultat->execute(array($_POST["Pseudo"]));
                
                $data = $resultat->fetch(\PDO::FETCH_ASSOC);
                
                if(password_verify($_POST["Mot de Passe"], $data["pass"]))
                    {
                        $login=$data["pseudo"];
                        $mdp=$data["pass"];
                        
                        $_SESSION['pseudo'] = $login;  // on ajoute ses infos en tant que variables de session
                        $_SESSION['pass'] = $mdp;
                        
                        $authOK = true; // cette variable indique que l'authentification a réussi
                    }
                else
                    {
                        $authOK=false;
                    }
                }
            else
                {
                    $erreur = 'Tous les champs doivent être remplie';
                }
    }
}