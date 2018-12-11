<?php include('includes/header.php'); ?>

<h1>POLYGON/POINT</h1>

<p>Circle and rectangle collisions are great, and oftentimes simplifying the collision of complex shapes using bounding boxes and circles makes sense. But there are applications when we want more accuracy. Fortunately, most of the remaining examples use ideas we've already covered, even if how we apply them gets more complicated.</p>

<p>In this first example, we'll check if a point is inside a complex polygon. We define our polygon using a set of X/Y points called <em>vertices</em>. To store these points, we'll use an array of <code>PVector</code> objects. PVectors simply store X/Y (or X/Y/Z) coordinates. This makes storing points a little easier, and Processing gives us some fancy math for PVectors that would be tricky otherwise. If you haven't used PVectors before, at least read the first part of <a href="https://processing.org/tutorials/pvector/">this tutorial on the Processing site</a> before continuing.</p>

<p>First, we create an array of four PVectors, one for each corner of our polygon:</p>

<pre>PVector[] vertices = new PVector[4];
</pre>

<p>Then, we set their X/Y positions. Here we're drawing a distorted trapezoid (like above), but you could make more complicated shapes, or even randomize the points!</p>

<pre>vertices[0] = new PVector(200,100);     // set X/Y position
vertices[1] = new PVector(400,130);
vertices[2] = new PVector(350,300);
vertices[3] = new PVector(250,300);
</pre>

<p>To check for collision, we're going to use a separate boolean variable. This will be inside our function later, so if this gets confusing, jump to the full example at the bottom.</p>

<pre>boolean collision = false;
</pre>

<p>Then we need to go through the vertices one-by-one. To do this we use a for loop with the variable <code>current</code>. But also want the next vertex in the list so we can form a line (a side of the polygon). To do this, we use a second variable called <code>next</code>. Here's what the loop looks like:</p>

<pre>int next = 0;
for (int current=0; current&lt;vertices.length; current++) {

    // get next vertex in list
    // if we've hit the end, wrap around to 0
    next = current+1;
    if (next == vertices.length) next = 0;

}
</pre>

<p>Then we can use <code>current</code> and <code>next</code> to retrieve the PVectors from our array:</p>

<pre>PVector vc = vertices[current];    // c for "current"
PVector vn = vertices[next];       // n for "next"
</pre>

<p>Now for the if statement. We can access the X/Y coordinates of each vertex using the syntax <code>vc.x</code> and <code>vc.y</code>. This statement is pretty tricky, so here's the whole thing, then we'll break it down into its parts:</p>

<pre>if ( ((vc.y &gt; py) != (vn.y &gt; py)) &amp;&amp; (px &lt; (vn.x-vc.x) * (py-vc.y) / (vn.y-vc.y) + vc.x) ) {
  collision = !collision;
}
</pre>

<p>There are two tests happening here. The first checks if the point is between the two vertices in the Y direction:</p>

<pre>(vc.y &gt;= py &amp;&amp; vn.y &lt; py) || (vc.y &lt; py &amp;&amp; vn.y &gt;= py)
</pre>

<p>We test if the point is either above <code>vc.y</code> and below <code>vn.y</code>, or below <code>vc.y</code> and above <code>vn.y</code>. Here's what this looks like visually:</p>

<p><img src="images/poly-point.jpg" alt="Diagram of a point above/below the Y coordinates of a polygon" title=""></p>

<p>Note: There's a fancier, more concise way of writing this if statement, if you prefer:</p>

<pre>(vc.y &gt; py) != (vn.y &gt; py)
</pre>

<p>That's a little confusing: it does the same test, but only evaluates <code>true</code> if both tests are not the same as each other!</p>

<p>Next up is a more complicated test. This is based on the <a href="http://en.wikipedia.org/wiki/Jordan_curve_theorem">Jordan Curve Theorem</a>, which is pretty intense math so we'll skip explaining it. (If you  understand how this algorithm works, please do let me know!)</p>

<pre>px &lt; (vn.x-vc.x) * (py-vc.y) / (vn.y-vc.y) + vc.x
</pre>

<p>If both checks are true, we switch <code>collision</code> to its opposite value. This is different than our previous tests, where we set the collision to simply <code>true</code> or <code>false</code>. After we've gone through all the vertices, whatever the final state of <code>collision</code> is is the result.</p>

<pre>// set collision to the opposite of its current state
collision = !collision;
</pre>

<p>Here's a full example with everything together:</p>

<pre>float px = 0;    // point position
float py = 0;

// array of PVectors, one for each vertex in the polygon
PVector[] vertices = new PVector[4];


void setup() {
  size(600,400);
  noCursor();

  strokeWeight(5);  // make the point easier to see

  // set position of the vertices
  // here we draw a distorted trapezoid, but
  // you could make much more complex shapes
  // or even randomize the points!
  vertices[0] = new PVector(200,100);
  vertices[1] = new PVector(400,130);
  vertices[2] = new PVector(350,300);
  vertices[3] = new PVector(250,300);
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

    // compare position, flip 'collision' variable
    // back and forth
    if (((vc.y &gt;= py &amp;&amp; vn.y &lt; py) || (vc.y &lt; py &amp;&amp; vn.y &gt;= py)) &amp;&amp;
         (px &lt; (vn.x-vc.x)*(py-vc.y) / (vn.y-vc.y)+vc.x)) {
            collision = !collision;
    }
  }
  return collision;
}
</pre>

<p>This function is designed to take any number of vertices, so it can handle very complex shapes! However, the more vertices you check, the slower the function will be. If you wanted to do this in a full game, even just a few of these tests on complex shapes could slow your game to a crawl. Balance the need for accuracy with speed: whatever feels intuitive is probably the right way to go.</p>

<p>This example is based on <a href="http://stackoverflow.com/a/2922778/1167783">this answer by nirg and Pranav from StackOverflow</a>.</p>

<?php include('includes/footer.php'); ?>
