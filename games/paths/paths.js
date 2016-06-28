var WINDOW_HEIGHT = 600;
var WINDOW_WIDTH = 350;
var BUTTON_PADDING_TOP = 5;
var BUTTON_PADDING_LEFT = 3;
var BUTTON_PADDING_RIGHT = 3;
var BUTTON_PADDING = 20;
var game = new Phaser.Game(WINDOW_WIDTH, WINDOW_HEIGHT, Phaser.AUTO, 'game', { preload: preload, create: create, update: update });
var session;
var playButton;
var bet = 0;
var style;
class Button {
  constructor(value, xPos, yPos) {
    this.text = game.add.text(77, 12, value, style);  // TODO: fix positioning of text when they are big numbers
    this.value = value;
    this.correct = false;
    this.sprite = game.add.button(xPos, yPos, 'button');
    this.sprite.addChild(this.text);
  }
}
class ButtonPair {
  constructor(value, yPos) {
    this.buttons = [new Button(value, BUTTON_PADDING_LEFT, yPos), new Button(value, WINDOW_WIDTH-(167+BUTTON_PADDING_RIGHT),yPos)];
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
    this.winnings = 0;  // increased every time a player gets to the next level
  }
  buildGameBoard() {
    if (this.difficulty == 1) {
      // normal difficulty, 10x2 game board
      var xPos = BUTTON_PADDING_TOP;
      var value = bet * 500;
      for (var i = 0; i < 10; i++) {
        this.buttons.push(new ButtonPair(Math.round(value), xPos));
        xPos += 36+BUTTON_PADDING;
        value/=2;
      }
    }
  }
  start() {
    console.log(this.bet);
    if (this.bet < 15) {
      console.log("Bet must be at least 15");
      document.getElementById("bet").placeholder = "Bet must be at least 15!";
      document.getElementById("bet").value = "";
      return;
    } else {
      console.log("Session started");
      this.buildGameBoard();
    }
  }
  end() {
    // kill the game
  }
}

function preload() {
  // load textures
  game.load.image('playbutton','games/paths/assets/playbutton.png');
  game.load.image('button', 'games/paths/assets/button.png');
}

function create() {
  game.stage.backgroundColor = "#00638E";
  button = game.add.button(WINDOW_WIDTH-167, WINDOW_HEIGHT-36, 'playbutton', playButtonPressed, this);
  style = { font: "12px Arial", fill: "#000", wordWrap: true, wordWrapWidth: null, align: "center" };
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
