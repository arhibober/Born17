<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  if ($_POST ["topic"])
  {
    $dirct = "gb".$_POST ["topic"];
    $nom = "connection";
    $otziv4 = strip_tags ($_POST ["message_text"]);
    $j = 0; 
    $dirct_open = opendir ($dirct);
    while ($file = readdir ($dirct_open)) 
      if (strstr ($file, $nom) == true)
      {
        $j++;
        if ($j == $_POST ["messages"])
        {
          $otziv4 = substr ($otziv4, 0, 4500);
          $hdl = fopen ($dirct."/".$file, "w+");
          fwrite ($hdl, $otziv4);
          fclose ($hdl);
          echo "<p>
            Сообщение отредактировано успешно.
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