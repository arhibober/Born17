<?php
  $index = 0;
  if ($_GET [cursor] == "")
    echo "<p>
    Кажется, Вы ошиблись страницей.
    </p>";
  else
  {
    $f = fopen ("links/r".$_GET [rel_id]."_sb".$_GET [cursor], "w");
    fwrite ($f, "<a href='".$_GET [link]."'>".$_GET [text]."</a>");
    fclose ($f);
    echo "<p>
      Ссылка успешно добавлена.
      </p>";
  }
?>