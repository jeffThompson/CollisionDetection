
/*
POINT/CIRCLE
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

float px =     0;      // point position
float py =     0;

float cx, cy;          // circle center position
float radius = 100;    // circle's radius


void setup() {
  size($("#wrapper").width(), 400);
  noCursor();
  
  strokeWeight(15);   // thicker stroke so points are easier to see

  cx = width/2;
  cy = height/2;
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


// POINT/CIRCLE
boolean pointCircle(float px, float py, float cx, float cy, float r) {
  
  // get distance between the point and circle's center
  // using the Pythagorean Theorem
  float distX = px - cx;
  float distY = py - cy;
  float distance = sqrt( (distX*distX) + (distY*distY) );

  // if the distance is less than the circle's 
  // radius the point is inside!
  if (distance <= r) {
    return true;
  }
  return false;
}




