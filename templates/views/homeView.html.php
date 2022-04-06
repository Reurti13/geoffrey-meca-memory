<main>
    <?php
    // on vérifie que les variables de session identifiant l'utilisateur existent
    if (isset($_SESSION['pseudo']) && isset($_SESSION['pass'])) {
        $login = $_SESSION['pseudo'];
        $mdp   = $_SESSION['pass'];
    }

    if (isset($login) && isset($mdp)) { ?>
        <?= "<h1>Bienvenue dans votre espace personnel " . $userInfo['pseudo'] . " !</h1>"; ?>

        <div class="carte_acces">
            <div><a href="./index.php?controller=ControlUser&task=readUser">Mes infos</a></div>
            <?php
            if (!empty($userInfo['avatar'])) { ?>
                <img src="./public/pictures/avatar/<?= $userInfo['avatar'] ?>" width="150px" />
            <?php   } elseif (empty($avatar)) { ?>
                <img src=" ./public/pictures/avatar/neutre.jpg" width="150px" />
            <?php   }

            if (isset($_SESSION['id']) and $userInfo['id'] == $_SESSION['id']) {
            ?>
                <div><a href="./index.php?controller=ControlUser&task=editPage">Changer ma photo de profil</a></div>
                <div><a href="./index.php?controller=ControlApp&task=memoryPage">Jouer</a></div>
                <div><a href="./index.php?controller=ControlApp&task=logOut">Se déconnecter</a></div>
                <?php if ($userInfo['confirmation'] != 1) { ?>
                    <a href="./index.php?controller=ControlApp&task=confirmPage">Confirmer votre compte</a>
                <?php   } ?>
            <?php
            }
            ?>
        </div>
    <?php  } else { ?>
        <div class="carte_acces">
            <p>L'accès à cette page est réservé aux utilisateurs authentifiés</p>
            <a href="./index.php?controller=ControlApp&task=loginPage">Se connecter</a>
        </div>
    <?php
    } ?>

</main>