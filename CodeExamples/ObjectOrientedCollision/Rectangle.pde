
class Rectangle {
  float x, y;            // position
  float w, h;            // size
  boolean hit = false;   // is it hit?
  
  Rectangle (float _x, float _y, float _w, float _h) {
    x = _x;
    y = _y;
    w = _w;
    h = _h;
  }
  
  // check for collision with the circle using the
  // Circle/Rect function we made in the beginning
  void checkCollision(Circle c) {
    hit = circleRect(c.x,c.y,c.r, x,y,w,h);
  }
  
  // draw the rectangle
  // if hit, change the fill color
  void display() {
    if (hit) fill(255,150,0);
    else fill(0,150,255);
    noStroke();
    rect(x,y, w,h);
  }
}


