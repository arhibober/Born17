<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  if ($_POST ["news"])
  {
    $m1 = $_POST ["news"];
    $nom = "new";
    $dirct = "news";
    $hdl = opendir ($dirct);
    $j = 0;
    while ($file = readdir ($hdl))
      if (strstr ($file, $nom) == true)
   	  {
        $j++;
        if ($m1 == $j)
          unlink ($dirct."/".$file);
   	  }
    echo "<p class='cent'>
      Новость успешно удалена.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  include "footer.php";
?>