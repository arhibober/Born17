<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "functions147.php";
  include "menu.php";
  if ($_POST ["album"] > 0)
  {
    fromBD ($result, "ALBUM", $_POST ["album"]);
    onBD ($result1, "PHOTO");
    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
      if ($row1 [2] == $_POST ["album"])
      {      	
        fromBD ($result, "PHOTO", $row1 [0]);
        $dirct = "Albums";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl)) 
          if (strstr ($file, "PHOTO".$row1 [0].".") == true)
            unlink ($dirct."/".$file);
        onBD ($result2, "PHOTO_PEOPLE");
        while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
          if ($row2 [1] == $row1 [0])
            fromBD ($result, "PHOTO_PEOPLE", $row2 [0]);
      }
    echo "<p>
      Альбом успешно удалён.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";   
  include "footer.php";
?>