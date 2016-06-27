var game = new Phaser.Game(350, 700, Phaser.AUTO, 'game', { preload: preload, create: create, update: update });
var session;
var playButton;
var bet = 0;
class Button {
  constructor(value) {
    this.value = value;
    this.correct = false;
  }
}
class ButtonPair {
  constructor(value) {
    this.buttons = [new Button(), new Button()];
    this.buttons[Math.round(Math.random())].correct = true;
  }
}
// Session will act as a handler for all aspects of the game.
// It will control the buttonpairs, how they spawn, and their values.
class Session {
  // handles player bet, buttons+values, starting+stopping games
  constructor(difficulty = 1, bet) {
    this.difficulty = difficulty;   // 0 = easy, 1 = normal, 2 = hard
    this.buttons = [];  // stores buttonpairs
    this.bet = bet;
  }
  start() {
    console.log(this.bet);
    if (this.bet == 0) {
      console.log("Bet must be > 0");
      return;
    }
    console.log("Session started");
  }
  end() {
    // kill the game
  }
}

function preload() {
  // load textures
  game.load.image('button','games/paths/assets/playbutton.png');
}

function create() {
  game.stage.backgroundColor = "#00638E";
  button = game.add.button(0, 0, 'button', playButtonPressed, this);

}

function update() {
  
}
function waitForBet(e) {
  bet = e.value;
}
function playButtonPressed () {
  session = new Session(1, bet);
  session.start();
}
