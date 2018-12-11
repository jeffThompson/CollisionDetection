<?php include('includes/header.php'); ?>

<h1>RECTANGLE/RECTANGLE</h1>

<p>Moving from <a href="point-rect.php">Point/Rectangle</a> to two rectangles is easy, but the if statements start to get pretty long. Let's say we have two squares, <code>r1</code> and <code>r2</code>, with positions and sizes set like the last example. We now have to check:</p>

<pre>Is the RIGHT edge of r1 to the RIGHT of the LEFT edge of r2?
Is the LEFT edge of r1 to the LEFT of the RIGHT edge of r2?
Is the BOTTOM edge of r1 BELOW the TOP edge of r2?
Is the TOP edge of r1 ABOVE the BOTTOM edge of r2?
</pre>

<p>Yeah, not so intuitive 😖. A picture will probably help:</p>

<p><img src="images/rect-rect.jpg" alt="Testing rectangle overlap" title=""></p>

<p>To start, let's test the right edge of <code>r1</code> with the left edge of <code>r2</code>:</p>

<pre>float r1RightEdge = r1x + r1w;
if (r1RightEdge &gt;= r2x) {
    // right edge of r1 is past left edge of r2
}
</pre>

<p>We can expand this idea, checking all four edges:</p>

<pre>if (r1x + r1w &gt;= r2x &amp;&amp;     // r1 right edge past r2 left
  r1x &lt;= r2x + r2w &amp;&amp;       // r1 left edge past r2 right
  r1y + r1h &gt;= r2y &amp;&amp;       // r1 top edge past r2 bottom
  r1y &lt;= r2y + r2h) {       // r1 bottom edge past r2 top
    return true;
}
return false;
</pre>

<p>While the math here is simple addition, this is the trickiest collision for most people to get used to. With practice, you'll be able to picture this in your head. Of course, building a re-usable function makes checking for collisions much easier! In the meantime, it may help to map things out on a piece of paper when you're writing your code.</p>

<p>Here's a full example:</p>

<pre>float s1x = 0;      // square position (move with mouse)
float s1y = 0;
float s1w = 30;     // and dimensions
float s1h = 30;

float s2x = 200;    // same for second square
float s2y = 100;
float s2w = 200;
float s2h = 200;


void setup() {
  size(600,400);
  noStroke();
}


void draw() {
  background(255);

  // update square to mouse coordinates
  s1x = mouseX;
  s1y = mouseY;

  // check for collision
  // if hit, change rectangle color
  boolean hit = rectRect(s1x,s1y,s1w,s1h, s2x,s2y,s2w,s2h);
  if (hit) {
    fill(255,150,0);
  }
  else {
    fill(0,150,255);
  }
  rect(s2x,s2y, s2w,s2h);

  // draw the other square
  fill(0, 150);
  rect(s1x,s1y, s1w,s1h);
}


// RECTANGLE/RECTANGLE
boolean rectRect(float r1x, float r1y, float r1w, float r1h, float r2x, float r2y, float r2w, float r2h) {

  // are the sides of one rectangle touching the other?

  if (r1x + r1w &gt;= r2x &amp;&amp;    // r1 right edge past r2 left
      r1x &lt;= r2x + r2w &amp;&amp;    // r1 left edge past r2 right
      r1y + r1h &gt;= r2y &amp;&amp;    // r1 top edge past r2 bottom
      r1y &lt;= r2y + r2h) {    // r1 bottom edge past r2 top
        return true;
  }
  return false;
}
</pre>

<p>It's worth noting two important things here. First, the last two examples use squares, but any rectangle will work with this code. Second, this algorithm assumes you're using the default <code>rectMode(CORNER)</code>, which draws rectangles from the top corner and specifies width/height. If you want to use <code>rectMode(CENTER)</code>, you'll need to modify this algorithm (see the <a href="section_2_challenges.php">Challenge Questions</a> at the end of this section).</p>

<p><img src="images/bounding-box.jpg"></p>

<p>Similar to the <a href="circle-circle.php">Circle/Circle</a> example, <strong>Rectangle/Rectangle</strong> collision can be used to draw "bounding boxes" around more complex shapes. However, what you gain in performance you lose in accuracy. If you've ever played a game and frustratedly shouted "I totally hit you!" you have probably experienced bounding boxes that don't quite line up with their objects. Find the right balance between actually being correct and what feels right for the user.</p>

<?php include('includes/footer.php'); ?>
