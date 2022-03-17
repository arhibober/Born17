<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  if ($_POST ["sernames"])
  {
    include "functions147.php";
    fromBD ($result, "HUSBEND_SERNAMES", $_POST ["sernames"]);
    echo "<p>
      Дополнительная фамилия успешно удалена.
      </p>";
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";
?>