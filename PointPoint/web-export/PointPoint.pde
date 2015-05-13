
/*
1: POINT POINT
Jeff Thompson | 2015 | www.jeffreythompson.org


*/

int px, py;        // point controlled by the mouse
int targetX = 300;    // target point coordinates
int targetY = 200;


void setup() {
  size(600, 400);
  noCursor();
  
  strokeWeight(5);  // thicker stroke so points are easier to see
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
  stroke(255,0,0);
  point(targetX, targetY);
  
  stroke(0);
  point(px, py);
}


// check if points are in the same location
boolean pointPoint(int x1, int y1, int x2, int y2) {
  if (x1 == x2 && y1 == y2) {
    return true;
  }
  return false;
}


