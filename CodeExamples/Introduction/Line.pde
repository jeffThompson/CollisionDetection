
class Line {
  float x1, y1, x2, y2;
  float speed;
  boolean hit = false;
  
  Line(float _x1, float _y1, float _x2, float _y2) {
    x1 = _x1;
    y1 = _y1;
    x2 = _x2;
    y2 = _y2;
    speed = random(0.5, 2);
  }
  
  void update() {
    y1 += speed;
    y2 += speed;
    hit = lineCircle(x1,y1,x2,y2, cx,cy,cr);
  }
  
  void display() {
    if (!hit) stroke(0,150,255, 150);
    else stroke(255,150,0, 150);
    strokeWeight(5);
    line(x1,y1, x2,y2);
  }  
}


