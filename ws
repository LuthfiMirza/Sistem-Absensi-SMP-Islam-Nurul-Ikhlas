<html>
 <head>
  <style>
    body {
        margin:0px;
        padding:0px;
   }
 </style>
</head>
<body>
    <canvas id="myCanvas" width="500" height="200"></canvas>
    <script>
        var canvas = document.getElementById('myCanvas');
        var context = canvas.getContext('2d');           
        context.beginPath();
        context.moveTo(100, 150);
        context.lineTo(450,50);
        context.stroke();
    </script>
 </body>
</html>

3. garis tebal
<html>
 <head>
  <style>
    body {
        margin:0px;
        padding:0px;
   }
 </style>
</head>
<body>
    <canvas id="myCanvas" width="500" height="200"></canvas>
    <script>
        var canvas = document.getElementById('myCanvas');
        var context = canvas.getContext('2d');           
        context.beginPath();
        context.moveTo(100, 150);
        context.lineTo(450,50);
        context.lineWidth =5;
        context.stroke();
    </script>
 </body>
</html>
