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

/***************************************************Jeu Memory********************************** */ 

const divJeu = document.querySelector("#jeu");
const divCount = document.querySelector("#count");
const divDeCount = document.querySelector("#decount");

var tabJeu = [
    [0,0,0,0,0],
    [0,0,0,0,0],
    [0,0,0,0,0],
    [0,0,0,0,0]
];

var tabResultat = genereTableauAleatoire();

var ready = true;

var premierClick ="";

var nbAffiche = 0;
var nbPairesTrouvees = 0;
var ndEssai = 0;
var nbChance = 22;

afficherTableau();
afficheCount();
afficheDeCount();

function afficherTableau(){  
    var txt = "";

    for(var i=0; i < tabJeu.length; i++){
        txt += "<div>";

        for(var j=0; j < tabJeu[i].length; j++){

            if(tabJeu[i][j] === 0){
                txt += "<button class='btn btn-primary m-2' style='width:15vw; height:15vw;' onclick='controle(\""+i+","+j+"\")'>?</button>"
            }
            else if (tabJeu[i][j] === -1) {
                txt += "<img src='' style='visibility:hidden; width:15vw; height:15vw;' class='m-2'>";
            }
            else{
                txt += "<img src='"+getImage(tabJeu[i][j])+"' style='width:15vw;height:15vw;' class='m-2'>";
            }
        }
        txt += "</div>";
    }
    divJeu.innerHTML = txt ;
}

function getImage(valeur){
    var imgTxt = "./public/pictures/image/";

    switch(valeur){
        case 1 : imgTxt += "Anni.jfif";
        break;
        case 2 : imgTxt += "Concept.jpg";
        break;
        case 3 : imgTxt += "Kylo.jpg";
        break;
        case 4 : imgTxt += "luke-skywalker.jpg";
        break;
        case 5 : imgTxt += "Maul.jpg";
        break;
        case 6 : imgTxt += "Obi.jpg";
        break;
        case 7 : imgTxt += "OldJedi.jpg";
        break;
        case 8 : imgTxt += "QuiQuon.jfif";
        break;
        case 9 : imgTxt += "Revan.jpg";
        break;
        case 10 : imgTxt += "Rey.jpg";
        break;
        default : console.log("cas non pris en compte")
    }
    return imgTxt;
}

function controle(carte){
    if(ready){
        nbAffiche++;
        var ligne = carte.substr(0,1);
        var colone= carte.substr(2,1);
        tabJeu[ligne][colone] = tabResultat[ligne][colone];
        afficherTableau();

        if(nbAffiche>1){ // Vérification
            ready = false;
            ndEssai++;
            nbChance--;
            afficheDeCount();
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
					finDeJeu();
				}
                else if (nbChance==0) {
                    gameOver();
                }
            },1000)  

        } else {
            premierClick = [ligne,colone];
            console.log(tabJeu[ligne][colone]);
        }
    }
}

function genereTableauAleatoire(){
    var tab = [];
    var nbImagePosition=[0,0,0,0,0,0,0,0,0,0];

    for(var i=0; i < 4; i++){
        var ligne = [];

        for(var j=0; j<5; j++){
            var fin = false;

            while(!fin){
                var randomImage = Math.floor(Math.random()*10);
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
    divCount.innerHTML = ndEssai; 
}

function afficheDeCount(){
    divDeCount.innerHTML = nbChance; 
}

function finDeJeu(){
	alert("Félicitation !!!!!!");
	location.reload();
}
function gameOver(){
    alert("Vous avez Perdu la partie !");
    location.reload();
}
function rejouer(){
	location.reload();
}