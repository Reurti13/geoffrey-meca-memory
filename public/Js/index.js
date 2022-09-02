/***************************************************Menu Burger********************************** */ 
function toggleMenu()
{
  const navbar = document.querySelector('.navbar');
  const burger = document.querySelector('.burger');
  burger.addEventListener('click', () => {
    navbar.classList.toggle('open-nav');
  });
}
toggleMenu();

/***************************************************BACKGROUNDS********************************** */ 

let $_GET = [];
let parts = window.location.search.substr(1).split("&");

for (let i = 0; i < parts.length; i++) {

    let temp = parts[i].split("=");

    $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);

    const main = document.querySelector("main");

    if(temp[1] == undefined){
        main.classList.add('accueil')
    }
    else if(temp[1] == 'memoryPage'){
        main.classList.add('arene')
    }
    else if(temp[1] == 'snakePage'){
        main.classList.add('arene')
    }
    else {
        main.classList.add('standby')
    }


/***************************************************Jeu Memory********************************** */ 

    const divJeu     = document.querySelector("#jeu");
    const divCount   = document.querySelector("#count");
    const divPoint   = document.querySelector("#point");
    const inputScore = document.querySelectorAll("input")[1];
    const inputPoint = document.querySelectorAll("input")[2];
    const divPanel   = document.querySelector("#panel");
    const formResult = document.querySelector("#result")


    if (temp[1] == 'facile'){

        let tabJeu = [
            [0,0,0,0],
            [0,0,0,0]
        ];

        let tabResultat      = genereTableauAleatoire();
        let ready            = true;
        let premierClick     ="";
        let nbAffiche        = 0;
        let nbPairesTrouvees = 0;
        let nbEssaiFacile    = 0;
        let nbPoints         = 0;

        afficherTableau();
        afficheCount();

        function afficherTableau(){  
            let txt = "";
    
            for(let i=0; i < tabJeu.length; i++){
                txt += "<div>";
    
                for(let j=0; j < tabJeu[i].length; j++){
    
                    if(tabJeu[i][j] === 0){
                        txt += "<button type='submit' class='pokeball m-2' name='click' onclick='controle(\""+i+","+j+"\")'></button>"
                    }
                    else if (tabJeu[i][j] === -1) {
                        txt += "<img src='' style='visibility:hidden;' class='pokemon m-2'>";
                    }
                    else{
                        txt += "<img src='"+getImage(tabJeu[i][j])+"' class='pokemon m-2'>";
                    }
                }
                txt += "</div>";
            }
            divJeu.innerHTML = txt ;
        }
    
        function getImage(valeur){
            let imgTxt = "./public/pictures/poke/";
    
            switch(valeur){
                case 1 : imgTxt += "Arbok.webp";
                break;
                case 2 : imgTxt += "Bulbizarre.png";
                break;
                case 3 : imgTxt += "Carapuce.png";
                break;
                case 4 : imgTxt += "evoli.webp";
                break;
                case 5 : imgTxt += "Machoc.png";
                break;
                case 6 : imgTxt += "mewtwo.webp";
                break;
                case 7 : imgTxt += "Miaouss.png";
                break;
                case 8 : imgTxt += "pikachu.jpg";
                break;
                case 9 : imgTxt += "Smogogo.png";
                break;
                case 10 : imgTxt += "reptincel.jpg";
                break;
                default : console.log("cas non pris en compte")
            }
            return imgTxt;
        }

        function controle(carte){
            if(ready){
                nbAffiche++;
                let ligne = carte.substr(0,1);
                let colone= carte.substr(2,1);
                tabJeu[ligne][colone] = tabResultat[ligne][colone];
                afficherTableau();
    
                if(nbAffiche>1){ // Vérification
                    ready = false;
                    nbEssaiFacile++;
                    afficheCount();
    
                    setTimeout(() => {
                        if(tabJeu[ligne][colone] !== tabResultat[premierClick[0]][premierClick[1]]){
                            tabJeu[ligne][colone] = 0;
                            tabJeu[premierClick[0]][premierClick[1]] = 0;
                        }
                        else{
                            tabJeu[ligne][colone] = -1;
                            tabJeu[premierClick[0]][premierClick[1]] = -1;
                            nbPairesTrouvees++;
                        }
    
                        afficherTableau();
                        ready = true;
                        nbAffiche = 0;
                        premierClick = [ligne,colone];
    
                        if(nbPairesTrouvees==4){
                            divPanel.classList.add('visually-hidden')
                            formResult.classList.remove('visually-hidden')
                            inputScore.value = nbEssaiFacile
                            inputPoint.value = nbPoints
                        }
    
                    },1000)  
    
                } else {
                    premierClick = [ligne,colone];
                }
            }
        }
    
        function genereTableauAleatoire(){
            let tab = [];
            let nbImagePosition=[0,0,0,0];
    
            for(let i=0; i < 2; i++){
                let ligne = [];
    
                for(let j=0; j<4; j++){
                    let fin = false;
    
                    while(!fin){
                        let randomImage = Math.floor(Math.random()*4);
                        if(nbImagePosition[randomImage] < 2){
                        
                            ligne.push(randomImage+1);
                            nbImagePosition[randomImage]++;
    
                            fin = true;
                        }
                    }    
                }
                tab.push(ligne);
            }
            return tab;
        }

        function afficheCount(){
            if (nbEssaiFacile < 6){
                nbPoints = 10;
            }else{
                nbPoints = 5;
            }
            divCount.innerHTML = nbEssaiFacile;
            divPoint.innerHTML = nbPoints;
        }

        function rejouer(){
            location.reload();
        }

    }else if (temp[1] == 'moyen'){

        let tabJeu = [
            [0,0,0,0],
            [0,0,0,0],
            [0,0,0,0]
        ];

        let tabResultat      = genereTableauAleatoire();
        let ready            = true;
        let premierClick     ="";
        let nbAffiche        = 0;
        let nbPairesTrouvees = 0;
        let nbEssaiMoyen     = 0;
        let nbPoints         = 0

        afficherTableau();
        afficheCount();

        function afficherTableau(){  
            let txt = "";
    
            for(let i=0; i < tabJeu.length; i++){
                txt += "<div>";
    
                for(let j=0; j < tabJeu[i].length; j++){
    
                    if(tabJeu[i][j] === 0){
                        txt += "<button type='submit' class='pokeball m-2' name='click' onclick='controle(\""+i+","+j+"\")'></button>"
                    }
                    else if (tabJeu[i][j] === -1) {
                        txt += "<img src='' style='visibility:hidden;' class='pokemon m-2'>";
                    }
                    else{
                        txt += "<img src='"+getImage(tabJeu[i][j])+"' class='pokemon m-2'>";
                    }
                }
                txt += "</div>";
            }
            divJeu.innerHTML = txt ;
        }
    
        function getImage(valeur){
            let imgTxt = "./public/pictures/poke/";
    
            switch(valeur){
                case 1 : imgTxt += "Arbok.webp";
                break;
                case 2 : imgTxt += "Bulbizarre.png";
                break;
                case 3 : imgTxt += "Carapuce.png";
                break;
                case 4 : imgTxt += "evoli.webp";
                break;
                case 5 : imgTxt += "Machoc.png";
                break;
                case 6 : imgTxt += "mewtwo.webp";
                break;
                case 7 : imgTxt += "Miaouss.png";
                break;
                case 8 : imgTxt += "pikachu.jpg";
                break;
                case 9 : imgTxt += "Smogogo.png";
                break;
                case 10 : imgTxt += "reptincel.jpg";
                break;
                default : console.log("cas non pris en compte")
            }
            return imgTxt;
        }

        function controle(carte){
            if(ready){
                nbAffiche++;
                let ligne = carte.substr(0,1);
                let colone= carte.substr(2,1);
                tabJeu[ligne][colone] = tabResultat[ligne][colone];
                afficherTableau();
    
                if(nbAffiche>1){ // Vérification
                    ready = false;
                    nbEssaiMoyen++;
                    afficheCount();
    
                    setTimeout(() => {
                        if(tabJeu[ligne][colone] !== tabResultat[premierClick[0]][premierClick[1]]){
                            tabJeu[ligne][colone] = 0;
                            tabJeu[premierClick[0]][premierClick[1]] = 0;
                        }
                        else{
                            tabJeu[ligne][colone] = -1;
                            tabJeu[premierClick[0]][premierClick[1]] = -1;
                            nbPairesTrouvees++;
                        }
    
                        afficherTableau();
                        ready = true;
                        nbAffiche = 0;
                        premierClick = [ligne,colone];
    
                        if(nbPairesTrouvees==6){
                            divPanel.classList.add('visually-hidden')
                            formResult.classList.remove('visually-hidden')
                            inputScore.value = nbEssaiMoyen
                            inputPoint.value = nbPoints
                        }
    
                    },1000)  
    
                } else {
                    premierClick = [ligne,colone];
                }
            }
        }
    
        function genereTableauAleatoire(){
            let tab = [];
            let nbImagePosition=[0,0,0,0,0,0];
    
            for(let i=0; i < 3; i++){
                let ligne = [];
    
                for(let j=0; j<4; j++){
                    let fin = false;
    
                    while(!fin){
                        let randomImage = Math.floor(Math.random()*6);
                        if(nbImagePosition[randomImage] < 2){
                        
                            ligne.push(randomImage+1);
                            nbImagePosition[randomImage]++;
    
                            fin = true;
                        }
                    }    
                }
                tab.push(ligne);
            }
            return tab;
        }

        function afficheCount(){
            if (nbEssaiMoyen < 8){
                nbPoints = 25
            }else{
                nbPoints = 10
            }
            divCount.innerHTML = nbEssaiMoyen;
            divPoint.innerHTML = nbPoints;
        }

        function rejouer(){
            location.reload();
        }

    }else if (temp[1] == 'difficile') {

        let tabJeu = [
            [0,0,0,0],
            [0,0,0,0],
            [0,0,0,0],
            [0,0,0,0],
            [0,0,0,0]
        ];

        let tabResultat      = genereTableauAleatoire();
        let ready            = true;
        let premierClick     ="";
        let nbAffiche        = 0;
        let nbPairesTrouvees = 0;
        let nbEssai          = 0;
        let nbPoints         = 0

        afficherTableau();
        afficheCount();

        function afficherTableau(){  
            let txt = "";

            for(let i=0; i < tabJeu.length; i++){
                txt += "<div>";

                for(let j=0; j < tabJeu[i].length; j++){

                    if(tabJeu[i][j] === 0){
                        txt += "<button type='submit' class='pokeball m-2' name='click' onclick='controle(\""+i+","+j+"\")'></button>"
                    }
                    else if (tabJeu[i][j] === -1) {
                        txt += "<img src='' style='visibility:hidden;' class='pokemon m-2'>";
                    }
                    else{
                        txt += "<img src='"+getImage(tabJeu[i][j])+"' class='pokemon m-2'>";
                    }
                }
                txt += "</div>";
            }
            divJeu.innerHTML = txt ;
        }

        function getImage(valeur){
            let imgTxt = "./public/pictures/poke/";

            switch(valeur){
                case 1 : imgTxt += "Arbok.webp";
                break;
                case 2 : imgTxt += "Bulbizarre.png";
                break;
                case 3 : imgTxt += "Carapuce.png";
                break;
                case 4 : imgTxt += "evoli.webp";
                break;
                case 5 : imgTxt += "Machoc.png";
                break;
                case 6 : imgTxt += "mewtwo.webp";
                break;
                case 7 : imgTxt += "Miaouss.png";
                break;
                case 8 : imgTxt += "pikachu.jpg";
                break;
                case 9 : imgTxt += "Smogogo.png";
                break;
                case 10 : imgTxt += "reptincel.jpg";
                break;
                default : console.log("cas non pris en compte")
            }
            return imgTxt;
        }

        function controle(carte){
            if(ready){
                nbAffiche++;
                let ligne = carte.substr(0,1);
                let colone= carte.substr(2,1);
                tabJeu[ligne][colone] = tabResultat[ligne][colone];
                afficherTableau();

                if(nbAffiche>1){ // Vérification
                    ready = false;
                    nbEssai++;
                    afficheCount();

                    setTimeout(() => {
                        if(tabJeu[ligne][colone] !== tabResultat[premierClick[0]][premierClick[1]]){
                            tabJeu[ligne][colone] = 0;
                            tabJeu[premierClick[0]][premierClick[1]] = 0;
                        }
                        else{
                            tabJeu[ligne][colone] = -1;
                            tabJeu[premierClick[0]][premierClick[1]] = -1;
                            nbPairesTrouvees++;
                        }

                        afficherTableau();
                        ready = true;
                        nbAffiche = 0;
                        premierClick = [ligne,colone];

                        if(nbPairesTrouvees==10){
                            gameOver()
                            inputScore.value = nbEssai
                            inputPoint.value = nbPoints
                        }

                    },1000)  

                } else {
                    premierClick = [ligne,colone];
                }
            }
        }

        function genereTableauAleatoire(){
            let tab = [];
            let nbImagePosition=[0,0,0,0,0,0,0,0,0,0];

            for(let i=0; i < 5; i++){
                let ligne = [];

                for(let j=0; j<4; j++){
                    let fin = false;

                    while(!fin){
                        let randomImage = Math.floor(Math.random()*10);
                        if(nbImagePosition[randomImage] < 2){
                        
                            ligne.push(randomImage+1);
                            nbImagePosition[randomImage]++;

                            fin = true;
                        }
                    }    
                }
                tab.push(ligne);
            }
            return tab;
        }

        function afficheCount(){
            if (nbEssai < 15){
                nbPoints = 30
            }else{
                nbPoints = 20
            }
            divCount.innerHTML = nbEssai;
            divPoint.innerHTML = nbPoints;
        }
        function gameOver(){
            divPanel.classList.add('visually-hidden')
            formResult.classList.remove('visually-hidden')
        }

        function rejouer(){
            location.reload();
        }
}
}