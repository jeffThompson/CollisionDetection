# Collision Detection
The collision of objects underlies most game experiences and user-interfaces. Baseball bats collide with balls, zombies bump into walls, and Mario lands on platforms and stomps turtles. Even something as simple as clicking a button (a rectangle) with your mouse (a point) is a collision.

This book explains the algorithms behind those collisions using basic shapes like circles, rectangles, and lines so you can implement them into your own projects.

View the book, including interactive examples: [jeffreythompson.org/collision-detection](http://www.jeffreythompson.org/collision-detection)

---

#### WHAT'S COVERED HERE?
This book covers collisions between points, circles, rectangles, lines, polygons, and triangles. These examples are meant to be as readable and easily understood as possible. There are definitely faster, more efficient ways to detect these collisions, but these examples are intended to teach the principles with minimal math. Each section include a description of the collision algorithm and an interactive example.

---

#### WHAT'S NOT?  
As with any book, there's a lot more useful material than could be covered here. Things that aren't discussed are mostly left out because the math gets too complicated. Three-dimensional space isn't touched on. Ellipses, which seem like they should be pretty easy, are actually very difficult.

If there's a specific collision not covered that would be helpful, please [send an email](mailto:mail@jeffreythompson.org) with a request (or better yet, submit an example!).

---

#### ISSUES?  
If you find code that doesn't run correctly, an algorithm that isn't explained quite right, or a typo, please [report them](https://github.com/jeffThompson/CollisionDetection/issues). Thanks for your help!

---

#### LICENSE  
This book's entire contents, including the code examples and this text, is released under a [Creative Commons Attribution, Non-Commercial, Share-Alike license](http://creativecommons.org/licenses/by-nc-sa/3.0/). This means:  

1. You're welcome to use this book and the examples to make great stuff, but please cite this book somewhere in your project or its documentation.  
2. You can only use the book and code for non-commercial projects. I'm very happy to talk options if you have a paid gig and you'd like to use some of the materials.  
3. If you do make a project that relies on this book or code, it must be released under this same license or a looser one. Pay it forward!

If you have any questions about what you can and can't do with these examples, please [get in touch](mailto:mail@jeffreythompson.org).

---

#### WHAT YOU SHOULD ALREADY KNOW  
This book's examples are written in [Processing](http://www.processing.org), a wrapper for the Java programming language. While you need little programming experience to use these examples, you should understand how a basic Processing sketch is structured, how to use variables, how to draw shapes and get input from the mouse, and how `if/else` statements work. It may be helpful to understand using `PVector` objects to store positions, but we'll cover that a little bit if you haven't used them before. 

At the end, we will talk about using collision in object-oriented code. Understanding object-oriented programming will not be required to use this book, but it will be helpful for using these topics in larger projects.
