
class Rectangle {
  float x, y;
  float w, h;
  float speed;
  boolean hit = false;
  
  Rectangle(float _x, float _y) {
    x = _x;
    y = _y;
    w = random(8,20);
    h = random(8,20);
    speed = random(0.5, 2);
  }
  
  void update() {
    y += speed;
    hit = circleRect(cx,cy,cr, x,y,w,h);
  }
  
  void display() {
    if (!hit) fill(0,150,255, 150);
    else fill(255,150,0, 150);
    noStroke();
    rect(x,y, w,h);
  }  
}


