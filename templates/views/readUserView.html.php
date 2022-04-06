<main>
    <div class="carte_acces">
        <?php
        if (!empty($userInfo['avatar'])) { ?>
            <img src="membres/Avatars/<?= $userInfo['avatar'] ?>" width="150px" />
        <?php } ?>
        <p>Votre meilleur score : </p>
        <p>Pseudo = <?= $userInfo['pseudo'] ?></p>
        <p>Age = <?= $userInfo['age'] ?></p>
        <p>Mail = <?= $userInfo['email'] ?></p>
    </div>

    <div class="deconnexion">
        <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
    </div>
</main>