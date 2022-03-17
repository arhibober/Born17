<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "functions147.php";
  include "menu.php";
  if ($_POST ["rels"] > 0)
  {
    if (file_exists ("bio".$_POST ["rels"].".txt"))
      unlink ("bio".$_POST ["rels"].".txt");  
    $hdl = opendir ("photo_bio");
    while ($file = readdir ($hdl))
    {
      $pf = strstr ($file, "i", true);
      if (substr ($pf, 1, strlen ($pf) - 2) == $_POST ["rels"])
        unlink ("photo_bio/".$file);
    }
    $hdl1 = opendir ("links");    
    while ($file = readdir ($hdl1))
    {
      $pf = strstr ($file, "s", true);
      if (substr ($pf, 1, strlen ($pf) - 2) == $_POST ["rels"])
        unlink ("links/".$file);
    }
    fromBD ($result, "PEOPLE", $_POST ["rels"]);
    $dirct = "portraits";
    $hdl2 = opendir ($dirct);
    while ($file = readdir ($hdl2))
      if (strstr ($file, "PHOTO".$_POST ["rels"].".") == true)
      {
        unlink ("portraits/".$file);
        break;
      }
    $hdl3 = opendir ($dirct);
    while ($file = readdir ($hdl3))
      if (strstr ($file, "bio".$_POST ["rels"]."_") == true)
        unlink ($file);
    echo "<p>
      Сведения успешно удалены.
      </p>";
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  include "footer.php";
?>