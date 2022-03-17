<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "functions147.php";
  include "menu.php";
  if ($_POST ["virt"] > 0)
  {
    fromBD($result, "PEOPLE", $_POST ["virt"]);
    echo "<p>
      Информация о браке успешно удалена.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";   
  include "footer.php";
?>