<?php include('includes/header.php'); ?>

<h1>WHAT YOU SHOULD ALREADY KNOW</h1>

<p>This book's examples are written in <a href="http://www.processing.org">Processing</a>, a wrapper for the Java programming language. While you need only a little programming experience, you should understand how a basic Processing sketch is structured, how to use variables, how to draw shapes and get input from the mouse, and how <code>if/else</code> statements work.</p>

<p>It may be helpful to understand using <code>PVector</code> objects to store positions, but we'll cover the basics if you haven't used them before.</p>

<p>At the end, we will talk about using collision in object-oriented code. Understanding object-oriented programming will not be required to use this book, but it will be helpful for using these topics in larger projects with lots of objects hitting each other.</p>

<p class="callout"><strong>Haven't used Processing before? That's ok!</strong> If you've used another programming language before it should be easy to understand these examples and port the code to the language of your choice.</p>

<h2>FUNCTIONS</h2>

<p>The core of the collision examples are <em>functions</em>, so you will need to be familiar with them to use this book. If you have never created a function, please read this section carefully; if you already understand this topic, you can skip ahead.</p>

<p>A function is a re-usable, self-contained piece of code. Functions are used for operations that you want to perform more than once: like checking for collision between two objects.</p>

<p>A function <em>returns</em> (sends back) a variable <em>type</em> (like <code>int</code> or <code>boolean</code>). For example, here's a function that returns the string "Hello!"</p>

<pre>String sayHi() {
    return "Hello!";
}
</pre>

<p>Note that when we declare the function, we list the variable type to be returned. The function does something useful, then sends data back using the <code>return</code> command. If the function doesn't need to return anything (for example, if all it does is draw a rectangle), the type is <code>void</code>. Sound familiar? The <code>setup()</code> and <code>draw()</code> sections of Processing are actually functions!</p>

<p>Functions can also receive <em>arguments</em>, or parameters that are fed into them. An argument is given a type and name (which exists only inside the function); multiple arguments are separated by commas. Here's a simple function that adds two numbers:</p>

<pre>int sum(int a, int b) {
    return a + b;
}
</pre>

	<p>Once finished, you can use the function elsewhere in your code. For example, our <code>sum()</code> function above can be used like this:</p>

<pre>int result = sum(2, 2);
println(result);
>> 4
</pre>

<p>All of the examples in this book are functions. They are fed parameters of the objects to be tested (such as position or size) and return a <code>boolean</code> value whether or not a collision is happening. They could also be modified to return the position of the collision, such as in the <a href="line-line.php">Line/Line</a> example. Be sure to look at the full code at the end of each example to see how the function is structured and called.</p>

<h2>FLOATS</h2>

<p>You'll notice throughout this book that we use floating-point variables. This is for a few reasons. </p>

<p>First, it allows more flexibility for later use. Integers (whole numbers) can be passed into the functions without an error, but the opposite would not be true.</p>

<pre>// int-to-float argument ok
int a = 1;
floatFunction(a);

void floatFunction(float f) {
    // Processing automatically converts to a float
}


// float-to-int argument not ok!
float b = 1;
intFunction(b);

void intFunction(int i) {
    // this will cause an error
}
</pre>

<p>Second, floats give us the ability to measure more precisely and to move objects more smoothly across the screen, making your interactive projects feel more natural.</p>

<p>Finally, using floats makes it much easier to transition from separate X/Y positions to using using the <code>PVector</code> class, as the more advanced examples will do. The numbers inside a PVectors are floats, so this ensures our functions can be easily tweaked to work with vectors.</p>

<?php include('includes/footer.php'); ?>
