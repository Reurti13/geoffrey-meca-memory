<div id="panel" class="affichageJeu">

    <div class="resultat text-center">

        <p class="top">Top 10</p>
        <?php foreach ($usersList as $user) {

            if (!empty($user['avatar'])) { ?>
                <img src="./public/pictures/avatar/<?= $user['avatar'] ?>" width="70px" />
            <?php   } elseif (empty($avatar)) { ?>
                <img src=" ./public/pictures/avatar/neutre.jpg" width="70px" />
        <?php   }
            echo "<p>" . $user['pseudo'] . " : " . $user['points'] . " pts</p>" . "</br>";
        }
        ?>
    </div>
    <div class="canvas">
        <canvas id="game" width="600" height="600"></canvas>
        <button class='text-center button' onclick='rejouer()'>Rejouer</button>
        <div class="deconnexion">
            <a href="./index.php?controller=ControlUser&task=homePage">Retour</a>
        </div>
    </div>

    <div class="info text-center">
        <p>SCORE = <span id="score"></span> points</p>
    </div>
</div>

<form id="result" class="text-center visually-hidden" action="" method="POST">
    <p>GAME OVER</p></br>
    <p>Sauvegarder votre score</p>
    <table>
        <tr>
            <td>
                <?= $form->inputTexte('Pseudo', 'pseudo', "", $userInfo['pseudo']); ?>
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