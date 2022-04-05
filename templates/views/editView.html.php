<main>
    <h1>Profil de <?= $userInfo['pseudo'] ?></h1>

    <h2>Mettre à jour mon profil</h2>

    <div class="deconnexion">
        <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
    </div>

    <div class="form-edit">
    <?php   
        if(isset($error))
        {?>
        <div class="msgerreur" align="bottom">
            <?= $error; ?>
        </div>
        <?php 
        }
    ?>
        <form method="post" action="" enctype="multipart/form-data">
            <?= $form->inputTexteId('id', !empty($id)?$id:'');?>

                    <!-- Name -->
            <div class="control-group <?= !empty($nameError)?'error':'';?>">
                <label class="control-label">Votre nom</label><br />
                    <div class="controls">
                        <?= $form->inputTexte('', 'nom', 'Entrer votre Nom', !empty($nom)?$nom:'');?>
                        <?php if (!empty($nameError)): ?>
                            <span class="help-inline"><?= $nameError;?></span>
                        <?php endif; ?>
                    </div>
                    <p>
            </div>
            <p>
            <br />
                    <!-- FirstName -->
            <div class="control-group<?= !empty($nameError)?'error':'';?>">
                <label class="control-label">Votre prénom</label><br />
                    <div class="controls">
                        <?= $form->inputTexte('', 'prenom', 'Entrer votre Prenom', !empty($prenom)?$prenom:'');?>
                        <?php if(!empty($nameError)):?>
                        <span class="help-inline"><?= $nameError ;?></span>
                        <?php endif;?>
                    </div>
                    <p>
            </div>
            <p>
            <br />
                    <!-- Pseudo -->
            <div class="control-group">
                <label class="control-label">Votre Pseudo</label><br />
                    <div class="controls">
                        <?= $form->inputTexte('', 'pseudo', 'Entrer votre Pseudo', !empty($Pseudo)?$Pseudo:'');?>
                    </div>
                    <p>
            </div>
            <p>
            <br />
                    <!-- Avatar -->
            <div class="control-group<?= !empty($avatarError)?'error':'';?>">
                <label class="control-label">Avatar</label><br />
                    <div class="controls">
                        <?= $form->inputAvatar('', 'avatar', !empty($avatar)?$avatar:'');?>
                        <?php
                            if(!empty($avatar))
                                {?>
                                    <img src="membres/Avatars/<?= $avatar?>" width="150px" />
                        <?php   }?>
                        <?php if(!empty($avatarError)):?>
                        <span class="help-inline"><?= $avatarError ;?></span>
                        <?php endif;?>
                    </div>
                    <p>
            </div>
            <p>
            <br />
                    <!-- Age -->
            <div class="control-group">
                <label class="control-label">Votre Age</label><br />
                    <div class="controls">
                        <?= $form->inputNumber('', 'age', '', !empty($age)?$age:'');?>
                    </div>
                    <p>
            </div>
            <p>
            <br />
                    <!-- Mail -->
            <div class="control-group <?= !empty($emailError)?'error':'';?>">
                <label class="control-label">Email Address</label><br />
                    <div class="controls">
                        <?= $form->inputMail('', 'email', !empty($email)?$email:'');?>
                        <?php if (!empty($emailError)): ?>
                            <span class="help-inline"><?= $emailError;?></span>
                        <?php endif;?>
                    </div>
                    <p>
            </div>
            <p>
            <br />
            <div class="form-actions">
                <?= $form->submit('envoyer', 'Envoyer');?>
                <a class="btn" href="./index.php?controller=ControlApp&task=homePage">Retour</a>
            </div>
        </form>
    </div>
</div>
</main>