
/*
COLLISION DETECTION: INTRODUCTION
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

int numEach = 50;

// circle, controlled by the mouse
float cx, cy;
float cr = 30;

// lots of other objects!
ArrayList<Circle> circles = new ArrayList<Circle>();
ArrayList<Rectangle> rectangles = new ArrayList<Rectangle>();
ArrayList<Line> lines = new ArrayList<Line>();
//ArrayList<Polygon> polygons = new ArrayList<Polygon>();


void setup() {
  size($("#wrapper").width(), 400);

  cx = width/2;
  cy = height/2;
  
  // make some cirlces
  for (int i=0; i<numEach; i++) {
    Circle c = new Circle(random(width), random(-height,height));
    circles.add(c);
  }
  
  // rectangles
  for (int i=0; i<numEach; i++) {
    Rectangle r = new Rectangle(random(width), random(-height,height));
    rectangles.add(r);
  }
  
  // lines
  for (int i=0; i<numEach; i++) {
    float x = random(width);
    float y = random(-height,height);
    Line l = new Line(x,y, x+random(-20,20), y+random(-20,20));
    lines.add(l);
  }
  
  // and polygons
//  for (int i=0; i<30; i++) {
//    Polygon p = new Polygon(random(width), random(-height,height));
//    Polygon.add(p);
//  }
}

void draw() {
  background(255);
  
  // update main circle to mouse coordinates
  if (mouseX != pmouseX && mouseY != pmouseY) {
    cx = mouseX;
    cy = mouseY;
  }
  
  // draw us!
  fill(0,150);
  noStroke();
  ellipse(cx,cy, cr*2,cr*2);
  
  // draw the other shapes
  for (int i=circles.size()-1; i>=0; i-=1) {
    Circle c = circles.get(i);
    c.update();
    c.display();
    if (c.y > height+50) {
      circles.remove(c);
      circles.add(new Circle(random(width), random(-height,-50)));
    }      
  }
  
  for (int i=rectangles.size()-1; i>=0; i-=1) {
    Rectangle r = rectangles.get(i);
    r.update();
    r.display();
    if (r.y > height+50) {
      rectangles.remove(r);
      rectangles.add(new Rectangle(random(width), random(-height,-50)));
    }
  }
  
  for (int i=lines.size()-1; i>=0; i-=1) {
    Line l = lines.get(i);
    l.update();
    l.display();
    if (l.y1 > height+50 && l.y2 > height+50) {
      lines.remove(l);
      float x = random(width);
      float y = random(-height,-50);
      lines.add(new Line(x,y, x+random(-20,20), y+random(-20,20)));
    }
  }
}



class Circle {
  float x, y;
  float r;
  float speed;
  boolean hit = false;
  
  Circle(float _x, float _y) {
    x = _x;
    y = _y;
    r = random(8,20);
    speed = random(0.5, 2);
  }
  
  void update() {
    y += speed;
    hit = circleCircle(x,y,r, cx,cy,cr);
  }    
  
  void display() {
    if (!hit) fill(0,150,255, 150);
    else fill(255,150,0, 150);
    noStroke();
    ellipse(x,y, r*2,r*2);
  }  
}



// CIRCLE/CIRCLE
boolean circleCircle(float c1x, float c1y, float c1r, float c2x, float c2y, float c2r) {
  
  // get distance between the circle's centers
  // use the Pythagorean Theorem to compute the distance
  float distX = c1x - c2x;
  float distY = c1y - c2y;
  float distance = sqrt( (distX*distX) + (distY*distY) );

  // if the distance is less than the sum of the circle's
  // radii, the circles are touching!
  if (distance <= c1r+c2r) {
    return true;
  }
  return false;
}


// LINE/CIRCLE
boolean lineCircle(float x1, float y1, float x2, float y2, float cx, float cy, float r) {

  // either end inside the circle?
  boolean inside = pointCircle(x1,y1, cx,cy,r);
  if (inside) return true;
  inside = pointCircle(x2,y2, cx,cy,r);
  if (inside) return true;
  
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
  float buffer = 5;    // higher # = less accurate
  
  // if the two distances are equal to the line's length, the
  // point is on the line!
  // note we use the buffer here to give a range, rather than one #
  if (d1+d2 >= lineLen-buffer && d1+d2 <= lineLen+buffer) {
    return true;
  }
  return false;
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



class Line {
  float x1, y1, x2, y2;
  float speed;
  boolean hit = false;
  
  Line(float _x1, float _y1, float _x2, float _y2) {
    x1 = _x1;
    y1 = _y1;
    x2 = _x2;
    y2 = _y2;
    speed = random(0.5, 2);
  }
  
  void update() {
    y1 += speed;
    y2 += speed;
    hit = lineCircle(x1,y1,x2,y2, cx,cy,cr);
  }
  
  void display() {
    if (!hit) stroke(0,150,255, 150);
    else stroke(255,150,0, 150);
    strokeWeight(5);
    line(x1,y1, x2,y2);
  }  
}



class Rectangle {
  float x, y;
  float w, h;
  float speed;
  boolean hit = false;
  
  Rectangle(float _x, float _y) {
    x = _x;
    y = _y;
    w = random(8,20);
    h = random(8,20);
    speed = random(0.5, 2);
  }
  
  void update() {
    y += speed;
    hit = circleRect(cx,cy,cr, x,y,w,h);
  }
  
  void display() {
    if (!hit) fill(0,150,255, 150);
    else fill(255,150,0, 150);
    noStroke();
    rect(x,y, w,h);
  }  
}



