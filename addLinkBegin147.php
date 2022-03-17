<?php
  $index = 0;
  if ($_GET ["cursor"] == "")
    echo "<p>
    Кажется, Вы ошиблись страницей.
    </p>";
  else
  {
    $f = fopen ("links_begin/lb".time()."ri".$_GET ["rel_id"]."c".$_GET ["cursor"], "w+");
    fclose ($f);
  }
?>