
/*
POLYGON/POINT
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

float px = 0;    // point position
float py = 0;

// array of PVectors, one for each vertex in the polygon
PVector[] vertices = new PVector[4];


void setup() {
  size($("#wrapper").width(), 400);
  noCursor();
  
  strokeWeight(15);  // make the point easier to see
  
  // set position of the vertices
  // here we draw a distorted trapezoid, but you could
  // make much more complex shapes, or even randomize the points!
  vertices[0] = new PVector(width/2-100, height/2-100);
  vertices[1] = new PVector(width/2+100, height/2-100);
  vertices[2] = new PVector(width/2+50,  height/2+100);
  vertices[3] = new PVector(width/2-50,  height/2+100);
}


void draw() {
  background(255);
  
  // update point to mouse coordinates
  px = mouseX;
  py = mouseY;
  
  // check for collision
  // if hit, change fill color
  boolean hit = polyPoint(vertices, px,py);
  if (hit) fill(255,150,0);
  else fill(0,150,255);
  
  // draw the polygon using beginShape()
  noStroke();
  beginShape();
  for (PVector v : vertices) {
    vertex(v.x, v.y);
  }
  endShape();
  
  // draw the point
  stroke(0, 150);
  point(px,py);
}


// POLYGON/POINT
boolean polyPoint(PVector[] vertices, float px, float py) {
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
    //((vc.y > py) != (vn.y > py)) &&
    if ( ((vc.y >= py && vn.y < py) || (vc.y < py && vn.y >= py)) &&
         (px < (vn.x-vc.x) * (py-vc.y) / (vn.y-vc.y) + vc.x) ) {
            collision = !collision;
    }
  }
  return collision;  
}



