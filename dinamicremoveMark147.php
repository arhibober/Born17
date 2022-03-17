<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET [ind] > 0)
  {
    include "functions147.php";
    onBD ($result, "PHOTO_PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_GET [ind])
      {
        $dirct = "Albums";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl))
          if (strstr ($file, "PHOTO".$row [1].".") == true)
          {
            echo "<p>
              <img src='Albums/".$file."' style='width: 600px'/><br/>
              Отмеченный родственник: ";
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if ($row1 [9] == $row [2])
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
                  echo "<br/>
                    <input type='hidden' name='mark1' value='".$row [0]."'/>
                    </p>";
                }
              $wasMark = true;
              break;
            }
          if ($wasMark)
            break;
        }
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>