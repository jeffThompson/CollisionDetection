<?php include('includes/header.php'); ?>

<h1>LINE/POINT</h1>

<p>So far, our collisions have mostly been logic and a little bit of addition. Line collision is a little trickier, unless your high school geometry class is still fresh.</p>

<p>A line (<a href="#not-a-line">see note</a>) is defined by two sets of X/Y coordinates. We can find the length of the line using our old standby the Pythagorean Theorem, but since we'll need to use it three times in this example, let's cheat and use Processing's built-in <code>dist()</code> function:</p>

<pre>float lineLen = dist(x1,y1, x2,y2);
</pre>

<p>We also need to figure out the distance between the point and the two ends of the line:</p>

<pre>float d1 = dist(px,py, x1,y1);
float d2 = dist(px,py, x2,y2);
</pre>

<p>If <code>d1+d2</code> is equal to the length of the line, then we're on the line! This doesn't make intuitive sense, but look at this diagram:</p>

<p><img src="images/line-point.jpg" alt="Forming triangles between a point and line" title=""></p>

<p>If we collapse the distances, they are longer than the line!</p>

<p>There's a bit of an issue here, though. Since floating-point numbers are so minutely accurate, the collision only occurs if the point is <em>exactly</em> on the line, which means we're not going to get a natural-feeling collision. This is very similar to our first example, <a href="point-point.php">Point/Point</a>. To fix this, let's create a small buffer and check if <code>d1+d2</code> is +/- that range.</p>

<pre>float buffer = 0.1;     // higher # = less accurate collision
</pre>

<p>Try playing with this value until you get something that feels right. Using this buffer value, we'll check for a collision:</p>

<pre>if (d1+d2 &gt;= lineLen-buffer &amp;&amp; d1+d2 &lt;= lineLen+buffer) {
    return true;
}
return false;
</pre>

<p>Here's a full example, combining everything above:</p>

<pre>float px = 0;     // point position (set by mouse)
float py = 0;

float x1 = 100;   // line defined by two points
float y1 = 300;
float x2 = 500;
float y2 = 100;


void setup() {
  size(600,400);
  noCursor();

  strokeWeight(5);  // make things a little easier to see
}


void draw() {
  background(255);

  // set point to mouse coordinates
  px = mouseX;
  py = mouseY;

  // check for collision
  // if hit, change the color of the line
  boolean hit = linePoint(x1,y1, x2,y2, px,py);
  if (hit) stroke(255,150,0, 150);
  else stroke(0,150,255, 150);
  line(x1,y1, x2,y2);

  // draw the point
  stroke(0, 150);
  point(px,py);
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
  // note we use the buffer here to give a range, 
  // rather than one #
  if (d1+d2 &gt;= lineLen-buffer &amp;&amp; d1+d2 &lt;= lineLen+buffer) {
    return true;
  }
  return false;
}
</pre>

<a name="not-a-line"></a>
<p class="callout"><strong>OK technically this would be called a <a href="http://en.wikipedia.org/wiki/Line_segment"><em>line segment</em></a>.</strong> But for the sake of simplicity, we'll be referring to these as the generic term <em>line</em>. <a href="http://knowyourmeme.com/memes/haters-to-the-left">Haters to the left</a>.</p>

<p>This algorithm is thanks to help from <a href="http://stackoverflow.com/a/17693146/1167783">this answer by MrRoy</a> on StackOverflow.</p>

<?php include('includes/footer.php'); ?>
