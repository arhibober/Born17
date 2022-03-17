<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET [ind] > 0)
  {
    $hdl = opendir ("Albums");
    while ($file = readdir ($hdl)) 
      if (strstr ($file, "PHOTO".$_GET [ind].".") == true)
        echo "<p>
         <img src='Albums/".$file."' style='width: 600px'/>";
    echo "</p>";
  }
  else
    echo "Кажется, Вы ошиблись страницей."; 
?>