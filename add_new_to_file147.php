<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  if ($_POST ["new_text"] != "")
  {
    $dirct = "news";
    $nom = "new";
    $new2 = strip_tags ($_POST ["new_text"]);
    $new2 = substr ($new2, 0, 9000);
    $otznam = $nom.time ();
    $hdl = fopen ($dirct."/".$otznam, "w+");
    fwrite ($hdl, $new2);
    fclose ($hdl);
    echo "<p>
      Новость успешно загружена.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";  
  include "footer.php";
?>