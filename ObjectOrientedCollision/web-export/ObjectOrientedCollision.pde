
/*
OBJECT-ORIENTED COLLISION
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

// a single Circle object, controlled by the mouse
Circle c;

// a list of rectangles
Rectangle[] rects = new Rectangle[8];


void setup() {
  size(600,400);
  
  // create a new Circle with 30px radius
  circle = new Circle(0,0, 30);
  
  // generate rectangles in random locations
  for (int i=0; i<rects.length; i++) {
    rects[i] = new Rectangle(random(width-50), random(height-50), 50,50);
  }
}


void draw() {
  background(255);
  
  // go through all rectangles...
  for (Rectangle r : rects) {
    r.checkCollision(circle);  // check for collision
    r.display();               // and draw
  }
  
  // update circle's position and draw
  circle.update();
  circle.display();
}



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



boolean circleRect(float cx, float cy, float r, float sx, float sy, float sw, float sh) {
  
  // temporary variables to set edges for testing
  float testX = cx;
  float testY = cy;
  
  // which edge is closest?
  if (cx < sx)         testX = sx;        // compare to left edge
  else if (cx > sx+sw) testX = sx+sw;     // right edge
  if (cy < sy)         testY = sy;        // top edge
  else if (cy > sy+sh) testY = sy+sh;     // bottom edge
  
  // get distance from closest edges
  float distX = cx-testX;
  float distY = cy-testY;
  float distance = sqrt( (distX*distX) + (distY*distY) );
  
  // if the distance is less than the radius, collision!
  if (distance <= r) {
    return true;
  }
  return false;
}



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



