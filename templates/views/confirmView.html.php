<h1>Confirmation de votre compte</h1>

<div class="carte_acces">
    <?php
    echo "<p>Votre compte a bien été confirmé correctement " . $pseudo . "</p>";
    echo '<a href="./index.php?controller=controlUser&task=homePage&id= ' . $_SESSION['id'] . '">Poursuivre vers votre espace perso</a>';
    ?>
</div>
<?php   
    if(isset($error))
    {?>
    <div class="msgerreur" align="bottom">
        <?= $error; ?>
    </div>
    <?php 
    }
?>