
class Circle {
  float x, y;
  float r;
  float speed;
  boolean hit = false;
  
  Circle(float _x, float _y) {
    x = _x;
    y = _y;
    r = random(8,20);
    speed = random(0.5, 2);
  }
  
  void update() {
    y += speed;
    hit = circleCircle(x,y,r, cx,cy,cr);
  }    
  
  void display() {
    if (!hit) fill(0,150,255, 150);
    else fill(255,150,0, 150);
    noStroke();
    ellipse(x,y, r*2,r*2);
  }  
}


