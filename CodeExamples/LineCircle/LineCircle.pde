
/*
LINE/CIRCLE
 Jeff Thompson | 2015 | www.jeffreythompson.org
 
 Via this example by Philip Nicoletti:
 http://www.codeguru.com/forum/showthread.php?threadid=194400
 
 */

float cx = 0;      // circle position (set by mouse)
float cy = 0;
float r =  30;     // circle radius

float x1, y1;      // coordinates of line
float x2, y2;


void setup() {
  size($("#wrapper").width(), 400);
  
  strokeWeight(5);    // make it a little easier to see the line

  x1 = 100;
  y1 = height-100;
  x2 = width-100;
  y2 = 100;
}


void draw() {
  background(255);
  
  // update circle to mouse position
  cx = mouseX;
  cy = mouseY;
  
  // check for collision
  // if hit, change line's stroke color
  boolean hit = lineCircle(x1,y1, x2,y2, cx,cy,r);
  if (hit) stroke(255,150,0, 150);
  else stroke(0,150,255, 150);
  line(x1,y1, x2,y2);
  
  // draw the circle
  fill(0, 150);
  noStroke();
  ellipse(cx,cy, r*2,r*2);  
}


// LINE/CIRCLE
boolean lineCircle(float x1, float y1, float x2, float y2, float cx, float cy, float r) {

  // is either end INSIDE the circle?
  // if so, return true immediately
  boolean inside1 = pointCircle(x1,y1, cx,cy,r);
  boolean inside2 = pointCircle(x2,y2, cx,cy,r);
  if (inside1 || inside2) return true;
  
  // get length of the line
  float distX = x1 - x2;
  float distY = y1 - y2;
  float len = sqrt( (distX*distX) + (distY*distY) );

  // get dot product of the line and circle
  float dot = ( ((cx-x1)*(x2-x1)) + ((cy-y1)*(y2-y1)) ) / pow(len,2);

  // find the closest point on the line
  float closestX = x1 + (dot * (x2-x1));
  float closestY = y1 + (dot * (y2-y1));
  
  // is this point actually on the line segment?
  // if so keep going, but if not, return false
  boolean onSegment = linePoint(x1,y1,x2,y2, closestX,closestY);
  if (!onSegment) return false;

  // optionally, draw a circle at the closest point on the line
  fill(255,0,0);
  noStroke();
  ellipse(closestX, closestY, 20, 20);

  // get distance to closest point
  distX = closestX - cx;
  distY = closestY - cy;
  float distance = sqrt( (distX*distX) + (distY*distY) );

  if (distance <= r) {
    return true;
  }
  return false;
}


// LINE/POINT
boolean linePoint(float x1, float y1, float x2, float y2, float px, float py) {
  
  // get distance from the point to the two ends of the line
  float d1 = dist(px,py, x1,y1);
  float d2 = dist(px,py, x2,y2);
  
  // get the length of the line
  float lineLen = dist(x1,y1, x2,y2);
  
  // since floats are so minutely accurate, add
  // a little buffer zone that will give collision
  float buffer = 0.1;    // higher # = less accurate
  
  // if the two distances are equal to the line's length, the
  // point is on the line!
  // note we use the buffer here to give a range, rather than one #
  if (d1+d2 >= lineLen-buffer && d1+d2 <= lineLen+buffer) {
    return true;
  }
  return false;
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


