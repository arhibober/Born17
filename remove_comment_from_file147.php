<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  if ($_POST ["comment"])
  {
    $m1 = $_POST ["comment"];
    $nom = "comment";
    $dirct = "photo".$_POST ["photo"];
    $hdl = opendir ($dirct);
    $j = 0;
    while ($file = readdir ($hdl))
      if (strstr ($file, $nom) == true)
      {
        $j++;
        if ($m1 == $j)
          unlink ($dirct."/".$file);
      }
    echo "<p>
      Комментарий успешно удалён.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";   
  include "footer.php";
?>