<?php include('includes/header.php'); ?>

<figcaption>Refresh your browser for a new random polygon!</figcaption>

<h1>POLYGON/POLYGON</h1>

<p>Our final example in this section checks for the collision of two polygons. Since we really just need to check if any of the sides of one polygon are hitting any of the sides of the other, this is pretty straight-forward! As before, we also test if the one polygon is fully inside the other one.</p>

<p>Here's the full example:</p>

<pre>// array of PVectors for each shape
PVector[] pentagon = new PVector[5];
PVector[] randomPoly = new PVector[8];


void setup() {
  size(600,400);
  noStroke();

  // set position of the pentagon's vertices
  float angle = TWO_PI / pentagon.length;
  for (int i=0; i&lt;pentagon.length; i++) {
    float a = angle * i;
    float x = 300 + cos(a) * 100;
    float y = 200 + sin(a) * 100;
    pentagon[i] = new PVector(x,y);
  }

  // and create the random polygon
  float a = 0;
  int i = 0;
  while (a &lt; 360) {
    float x = cos(radians(a)) * random(30,50);
    float y = sin(radians(a)) * random(30,50);
    randomPoly[i] = new PVector(x,y);
    a += random(15, 40);
    i += 1;
  }
}


void draw() {
  background(255);

  // update random polygon to mouse position
  PVector mouse = new PVector(mouseX, mouseY);
  PVector diff = PVector.sub(mouse, randomPoly[0]);
  for (PVector v : randomPoly) {
    v.add(diff);
  }

  // check for collision
  // if hit, change fill color
  boolean hit = polyPoly(pentagon, randomPoly);
  if (hit) fill(255,150,0);
  else fill(0,150,255);

  // draw the pentagon
  noStroke();
  beginShape();
  for (PVector v : pentagon) {
    vertex(v.x, v.y);
  }
  endShape();

  // draw the random polygon
  fill(0, 150);
  beginShape();
  for (PVector v : randomPoly) {
    vertex(v.x, v.y);
  }
  endShape();
}


// POLYGON/POLYGON
boolean polyPoly(PVector[] p1, PVector[] p2) {

  // go through each of the vertices, plus the next
  // vertex in the list
  int next = 0;
  for (int current=0; current&lt;p1.length; current++) {

    // get next vertex in list
    // if we've hit the end, wrap around to 0
    next = current+1;
    if (next == p1.length) next = 0;

    // get the PVectors at our current position
    // this makes our if statement a little cleaner
    PVector vc = p1[current];    // c for "current"
    PVector vn = p1[next];       // n for "next"

    // now we can use these two points (a line) to compare
    // to the other polygon's vertices using polyLine()
    boolean collision = polyLine(p2, vc.x,vc.y,vn.x,vn.y);
    if (collision) return true;

    // optional: check if the 2nd polygon is INSIDE the first
    collision = polyPoint(p1, p2[0].x, p2[0].y);
    if (collision) return true;
  }

  return false;
}


// POLYGON/LINE
boolean polyLine(PVector[] vertices, float x1, float y1, float x2, float y2) {

  // go through each of the vertices, plus the next
  // vertex in the list
  int next = 0;
  for (int current=0; current&lt;vertices.length; current++) {

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
    // if true, return 'true' immediately and
    // stop testing (faster)
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
  if (uA &gt;= 0 &amp;&amp; uA &lt;= 1 &amp;&amp; uB &gt;= 0 &amp;&amp; uB &lt;= 1) {
    return true;
  }
  return false;
}


// POLYGON/POINT
// used only to check if the second polygon is
// INSIDE the first
boolean polyPoint(PVector[] vertices, float px, float py) {
  boolean collision = false;

  // go through each of the vertices, plus the next
  // vertex in the list
  int next = 0;
  for (int current=0; current&lt;vertices.length; current++) {

    // get next vertex in list
    // if we've hit the end, wrap around to 0
    next = current+1;
    if (next == vertices.length) next = 0;

    // get the PVectors at our current position
    // this makes our if statement a little cleaner
    PVector vc = vertices[current];    // c for "current"
    PVector vn = vertices[next];       // n for "next"

    // compare position, flip 'collision' variable
    // back and forth
    if (((vc.y &gt; py &amp;&amp; vn.y &lt; py) || (vc.y &lt; py &amp;&amp; vn.y &gt; py)) &amp;&amp;
         (px &lt; (vn.x-vc.x)*(py-vc.y) / (vn.y-vc.y)+vc.x)) {
            collision = !collision;
    }
  }
  return collision;
}
</pre>

<?php include('includes/footer.php'); ?>
