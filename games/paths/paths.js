var game = new Phaser.Game(350, 700, Phaser.AUTO, 'game', { preload: preload, create: create, update: update });

class Button {
  constructor(value) {
    this.value = value;
    this.correct = false;
  }
}
class ButtonPair {
  constructor() {
    this.buttons = [new Button(), new Button()];
    this.buttons[Math.round(Math.random())].correct = true;
  }
}
class Session {
  // handles player bet, buttons+values, starting+stopping games
  constructor(difficulty = 1) {
    this.difficulty = difficulty;   // 0 = easy, 1 = normal, 2 = hard
    this.buttons = [];  // stores buttonpairs
    this.bet = document.getElementById('bet').value;
  }
  start() {
    if (this.bet == 0) {
      console.log("Bet must be > 0");
      return;
    }
    console.log("Session started");
  }
  end() {
  }
}

function preload() {

}

function create() {
  game.stage.backgroundColor = "#00638E";
  var session = new Session();
  session.start();

}

function update() {
}
