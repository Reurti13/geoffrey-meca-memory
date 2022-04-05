<nav class="navbar perso-mode">

  <div class="navbar_logo"><a href="./index.php"><img class="logo" src="./public/pictures/fokemon4.svg" alt="logoFokemon"></a></div>

  <div class="date">
    <?php setlocale(LC_TIME, 'fr_FR');
    date_default_timezone_set('Europe/Paris');
    echo utf8_encode(strftime('%A %d %B %Y, %H:%M'));
    ?>
  </div>

  <ul class="navbar_links">
    <li class="navbar_link un"><a href="./index.php">Accueil</a></li>
    <li class="navbar_link deux"><a href="./index.php?controller=ControlApp&task=loginPage">Login</a></li>
    <li class="navbar_link trois"><a href="./index.php?controller=ControlApp&task=inscriptionPage">Inscription</a></li>
    <li class="navbar_link quatre"><a href="./index.php?controller=ControlUser&task=homePage">Mon Espace</a></li>
  </ul>

  <button class="burger">
    <span class="bar"></span>
  </button>
</nav>