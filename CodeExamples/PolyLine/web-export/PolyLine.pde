
/*
POLYGON/LINE
 Jeff Thompson | 2015 | www.jeffreythompson.org
 
 */

float x1 = 0;    // line position (set by mouse)
float y1 = 0;
float x2 = 20;   // fixed end
float y2 = 20;

// array of PVectors, one for each vertex in the polygon
PVector[] vertices = new PVector[16];


void setup() {
  size($("#wrapper").width(), 400);
  noCursor();

  strokeWeight(15);  // make the line easier to see

  // set position of the vertices - a regular polygon!
  // based on this example: 
  // https://processing.org/examples/regularpolygon.html
  float angle = TWO_PI / vertices.length;
  for (int i=0; i<vertices.length; i++) {
    float a = angle * i;
    float x = width/2 + cos(a) * 100;
    float y = height/2 + sin(a) * 100;
    vertices[i] = new PVector(x,y);
  }
}


void draw() {
  background(255);

  // update line to mouse coordinates
  x1 = mouseX;
  y1 = mouseY;

  // check for collision
  // if hit, change fill color
  boolean hit = polyLine(vertices, x1, y1, x2, y2);
  if (hit) fill(255, 150, 0);
  else fill(0, 150, 255);

  // draw the polygon using beginShape()
  noStroke();
  beginShape();
  for (PVector v : vertices) {
    vertex(v.x, v.y);
  }
  endShape(CLOSE);

  // draw line
  stroke(0, 150);
  line(x1, y1, x2, y2);
}


// POLYGON/LINE
boolean polyLine(PVector[] vertices, float x1, float y1, float x2, float y2) {

  // go through each of the vertices, plus the next vertex in the list
  int next = 0;
  for (int current=0; current<vertices.length; current++) {

    // get next vertex in list
    // if we've hit the end, wrap around to 0
    next = current+1;
    if (next == vertices.length) next = 0;

    // get the PVectors at our current position
    // extract X/Y coordinates from each
    float x3 = vertices[current].x;
    float y3 = vertices[current].y;
    float x4 = vertices[next].x;
    float y4 = vertices[next].y;

    // do a Line/Line comparison
    // if true, return 'true' immediately and stop testing (faster)
    boolean hit = lineLine(x1, y1, x2, y2, x3, y3, x4, y4);
    if (hit) {
      return true;
    }
  }

  // never got a hit
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



