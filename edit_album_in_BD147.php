<meta name="robots" content="noindex"/>
<?php
  $index = 0;  
  include "menu.php";
  if ($_POST ["album_name"] != "")
  {
    include "functions147.php";
    editDB ($result, "ALBUM", $_POST ["album_id"], "NAME", $_POST ["album_name"]);
    echo "<p>
      Название альбома успешно отредактировано.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";  
  include "footer.php";
?>