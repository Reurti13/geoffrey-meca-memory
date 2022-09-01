<main class="">
  <nav class="navbar perso-mode">

    <div class="navbar_logo">
      <a href="./index.php"><img class="logo" src="./public/pictures/SVG/fokemon4.svg" alt="logoFokemon"></a>
    </div>

    <div class="date">
      <?php setlocale(LC_TIME, 'fr_FR');
      date_default_timezone_set('Europe/Paris');
      echo utf8_encode(date("D F, j, Y, g:i a"));
      ?>
    </div>

    <ul class="navbar_links">
      <li class="navbar_link un"> <a href="./index.php">Accueil</a></li>
      <li class="navbar_link deux"> <a href="./index.php?controller=ControlApp&task=loginPage">Connexion</a></li>
      <li class="navbar_link trois"> <a href="./index.php?controller=ControlApp&task=gamesPage">Jeux</a></li>
      <li class="navbar_link quatre"><a href="./index.php?controller=ControlUser&task=homePage">Mon Espace</a></li>
    </ul>

    <button class="burger">
      <span class="bar"></span>
    </button>
  </nav>