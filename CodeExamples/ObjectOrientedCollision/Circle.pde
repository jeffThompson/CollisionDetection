
class Circle {
  float x, y;    // position
  float r;       // radius
  
  Circle (float _x, float _y, float _r) {
    x = _x;
    y = _y;
    r = _r;
  }
  
  // move into mouse position
  void update() {
    x = mouseX;
    y = mouseY;
  }
  
  // draw
  void display() {
    fill(0, 150);
    noStroke();
    ellipse(x,y, r*2, r*2);
  }
}


