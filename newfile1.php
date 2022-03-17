<!DOCTYPE html>
<html>
<head>
  <meta />
  <title>Определение координат клика</title>
  <script type="text/javascript">
  function koordinati_klika(event) {
    x = event.clientX;
    y = event.clientY;
    alert("X=" + x + ", Y=" + y);
  }
  </script>
</head>
<body onmousedown="koordinati_klika(event)">
  <p>Кликните в любом месте этой надписи. Окно <code>alert()</code>
  будет информировать вас о X и Y координатах курсора.</p>
</body>
</html>