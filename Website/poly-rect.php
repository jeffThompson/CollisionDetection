<?php include('includes/header.php'); ?>

<h1>POLYGON/RECTANGLE</h1>

<p>Like the previous example, collision between a polygon and a rectangle really just requires us to extend existing functions. In this case, we can test if any of the edges of the rectangle are hitting any of the edges of the polygon.</p>

<p>To do this, we test <a href="line-rectangle.php">Line/Rectangle</a> collision for each side of the polygon. Like our previous exmaples, <code>vc</code> and <code>vn</code> are the two PVectors forming a side:</p>

<pre>boolean collision = lineRect(vc.x,vc.y,vn.x,vn.y, rx,ry,rw,rh);
if (collision) return true;
</pre>

<p>Also like the last example, we can catch the edge case where the rectangle is inside the polygon by testing if its X/Y position (a point) is inside the polygon. This should be left off unless necessary, since like our previous example it requires going through all the vertices of the polygon again, slowing down your program.</p>

<pre>boolean inside = polygonPoint(vertices, rx,ry);
if (inside) return true;
</pre>

<p>Here's a full example:</p>

<pre>float sx = 0;    // a square, controlled by the mouse
float sy = 0;
float sw = 30;   // width and height
float sh = 30;

// array of PVectors, one for each vertex in the polygon
PVector[] vertices = new PVector[4];


void setup() {
  size(600,400);
  noStroke();

  // set position of the vertices (here a parallelogram)
  vertices[0] = new PVector(100,100);
  vertices[1] = new PVector(400,100);
  vertices[2] = new PVector(500,300);
  vertices[3] = new PVector(200,300);
}


void draw() {
  background(255);

  // update circle to mouse coordinates
  sx = mouseX;
  sy = mouseY;

  // check for collision
  // if hit, change fill color
  boolean hit = polyRect(vertices, sx,sy,sw,sh);
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
boolean polyRect(PVector[] vertices, float rx, float ry, float rw, float rh) {

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

    // check against all four sides of the rectangle
    boolean collision = lineRect(vc.x,vc.y,vn.x,vn.y, rx,ry,rw,rh);
    if (collision) return true;

    // optional: test if the rectangle is INSIDE the polygon
    // note that this iterates all sides of the polygon
    // again, so only use this if you need to
    boolean inside = polygonPoint(vertices, rx,ry);
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

  // if ANY of the above are true,
  // the line has hit the rectangle
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
  if (uA &gt;= 0 &amp;&amp; uA &lt;= 1 &amp;&amp; uB &gt;= 0 &amp;&amp; uB &lt;= 1) {
    return true;
  }
  return false;
}


// POLYGON/POINT
// only needed if you're going to check if the rectangle
// is INSIDE the polygon
boolean polygonPoint(PVector[] vertices, float px, float py) {
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
