<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET [ind] > 0)
  {
    include "functions147.php";
    $ind = $_GET [ind];
    $nom = "connection";
    $dirct = "gb";
    $hdl = opendir ($dirct);
    $j = 0;
    while ($file = readdir ($hdl))
      if (strstr ($file, $nom) == true)
      {      	
        $j++;
        if ($ind == $j)
        {
          echo "<table border='0' align='center'>
            <tr>
              <td width='200'>
                №".$j;
          $file1 = fopen ($dirct."/".$file, "r");
          echo fgets ($file1, 10000);
          while (!feof ($file1))
          {
            $i = 0;
            $temp = fgets ($file1, 10000);
      	    while (substr ($temp, $i, 1) == " ")
      	      $i++;
      	    for ($k = 0; $k < $i; $k++)
              echo "&nbsp";
            echo substr ($temp, $i, strlen ($temp) - $i);
      	    echo "<br/>";
          }
        }
      }
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>