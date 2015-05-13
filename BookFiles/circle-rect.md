## CIRCLE/RECTANGLE  
The last example of this section combines the circle and rectangle code. We have to test which edge of the rectangle is closest, then check using the Pythagorean Theorem. For this example, we have a circle with the position `(cx,cy)` with a radius and a square at `(rx,ry)` with a width/height.

First, we create a temporary variable for the X and Y edges we want to check. We'll set them as the circle's position to start:

	float testX = cx;
	float testY = cy;

To find which edge to check, we do the following tests:

	If the circle is to the RIGHT of the square, check against square's RIGHT edge.
	If the circle is to the LEFT of the square, check against square's LEFT edge.
	If the circle is ABOVE the square, check against square's TOP edge.
	If the circle is to the BELOW the square, check against square's BOTTOM edge.

Here's how that works as an if statement:
  
	if (cx < rx)         testX = rx;		// compare to left edge
	else if (cx > rx+rw) testX = rx+rw;		// right edge
	if (cy < ry)         testY = ry;		// top edge
	else if (cy > ry+rh) testY = ry+rh;		// bottom edge

Notice the slightly different `if/else` layout. You don't need the curly brackets if your statement is all on one line. This can tidy things up, but be careful you're not saving space at the expense of readable code!

Now that we know which edges to check, we run the Pythagorean Theorem code using the circle's center and the two edges we found above:

	float distX = cx-testX;
  	float distY = cy-testY;
  	float distance = sqrt( (distX*distX) + (distY*distY) );

Then we compare this distance to the circle's radius. Here's the full function:

	if (distance <= radius) {
		return true;
	}
	return false;

And here's a working example:

	float cx = 0;      // circle position (set with mouse)
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
	  if (cx < rx)         testX = rx;        // compare to left edge
	  else if (cx > rx+rw) testX = rx+rw;     // right edge
	  if (cy < ry)         testY = ry;        // top edge
	  else if (cy > ry+rh) testY = ry+rh;     // bottom edge
	  
	  // get distance from closest edges
	  float distX = cx-testX;
	  float distY = cy-testY;
	  float distance = sqrt( (distX*distX) + (distY*distY) );
	  
	  // if the distance is less than the radius, collision!
	  if (distance <= radius) {
	    return true;
	  }
	  return false;
	}

This example is built on code by [Matt Worden](http://vband3d.tripod.com/visualbasic/tut_mixedcollisions.htm).