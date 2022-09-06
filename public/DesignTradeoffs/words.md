
## What this talk is about

Union types and how they can be helpful in making code easier to use.

* Introduce some code.

* Theoretical aspects of humans liking spaghetti sauce.

* Apply that theory to code design.


## The code i'm going to be talking about.

Very simple graphics library. It can draw

Triangles
  * Triangles have 3 corners
    
Rectangles
  * Rectangles have top, bottom, left and right.

Squished circles 
  * Squished circles have top, bottom, left and right bounds.

(there are other ways to define these, but this way allows touching shapes)

## The code for this could be written in multiple ways

  * Separate methods
  * Type + parameters 
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

## Separate methods in use

```
function drawStuff(Canvas $c)
{
    $c->drawTriangle(50, 50, 100, 100, 100, 50);

    $c->drawRectangle(10, 100, 200, 150);

    $c->drawEllipse(10, 100, 200, 150);
}
```

## Type + parameters

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

## Type + parameters in use
```
function drawStuff(Canvas $c)
{
    $c->draw('triangle', 50, 50, 100, 100, 100, 50);

    $c->draw('rectangle', 10, 100, 200, 150);

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
    function __construct(
        readonly float $x1;
        readonly float $y1;
        
        readonly float $x2;
        readonly float $y2;
        
        readonly float $x3;
        readonly float $y3;    
    ) {}
}

class Rectangle
{
    function __construct(
        readonly float $left;
        readonly float $top;
        readonly float $right;
        readonly float $bottom;
    ) {}
}


class Ellipse
{
    function __construct(
        float $left;
        float $top;
        float $right;
        float $bottom;
    ) {}
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
   

## Caches

interface Cache
{
    public function get(string $key): string|null;
    public function set(string $key, string $value): void;

    <span class="fragment">public function exists($key);</span>

    <span class="fragment">public function clear();</span>
    <span class="fragment">public function delete(string $key);</span>

    <span class="fragment">public function setWithTTL(string $key, string $value, int $milliseconds);</span>
    <span class="fragment">public function set(string $key, string $value): void;</span>
}


## Diagram of cache complexity

Cache_1
Cache_2
Cache_3

## Cache - separate interfaces

interface CacheBasic
{
    public function get(string $key): string|null;
    public function set(string $key, string $value): void;
}

interface CacheExists
{
    public function exists($key);
}

interface CacheClear
{
    public function clear();
}

interface CacheDelete
{
    public function delete(string $key);
}


## PHP 8.1

function foo(CacheBasic & CacheDelete & CacheExists $cache)
{
    // Static analysis says ok
    $cache->get('foo');
    $cache->delete('foo');
    $cache->exists('foo');

    // Static analysis reports as error
    $cache->setWithTTL('foo', 'quux', 3600_000);
}


## Type definitions - PHP 8.2/8.3 ?

type BarCache = CacheBasic & CacheClear & CacheExists;

function foo(BarCache $cache)
{
    ...
}




## fin













## PSR-6: Caching Interface

<?php

namespace Psr\Cache;

interface CacheItemPoolInterface
{
    public function getItem($key);
    public function getItems(array $keys = array());
    public function hasItem($key);
    public function clear();
    public function deleteItem($key);
    public function deleteItems(array $keys);
    public function save(CacheItemInterface $item);
    public function saveDeferred(CacheItemInterface $item);
    public function commit();
}

interface CacheItemInterface
{
    public function getKey();
    public function get();
    public function isHit();
    public function set($value);
    public function expiresAt($expiration);
    public function expiresAfter($time);
}

interface CacheException {}

