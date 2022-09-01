<?php
// on vérifie que les variables de session identifiant l'utilisateur existent
if (isset($_SESSION['pseudo']) && isset($_SESSION['pass'])) {
    $login = $_SESSION['pseudo'];
    $mdp   = $_SESSION['pass'];
} ?>
<?php
if (isset($login) && isset($mdp)) { ?>
    <h1>Choisi ton jeu !</h1>

    <div class="carte">
        <a href="index.php?controller=controlApp&task=difficultPage">Memory</a> -
        <a href="index.php?controller=controlApp&task=snakePage">Snake</a>
    </div>
<?php  } else { ?>

    <div class="carte_acces">
        <p>Connectez vous pour accéder aux jeux !</p>
        <a href="./index.php?controller=ControlApp&task=loginPage">Se connecter</a>
    </div>
<?php
} ?>
<div class="text-center score">
    <p class="top">Top 10</p>
    <?php foreach ($usersList as $user) {

        if (!empty($user['avatar'])) { ?>
            <img src="./public/pictures/avatar/<?= $user['avatar'] ?>" width="100px" />
        <?php   } elseif (empty($avatar)) { ?>
            <img src=" ./public/pictures/avatar/neutre.jpg" width="100px" />
    <?php   }

        echo "<p>" . $user['pseudo'] . " : " . $user['points'] . " points </p>" . "</br>";
    } ?>

</div>
</main>