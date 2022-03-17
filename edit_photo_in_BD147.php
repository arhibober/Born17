<meta name="robots" content="noindex"/>
<?php
  $index = 0;  
  include "menu.php";
  if ($_POST ["photo_id"])
  {
    include "functions147.php";
    $description = $_POST ["description"];
    if ($_POST ["description"] == "")
      $description = "NULL";
    editDB ($result, "PHOTO", $_POST ["photo_id"], "NAME", $description);
    editDB ($result, "PHOTO", $_POST ["photo_id"], "ALBUM", $_POST ["album"]);
    echo "<p>
      Данные о фотографии успешно отредактированы.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  include "footer.php";
?>