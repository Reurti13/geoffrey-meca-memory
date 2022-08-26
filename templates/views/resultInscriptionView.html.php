<h1>Résultat de l'inscription</h1>

<div class="carte_acces">
    <?php
    echo "<p>Vous avez été inscrit correctement " . $pseudo . "</p>"; ?> </br>
    <?php
    echo '<p>Vous pouvez confirmer votre compte <a href="./index.php?controller=controlApp&task=confirmPage">ici</a></p>';
    echo '<p> OU </p>'; ?> </br>
    <?php
    echo '<a href="./index.php?controller=controlApp&task=homePage&id= ' . $_SESSION['id'] . '">Poursuivre vers votre espace perso</a>';

    if (isset($error)) { ?>
        <div class="msgerreur" align="bottom">
            <?= $error; ?>
        </div>
    <?php
    }
    ?>
</div>
</main>