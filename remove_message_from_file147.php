<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_POST ["message"])
  {
    include "menu.php";
    $m1 = $_POST ["message"];
    $nom = "connection";
    $dirct = "gb".$_POST ["topic"];
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
      Сообщение успешно удалено.
      </p>";
    include "footer.php";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";   
?>