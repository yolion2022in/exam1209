<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - The frantic run of the valorous rabbit</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="{{asset('game1/style.css')}}">

</head>
<body>
<!-- partial:index.partial.html -->
<div id="world" />
<div id="gameoverInstructions">
  Game Over
</div>
<div id="dist">
    <div class="label">distance</div>
    <div id="distValue">000</div>
</div>

<div id="instructions">Click to jump<span class="lightInstructions"> — Grab the carrots / avoid the hedgehogs</span></div>


<div id="credits">
  <p><a href="https://codepen.io/Yakudoo/" target="blank">other codepens</a> | <a href="https://www.epic.net" target="blank">epic.net</a></p>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/three.js/r80/three.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/264161/OrbitControls.js'></script><script  src="{{asset('game1/script.js')}}"></script>

</body>
</html>
