<?php include('includes/header.php'); ?>

<figcaption>Use your mouse to collide the two points!</figcaption>

<h1>POINT/POINT</h1>

<p>The easiest collision to test is between two points. To test if they are touching, we simply check to see if their X and Y coordinates are the same!</p>

<pre>if (x1 == x2 &amp;&amp; y1 == y2) {
    // points are in the same place: collision!
}
else {
    // not colliding
}
</pre>

<p>We can then wrap this code up in a function to make the it more usable. As arguments, we pass the X/Y coordinates for both points. The function returns a boolean value of <code>true</code> or <code>false</code>, depending on whether there is a collision or not.</p>

<pre>boolean pointPoint(float x1, float y1, float x2, float y2) {
    if (x1 == x2 &amp;&amp; y1 == y2) {
        return true;
    }
    return false;
}
</pre>

<p>Note the bit of shorthand above: we could specify <code>else { return false; }</code>, but our code does the same thing! Our version is a little easier to read, once you get used to it. Think of the <code>return false;</code> as the default value to be sent back, unless certain conditions are met.</p>

<p>With our very first collision detection function in hand, we can build something useful with it. Try the interactive example bumping into the other point and watch the background change color!</p>

<p class="callout">You'll notice it's a bit hard to get a collision to trigger (can you guess why?) &mdash; a problem we'll try to fix in the <a href="section_1_challenges.php">first challenges section</a>.</p>

<p>The code for the example above can be seen here. Try pasting it into Processing, running it, and making changes to see how the behavior changes.</p>

<pre>float px, py;           // point controlled by the mouse
float targetX = 300;    // target point coordinates
float targetY = 200;


void setup() {
  size(600, 400);
  noCursor();

  strokeWeight(5);    // thicker stroke = easier to see
}


void draw() {

  // update point position to mouse coordinates
  px = mouseX;
  py = mouseY;

  // check for collision!
  // if hit, make background orange; if not, make it white
  boolean colliding = pointPoint(px, py, targetX, targetY);
  if (colliding) {
    background(255, 150, 0);
  }
  else {
    background(255);
  }

  // draw the two points
  stroke(0,150,255);
  point(targetX, targetY);

  stroke(0,150);
  point(px, py);
}


// POINT/POINT
boolean pointPoint(float x1, float y1, float x2, float y2) {

  // are the two points in the same location?
  if (x1 == x2 &amp;&amp; y1 == y2) {
    return true;
  }
  return false;
}
</pre>

<p>Congrats, you've written your first program using collision! This basic structure (an interactive example, an explanation, some code, and the code from the example) will be the same in all the chapters.</p>

<?php include('includes/footer.php'); ?>
