
/*
TRIANGLE/POINT
Jeff Thompson | 2015 | ww.jeffreythompson.org

*/

float px = 0;        // point (set by mouse)
float py = 0;

float x1 = 300;      // three points of the triangle
float y1 = 100;
float x2 = 450;
float y2 = 300;
float x3 = 150;
float y3 = 300;


void setup() {
  size(600,400);
  noCursor();
  
  strokeWeight(5);   // make point easier to see
}


void draw() {
  background(255);

  // mouse point to mouse coordinates
  px = mouseX;
  py = mouseY;
  
  // check for collision
  // if hit, change fill color
  boolean hit = triPoint(x1,y1, x2,y2, x3,y3, px,py);
  if (hit) fill(255,150,0);
  else fill(0,150,255);
  noStroke();
  triangle(x1,y1, x2,y2, x3,y3);
  
  // draw the point
  stroke(0, 150);
  point(px,py);  
}


// TRIANGLE/POINT
boolean triPoint(float x1, float y1, float x2, float y2, float x3, float y3, float px, float py) {
  
  // get the area of the triangle
  float areaOrig = abs( (x2-x1)*(y3-y1) - (x3-x1)*(y2-y1) );
  
  // get the area of 3 triangles made between the point
  // and the corners of the triangle
  float area1 =    abs( (x1-px)*(y2-py) - (x2-px)*(y1-py) );
  float area2 =    abs( (x2-px)*(y3-py) - (x3-px)*(y2-py) );
  float area3 =    abs( (x3-px)*(y1-py) - (x1-px)*(y3-py) );
  
  // if the sum of the three areas equals the original, 
  // we're inside the triangle!
  if (area1 + area2 + area3 == areaOrig) {
    return true;
  }
  return false;
}


