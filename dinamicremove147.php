<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET ["ind"] > 0)
  {
    $ind = $_GET ["ind"];
    echo "<p>
      <a href='data.php?id=".$ind."'>Просмотреть дополнительные данные о родственнике</a>
      </p>";
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>