# LINE/LINE  
With this example, you'll be able to build a super-sweet sword fighting game! (Or reboot [one that never got finished](http://www.polygon.com/2014/9/19/6477103/neal-stephensons-kickstarter-clang-cancel)?)

To check if two lines are touching, we have to calculate their directions. In geometry, this is denoted with the letter `u`:

	float uA = ((x4-x3)*(y1-y3) - (y4-y3)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
	
	float uB = ((x2-x1)*(y1-y3) - (y2-y1)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));

If there is a collision, `uA` and `uB` should both be in the range of 0-1. We test for that like this:

	if (uA >= 0 && uA <= 1 && uB >= 0 && uB <= 1) {
		return true;
	}
	return false;

That's it! We can add one more feature, if desired, that will tell us the intersection point of the two lines. This might be useful if, for example, you're making a sword-fighting game and want [sparks to fly where the two blades hit](http://tvtropes.org/pmwiki/pmwiki.php/Main/SwordSparks).

	float intersectionX = x1 + (uA * (x2-x1));
    float intersectionY = y1 + (uA * (y2-y1));

Here's the full example:

	float x1 = 0;    // line controlled by mouse
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

	  // calculate the direction of the lines
	  float uA = ((x4-x3)*(y1-y3) - (y4-y3)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
	  float uB = ((x2-x1)*(y1-y3) - (y2-y1)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));

	  // if uA and uB are between 0-1, lines are colliding
	  if (uA >= 0 && uA <= 1 && uB >= 0 && uB <= 1) {
	    
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

Based on a tutorial by [Paul Bourke](http://paulbourke.net/geometry/pointlineplane), who includes code to test if the lines are parallel and [coincident](http://mathworld.wolfram.com/CoincidentLines.html). Also based on [this post by Ibackstrom](http://community.topcoder.com/tc?module=Static&d1=tutorials&d2=geometry2).