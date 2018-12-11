
/*
POINT POINT
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

float px, py;             // point controlled by the mouse
float targetX, targetY;   // target point coordinates


void setup() {
  size($("#wrapper").width(), 400);
  noCursor();
  
  strokeWeight(15);    // thicker stroke so points are easier to see

  targetX = width/2;
  targetY = height/2;
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
// (note this version includes a "buffer" zone around the points to
//  make collision feel more natural instead of being just a 1px zone)
boolean pointPoint(float x1, float y1, float x2, float y2) {
  
  // treat the points like circles
  float buffer = 3;
  float distX = x1-x2;
  float distY = y1-y2;
  float distance = sqrt( (distX*distX) + (distY*distY) );
  if (distance <= buffer*2) {
    return true;
  }
  return false;

  // original code
  // are the two points in the same location?
  //if (x1 == x2 && y1 == y2) {
  //  return true;
  //}
  //return false;
}



