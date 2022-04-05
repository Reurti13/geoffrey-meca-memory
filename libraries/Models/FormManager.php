<?php

namespace Models;

use \Models\PersonnagesManager;

class FormManager extends Manager
{
    protected $table = "users";

    // Formulaire Inscription
    public function verifCompteExist($pseudo)
    {
        $bdd = $this->getPdo();
        $verifcompte = $bdd->prepare("SELECT * FROM {$this->table} WHERE pseudo = ?");
        $verifcompte->execute(array($pseudo));
        $comptexiste = $verifcompte->rowCount();

        return $comptexiste;
    }

    public function add($pseudo, $age, $pass, $mail, $key)
    {
        $bdd = $this->getPdo();
        $insertMbr = $bdd->prepare("INSERT INTO {$this->table} 
                                    (pseudo, age, pass, email, confirmkey, date_inscription) 
                                    VALUE (?, ?, ?, ?, ?, NOW())");
        $insertMbr->execute(array($pseudo, $age, $pass, $mail, $key));
    }

    public function verifForm() // Inscription
    {
        $form = new FormManager($_POST);
        session_start();

        if (isset($_POST['envoyer'])) {
            $pseudo = htmlspecialchars(trim($_POST['pseudo']));
            $prePass = htmlspecialchars(trim($_POST['pass']));
            $age = htmlspecialchars(trim($_POST['age']));
            $prePass2 = htmlspecialchars(trim($_POST['Confirmation']));
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $mail = htmlspecialchars(trim($_POST['email']));

            if (!empty($_POST['pseudo']) and !empty($_POST['age']) and !empty($_POST['pass']) and !empty($_POST['Confirmation']) and !empty($_POST['email'])) {
                $pseudolength = strlen($pseudo);
                if ($pseudolength <= 50) {
                    $comptexiste = $form->verifCompteExist($pseudo);

                    if ($comptexiste == 0) {
                        if ($prePass == $prePass2) {
                            $password = $prePass;
                            $_SESSION['pass'] = $pass;

                            $error = $form->check_format_password($password);

                            if ($error == false) {
                                if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                                    $longueurKey = 12;
                                    $key = '';
                                    for ($i = 1; $i < $longueurKey; $i++) {
                                        $key .= mt_rand(0, 9);
                                    }

                                    $form->add($pseudo, $age, $pass, $mail, $key);
                                    $form->mail($pseudo, $key, $mail);

                                    $userManager = new UserManager();
                                    $userInfo = $userManager->reqUserByPseudo($pseudo);
                                    $_SESSION['pseudo'] = $userInfo['pseudo'];  // on ajoute ses infos en tant que variables de session
                                    $_SESSION['pass'] = $userInfo['pass'];
                                    $_SESSION['id'] = $userInfo['id'];
                                    $_SESSION['confirmkey'] = $userInfo['confirmkey'];
                                    $_SESSION['confirme'] = $userInfo['confirmation'];

                                    \Http::redirect('./index.php?controller=ControlApp&task=resultInscrPage');
                                } else {
                                    $error = "Votre adresse mail n'est pas valide !";
                                }
                            }
                        } else {
                            $error = "Vos Mots de passe ne sont pas identique !";
                        }
                    } else {
                        $error = "Votre Pseudo est déja utiliser !";
                    }
                } else {
                    $error = "Votre Pseudo de passe doit contenir plus de 50 caratères !";
                }
            } else {
                $error = 'Tous les champs doivent être complétés !';
            }
        }
        return $error;
    }

    public function check_format_password($password)
    {
        $majuscule = preg_match('@[A-Z]@', $password);
        $minuscule = preg_match('@[a-z]@', $password);
        $chiffre = preg_match('@[0-9]@', $password);

        if (strlen($password) < 8) {
            $error = 'Votre Mot de Passe doit contenir au moins 8 caractères';
        } elseif (!$majuscule) {
            $error = 'Votre Mot de Passe doit contenir une Majuscule';
        } elseif (!$minuscule) {
            $error = 'Votre Mot de Passe doit contenir une minuscule';
        } elseif (!$chiffre) {
            $error = 'Votre Mot de Passe doit contenir au moins un chiffre';
        } else {
            return false;
        }

        return $error;
    }

    public function confirmation($id)
    {
        $bdd = $this->getPdo();
        $sql = "UPDATE {$this->table} SET confirmation = 1 WHERE id = ?";
        $q = $bdd->prepare($sql);
        $q->execute(array($id));
    }

    // Formulaire Login
    public function login()
    {
        $user = new UserManager($_POST);
        $manager = new PersonnagesManager();
        if (isset($_POST['envoyer'])) {
            // on vérifie que les données du formulaire sont présentes
            if (!empty($_POST['pseudo']) && !empty($_POST['pass'])) {
                $pseudo = $_POST['pseudo'];
                // récupérer l'utilisateur depuis la BD
                $userInfo = $user->reqUserByPseudo($pseudo);
                $idUser = $userInfo['id'];
                $perso = $manager->reqPersoByUser($idUser);

                if (isset($userInfo) and password_verify($_POST["pass"], $userInfo["pass"])) {

                    $login              = $userInfo["pseudo"];
                    $mdp                = $userInfo["pass"];
                    $_SESSION['id']     = $userInfo['id'];
                    $_SESSION['email']  = $userInfo['email'];
                    $_SESSION['pseudo'] = $login;  // on ajoute ses infos en tant que variables de session
                    $_SESSION['pass']   = $mdp;
                    $_SESSION['perso']  = $perso;

                    $authOK = true; // cette variable indique que l'authentification a réussi

                    if ($authOK == true) {
                        \Http::redirect('./index.php?controller=ControlUser&task=homePage&id= ' . $_SESSION['id']);
                    }
                } else {
                    $error = 'Utilisateur ou mot de passe incorrect';
                    $authOK = false;
                }
            } else {
                $error = 'Tous les champs doivent être remplie';
            }
        }
        return $error;
    }

    // Mail
    public function mail($pseudo, $key, $mail)
    {
        $header = "MMIME-Version: 1.0\r\n";
        $header .= 'From: BKP.com"<support@gmail.com' . "\n";
        $header .= 'Content-Type:text/html; charset="utf-8"' . "\n";
        $header .= 'Content-Transfer-Encoding: 8bit';

        $message = '
        <html>
            <body>
                <div>
                    <p>"Votre Compte a bien été créer ' . $pseudo . ' !"</p>
                    <a href="http://localhost:8080/fokemon/index.php?controller=controlApp&task=confirmPage&pseudo=' . urlencode($pseudo) . '&key=' . $key . '">Confirmez votre compte !</a>
                </div>
            </body>
        </html>
        ';

        mail($mail, "Confirmation de compte", $message, $header);
    }

    public function confirmByMail()
    {
        $bdd = $this->getPdo();

        if (isset($_GET['pseudo'], $_GET['key']) and !empty($_GET['pseudo']) and !empty($_GET['key'])) {
            $pseudo = htmlspecialchars(urldecode($_GET['pseudo']));
            $key = $_GET['key'];

            $manager = new UserManager();
            $userExist = $manager->count();
            if ($userExist == 1) {
                if ($key = $_SESSION['confirmkey']) {
                    if ($_SESSION['confirmation'] == NULL) {
                        $updatUser = $bdd->prepare("UPDATE {$this->table} SET confirmation = 1 WHERE pseudo = ? AND confirmkey = ?");
                        $updatUser->execute(array($pseudo, $key));
                    } else {
                        $error = "Votre compte a déjà été confirmé !";
                    }
                }
            } else {
                $error = "L'utilisateur n'existe pas";
            }
        }
        return $error;
    }
}
