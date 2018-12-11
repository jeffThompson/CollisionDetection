
/*
LINE/LINE
 Jeff Thompson | 2015 | www.jeffreythompson.org
 
 Via examples by Paul Bourke:
 http://paulbourke.net/geometry/pointlineplane
 
 And Ibackstrom:
 http://community.topcoder.com/tc?module=Static&d1=tutorials&d2=geometry2
 
 */

float x1 = 0;        // line controlled by mouse
float y1 = 0;
float x2 = 20;       // fixed end
float y2 = 20;

float x3,y3, x4,y4;  // static line


void setup() {
  size($("#wrapper").width(), 400);
  
  strokeWeight(15);  // make lines easier to see

  x3 = 100;
  y3 = height-100;
  x4 = width-100;
  y4 = 100;
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


