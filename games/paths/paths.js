var game = new Phaser.Game(350, 700, Phaser.AUTO, '', { preload: preload, create: create, update: update });

class Button {
  constructor(value) {
    this.value = value;

  }
}
class Session {
  // handles player bet, buttons+values, starting+stopping games
  constructor() {
    this.buttons = [];
  }
  play() {

  }
  end() {
  }
}

function preload() {

}

function create() {
  game.stage.backgroundColor = "#00638E";
}

function update() {

}
