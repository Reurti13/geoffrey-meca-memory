<main>
    <div class="affichageJeu">
        <div class="resultat text-center">
            <p class="top">Top 10</p>
            <p><?= $userInfo['pseudo'] ?> : <?= $userInfo['score'] ?></p>

        </div>

        <div class="tapis text-center" id="strt">
            <div id="jeu"></div>
            <button class='text-center btn btn-success mt-5' style='width:100px; height:100px;' onclick='rejouer()'>Rejouer</button>
        </div>

        <div class="info text-center mt-3">
            <form action="#" method="post">
                <p>Vous en êtes à <span id="count"></span> coups !</p>

                </br>
                <!-- <p>Il vous reste <span id="decount"></span> coups !</p> -->

                <div id="chrono">
                    <h1><time>00:00:00</time></h1>
                    <button id="strt">start</button>
                    <button id="stp">stop</button>
                    <button id="rst">reset</button>
                </div>
            </form>
        </div>
    </div>
</main>