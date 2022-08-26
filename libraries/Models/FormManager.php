<?php

namespace Models;


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

    public function add($pseudo, $pass, $mail, $key)
    {
        $bdd = $this->getPdo();
        $insertMbr = $bdd->prepare("INSERT INTO {$this->table} 
                                    (pseudo, pass, email, confirmkey, date_inscription) 
                                    VALUE (?, ?, ?, ?, NOW())");
        $insertMbr->execute(array($pseudo, $pass, $mail, $key));
    }

    public function selectScore($idUser)
    {
        $bdd = $this->getPdo();
        $reqScore = $bdd->prepare("SELECT scoresfacile, scoresmoyen, scoresdifficile, points FROM scores WHERE id_users = ?");
        $reqScore->execute(array($idUser));

        $score = $reqScore->fetch();
        return $score;
    }

    public function addScore($idUser)
    {
        if (isset($_POST['envoyer'])) {

            $bdd = $this->getPdo();
            $newScore = intval(htmlspecialchars($_POST['score']));
            $point    = intval(htmlspecialchars($_POST['point']));

            if ($_GET['difficult'] == 'facile') {
                $score = 'scoresfacile';
            }
            if ($_GET['difficult'] == 'moyen') {
                $score = 'scoresmoyen';
            }
            if ($_GET['difficult'] == 'difficile') {
                $score = 'scoresdifficile';
            }

            if (!empty($_POST['score']) and !empty($_POST['point'])) {

                $insertScore = $bdd->prepare("INSERT INTO scores (id_users, $score, points) VALUE (?, ?, ?)");
                $insertScore->execute(array($idUser, $newScore, $point));

                \Http::redirect('./index.php?controller=ControlApp&task=difficultPage');
            }
        }
    }

    public function updateScore($idUser, $score, $point)
    {
        if (isset($_POST['envoyer']) and !empty($_POST['score']) and !empty($_POST['point'])) {

            $bdd = $this->getPdo();
            $newScore = intval(htmlspecialchars($_POST['score']));
            $newPoint = intval(htmlspecialchars($_POST['point']));
            $score    = intval($score);
            $point    = intval($point);

            $points   = $point + $newPoint;

            if ($_GET['difficult'] == 'facile') {
                $scoreTable = 'scoresfacile';
            }
            if ($_GET['difficult'] == 'moyen') {
                $scoreTable = 'scoresmoyen';
            }
            if ($_GET['difficult'] == 'difficile') {
                $scoreTable = 'scoresdifficile';
            }

            if ($newScore < $score || $score == null) {

                $insertScore = $bdd->prepare("UPDATE scores SET $scoreTable = ?, points = ? WHERE id_users = ?");
                $insertScore->execute(array($newScore, $points, $idUser));

                \Http::redirect('./index.php?controller=ControlApp&task=difficultPage');
            } else if ($points > $point) {

                $insertScore = $bdd->prepare("UPDATE scores SET points = ? WHERE id_users = ?");
                $insertScore->execute(array($idUser, $points));
                \Http::redirect('./index.php?controller=ControlApp&task=difficultPage');
            }
        }
    }

    public function verifForm() // Inscription
    {
        $form = new FormManager($_POST);

        if (isset($_POST['envoyer'])) {
            $pseudo = htmlspecialchars(trim($_POST['pseudo']));
            $prePass = htmlspecialchars(trim($_POST['passe']));
            $prePass2 = htmlspecialchars(trim($_POST['Confirmation']));
            $pass = password_hash($_POST['passe'], PASSWORD_DEFAULT);
            $mail = htmlspecialchars(trim($_POST['email']));

            if (!empty($_POST['pseudo']) and !empty($_POST['passe']) and !empty($_POST['Confirmation']) and !empty($_POST['email'])) {
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

                                    $form->add($pseudo, $pass, $mail, $key);
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
        if (isset($_POST['envoyer'])) {
            // on vérifie que les données du formulaire sont présentes
            if (!empty($_POST['pseudo']) && !empty($_POST['pass'])) {
                $pseudo = $_POST['pseudo'];
                // récupérer l'utilisateur depuis la BD
                $userInfo = $user->reqUserByPseudo($pseudo);
                $idUser = $userInfo['id'];

                if (isset($userInfo) and password_verify($_POST["pass"], $userInfo["pass"])) {

                    $login              = $userInfo["pseudo"];
                    $mdp                = $userInfo["pass"];
                    $_SESSION['id']     = $userInfo['id'];
                    $_SESSION['email']  = $userInfo['email'];
                    $_SESSION['pseudo'] = $login;  // on ajoute ses infos en tant que variables de session
                    $_SESSION['pass']   = $mdp;

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
