<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET ["ind"] > 0)
  {
    include "functions147.php";
    $ind = $_GET ["ind"];
    echo "<p class='cent'>Брак установлен между родственниками ";
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array($result))
      if ($row [9] == $ind)
      {
        onBD ($result1, "PEOPLE");
        while ($row1 = mysqli_fetch_array($result1))      	  
        if ($row1 [9] == $row [10])
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
        onBD($result1, "PEOPLE");
        while ($row1 = mysqli_fetch_array($result1))
          if ($row1 [9] == $row [11])
          {
      	    echo " и ";
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