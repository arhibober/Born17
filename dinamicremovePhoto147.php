<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET [ind] > 0)
  {
    include "functions147.php";
    onBD ($result, "PHOTO");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_GET [ind])
      {
        $dirct = "Albums";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl)) 
          if (strstr ($file, "PHOTO".$row [0].".") == true)
            echo "<p>
              <img src='Albums/".$file."' style='width: 600px' alt=''/><br/>
              <input type='hidden' name='photo1' value='".$row [0]."'/>
              </p>";
        break;
      }
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>