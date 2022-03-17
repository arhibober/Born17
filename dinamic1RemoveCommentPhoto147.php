<meta name="robots" content="noindex"/>
<?php
  $index = 0; 
  if ($_GET [ind] > 0)
  {
    include "functions147.php";
    $ind = $_GET [ind];
    $ind1 = $_GET [ind1];
    $nom = "comment";
    $dirct = "photo".$ind1;
    $hdl = opendir ($dirct);
    $j = 0;
    while ($file = readdir ($hdl))
      if (strstr ($file, $nom)==True)
      {      	
        $j++;
        if ($ind == $j)
        {
          echo "<table style='border: 0' align='center'>
            <tr>
              <td width='200'>
                <p>
                №".$j;
          $text = fopen($dirct."/".$file, "r");
          onBD ($result, "ACCOUNTS");
          while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
            if ($row [3] == substr ($file, 18, strlen ($file) - 18))
            {
              echo "&nbsp;&nbsp;".date ("d/m/Y H:i", substr ($file, 7, 10)).
                "</p>
                </td>
                <td width='700' rowspan='2' >\n";
              echo fgets ($text, 10000);
              while (!feof ($text))
              {
                $i = 0;
                $temp = fgets ($text, 10000);
      	        while (substr ($temp, $i, 1) == " ")
      	          $i++;
      	        for ($j = 0; $j < $i; $j++)
      	          echo "&nbsp";
                echo substr ($temp, $i, strlen ($temp) - $i);
      	        $b = true;
      	        echo "<br/>";
              }
              echo "</td>
              </tr>
              <tr>
              <td width='100'>
              <p>".
              $row [0]
              ."</p>
              </td>
              </tr>
              </table>";
            }
          fclose ($text);
        }
      }
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>