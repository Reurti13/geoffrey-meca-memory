<main>
    <div id="panel" class="affichageJeu">

        <div class="resultat text-center">
            <p class="top">Top 10</p>
            <?php foreach ($usersList as $user) {
                echo "<p>" . $user['pseudo'] . " : " . $user['scores'] . "</p>" . "</br>";
            } ?>
        </div>

        <?php if ($_GET['difficult'] === 'difficile') { ?>
            <div class="container text-center" id="strt">
                <div id="jeu"></div>
                <button class='text-center btn btn-success mt-5' style='width:100px; height:100px;' onclick='rejouer()'>Rejouer</button>
            </div>
        <?php   } ?>

        <div class="info text-center mt-3">
            <p>Vous en êtes à <span id="count"></span> coups !</p>
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
                <td class="button text-center">
                    <?= $form->submit('envoyer', 'Sauvegarder'); ?>
                </td>
            </tr>
        </table>
    </form>
</main>