<div id="panel" class="affichageJeu">

    <div class="resultat text-center">
        <p class="top">Top 10</p>
        <?php foreach ($usersList as $user) {

            if (!empty($user['avatar'])) { ?>
                <img src="./public/pictures/avatar/<?= $user['avatar'] ?>" width="30px" />
            <?php   } elseif (empty($avatar)) { ?>
                <img src=" ./public/pictures/avatar/neutre.jpg" width="30px" />
        <?php   }


            if ($_GET['difficult'] == 'facile') {
                echo "<p>" . $user['pseudo'] . " : " . $user['scoresfacile'] . "</p>" . "</br>";
            } else if ($_GET['difficult'] == 'moyen') {
                echo "<p>" . $user['pseudo'] . " : " . $user['scoresmoyen'] . "</p>" . "</br>";
            } else if ($_GET['difficult'] == 'difficile') {
                echo "<p>" . $user['pseudo'] . " : " . $user['scoresdifficile'] . "</p>" . "</br>";
            }
        } ?>

    </div>

    <div class="container text-center game">
        <div id="jeu"></div>
        <button class='text-center btn btn-success mt-5' style='width:100px; height:100px;' onclick='rejouer()'>Rejouer</button>
    </div>

    <div class="info text-center mt-3">
        <p>Vous en êtes à <span id="count"></span> coups !</p>
        <p>Votre score est de : <span id="point"></span> points</p>
    </div>
</div>


<form id="result" class="text-center visually-hidden" action="" method="POST">
    <p>Félicitation !!!</p></br>
    <p>Sauvegarder votre score</p>
    <table>
        <tr>
            <td>
                <?= $form->inputTexte('Pseudo', 'pseudo', "", $userInfo['pseudo']); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $form->inputTexte('Score', 'score', "", ""); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $form->inputTexte('Points', 'point', "", ""); ?>
            </td>
        </tr>
        <tr>
            <td class="button text-center">
                <?= $form->submit('envoyer', 'Sauvegarder'); ?>
            </td>
        </tr>
    </table>
</form>
</main>