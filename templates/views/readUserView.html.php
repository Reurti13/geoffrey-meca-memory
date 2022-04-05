<main>
<div class="carte_acces">
    <?php
        if(!empty($userInfo['avatar']))
            {?>
                <img src="membres/Avatars/<?= $userInfo['avatar']?>" width="150px" />
    <?php }?>

        <p>Pseudo   = <?= $userInfo['pseudo']?></p>
        <p>Nom      = <?= $userInfo['nom']?></p>
        <p>Prénom   = <?= $userInfo['prenom']?></p>
        <p>Age      = <?= $userInfo['age']?></p>
        <p>Mail     = <?= $userInfo['email']?></p>
        <!-- <p>Articles   = <?= $userInfo['article']?></p> -->
       <?php if(isset($_SESSION['id']) AND $userInfo['id'] == $_SESSION['id'])
            {?>
            <div class="deconnexion">
                <a href="./index.php?controller=ControlUser&task=editPage">Editer mon profil</a>
            </div>
      <?php }?> 
        
    </div>

    <fieldset class="conteneurPerso">
        <legend class="titres">Mes Perso !</legend>  
        <?php
            if (empty($fokemon)) 
            { 
                echo "Vous navez pas de Fokémon !";
            } 
            else 
            {
                foreach ($fokemon as $unPerso) 
                    { ?>
                        <div class="listepersonnage"> 
                            <a href="./index.php?controller=fokemon&task=infoPerso&id= <?= $unPerso->id()?>">
                                <div class="personnage">
                                    <p>Dresseur :    <?= $unPerso->nomUser()?></p><br/>
                                    <p><?= htmlspecialchars($unPerso->nom()) ?></p><br/>
                                    <p>PV :    <?= $unPerso->PV()?></p><br/>
                                    <p>XP :    <?= $unPerso->XP()?></p><br/>
                                    <p>LvL :   <?= $unPerso->level()?></p>
                                </div>
                            </a> 
                        </div>
            <?php   }
            }
            ?>
    </fieldset>
    <?php 
        if (empty($fokemon)) {?>

            <div class="deconnexion">
                    <a href="./index.php?controller=Fokemon&task=createPerso">Créer un Fokemon</a>
            </div>
    <?php    } ?>

    <div class="deconnexion">
        <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
    </div>
</main>