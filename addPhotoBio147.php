<?php
  $index = 0;
  if ($_GET ["cursor"] == "")
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  else
  {
    $f = fopen ("photo_bio/r".$_GET [rel_id]."_ib".$_GET [cursor], "w");
    fclose ($f);  
    $hdl1 = opendir ("photo_bio");
    while ($file = readdir ($hdl1))
    {
      $pf = strstr ($file, "i", true);
      if (strstr ($pf, $_GET [rel_id]))
        $a [] = $file;
    }
    for ($i = 0; $i < sizeof ($a); $i++)
      $b [$i] = (integer)(substr (strstr ($a [$i], "ib"), 2, strlen (strstr ($a [$i], "ib")) - 2));
    sort ($b);
    for ($i = 0; $i < sizeof ($b); $i++)
      echo "<p>
        Выберите иллюстрацию на своём компьютере для позиции биографии №".$b [$i].":<br/>
        <input name='photo_bio".$i."' type='file'/>
        </p>";
  }
?>