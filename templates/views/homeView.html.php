<?php
// on vérifie que les variables de session identifiant l'utilisateur existent
if (isset($_SESSION['pseudo']) && isset($_SESSION['pass'])) {
    $login = $_SESSION['pseudo'];
    $mdp   = $_SESSION['pass'];
}

if (isset($login) && isset($mdp)) { ?>
    <?= "<h1>Bienvenue dans votre espace personnel " . $userInfo['pseudo'] . " !</h1>"; ?>

    <div class="container">
        <div class="gauche">
            <?php
            if (!empty($userInfo['avatar'])) { ?>
                <img src="./public/pictures/avatar/<?= $userInfo['avatar'] ?>" width="350px" />
            <?php   } elseif (empty($avatar)) { ?>
                <img src=" ./public/pictures/avatar/neutre.jpg" width="350px" />
            <?php   } ?>
            <a href="./index.php?controller=ControlUser&task=editPage">Changer ma photo de profil</a>
            <?php
            if (isset($_SESSION['id']) and $userInfo['id'] == $_SESSION['id']) {

                if ($userInfo['confirmation'] != 1) { ?>
                    <a href="./index.php?controller=ControlApp&task=confirmPage">Confirmer votre compte</a>
                <?php   } ?>
            <?php
            }
            ?>
        </div>
        <div class="droite">
            <a href="./index.php?controller=ControlApp&task=gamesPage">Jouer</a>
            <a href="./index.php?controller=ControlApp&task=logOut">Se déconnecter</a>

            <?php if (!isset($scoreUser['points'])) {
                $scoreUser['points'] = 0;
            } ?>
            <p>Votre score total est de : <?= $scoreUser['points'] ?> points</p>

        </div>
    </div>
<?php  } else { ?>
    <div class="carte_acces">
        <p>L'accès à cette page est réservé aux utilisateurs authentifiés</p>
        <a href="./index.php?controller=ControlApp&task=loginPage">Se connecter</a>
    </div>
<?php
} ?>
</main>