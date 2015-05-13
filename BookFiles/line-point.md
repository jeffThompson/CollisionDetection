## LINE/POINT  
So far, our collisions have mostly been logic and a little bit of basic geometry. Line collision is a little trickier, unless you remember your high school geometry (I don't).

A line* is defined by two sets of X/Y coordinates, our point by one. First, we need to compute the distance between the point and the two ends of the line, and the length of the line itself. We could use the Pythagorean Theorem, but since we have to do this three times, lets use Processing's built-in `dist()` function:

	// get distance from the point to the two ends of the line
  	float d1 = dist(px,py, x1,y1);
  	float d2 = dist(px,py, x2,y2);
  
  	// get the length of the line
  	float lineLen = dist(x1,y1, x2,y2);

 If `d1+d2` is equal to the length of the line, then we're on the line! But since floating-point numbers are so minutely accurate, we're not going to get a natural-feeling collision. So let's create a small buffer and check if `d1+d2` is in that range.

 	float buffer = 0.1;		// higher # = less accurate collision

 Try playing with this value until you get something that feels right. Finally, we'll check for a collision:

 	if (d1+d2 >= lineLen-buffer && d1+d2 <= lineLen+buffer) {
    	return true;
  	}
  	return false;

Here's a full example:

	float px = 0;     // point position (set by mouse)
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
	  if (hit) stroke(255,150,0);
	  else stroke(0);
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
	  
	  // if the two distances are equal to the line's length, the
	  // point is on the line!
	  // note we use the buffer here to give a range, rather than one #
	  if (d1+d2 >= lineLen-buffer && d1+d2 <= lineLen+buffer) {
	    return true;
	  }
	  return false;
	}

\* OK, technically this would be called a "line segment" or a "ray". But for the sake of simplicity, we'll be referring to these as the generic "line".

This algorithm is thanks to help from [this answer](http://stackoverflow.com/a/17693146/1167783) by MrROY on StackOverflow.