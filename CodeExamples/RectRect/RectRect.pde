
/*
RECTANGLE/RECTANGLE
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

float s1x = 0;      // square position (move with mouse)
float s1y = 0;
float s1w = 30;     // and dimensions
float s1h = 30;

float s2x = 200;    // same for second square
float s2y = 100;
float s2w = 200;
float s2h = 200;


void setup() {
  size(600,400);
  noStroke();
}


void draw() {
  background(255);
  
  // update square to mouse coordinates
  s1x = mouseX;
  s1y = mouseY;
  
  // check for collision
  // if hit, change rectangle color
  boolean hit = rectRect(s1x,s1y,s1w,s1h, s2x,s2y,s2w,s2h);
  if (hit) {
    fill(255,150,0);
  }
  else {
    fill(0,150,255);
  }
  rect(s2x,s2y, s2w,s2h);
  
  // draw the other square
  fill(0, 150);
  rect(s1x,s1y, s1w,s1h);  
}


// RECTANGLE/RECTANGLE
boolean rectRect(float r1x, float r1y, float r1w, float r1h, float r2x, float r2y, float r2w, float r2h) {
  
  // are the sides of one rectangle touching the other?
  
  if (r1x + r1w >= r2x &&    // r1 right edge past r2 left
      r1x <= r2x + r2w &&    // r1 left edge past r2 right
      r1y + r1h >= r2y &&    // r1 top edge past r2 bottom
      r1y <= r2y + r2h) {    // r1 bottom edge past r2 top
        return true;
  }
  return false;
}


