# LINE/CIRCLE  
To check if a circle is hitting a line, we use code from previous examples &mdash; a practice that we'll use through the rest of the book. The resulting math behind this gets a little hairy, but we'll simplify the harder parts.

First, let's test if either of the ends of the line are inside the circle. This is likely to happen if the line is much smaller than the circle. To do this, we can use [Point/Circle](point-circle.php) from the beginning of the book. If either end is inside, return `true` immediately and skip the rest.

	boolean inside1 = pointCircle(x1,y1, cx,cy,r);
	boolean inside2 = pointCircle(x2,y2, cx,cy,r);
	if (inside1 || inside2) return true;

Next, we need to get closest point on the line. To start, let's get the length of the line using the Pythagorean Theorem:

	float distX = x1 - x2;
	float distY = y1 - y2;
	float len = sqrt( (distX*distX) + (distY*distY) );

Then, we get a value we're calling `dot`. If you've done vector math before, this is the same as doing the [dot product](http://en.wikipedia.org/wiki/Dot_product) of two vectors. If this isn't familiar, no worry! Consider this step a lot of math you can be glad not to have to solve by hand:

	float dot = ( ((cx-x1)*(x2-x1)) + ((cy-y1)*(y2-y1)) ) / pow(len,2);

Finally, we can use this equation to find the closest point on the line:

	float closestX = x1 + (r * (x2-x1));
	float closestY = y1 + (r * (y2-y1));

However, this returns a point anywhere on the line as it extends to infinity in both directions. In other words, it could give us a point off the end of the line! So let's check if that closest point is actually on the line using the [Line/Point](line-point.php) algorithm we just made. This is the first of many times we'll nest previous functions when working on more complex collisions.

If the point is on the line, we can keep going. If not, we can immediately return `false`, since that means the closest point is off one of the ends:

	boolean onSegment = linePoint(x1,y1,x2,y2, closestX,closestY);
  	if (!onSegment) return false;

Finally, we get the distance from the circle to the closest point on the line, once again using the Pythagorean Theorem:

	distX = closestX - cx;
	distY = closestY - cy;
	float distance = sqrt( (distX*distX) + (distY*distY) );

If that distance is less than the radius, we have a collision (same as [Point/Circle](point-circle.php)).

	if (distance <= r) {
		return true;
	}
	return false;

Here's a full example putting everything together. Notice that we have three functions at the bottom: the one we just built and two previous functions.

	float cx = 0;      // circle position (set by mouse)
	float cy = 0;
	float r =  30;     // circle radius

	float x1 = 100;    // coordinates of line
	float y1 = 300;
	float x2 = 500;
	float y2 = 100;


	void setup() {
	  size(600,400);
	  
	  strokeWeight(5);    // make it a little easier to see
	}


	void draw() {
	  background(255);
	  
	  // update circle to mouse position
	  cx = mouseX;
	  cy = mouseY;
	  
	  // check for collision
	  // if hit, change line's stroke color
	  boolean hit = lineCircle(x1,y1, x2,y2, cx,cy,r);
	  if (hit) stroke(255,150,0, 150);
	  else stroke(0,150,255, 150);
	  line(x1,y1, x2,y2);
	  
	  // draw the circle
	  fill(0,150,255, 150);
	  noStroke();
	  ellipse(cx,cy, r*2,r*2);  
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

	  // optionally, draw a circle at the closest
	  // point on the line
	  fill(255,0,0);
	  noStroke();
	  ellipse(closestX, closestY, 20, 20);

	  // get distance to closest point
	  distX = closestX - cx;
	  distY = closestY - cy;
	  float distance = sqrt( (distX*distX) + (distY*distY) );

	  if (distance <= r) {
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
	  if (d1+d2 >= lineLen-buffer && d1+d2 <= lineLen+buffer) {
	    return true;
	  }
	  return false;
	}

Math using lines can benefit from some of the built-in functionality of the `PVector` class. If you haven't used PVectors before, it may be worth some time to get familiar with them. The Processing website has a [good tutorial](https://processing.org/tutorials/pvector/). Daniel Shiffman's excellent ["Nature of Code"](http://natureofcode.com/book/) book deals with vectors quite a bit and is a very friendly introduction. We'll cover PVectors a little bit when we start working with polygons, if you want a very short introduction.

This example was based on code by [Philip Nicoletti](http://www.codeguru.com/forum/showthread.php?threadid=194400) (thanks!). This [CodeGuru post](http://www.codeguru.com/forum/showthread.php?threadid=194400) inclues a lot more discussion of how this algorithm works and the math behind it, if you're so inclined.