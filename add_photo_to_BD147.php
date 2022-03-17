<meta name="robots" content="noindex"/>
<?php
  $index = 0;  
  include "menu.php";
  if ($_POST ["account"] != "")
  {
    include "functions147.php";
    $id = 0;
    onBD ($result, "PHOTO");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  if ($row [0] > $id)
  	    $id = $row [0];
    $description = $_POST ["description"];
    if ($_POST ["description"] == "")
      $description = "NULL";
    if (is_uploaded_file ($_FILES ["myfile"]["tmp_name"]))
    {
      // Если файл загружен успешно, перемещаем его
      // из временной директории в конечную
      move_uploaded_file ($_FILES ["myfile"]["tmp_name"], "C:/xampp/htdocs/Born17/Albums/PHOTO".
        ($id + 1).substr ($_FILES ["myfile"]["name"], strlen ($_FILES ["myfile"]["name"]) - 4, 4));
      echo "<p>Фотография успешно загружена.</p>";
      toBD ($result, ($id + 1), $description, $_POST ["album"]);
      mkdir ("photo".($id + 1));
    } 	
    else
    {
      echo "<p class='cent'>Ошибка загрузки фотографии.</p>";
      exit;
    }
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  include "footer.php";
  function toBD($result, $id, $name, $album)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ("INSERT INTO PHOTO VALUES('".$id."', '".$name."', '".$album."')", $conn);
    if (!$result)
    {
      echo "Can't insert into ALBUM";
      return;
    }
    echo "<p>
      Информация о фотографии успешно сохранена.
      </p>";
  }
?>