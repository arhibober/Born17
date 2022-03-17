<?php
  $index = 0;
  $dirct = "photo".$_POST ["photo_id1"];
  $nom = "comment";  
  $nickNameExist = false;
  onBD1 ($result2, "ACCOUNTS");
  while ($row3 = mysqli_fetch_array ($result2, MYSQLI_NUM))
    if ($row3 [0] == $_POST ["nickName"])
    {
      $nickNameExist = true;
      if ($row3 [2] == $_POST ["password"])
      {
        ob_start ();
        setcookie ("account", $_POST ["nickName"]." ".$_POST ["password"]);
        echo "<meta name='robots' content='noindex'/>";
        $otziv4 = strip_tags ($_POST ["otziv"]);
        $otziv4 = substr ($otziv4, 0, 4500);
        $otznam = $nom.time ()."t".$row3 [3];
        $hdl = fopen ($dirct."/".$otznam, "w+");
        fwrite ($hdl, $otziv4);
        fclose ($hdl);
        $_GET ["id"] = $_POST ["photo_id1"];
        include "detail_photo.php";
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
      }
    }
  if (!$nickNameExist)
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Ошибка: данный никнейм не зарегистрирован.
      </p>";
  }
  include "footer.php";
  function onBD1($result, $table_name)
  {
    connect_to_DB ($conn);
    $result = mysqli_query("SELECT * FROM ".$table_name, $conn);
    if (!$result)
    {
	  echo " Can't select from (".$table_name.") ";
	  return;
    }
  }
?>