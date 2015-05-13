
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


