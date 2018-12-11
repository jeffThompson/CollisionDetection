<?php include('includes/header.php'); ?>

<h1>POINT/CIRCLE</h1>

<p><a href="point-point.php">Point/Point</a> collision was very easy, but from here on out we'll need some basic math to check if objects are touching each other. Testing if a point is inside a circle requires us to remember back to middle school math class and the <a href="http://en.wikipedia.org/wiki/Pythagorean_theorem">Pythagorean Theorem</a>:</p>

<pre>a<sup>2</sup> + b<sup>2</sup> = c<sup>2</sup>
</pre>

<p>We can get the length of the long edge of a triangle <code>c</code> given the length of the other two sides. Translated to code, it looks like this:</p>

<pre>c = sqrt( (a*a) + (b*b) );
</pre>

<p>Multiply <code>a</code> by itself, same for <code>b</code>, add the two together, and get the square root of the result.</p>

<p>Why do we need this? We can use the Pythagorean Theorem to get the distance between two objects in 2D space! In this context, <code>a</code> and <code>b</code> are the horizontal and vertical distances between the point and the center of the circle. </p>

<p><img src="images/point-circle.jpg" alt="A triangle formed between a point and a circle" title=""></p>

<p>We can calculate the X and Y distance like this:</p>

<pre>float distX = px - cx;
float distY = py - cy;
</pre>

<p>Then we can find the distance between the two points using the Pythagorean Theorem:</p>

<pre>float distance = sqrt( (distX*distX) + (distY*distY) );
</pre>

<p>So if the point is at <code>(10,10)</code> and the circle's center is at <code>(40,50)</code>, we get a distance of <code>50</code>. You might be thinking, "What if the distance comes out negative?" Not to worry: since we multiply the distance values by themselves, even if they are negative the result will be positive.</p>

<p>OK, but how do we use this to test for collision? If the distance between the point and the center of the circle is less than the radius of the circle, we're colliding!</p>

<pre>if (distance &lt;= r) {
    return true;
}
return false;
</pre>

<p>Used in a full example, we can change the color of the circle if the point is inside it.</p>

<pre>float px =     0;      // point position
float py =     0;

float cx =     300;    // circle center position
float cy =     200;
float radius = 100;    // circle's radius


void setup() {
  size(600,400);
  noCursor();

  strokeWeight(5);   // thicker stroke = easier to see
}


void draw() {
  background(255);

  // update point position to mouse coordinates
  px = mouseX;
  py = mouseY;

  // check for collision!
  boolean hit = pointCircle(px,py, cx,cy, radius);

  // draw circle
  // change fill color if hit
  if (hit) {
    fill(255,150,0);
  }
  else {
    fill(0,150,255);
  }
  noStroke();
  ellipse(cx,cy, radius*2,radius*2);

  // draw the point
  stroke(0);
  point(px, py);
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
  if (distance &lt;= r) {
    return true;
  }
  return false;
}
</pre>

<p>This method using the Pythagorean Theorem will come back many times. Processing has a built-in <code>dist()</code> function, if you prefer, though we'll keep the math in place as a reference.</p>

<p>One caveat: if you have a very fast-moving object, it can sometimes go right through its target without a collision being triggered! This is sometimes referred to as the "bullet through paper" problem. There are lots of solutions, but a good place to start would be <a href="http://gamedev.stackexchange.com/questions/22765/how-do-i-check-collision-when-firing-bullet">this GameDev.net post</a>. A standard way for detecting this is called <a href="http://en.wikipedia.org/wiki/Collision_detection#A_posteriori_.28discrete.29_versus_a_priori_.28continuous.29">"Continuous Collision Detection"</a> or CCD.</p>

<?php include('includes/footer.php'); ?>
