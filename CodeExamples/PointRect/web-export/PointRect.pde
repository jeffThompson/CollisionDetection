
/*
POINT/RECTANGLE
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

float px = 0;      // point position (move with mouse)
float py = 0;

float sx, sy;      // square position
float sw = 200;    // and dimensions
float sh = 200;


void setup() {
  size($("#wrapper").width(), 400);
  noCursor();
  
  strokeWeight(15);    // thicker stroke so points are easier to see

  sx = width/2-sw/2;
  sy = height/2-sh/2;
}


void draw() {
  background(255);
  
  // update point to mouse coordinates
  px = mouseX;
  py = mouseY;
  
  // check for collision
  // if hit, change rectangle color
  boolean hit = pointRect(px,py, sx,sy,sw,sh);
  if (hit) {
    fill(255,150,0);
  }
  else {
    fill(0,150,255);
  }
  noStroke();
  rect(sx,sy, sw,sh);
  
  // draw the point
  stroke(0);
  point(px,py);  
}


// POINT/RECTANGLE
boolean pointRect(float px, float py, float rx, float ry, float rw, float rh) {
    
  // is the point inside the rectangle's bounds?
  if (px >= rx &&        // right of the left edge AND
      px <= rx + rw &&   // left of the right edge AND
      py >= ry &&        // below the top AND
      py <= ry + rh) {   // above the bottom 
        return true;
  }
  return false;
}



