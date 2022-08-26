<div class="carte_acces">
    <?php if (!isset($scoreUser['points'])) {
        $scoreUser['points'] = 0;
    } ?>
    <p>Votre score total est de : <?= $scoreUser['points'] ?> points</p>
    <?php
    if (!empty($userInfo['avatar'])) { ?>
        <img src="public/pictures/avatar/<?= $userInfo['avatar'] ?>" width="150px" />
    <?php } ?>
    <p>Pseudo = <?= $userInfo['pseudo'] ?></p>
    <p>Mail = <?= $userInfo['email'] ?></p>
</div>

<div class="deconnexion">
    <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
</div>
</main>