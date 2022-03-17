<?php
  $index = 5;
  include "menu.php"; 
  $nom = "new";
  $dirct = "news";
  $hdl = opendir ($dirct);
  echo "<br/>"; 
  while ($file = readdir ($hdl)) 
    if (strstr ($file, $nom) == true)
      $a [] = $file; 
  $l = sizeof ($a);
  if ($l == 0)
    echo "<p>
      На данный момент не было зарегистрировано ни одной новости.
      </p>" ;
  else
  { 
    echo "<h3>
      Последние новости:
      </h3>
  	  <table style='border: 0' align='center'>";
    rsort ($a);
    foreach ($a as $k)
    {
      echo "<div class='cent'>
        <table width='100%' cellpadding='5' style='border: 0'>
        <tr>
        <td width='20%'>
        <p>
        №".$l."<br/>".
        date ("d/m/Y H:i", filemtime ($dirct."/".$k))."
        </p>
        </td>
        <td bgcolor='#fffddd'>\n";
      $file = fopen ($dirct."/".$k, "r");
      echo fgets ($file, 10000);
      while (!feof ($file))
      {
      	$i = 0;
        $temp = fgets ($file, 10000);
      	while (substr ($temp, $i, 1) == " ")
      	  $i++;
      	for ($j = 0; $j < $i; $j++)
      	  echo "&nbsp";
        echo substr ($temp, $i, strlen ($temp) - $i);
      	$b = true;
      	echo "<br/>";
      }
      echo "</td></tr></table></div>";
      fclose ($file);      
      $l--;     
    }
  }  
  include "footer.php";
?>