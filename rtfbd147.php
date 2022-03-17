<meta name="robots" content="noindex"/>
<?php
  $index = 0;  
  include "menu.php";
  if ($_POST ["topics"])
  {
    include "functions147.php";
    $dir = "gb".$_POST ["topics"];
    $hdl = opendir ($dir);
    while ($file = readdir ($hdl))
    {   
      if ($file == "." || $file == "..")
  	continue;
      unlink($dir."/".$file);
    }
    closedir ($hdl);
    rmdir ($dir);
    fromBD ($result, "TOPICS", $_POST ["topics"]);
    echo "<p>
      Тема успешно удалена.
      </p>";
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";
?>