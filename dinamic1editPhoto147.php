<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_GET [ind] > 0)
  {
    include "functions147.php";
    onBD ($result, "PHOTO");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_GET [ind])
      {
        $dirct = "Albums";
        $hdl = opendir ($dirct);
        while ($file = readdir ($hdl)) 
          if (strstr ($file, "PHOTO".$row [0].".") == true)
          {
            echo "<p>
              <img src='Albums/".$file."'/ style='width: 600px' alt=''/><br/>
              Отредактируйте описание к фотографии:<br/>
              <input type='text' name='description' value='";
            if ($row [1] != "NULL")
              echo $row [1];
            echo "'/>
              <input type='hidden' name='photo_id' value='".$row [0]."'/><br/>
              Название альбома с фотографией:<br/>
              <select name='album' size='1' id='ind'>";
              onBD ($result1, "ALBUM");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if ($row1 [2] == $_GET [ind1])
                {
                  echo "<option value='".$row1 [0]."'";
                  if ($row1 [0] == $row [2])
                    echo " selected";
                  echo "/>".$row1 [1];
                }
              echo "</select>";
          }
          echo "</p>";
          break;
      }
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
?>