## POLYGON/POINT  
Circle and rectangle collisions are great, and often simplifying collision of complex shapes using bounding boxes and circles makes the most sense. But there are times when we have complicated shapes and want more accuracy. Fortunately, while the way we apply them can get a bit complicated, many of the methods used in the remaining examples use ideas we've already covered.

In this example, we'll check if a point is inside a complex polygon. We define our polygon using a set of X/Y points called *vertices*. To store these points, we'll use an array of `PVector` objects. If you haven't used PVectors before, they simply store X/Y (or X/Y/Z) coordinates. This makes storing points a little easier, and Processing gives us some fancy math for PVectors that would be tricky otherwise.

First, we create an array of four PVectors:

	PVector[] vertices = new PVector[4];

Then, we set their positions. Here we're drawing a distorted trapezoid, but you could make more complicated shapes, or even randomize the points!

	vertices[0] = new PVector(200,100);		// set X/Y position
  	vertices[1] = new PVector(400,130);
  	vertices[2] = new PVector(350,300);
  	vertices[3] = new PVector(250,300);

To check for collision, we're going to use a separate boolean variable. This will be inside our function later.

	boolean collision = false;

Then we need to go through the vertices one-by-one. To do this we use a for loop. But also want the next vertex in the list, so we use a second variable. Here's what the loop looks like:

	int next = 0;
  	for (int current=0; current<vertices.length; current++) {
  		
  		// get next vertex in list
    	// if we've hit the end, wrap around to 0
    	next = current+1;
    	if (next == vertices.length) next = 0;

    }

Then we can use `current` and `next` to retrieve the PVectors from our array:

	PVector vc = vertices[current];    // c for "current"
    PVector vn = vertices[next];       // n for "next"

We can access the X/Y coordinates of each vertex using the syntax `vc.x` and `vc.y`. Now for the if statement. This gets a little tricky, so here's the whole thing, then we'll break it down into its parts:

	if ( ((vc.y > py) != (vn.y > py)) && (px < (vn.x-vc.x) * (py-vc.y) / (vn.y-vc.y) + vc.x) ) {
      collision = !collision;
    }

There are two tests happening here. The first checks if the point is between the two vertices in the Y direction. 

	(vc.y > py) != (vn.y > py)

That's a little confusing. Imagine a line and a point in the middle:

	Line:  (0,0, 0,10)
	Point: (0,5)

The point is clearly between the two Y coordinates of the line. That's what the first comparison in the if statement does:

	0  > 5	FALSE
	10 > 5  TRUE

If one of those statements is true and the other false, we know the line is between the two points! If both are true, the point is above the line; if both are false, it is below.

Next up is a more complicated test. This is based on the [Jordan Curve Theorem](http://en.wikipedia.org/wiki/Jordan_curve_theorem), which is pretty intense math so we'll skip explaining it. If you want a collision-detection challenge, by all means! (And, if you already understand this algorithm, please do let me know!)

	px < (vn.x-vc.x) * (py-vc.y) / (vn.y-vc.y) + vc.x

If both checks are true, we switch the value of `collision`. This is different than our other previous tests, where we set the collision to true or false. After we've gone through all the vertices, whatever the final state of `collision` is is the result.

	collision = !collision;		// set collision to the opposite of its current state

Here's a full example using a distorted trapezoid as the polygon:

	float px = 0;    // point position
	float py = 0;

	// array of PVectors, one for each vertex in the polygon
	PVector[] vertices = new PVector[4];


	void setup() {
	  size(600,400);
	  noCursor();
	  
	  strokeWeight(5);  // make the point easier to see
	  
	  // set position of the vertices
	  // here we draw a distorted trapezoid, but you could
	  // make much more complex shapes, or even randomize the points!
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
	  
	  // go through each of the vertices, plus the next vertex in the list
	  int next = 0;
	  for (int current=0; current<vertices.length; current++) {
	    
	    // get next vertex in list
	    // if we've hit the end, wrap around to 0
	    next = current+1;
	    if (next == vertices.length) next = 0;
	    
	    // get the PVectors at our current position
	    // this makes our if statement a little cleaner
	    PVector vc = vertices[current];    // c for "current"
	    PVector vn = vertices[next];       // n for "next"
	    
	    // compare position, flip 'collision' variable back and forth
	    if ( ((vc.y > py) != (vn.y > py)) && (px < (vn.x-vc.x) * (py-vc.y) / (vn.y-vc.y) + vc.x) ) {
	      collision = !collision;
	    }
	  }
	  return collision;  
	}

This function is designed to take any number of vertices, so it can handle very complex shapes! However, the more vertices you check, the slower the function will be. If you wanted to do this in a full game, a few of these checks on complex shapes could slow your game to a crawl. Balance the need for accuracy with speed; whatever feels intuitive is probably right.

This example is based on [this answer by nirg and Pranav from StackOverflow](http://stackoverflow.com/a/2922778/1167783).
