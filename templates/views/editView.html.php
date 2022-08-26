<h2>Changer mon Avatar</h2>

<div class="deconnexion">
    <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
</div>

<div class="form-edit">
    <?php
    if (isset($error)) { ?>
        <div class="msgerreur" align="bottom">
            <?= $error; ?>
        </div>
    <?php
    } ?>

    <form method="post" action="" enctype="multipart/form-data">
        <?= $form->inputTexteId('id', !empty($id) ? $id : ''); ?>

        <!-- Avatar -->
        <div class="control-group">
            <label class="control-label">Avatar</label>
            <div class="controls">
                <?= $form->inputAvatar('', 'avatar', !empty($avatar) ? $avatar : ''); ?>
                <?php
                if (!empty($avatar)) { ?>
                    <img src="public/pictures/avatar/<?= $avatar ?>" width="150px" />
                <?php   } else { ?>
                    <img src="public/pictures/avatar/neutre.jpg" width="150px" />
                <?php   } ?>

            </div>
        </div>

        <div class="form-actions">
            <?= $form->submit('envoyer', 'Envoyer'); ?>
        </div>
    </form>
</div>
</main>