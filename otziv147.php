<?php
  $index = 0;
  if ($_POST ["topic_index"] > 0)
  {
    $dirct = "gb".$_POST ["topic_index"];
    $nom = "connection";  
    $nickNameExist = false;
    onBD1 ($result2, "ACCOUNTS");
    while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
      if ($row2 [0] == $_POST ["nickName"])
      {
        $nickNameExist = true;
        if ($row2 [2] == $_POST ["password"])
        {
          ob_start ();
          setcookie ("account", $_POST ["nickName"]." ".$_POST ["password"]);
          echo "<meta name='robots' content='noindex'/>";
          $otziv4 = strip_tags ($_POST ["otziv"]);
          $otziv4 = substr ($otziv4, 0, 4500);
          $otznam = $nom.time ()."t".$row2 [3];
          $hdl = fopen ($dirct."/".$otznam, "w+");
          fwrite ($hdl, $otziv4);
          fclose ($hdl);
          $_GET ["id"] = $_POST ["topic_index"];
          include "topics.php";
          ob_end_flush ();
        }
        else
        {
          echo "<meta name='robots' content='noindex'/>";
          include "menu.php";
          echo "<p>
            Ошибка: неверный пароль!
            </p>";
          break;
          include "footer.php";
        }
      }
    if (!$nickNameExist)
    {
      echo "<meta name='robots' content='noindex'/>";
      include "menu.php";
      echo "<p>
        Ошибка: данный никнейм не зарегистрирован.
        </p>";      
      include "footer.php";
    }
  }
  else
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
      echo "<p>
        Кажется, Вы ошиблись страницей.
      </p>";
    break;    
    include "footer.php";
  }
  function onBD1 ($result, $table_name)
  {
    connect_to_DB ($conn);
    $result = mysqli_query($conn, "SELECT * FROM ".$table_name);
    if (!$result)
    {
      echo "Can't select from ".$table_name";
      return;
    }
  }
?>