# COLLISION DETECTION  
Jeff Thompson  

The collision of objects underlies most game experiences and many other user-interfaces (UIs). Baseball bats collide with balls, zombies bump into walls, and Mario lands on platforms and stomps turtles. This book explains the algorithms behind those collisions using basic shapes like circles, rectangles, and lines.


## WHAT YOU SHOULD ALREADY KNOW  
This book's examples are written in Processing, a wrapper for the Java programming language. While you need little programming experience to use these examples, you should understand how a basic Processing sketch is structured, how to use variables, how to draw shapes and get input from the mouse, and how if/else statements work. It may be helpful to understand using `PVector` objects to store positions, but we'll cover that a little bit if you haven't used them before. 

At the end, we will talk about using collision in object-oriented code. Understanding object-oriented programming will not be required to use this book, but it will be helpful for using these topics in larger projects.


## FUNCTIONS  
You also should understand how to create and use custom *functions*. If you have never created a function, please read the next section carefully; if you already understand this topic, you can skip ahead.
A *function* is a re-usable, self-contained piece of code. Functions are used for operations that you want to use more than once, like checking for collision between two objects.

A function *returns* (sends back) a variable *type* (like `int` or `boolean`). For example, here's a function that returns the String "Hello!":

    String sayHi() {
    	return "Hello!";
    }

Note when we declare the function, we list the variable type to be returned. We do something useful, then use the `return` command to send data back. If the function doesn't return anything (for example, if all it does is draw a rectangle), the type is `void`. Sound familiar? The `setup()` and `draw()` sections of Processing are functions!

Functions can also receive *arguments*, or parameters that are fed in. An argument is given a type and name (which exists only in the function); multiple arguments are separated by commas. Here's a simple function that adds two numbers:

	int sum(int a, int b) {
		return a + b;
	} 

All of the examples in this book are functions. They are fed parameters of the objects to be tested (such as position or size). Most return a `boolean` value whether or not a collision is happening. Sometimes they will return a position (such as the "Line/Line" example) where the collision is taking place.

## FLOATS  
You'll notice throughout this book that we use floating-point variables for all positions. This is for a few reasons. First, it allows more flexibility for later use. Ints can be passed into the functions readily, but the opposite would not be true.

	// int to float argument ok
	int a = 1;
	floatFunction(a);

	void floatFunction(float f) {
		// Processing automatically converts to a float
	}


	// float to int argument not!
	float b = 1;
	intFunction(b);

	void intFunction(int i) {
		// this will cause an error
	}

Second, floats give us the ability to measure more precisely, and to move objects more smoothly across the screen. Finally, this smooths the transition from separate X/Y positions to using the `PVector` class, as the more advanced examples will do. PVectors are built-in as floats, so this ensures our functions can be easily tweaked to work with vectors.

## WHAT'S COVERED HERE?
This book covers collisions between points, circles, rectangles, lines, polygons, and triangles (and a few bonus functions). Note that these examples are meant to be as readable and easily understood as possible. There are faster, more efficient ways to perform these collisions, but these examples are intended to teach the principles with minimal math :)

Examples include the collision algorithm as a function, followed by an interactive example.

## WHAT'S NOT?  
As with any book, there's a lot more material than could be covered here. Things that aren't covered are mostly left out because the math gets too complicated. Three-dimensional space isn't touched on. Ellipses, which seem like they should be pretty easy, are actually very difficult.

If there's a specific collision not covered, please send an email with a request (or better yet, submit an example!).

## ISSUES WITH THE CODE?  
If you find code that doesn't run correctly, an algorithm that isn't explained quite right, or a typo, please report them at this project's GitHub repository. Click on the `Issues` tab and fill out the form. Thanks for your help!