<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  if ($_POST ["news"])
  {
    $dirct = "news";
    $nom = "new";
    $new2 = strip_tags ($_POST ["new_text"]);
    $j = 0; 
    $dirct_open = opendir ($dirct);
    while ($file = readdir ($dirct_open)) 
      if (strstr ($file, $nom) == true)
      {
        $j++;
        if ($j == $_POST ["news"])
        {
          $new2 = substr ($new2, 0, 9000);
          $hdl = fopen ($dirct."/".$file, "w+");
          fwrite ($hdl, $new2);
          fclose ($hdl);
          echo "<p class='cent'>
            Ошибка в новости исправлена.
            </p>";
        }
      }
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  include "footer.php";
?>