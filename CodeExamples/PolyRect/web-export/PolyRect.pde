
/*
POLYGON/RECTANGLE
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

float sx = 0;    // a square, controlled by the mouse
float sy = 0;
float sw = 30;   // width and height
float sh = 30;

// array of PVectors, one for each vertex in the polygon
PVector[] vertices = new PVector[4];


void setup() {
  size($("#wrapper").width(), 400);
  noStroke();
  
  // set position of the vertices (here a parallelogram)
  vertices[0] = new PVector(width/2-100, height/2-100);
  vertices[1] = new PVector(width/2+100, height/2-100);
  vertices[2] = new PVector(width/2+50,  height/2+100);
  vertices[3] = new PVector(width/2-50,  height/2+100);
}


void draw() {
  background(255);
  
  // update circle to mouse coordinates
  sx = mouseX;
  sy = mouseY;
  
  // check for collision
  // if hit, change fill color
  boolean hit = polyRect(sx,sy,sw,sh, vertices);
  if (hit) fill(255,150,0);
  else fill(0,150,255);
  
  // draw the polygon using beginShape()
  noStroke();
  beginShape();
  for (PVector v : vertices) {
    vertex(v.x, v.y);
  }
  endShape();
  
  // draw the rectangle
  fill(0, 150);
  rect(sx,sy, sw,sh);
}


// POLYGON/RECTANGLE
boolean polyRect(float rx, float ry, float rw, float rh, PVector[] vertices) {
  
  // go through each of the vertices, plus the next vertex in the list
  int next = 0;
  for (int current=0; current<vertices.length; current++) {
    
    // get next vertex in list
    // if we've hit the end, wrap around to 0
    next = current+1;
    if (next == vertices.length) next = 0;
    
    // get the PVectors at our current position
    // this makes our if statement a little cleaner
    PVector vc = vertices[current];    // c for "current"
    PVector vn = vertices[next];       // n for "next"
    
    // check against all four sides of the rectangle
    boolean collision = lineRect(vc.x,vc.y,vn.x,vn.y, rx,ry,rw,rh);
    if (collision) return true;
    
    // optional: test if the rectangle is INSIDE the polygon
    // note that this iterates all sides of the polygon again, so
    // only use this if you need to
    boolean inside = polygonPoint(rx,ry, vertices);
    if (inside) return true;
  }
  
  return false;
}


// LINE/RECTANGLE
boolean lineRect(float x1, float y1, float x2, float y2, float rx, float ry, float rw, float rh) {
  
  // check if the line has hit any of the rectangle's sides
  // uses the Line/Line function below
  boolean left =   lineLine(x1,y1,x2,y2, rx,ry,rx, ry+rh);
  boolean right =  lineLine(x1,y1,x2,y2, rx+rw,ry, rx+rw,ry+rh);
  boolean top =    lineLine(x1,y1,x2,y2, rx,ry, rx+rw,ry);
  boolean bottom = lineLine(x1,y1,x2,y2, rx,ry+rh, rx+rw,ry+rh);
  
  // if ANY of the above are true, the line has hit the rectangle
  if (left || right || top || bottom) {
    return true;
  }
  return false;
}


// LINE/LINE
boolean lineLine(float x1, float y1, float x2, float y2, float x3, float y3, float x4, float y4) {

  // calculate the direction of the lines
  float uA = ((x4-x3)*(y1-y3) - (y4-y3)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
  float uB = ((x2-x1)*(y1-y3) - (y2-y1)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));

  // if uA and uB are between 0-1, lines are colliding
  if (uA >= 0 && uA <= 1 && uB >= 0 && uB <= 1) {
    return true;
  }
  return false;
}


// POLYGON/POINT
// only needed if you're going to check if the rectangle is INSIDE the polygon
boolean polygonPoint(float px, float py, PVector[] vertices) {
  boolean collision = false;
  
  // go through each of the vertices, plus the next vertex in the list
  int next = 0;
  for (int current=0; current<vertices.length; current++) {
    
    // get next vertex in list
    // if we've hit the end, wrap around to 0
    next = current+1;
    if (next == vertices.length) next = 0;
    
    // get the PVectors at our current position
    // this makes our if statement a little cleaner
    PVector vc = vertices[current];    // c for "current"
    PVector vn = vertices[next];       // n for "next"
    
    // compare position, flip 'collision' variable back and forth
    if ( ((vc.y > py) != (vn.y > py)) && (px < (vn.x-vc.x) * (py-vc.y) / (vn.y-vc.y) + vc.x) ) {
      collision = !collision;
    }
  }
  return collision;  
}



