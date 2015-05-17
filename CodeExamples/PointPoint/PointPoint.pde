
/*
POINT POINT
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

float px, py;           // point controlled by the mouse
float targetX = 300;    // target point coordinates
float targetY = 200;


void setup() {
  size(600, 400);
  noCursor();
  
  strokeWeight(5);    // thicker stroke so points are easier to see
}


void draw() {

  // update point position to mouse coordinates
  px = mouseX;
  py = mouseY;

  // check for collision!
  // if hit, make background orange; if not, make it white
  boolean colliding = pointPoint(px, py, targetX, targetY);
  if (colliding) {
    background(255, 150, 0);
  } 
  else {
    background(255);
  }

  // draw the two points
  stroke(0,150,255);
  point(targetX, targetY);
  
  stroke(0,150);
  point(px, py);
}


// POINT/POINT
boolean pointPoint(float x1, float y1, float x2, float y2) {
  
  // are the two points in the same location?
  if (x1 == x2 && y1 == y2) {
    return true;
  }
  return false;
}


