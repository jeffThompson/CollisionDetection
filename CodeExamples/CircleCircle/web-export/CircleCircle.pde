
/*
CIRCLE/CIRCLE
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

int c1x = 0;      // circle 1 position (controlled by mouse)
int c1y = 0;
int c1r = 30;     // radius

int c2x, c2y;     // circle 2 position
int c2r = 100;


void setup() {
  size($("#wrapper").width(), 400);
  noStroke();

  c2x = width/2;
  c2y = height/2;
}


void draw() {
  background(255);
  
  // update position to mouse coordinates
  c1x = mouseX;
  c1y = mouseY;
  
  // check for collision
  // if hit, change color
  boolean hit = circleCircle(c1x,c1y,c1r, c2x,c2y,c2r);
  if (hit) {
    fill(255,150,0);
  }
  else {
    fill(0,150,255);
  }
  ellipse(c2x,c2y, c2r*2,c2r*2);
  
  // other circle, controlled by mouse
  fill(0, 150);
  ellipse(c1x,c1y, c1r*2,c1r*2);
}


// check if circles are touching
boolean circleCircle(int c1x, int c1y, int c1r, int c2x, int c2y, int c2r) {
  int distX = c1x - c2x;
  int distY = c1y - c2y;
  int distance = sqrt( (distX*distX) + (distY*distY) );

  if (distance <= c1r+c2r) {
    return true;
  }
  else {
    return false;
  }
}



