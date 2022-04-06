<?php

namespace Models;

class UserManager extends Manager
{
    protected $table = "users";

    // Créer
    public function addUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) //on initialise nos messages d'erreurs;
        {
            // on recupère nos valeurs 

            $nom        = htmlentities(trim($_POST['nom']));
            $prenom     = htmlentities(trim($_POST['prenom']));
            $Pseudo     = htmlentities(trim($_POST['Pseudo']));
            $age        = htmlentities(trim($_POST['age']));
            $email      = htmlentities(trim($_POST['email']));
            $avatar     = htmlentities(trim($_POST['avatar']));

            // on vérifie nos champs 

            if (empty($name)) {
                $nameError = 'Enter votre Nom';
            } else if (!preg_match("/^[a-zA-Z ]*$/", $nom)) {
                $nameError = "Seules les lettres et les espaces blancs sont autorisés";
            }
            if (empty($prenom)) {
                $firstnameError = 'Enter votre Prénom';
            } else if (!preg_match("/^[a-zA-Z ]*$/", $prenom)) {
                $nameError = "Seules les lettres et les espaces blancs sont autorisés";
            }
            if (empty($Pseudo)) {
                $PseudoError = 'Enter votre Pseudo';
            }
            if (empty($email)) {
                $emailError = 'Enter votre Email';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailError = 'Enter une addresse mail valide';
            }
            if (empty($age)) {
                $ageError = 'Enter votre age';
            }

            // Pour l'Avatar
            if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])) {
                $tailleMax = 2097152;
                $extensionValides = array('jpg', 'jpeg', 'gif', 'png');

                if ($_FILES['avatar']['size'] <= $tailleMax) {
                    if (($extensionValides)) {
                        $chemin = "./membres/Avatars/" . $_FILES['avatar']['name'];

                        $avatar = $_FILES['avatar']['name'];

                        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);

                        if ($resultat) {
                            // si les données sont présentes et bonnes, on se connecte à la base    
                            $bdd = $this->getPdo();

                            $sql = "INSERT INTO {$this->table} (nom, prenom, pseudo, age, email, avatar) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            $insertMbr = $bdd->prepare($sql);
                            $insertMbr->execute(array($nom, $prenom, $Pseudo, $age, $email, $avatar));

                            \Http::redirect('./index.php?controller=controlAdmin&task=admin');
                        } else {
                            $error = "Erreur durant l'importation de votre photo de profil";
                        }
                    } else {
                        $error = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
                    }
                } else {
                    $error = 'Votre photo de profile ne doit pas dépasser 2 Mo !';
                }
            }
        }
    }

    // Lire
    public function findAll(?string $order = "")
    {
        $bdd = $this->getPdo();
        $sql = "SELECT * FROM {$this->table}";

        if ($order) {
            $sql .= " ORDER BY " . $order;
        }
        $data = $bdd->query($sql);
        return $data;
    }

    public function reqUser()
    {
        $bdd = $this->getPdo();

        if (isset($_GET['id']) and $_GET['id'] > 0) {
            $getid = intval($_GET['id']);
            $reqUser = $bdd->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $reqUser->execute(array($getid));
            $reqUser->fetch();
            return $reqUser;
        }
    }

    public function reqUserById()
    {
        $bdd = $this->getPdo();

        $reqUser = $bdd->prepare("SELECT * FROM {$this->table} WHERE id= ?");
        $reqUser->execute(array($_SESSION['id']));
        $user = $reqUser->fetch();

        return $user;
    }

    public function reqUserByPseudo($pseudo)
    {
        $bdd = $this->getPdo();

        $requete = "SELECT * FROM {$this->table} WHERE pseudo = ? ";
        $resultat = $bdd->prepare($requete);
        $resultat->execute(array($pseudo));
        $userInfo = $resultat->fetch();

        return $userInfo;
    }

    public function reqPseudoUserByIdUser($idUser)
    {
        // retourne le nom du l'utilisateur d'un personnage par l'idUser.
        $bdd = $this->getPdo();
        $p = $bdd->prepare("SELECT DISTINCT t1.pseudo FROM users AS t1 JOIN {$this->table} AS t2 ON t1.id = t2.idUser WHERE t2.idUser = ?");
        $p->execute(array($idUser));
        $pseudoUser = $p->fetch();
        $pseudo = $pseudoUser['pseudo'];
        return $pseudo;
    }

    public function count()
    { // Exécute une requête COUNT() et retourne le nombre de résultats retourné.
        $bdd = $this->getPdo();
        return $bdd->query("SELECT COUNT(*) FROM {$this->table}")->rowCount();
    }

    // Mettre à jour
    public function editProfil()
    {
        if (isset($_SESSION['id'])) {
            $user = $this->reqUserById();

            // Pour le Nom
            if (isset($_POST['nom']) and !empty($_POST['nom']) and $_POST['nom'] != $user['nom']) {
                $updateNom = $this->updateNom();
            }

            // Pour le Prenom
            if (isset($_POST['prenom']) and !empty($_POST['prenom']) and $_POST['prenom'] != $user['prenom']) {
                $updatePrenom = $this->updatePrenom();
            }

            // Pour le Pseudo
            if (isset($_POST['pseudo']) and !empty($_POST['pseudo']) and $_POST['pseudo'] != $user['pseudo']) {
                $updatePseudo = $this->updatePseudo();
            }

            // Pour le Mail
            if (isset($_POST['email']) and !empty($_POST['email']) and $_POST['email'] != $user['email']) {
                $updateEmail = $this->updateEmail();
            }

            // Pour le Pass
            if (isset($_POST['Mot de Passe']) and !empty($_POST['Mot de Passe']) and isset($_POST['Confirmation']) and !empty($_POST['Confirmation'])) {
                $prePass = htmlspecialchars($_POST['Mot de Passe']);
                $prePass2 = htmlspecialchars($_POST['Confirmation']);

                if ($prePass == $prePass2) {
                    $password = $prePass;
                    $form = new FormManager();
                    $error = $form->check_format_password($password);

                    if ($error == false) {
                        $updatePass = $this->updatePass();
                    }
                } else {
                    $error = "Vos de mots de passe ne correspondent pas !";
                }
            }

            // Pour l'age
            if (isset($_POST['age']) and !empty($_POST['age']) and $_POST['age'] != $user['age']) {
                $updateAge = $this->updateAge();
            }

            // Pour l'Avatar
            if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])) {
                $tailleMax = 2097152;
                $extensionValides = array('jpg', 'jpeg', 'gif', 'png');

                if ($_FILES['avatar']['size'] <= $tailleMax) {
                    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));

                    if (in_array($extensionUpload, $extensionValides)) {
                        $chemin = "./public/pictures/avatar/" . $_SESSION['id'] . "." . $extensionUpload;

                        $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);

                        if ($resultat) {
                            $updateAvatar = $this->updateAvatar($extensionUpload);
                        } else {
                            $error = "Erreur durant l'importation de votre photo de profil";
                        }
                    } else {
                        $error = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
                    }
                } else {
                    $error = 'Votre photo de profile ne doit pas dépasser 2 Mo !';
                }
            }
        }
        return $error;
    }
    public function updateNom()
    {
        $bdd = $this->getPdo();
        $newNom = htmlspecialchars($_POST['nom']);
        $insertNom = $bdd->prepare("UPDATE {$this->table} SET nom = ? WHERE id = ?");
        $insertNom->execute(array($newNom, $_SESSION['id']));
        \Http::redirect('./index.php?controller=ControlUser&task=homePage&id=' . $_SESSION['id']);

        return $error = " Votre Nom a bien été changé";
    }
    public function updatePrenom()
    {
        $bdd = $this->getPdo();
        $newPrenom = htmlspecialchars($_POST['prenom']);
        $insertPrenom = $bdd->prepare("UPDATE {$this->table} SET prenom = ? WHERE id = ?");
        $insertPrenom->execute(array($newPrenom, $_SESSION['id']));
        \Http::redirect('./index.php?controller=ControlUser&task=homePage&id=' . $_SESSION['id']);

        return $error = " Votre Prénom a bien été changé";
    }
    public function updatePseudo()
    {
        $bdd = $this->getPdo();
        $newPseudo = htmlspecialchars($_POST['pseudo']);
        $insertPseudo = $bdd->prepare("UPDATE {$this->table} SET pseudo = ? WHERE id = ?");
        $insertPseudo->execute(array($newPseudo, $_SESSION['id']));
        \Http::redirect('./index.php?controller=ControlUser&task=homePage&id=' . $_SESSION['id']);

        return $error = " Votre Pseudo a bien été changé";
    }
    public function updatePass()
    {
        $bdd = $this->getPdo();

        $pass = password_hash($_POST['Mot de Passe'], PASSWORD_DEFAULT);
        $insertPass = $bdd->prepare("UPDATE {$this->table} SET pass = ? WHERE id = ? ");
        $insertPass->execute(array($pass, $_SESSION['id']));
        \HTTP::redirect('./index.php?controller=ControlUser&task=homePage&id=' . $_SESSION['id']);
    }
    public function updateAge()
    {
        $bdd = $this->getPdo();
        $newAge = htmlspecialchars($_POST['age']);
        $insertAge = $bdd->prepare("UPDATE {$this->table} SET age = ? WHERE id = ?");
        $insertAge->execute(array($newAge, $_SESSION['id']));
        \Http::redirect('./index.php?controller=ControlUser&task=homePage&id=' . $_SESSION['id']);

        return $error = " Votre age a bien été changé";
    }
    public function updateEmail()
    {
        $bdd = $this->getPdo();
        $newMail = htmlspecialchars($_POST['email']);
        $insertMail = $bdd->prepare("UPDATE {$this->table} SET email = ? WHERE id = ?");
        $insertMail->execute(array($newMail, $_SESSION['id']));
        \Http::redirect('./index.php?controller=ControlUser&task=homePage&id=' . $_SESSION['id']);
    }
    public function updateAvatar($extensionUpload)
    {
        $bdd = $this->getPdo();

        $updateAvatar = $bdd->prepare("UPDATE {$this->table} SET avatar = :avatar WHERE id = :id");
        $updateAvatar->execute(array('avatar' => $_SESSION['id'] . "." . $extensionUpload, 'id' => $_SESSION['id']));
        \Http::redirect('./index.php?controller=ControlUser&task=homePage&id=' . $_SESSION['id']);
    }

    // Supprimer
    public function deleteUser(int $id): void
    {
        $bdd = $this->getPdo();
        $query = $bdd->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
    }

    // Confirmation du compte
    public function confirmation($id)
    {
        $bdd = $this->getPdo();
        $sql = "UPDATE {$this->table} SET confirmation = 1 WHERE id = ?";
        $q = $bdd->prepare($sql);
        $q->execute(array($id));
    }
}
