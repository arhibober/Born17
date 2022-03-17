<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  if ($_POST ["mark1"])
  {
    include "functions147.php";
    fromBD ($result, "PHOTO_PEOPLE", $_POST ["mark1"]);
    echo "<p>
      Отметка успешно удалена.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";   
  include "footer.php";
?>