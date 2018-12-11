<?php include('includes/header.php'); ?>

<figcaption>Note what happens when the circle is inside<br>the polygon: we'll fix that later.</figcaption>

<h1>POLYGON/CIRCLE</h1>

<p>To test if a circle has collided with a polygon, we can simplify the problem to a series of <a href="line-circle.php">Line/Circle</a> collisions, one for each side of the polygon. Since we've already covered the steps to go through the vertices as lines, and <a href="line-circle.php">Line/Circle</a> collisions, let's just look at the test for each side:</p>

<pre>boolean collision = lineCircle(vc.x,vc.y, vn.x,vn.y, cx,cy,r);
if (collision) return true;
</pre>

<p>Cool! We can build on previous code this way, allowing flexible, complex code to emerge from simpler pieces.</p>

<p>Here's the full example:</p>

<pre>float cx = 0;    // position of the circle
float cy = 0;
float r =  30;   // circle's radius

// array of PVectors, one for each vertex in the polygon
PVector[] vertices = new PVector[4];


void setup() {
  size(600,400);
  noStroke();

  // set position of the vertices (here a trapezoid)
  vertices[0] = new PVector(200,100);
  vertices[1] = new PVector(400,100);
  vertices[2] = new PVector(350,300);
  vertices[3] = new PVector(250,300);
}


void draw() {
  background(255);

  // update circle to mouse coordinates
  cx = mouseX;
  cy = mouseY;

  // check for collision
  // if hit, change fill color
  boolean hit = polyCircle(vertices, cx,cy,r);
  if (hit) fill(255,150,0);
  else fill(0,150,255);

  // draw the polygon using beginShape()
  noStroke();
  beginShape();
  for (PVector v : vertices) {
    vertex(v.x, v.y);
  }
  endShape();

  // draw the circle
  fill(0, 150);
  ellipse(cx,cy, r*2,r*2);
}


// POLYGON/CIRCLE
boolean polyCircle(PVector[] vertices, float cx, float cy, float r) {

  // go through each of the vertices, plus
  // the next vertex in the list
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

    // check for collision between the circle and
    // a line formed between the two vertices
    boolean collision = lineCircle(vc.x,vc.y, vn.x,vn.y, cx,cy,r);
    if (collision) return true;
  }

  // the above algorithm only checks if the circle
  // is touching the edges of the polygon – in most
  // cases this is enough, but you can un-comment the
  // following code to also test if the center of the
  // circle is inside the polygon

  // boolean centerInside = polygonPoint(vertices, cx,cy);
  // if (centerInside) return true;

  // otherwise, after all that, return false
  return false;
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

  // optionally, draw a circle at the closest point
  // on the line
  fill(255,0,0);
  noStroke();
  ellipse(closestX, closestY, 20, 20);

  // get distance to closest point
  distX = closestX - cx;
  distY = closestY - cy;
  float distance = sqrt( (distX*distX) + (distY*distY) );

  // is the circle on the line?
  if (distance &lt;= r) {
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

  // if the two distances are equal to the line's
  // length, the point is on the line!
  // note we use the buffer here to give a range, rather
  // than one #
  if (d1+d2 &gt;= lineLen-buffer &amp;&amp; d1+d2 &lt;= lineLen+buffer) {
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


// POLYGON/POINT
// only needed if you're going to check if the circle
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

<p>Since <code>polyCircle()</code> calls <code>lineCircle()</code> which calls <code>linePoint()</code>, we could combine these into a single function, but the idea of functions in programming is reusability. Now, if we update <code>linePoint()</code>, it carries through all our projects.</p>

<p>But! We have a bit of a problem. Try moving the circle so it's completely inside the polygon. No more collision! These situations are called <em>edge cases</em>, ones that require a different set of parameters to check for. </p>

<p>In most situations, we don't need to know if the circle is inside: imagine the polygon is a spaceship and the circle is an asteroid. As soon as the asteroid touches the ship, we'd register the collision and do something (like blow up the ship).</p>

<p>If you do need to know if the circle is inside the polygon, you can add two more lines to the <code>polyCircle()</code> function (right before the final <code>return false;</code>) to test if the center of the circle is inside the polygon:</p>

<pre>boolean centerInside = polygonPoint(cx,cy, vertices);
if (centerInside) return true;
</pre>

<p>We do this after we test the edges, since those are more likely to be hit first. Unless you need this functionality, leave it out. It requires running through all the vertices of the polygon again, which will slow down your program.</p>

<?php include('includes/footer.php'); ?>
