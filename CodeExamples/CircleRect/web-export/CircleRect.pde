
/*
CIRCLE/RECTANGLE
Jeff Thompson | 2015 | www.jeffreythompson.org

Via this example by Matt Worden:
http://vband3d.tripod.com/visualbasic/tut_mixedcollisions.htm

*/

float cx = 0;      // circle position (set with mouse)
float cy = 0;
float r = 30;      // circle radius

float sx, sy;      // square position
float sw = 200;    // and dimensions
float sh = 200;


void setup() {
  size($("#wrapper").width(), 400);
  noStroke();

  sx = width/2-sw/2;
  sy = height/2-sh/2;
}


void draw() {
  background(255);
  
  // update square to mouse coordinates
  cx = mouseX;
  cy = mouseY;
  
  // check for collision
  // if hit, change rectangle color
  boolean hit = circleRect(cx,cy,r, sx,sy,sw,sh);
  if (hit) {
    fill(255,150,0);
  }
  else {
    fill(0,150,255);
  }
  rect(sx,sy, sw,sh);
  
  // draw the circle
  fill(0, 150);
  ellipse(cx,cy, r*2,r*2);  
}


// CIRCLE/RECTANGLE
boolean circleRect(float cx, float cy, float radius, float rx, float ry, float rw, float rh) {
  
  // temporary variables to set edges for testing
  float testX = cx;
  float testY = cy;
  
  // which edge is closest?
  if (cx < rx)         testX = rx;        // compare to left edge
  else if (cx > rx+rw) testX = rx+rw;     // right edge
  if (cy < ry)         testY = ry;        // top edge
  else if (cy > ry+rh) testY = ry+rh;     // bottom edge
  
  // get distance from closest edges
  float distX = cx-testX;
  float distY = cy-testY;
  float distance = sqrt( (distX*distX) + (distY*distY) );
  
  // if the distance is less than the radius, collision!
  if (distance <= radius) {
    return true;
  }
  return false;
}



