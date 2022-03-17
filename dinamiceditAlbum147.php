<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET [ind] > 0)
  {
    include "functions147.php";    
      onBD ($result, "ALBUM");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ($row [0] == $_GET [ind])
          echo "<p>
            <input type='text' name='album_name' value='".$row [1]."'/>
            <input type='hidden' name='album_id' value='".$row [0]."'/>
            </p>";
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>