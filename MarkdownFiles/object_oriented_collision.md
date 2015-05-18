<figcaption>Refresh your browser for random squares!</figcaption>

# MOVING TO OBJECT-ORIENTED COLLISION  
Congrats! You've made it through a *lot* of collision-detection code. But these examples are meant as simple demonstrations of how the algorithms work. Combining them into bigger projects probably means moving your code to an object-oriented approach. (For an excellent introduction to object-oriented programming, see Daniel Shiffman's book ["Nature Of Code"](http://natureofcode.com/book/).)

Why? Let's say we have a circle and a bunch of rectangles (like above). We could store separate positions, sizes, and collisions for each, but that would quickly get messy. Instead, a `Circle` and `Rectangle` class will give our code a lot more power and flexibility.

Let's start with our Circle class:

	class Circle {
	  float x, y;    // position
	  float r;       // radius
	  
	  Circle (float _x, float _y, float _r) {
	    x = _x;
	    y = _y;
	    r = _r;
	  }
	  
	  // move into mouse position
	  void update() {
	    x = mouseX;
	    y = mouseY;
	  }
	  
	  // draw
	  void display() {
	    fill(0, 150);
	    noStroke();
	    ellipse(x,y, r*2, r*2);
	  }
	}

Pretty straightforward. We can also make a basic Rectangle class:

	class Rectangle {
	  float x, y;            // position
	  float w, h;            // size
	  boolean hit = false;   // is it hit?
	  
	  Rectangle (float _x, float _y, float _w, float _h) {
	    x = _x;
	    y = _y;
	    w = _w;
	    h = _h;
	  }
	  
	  // draw the rectangle
	  // if hit, change the fill color
	  void display() {
	    if (hit) fill(255,150,0);
	    else fill(0,150,255);
	    noStroke();
	    rect(x,y, w,h);
	  }
	}

Notice we have a variable for the Rectangle called `hit`. This way we can keep track of whether or not the circle has hit a particular rectangle and change its fill color accordingly. By default, the value is set to `false`.

We have just one `Circle`, but we create an `ArrayList` of `Rectangle` objects. To run everything, here's what our main `draw()` loop looks like:

	void draw() {
	  background(255);
	  
	  // go through all rectangles
	  // and draw them onscreen
	  for (Rectangle r : rects) {
	    r.display();
	  }
	  
	  // update circle's position and draw
	  circle.update();
	  circle.display();
	}

So how do we test if the circle has hit something? Let's create a *method* (an internal function) of the Rectangle class called `checkCollision()`. We'll pass the `Circle` object as an argument, then do a basic [Circle/Rectangle](circle-rect.php) collision test.

	void checkCollision(Circle c) {
	  hit = circleRect(c.x,c.y,c.r, x,y,w,h);
  	}

The result of `circleRect()` sets `hit` to be `true` or `false`, which in turn changes the fill color. Now we just add the test to the `draw()` loop:

	for (Rectangle r : rects) {
	  r.checkCollision(circle);  // check for collision
	  r.display();               // and draw
	}

Pretty cool! Here's the full code:

	// a single Circle object, controlled by the mouse
	Circle c;

	// a list of rectangles
	Rectangle[] rects = new Rectangle[8];


	void setup() {
	  size(600,400);
	  
	  // create a new Circle with 30px radius
	  circle = new Circle(0,0, 30);
	  
	  // generate rectangles in random locations
	  // but snap to grid!
	  for (int i=0; i<rects.length; i++) {
	    float x = int(random(50,width-50)/50) * 50;
	    float y = int(random(50,height-50)/50) * 50;
	    rects[i] = new Rectangle(x,y, 50,50);
	  }
	}


	void draw() {
	  background(255);
	  
	  // go through all rectangles...
	  for (Rectangle r : rects) {
	    r.checkCollision(circle);  // check for collision
	    r.display();               // and draw
	  }
	  
	  // update circle's position and draw
	  circle.update();
	  circle.display();
	}


	class Circle {
	  float x, y;    // position
	  float r;       // radius
	  
	  Circle (float _x, float _y, float _r) {
	    x = _x;
	    y = _y;
	    r = _r;
	  }
	  
	  // move into mouse position
	  void update() {
	    x = mouseX;
	    y = mouseY;
	  }
	  
	  // draw
	  void display() {
	    fill(0, 150);
	    noStroke();
	    ellipse(x,y, r*2, r*2);
	  }
	}


	class Rectangle {
	  float x, y;            // position
	  float w, h;            // size
	  boolean hit = false;   // is it hit?
	  
	  Rectangle (float _x, float _y, float _w, float _h) {
	    x = _x;
	    y = _y;
	    w = _w;
	    h = _h;
	  }
	  
	  // check for collision with the circle using the
	  // Circle/Rect function we made in the beginning
	  void checkCollision(Circle c) {
	    hit = circleRect(c.x,c.y,c.r, x,y,w,h);
	  }
	  
	  // draw the rectangle
	  // if hit, change the fill color
	  void display() {
	    if (hit) fill(255,150,0);
	    else fill(0,150,255);
	    noStroke();
	    rect(x,y, w,h);
	  }
	}


	// CIRCLE/RECTANGLE
	boolean circleRect(float cx, float cy, float radius, float rx, float ry, float rw, float rh) {
	  
	  // temporary variables to set edges for testing
	  float testX = cx;
	  float testY = cy;
	  
	  // which edge is closest?
	  if (cx < rx)         testX = rx;      // compare left edge
	  else if (cx > rx+rw) testX = rx+rw;   // right edge
	  if (cy < ry)         testY = ry;      // top edge
	  else if (cy > ry+rh) testY = ry+rh;   // bottom edge
	  
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

Note that our code is a bit long with all the classes, so the actual Processing file is broken up into separate tabs. This would be a good idea for projects that require several collision functions. You could name the tab "CollisionFunctions" and keep all the code there.

You can see another, more complex example of object-oriented collision in the [Introduction](index.php). It uses a class for circles, rectangles, and lines.