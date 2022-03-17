<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  if (isset ($_COOKIE ["account"]))
  {
    $i = 0;
    while (substr ($_COOKIE ["account"], $i, 1) != " ")
      $i++;
    $login = substr ($_COOKIE ["account"], 0, $i);
  }
  if ($login == "Архибобёр")
  {
    echo "<h3>
      Выберите фотографию, к которой Вы хотите удалить лишний комментарий:
      <h3>
      <form method='post' action='removeCommentPhoto147.php'>
      <p>
        <select size='1' name='photo' id='ind' onChange='submitForm(\"editChoiseComment147\")'>";
        onBD ($result, "PHOTO");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        {
          echo "<option value='".$row [0]."'/>";
          $hdl = opendir ("Albums");
          while ($file = readdir ($hdl)) 
            if (strstr ($file, "PHOTO".$row [0].".") == true)
              echo $file;
        }
        echo "</select>
    <div id='dest'>";
    onBD ($result, "PHOTO");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
    {
      $hdl = opendir ("Albums");
      while ($file = readdir ($hdl)) 
        if (strstr ($file, "PHOTO".$row [0].".") == true)
          echo "<p>
            <img src='Albums/".$file."' style='width: 600px'/>";
      break;
    }
    echo "</p>
      </div>
      <p>
        <input type='submit' value='OK'/>
      </p>
    </form>";
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";
?>