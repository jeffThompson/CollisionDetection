
/*
OBJECT-ORIENTED COLLISION
Jeff Thompson | 2015 | www.jeffreythompson.org

*/

// a single Circle object, controlled by the mouse
Circle circle;

// a list of rectangles
Rectangle[] rects = new Rectangle[8];


void setup() {
  size(600,400);
  
  // create a new Circle with 30px radius
  circle = new Circle(0,0, 30);
  
  // generate rectangles in random locations
  for (int i=0; i<rects.length; i++) {
    float x = int(random(50,width-50)/50) * 50;    // but snap to grid!
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


