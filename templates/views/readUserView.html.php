<main>
    <div class="carte_acces">
        <?php
        if (!empty($userInfo['avatar'])) { ?>
            <img src="membres/Avatars/<?= $userInfo['avatar'] ?>" width="150px" />
        <?php } ?>

        <p>Pseudo = <?= $userInfo['pseudo'] ?></p>
        <p>Age = <?= $userInfo['age'] ?></p>
        <p>Mail = <?= $userInfo['email'] ?></p>
        <?php if (isset($_SESSION['id']) and $userInfo['id'] == $_SESSION['id']) { ?>
            <div class="deconnexion">
                <a href="./index.php?controller=ControlUser&task=editPage">Editer mon profil</a>
            </div>
        <?php } ?>
    </div>

    <div class="deconnexion">
        <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
    </div>
</main>