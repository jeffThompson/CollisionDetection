
/*
COLLISION DETECTION: INTRODUCTION
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

int numEach = 50;

// circle, controlled by the mouse
float cx = 0;
float cy = 0;
float cr = 30;

// lots of other objects!
ArrayList<Circle> circles = new ArrayList<Circle>();
ArrayList<Rectangle> rectangles = new ArrayList<Rectangle>();
ArrayList<Line> lines = new ArrayList<Line>();
//ArrayList<Polygon> polygons = new ArrayList<Polygon>();


void setup() {
  size(600,400);
  
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
  cx = mouseX;
  cy = mouseY;
  
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


