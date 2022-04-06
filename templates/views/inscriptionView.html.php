<main>
    <p class="text-center">Avant de commencer inscrivez vous ou connecter vous !</p>
    <div class="form-login">
        <form action="#" method="post">
            <table>
                <tr>
                    <td>
                        <?= $form->inputTexte('Pseudo', 'pseudo', 'Entrer votre Pseudo', ""); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $form->inputPass('Mot de Passe', 'pass', 'Entrer Mot de Pass'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $form->inputPass('Mot de Passe', 'Confirmation', 'Confirmer Mot de Passe'); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $form->inputNumber('Votre Age', 'age', "Entrer votre age", ""); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $form->inputMail('Votre Email', 'email', ""); ?>
                    </td>
                </tr>
                <tr>
                    <td class="button">
                        <?= $form->submit('envoyer', 'Envoyer'); ?>
                    </td>
                </tr>
            </table>
            <?php
            if (isset($error)) { ?>
                <div class="msgerreur" align="bottom">
                    <?= $error; ?>
                </div>
            <?php
            }
            ?>
        </form>
    </div>

    <div class="carte_acces">
        <p><a href="./index.php?controller=ControlApp&task=loginPage">Se connecter</a></p>
    </div>
</main>