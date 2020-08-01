

## What this talk is about

Union types and how they can be helpful in making code easier to use.


* Introduce some code.

* Theoretical aspects of humans liking spaghetti sauce.

* Apply that theory to code design.


## The code i'm going to be talking about.

Very simple graphics library

Can draw triangles.
    * Triangles have 3 corners
    
Rectangles
    * Rectangles have top, bottom, left and right.

Ellipses aka Circles 
    * Circles have top, bottom, left and right bounds.


## The code for this could be written in multiple ways

    * Separate methods
    * Command parameters 
    * Object types

## Separate methods

```
interface Canvas
{
    function drawTriangle(
        float $x1, float $y1,
        float $x2, float $y2,
        float $x3, float $y3
    );

    function drawRectangle(
        float $left, float $top,
        float $right, float $bottom,
    );

    function drawEllipse(
        float $left, float $top,
        float $right, float $bottom
    );
}
```

## Standard style in use

```
function drawStuff(Canvas $c)
{
    $c->drawTriangle(50, 50, 100, 100, 100, 50);

    $c->drawRectangle(10, 100, 200, 150);

    $c->drawEllipse(10, 100, 200, 150);
}
```


## Raw parameters

```
interface Canvas
{
    function draw(
        $shape,
        float $x1, float $y1,
        float $x2, float $y2,
        float $x3, float $y3,
        float ...$otherPoints
    );
}
```

## Raw parameters in use
```
function drawStuff(Canvas $c)
{
    $c->draw('triangle', 50, 50, 100, 100, 100, 50);

    $c->draw('rectangle',  10, 100, 200, 150);

    $c->draw('ellipse', 10, 100, 200, 150);
}
```


## Object parameters

```
interface Canvas
{
    function draw(Triangle|Rectange|Ellipse $shape);
}

class Triangle 
{
    float $x1;
    float $y1;

    float $x2;
    float $y2;

    float $x3;
    float $y3;

    //  Constructor skipped for space
}

class Rectangle
{
    float $left;
    float $top;
    float $right;
    float $bottom;

    //  Constructor skipped for space
}


class Ellipse
{
    float $left;
    float $top;
    float $right;
    float $bottom;
}

```

## Object parameters in use

```
function drawStuff(Canvas $c)
{
    $triangle = new Triangle(50, 50, 100, 100, 100, 50);
    $c->draw($triangle);

    $rectangle = new Rectangle(10, 100, 200, 150);
    $c->draw($rectangle);

    $ellipse = new Ellipse(10, 100, 200, 150);
    $c->draw($ellipse);
}
```


## Isomorphic

In biology, two things are isomorphic if they resemble each other.
  
In mathematics, two things are isomorphic if there is a structure-preserving map between them in both directions.

In computer science, two things are isomorphic if the person explaining a concept wishes to seem educated.


## The different versions are 'isomorphish'

  * Separate methods
  * Command parameters 
  * Object types
  
  
They all allow the same thing to be done.


## Audience participation time

  Which one do you prefer  
  
  
## Talk about spaghetti sauce



## Okay so it was a trick question earlier

Asking whether people like something or not is usually

* familiar style - a style different to one they are used to

* Typos detected in IDE - typos not detected in IDE.

* Easy to write code - easy 
    
