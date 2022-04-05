<div class="form-login">
    <form action="#" method="post">
        <table>
            <tr>
                <td>
                    <?= $form->inputTexte('Pseudo', 'pseudo', "Entrer votre Pseudo", ""); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $form->inputPass('Mot de Passe', "pass", "Entrer votre Mot de Passe"); ?>
                </td>
            </tr>
            <tr>
                <td class="button">
                    <?= $form->submit('envoyer', 'Connexion'); ?>
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