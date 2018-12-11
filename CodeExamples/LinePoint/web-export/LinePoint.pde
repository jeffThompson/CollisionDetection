
/*
LINE/POINT
 Jeff Thompson | 2015 | www.jeffreythompson.org
 
 Via: http://stackoverflow.com/a/17693146/1167783
 
 */

float px = 0;         // point position (set by mouse)
float py = 0;

float x1,y1, x2,y2;   // line defined by two points


void setup() {
  size($("#wrapper").width(), 400);
  noCursor();
  
  strokeWeight(15);  // make things a little easier to see

  x1 = 100;
  y1 = height-100;
  x2 = width-100;
  y2 = 100;
}


void draw() {
  background(255);
  
  // set point to mouse coordinates
  px = mouseX;
  py = mouseY;
  
  // check for collision
  // if hit, change the color of the line
  boolean hit = linePoint(x1,y1, x2,y2, px,py);
  if (hit) stroke(255,150,0, 150);
  else stroke(0,150,255, 150);
  line(x1,y1, x2,y2);
  
  // draw the point
  stroke(0, 150);
  point(px,py);
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



