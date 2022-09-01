const GAME_SIZE   = 600;
const SQUARE_SIZE = 20;
const canvas      = document.getElementById('game');
const divScore    = document.getElementById("score");
const inputScore  = document.querySelectorAll("input")[1];
const divPanel    = document.querySelector("#panel");
const formResult  = document.querySelector("#result");
const ctx         = canvas.getContext('2d');

const snake = new Snake(SQUARE_SIZE);
const food  = new Food();

let currentDirection = 'right';
let score = 0;
let speed = 300;

function detectKeyPressed(){
    document.addEventListener('keydown', function(event){
        switch (event.key) {
            case 'ArrowLeft':
                currentDirection = 'left';
                break;
            case 'ArrowRight':
                currentDirection = 'right';
                break;
            case 'ArrowUp':
                currentDirection = 'up';
                break;
            case 'ArrowDown':
                currentDirection = 'down';
                break;
        
            default:
                break;
        }

    });
}

function clearScreen() {
    ctx.clearRect(0, 0, GAME_SIZE, GAME_SIZE);
}

function rejouer(){
    location.reload();
}
function gameOver(){
    divPanel.classList.add('visually-hidden')
    formResult.classList.remove('visually-hidden')
    inputScore.value = score
}

function update() {
    clearScreen();
    food.draw();
    snake.update();
    if (snake.alive){
       setTimeout(update, speed); 
       divScore.innerHTML = score
    }
}

function start() {
    detectKeyPressed();
    update();
}

start();
