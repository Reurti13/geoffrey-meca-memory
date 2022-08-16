<p class="text-center">Avant de commencer inscrivez-vous ou connectez-vous !</p>
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
                    <?= $form->inputPass('Mot de Passe', 'passe', 'Entrer Mot de Passe'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $form->inputPass('Mot de Passe', 'Confirmation', 'Confirmer Mot de Passe'); ?>
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

<p class="text-center"><a href="./index.php?controller=ControlApp&task=loginPage" style="color:black;">Se connecter</a></p>

</main>