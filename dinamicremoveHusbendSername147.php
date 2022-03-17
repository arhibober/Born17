<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET ["ind"] > 0)
  {
    include "functions147.php";
    $ind = $_GET ["ind"];
    echo "<p>
      Имя человека при рождении: ";
    onBD ($result, "HUSBEND_SERNAMES");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($ind == $row [0])
      {
        onBD ($result1, "PEOPLE");
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row [1] == $row1 [9])
          {
            if ($row1 [2] != "NULL")
              echo $row1 [2];
            else
              echo "?";
            if ($row1 [0] != "NULL")
              echo " ".$row1 [0];
            else
              if ($row1 [2] != "NULL")
                echo " ?";
            if ($row1 [1] != "NULL")
              echo " ".$row1 [1];
            else
              echo "";
          }
      }
    echo "</p>";
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>