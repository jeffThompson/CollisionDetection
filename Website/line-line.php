<?php include('includes/header.php'); ?>

<h1>LINE/LINE</h1>

<p>With this example, you'll be able to build a super-sweet sword fighting game! (Or reboot <a href="http://www.polygon.com/2014/9/19/6477103/neal-stephensons-kickstarter-clang-cancel">one that never got finished</a>?)</p>

<p>To check if two lines are touching, we have to calculate the distance to the point of intersection:</p>

<pre>float uA = ((x4-x3)*(y1-y3) - (y4-y3)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));

float uB = ((x2-x1)*(y1-y3) - (y2-y1)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
</pre>

<p>If there is a collision, <code>uA</code> and <code>uB</code> should both be in the range of 0-1. We test for that like this:</p>

<pre>if (uA &gt;= 0 &amp;&amp; uA &lt;= 1 &amp;&amp; uB &gt;= 0 &amp;&amp; uB &lt;= 1) {
    return true;
}
return false;
</pre>

<p>That's it! We can add one more feature, if desired, that will tell us the intersection point of the two lines. This might be useful if, for example, you're making a sword-fighting game and want <a href="http://tvtropes.org/pmwiki/pmwiki.php/Main/SwordSparks">sparks to fly where the two blades hit</a>.</p>

<pre>float intersectionX = x1 + (uA * (x2-x1));
float intersectionY = y1 + (uA * (y2-y1));
</pre>

<p>Here's the full example:</p>

<pre>float x1 = 0;    // line controlled by mouse
float y1 = 0;
float x2 = 10;   // fixed end
float y2 = 10;

float x3 = 100;  // static line
float y3 = 300;
float x4 = 500;
float y4 = 100;


void setup() {
  size(600,400);

  strokeWeight(5);  // make lines easier to see
}


void draw() {
  background(255);

  // set line's end to mouse coordinates
  x1 = mouseX;
  y1 = mouseY;

  // check for collision
  // if hit, change color of line
  boolean hit = lineLine(x1,y1,x2,y2, x3,y3,x4,y4);
  if (hit) stroke(255,150,0, 150);
  else stroke(0,150,255, 150);
  line(x3,y3, x4,y4);

  // draw user-controlled line
  stroke(0, 150);
  line(x1,y1, x2,y2);
}


// LINE/LINE
boolean lineLine(float x1, float y1, float x2, float y2, float x3, float y3, float x4, float y4) {

  // calculate the distance to intersection point
  float uA = ((x4-x3)*(y1-y3) - (y4-y3)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
  float uB = ((x2-x1)*(y1-y3) - (y2-y1)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));

  // if uA and uB are between 0-1, lines are colliding
  if (uA &gt;= 0 &amp;&amp; uA &lt;= 1 &amp;&amp; uB &gt;= 0 &amp;&amp; uB &lt;= 1) {

    // optionally, draw a circle where the lines meet
    float intersectionX = x1 + (uA * (x2-x1));
    float intersectionY = y1 + (uA * (y2-y1));
    fill(255,0,0);
    noStroke();
    ellipse(intersectionX,intersectionY, 20,20);

    return true;
  }
  return false;
}
</pre>

<p>Based on a tutorial by <a href="http://paulbourke.net/geometry/pointlineplane">Paul Bourke</a>, who includes code to test if the lines are parallel and <a href="http://mathworld.wolfram.com/CoincidentLines.html">coincident</a>. Also based on <a href="http://community.topcoder.com/tc?module=Static&amp;d1=tutorials&amp;d2=geometry2">this post by Ibackstrom</a> and help from <a href="http://www.reddit.com/r/math/comments/36dt75/what_does_this_equation_solve_for/crd5mcc">Reddit</a>.</p>

<?php include('includes/footer.php'); ?>
