<main>
    <div class="carte_acces">
        <p>Votre meilleur score : </p>
        <?php
        if (!empty($userInfo['avatar'])) { ?>
            <img src="public/pictures/avatar/<?= $userInfo['avatar'] ?>" width="150px" />
        <?php } ?>
        <p>Pseudo = <?= $userInfo['pseudo'] ?></p>
        <p>Age = <?= $userInfo['age'] ?></p>
        <p>Mail = <?= $userInfo['email'] ?></p>
    </div>

    <div class="deconnexion">
        <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
    </div>
</main>