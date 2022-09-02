<h1>Changer mon Avatar</h1>

<div class="form">
    <?php
    if (isset($error)) { ?>
        <div class="msgerreur" align="bottom">
            <?= $error; ?>
        </div>
    <?php
    } ?>

    <form method="post" action="" enctype="multipart/form-data">
        <?= $form->inputTexteId('id', !empty($id) ? $id : ''); ?>

        <?= $form->inputAvatar('Avatar', 'avatar', !empty($avatar) ? $avatar : ''); ?>
        <?php
        if (!empty($avatar)) { ?>
            <img src="public/pictures/avatar/<?= $avatar ?>" width="150px" />
        <?php   } else { ?>
            <img src="public/pictures/avatar/neutre.jpg" width="150px" />
        <?php   } ?>

        <div class="form-actions">
            <?= $form->submit('envoyer', 'Envoyer'); ?>
        </div>
    </form>
    <div class="deconnexion">
        <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
    </div>
</div>
</main>