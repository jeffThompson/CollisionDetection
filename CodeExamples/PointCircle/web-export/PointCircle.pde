
/*
POINT/CIRCLE
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

int px =     0;      // point position
int py =     0;

int cx =     300;    // circle center position
int cy =     200;
int radius = 100;    // circle's radius


void setup() {
  size(600,400);
  noCursor();
  
  strokeWeight(5);   // thicker stroke so points are easier to see
}


void draw() {
  background(255);
  
  // update point position to mouse coordinates
  px = mouseX;
  py = mouseY;
  
  // check for collision!
  boolean hit = pointCircle(px,py, cx,cy, radius);
  
  // draw circle
  // change fill color if hit
  if (hit) {
    fill(255,150,0);
  }
  else {
    fill(0,150,255);
  }
  noStroke();
  ellipse(cx,cy, radius*2,radius*2);
  
  // draw the point
  stroke(0);
  point(px, py);
}


// check if point is inside the circle
boolean pointCircle(int px, int py, int cx, int cy, int r) {
  //int distX = px - cx;
  //int distY = py - cy;
  //int distance = sqrt( (distX*distX) + (distY*distY) );
  int distance = dist(px,py, cx,cy);

  if (distance <= r) {
    return true;
  }
  return false;
}




