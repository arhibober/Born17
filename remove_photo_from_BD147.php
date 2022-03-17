<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "functions147.php";
  include "menu.php";
  if ($_POST ["photo1"] > 0)
  {
    fromBD ($result, "PHOTO", $_POST ["photo1"]);
    $dirct = "Albums";
    $hdl = opendir ($dirct);
    while ($file = readdir ($hdl)) 
      if (strstr ($file, "PHOTO".$_POST ["photo1"].".") == true)
        unlink ($dirct."/".$file);
    onBD ($result1, "PHOTO_PEOPLE");
    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
      if ($row1 [1] == $_POST ["photo1"])
        fromBD ($result, "PHOTO_PEOPLE", $row1 [0]);
    echo "<p>
      Фотография успешно удалена.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  include "footer.php";
?>