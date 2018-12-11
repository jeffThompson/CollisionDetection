<?php include('includes/header.php'); ?>

<h1>CIRCLE/RECTANGLE</h1>

<p>The last example of this section combines the circle and rectangle code together. We have a circle with the position <code>(cx,cy)</code> with a radius <code>r</code> and a square at <code>(rx,ry)</code> with a width/height <code>(rw,rh)</code>.</p>

<p>Our code will first test which edge of the rectangle is closest to the circle, then see if there is a collision using the Pythagorean Theorem. Let's create a temporary variable for the square's closest X/Y edges. We'll set them as the circle's position to start:</p>

<pre>float testX = cx;
float testY = cy;
</pre>

<p>Then we do the following tests:</p>

<pre>If the circle is to the RIGHT of the square, check against the RIGHT edge.

If the circle is to the LEFT of the square, check against the LEFT edge.

If the circle is ABOVE the square, check against the TOP edge.

If the circle is to the BELOW the square, check against the BOTTOM edge.
</pre>

<p>Here's how that works as an if statement:</p>

<pre>if (cx &lt; rx)         testX = rx;        // left edge
else if (cx &gt; rx+rw) testX = rx+rw;     // right edge

if (cy &lt; ry)         testY = ry;        // top edge
else if (cy &gt; ry+rh) testY = ry+rh;     // bottom edge
</pre>

<p>Notice the slightly different <code>if/else</code> layout. You don't need the curly brackets if your statement is all on one line. This can tidy things up, but be careful you're not saving space at the expense of readable code!</p>

<p>Now that we know which edges to check, we run the Pythagorean Theorem code using the circle's center and the two edges we found above:</p>

<pre>float distX = cx-testX;
float distY = cy-testY;
float distance = sqrt( (distX*distX) + (distY*distY) );
</pre>

<p>Finally, we compare this distance to the circle's radius:</p>

<pre>if (distance &lt;= radius) {
    return true;
}
return false;
</pre>

<p>Here's a full example:</p>

<pre>float cx = 0;      // circle position (set with mouse)
float cy = 0;
float r = 30;      // circle radius

float sx = 200;    // square position
float sy = 100;
float sw = 200;    // and dimensions
float sh = 200;


void setup() {
  size(600,400);
  noStroke();
}


void draw() {
  background(255);

  // update square to mouse coordinates
  cx = mouseX;
  cy = mouseY;

  // check for collision
  // if hit, change rectangle color
  boolean hit = circleRect(cx,cy,r, sx,sy,sw,sh);
  if (hit) {
    fill(255,150,0);
  }
  else {
    fill(0,150,255);
  }
  rect(sx,sy, sw,sh);

  // draw the circle
  fill(0, 150);
  ellipse(cx,cy, r*2,r*2);
}


// CIRCLE/RECTANGLE
boolean circleRect(float cx, float cy, float radius, float rx, float ry, float rw, float rh) {

  // temporary variables to set edges for testing
  float testX = cx;
  float testY = cy;

  // which edge is closest?
  if (cx &lt; rx)         testX = rx;      // test left edge
  else if (cx &gt; rx+rw) testX = rx+rw;   // right edge
  if (cy &lt; ry)         testY = ry;      // top edge
  else if (cy &gt; ry+rh) testY = ry+rh;   // bottom edge

  // get distance from closest edges
  float distX = cx-testX;
  float distY = cy-testY;
  float distance = sqrt( (distX*distX) + (distY*distY) );

  // if the distance is less than the radius, collision!
  if (distance &lt;= radius) {
    return true;
  }
  return false;
}
</pre>

<p>This example is built on code by <a href="http://vband3d.tripod.com/visualbasic/tut_mixedcollisions.htm">Matt Worden</a> (thanks!).</p>

<?php include('includes/footer.php'); ?>
