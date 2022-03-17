<meta name="robots" content="noindex"/>
<?php
  $index = 0;  
  include "menu.php";
  include "functions147.php";
  if ($_POST ["photo"] != "")
  {
    $id = 0;
    onBD ($result, "PHOTO_PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  if ($row [0] > $id)
  	    $id = $row [0];
    toBD ($result, ($id + 1), $_POST ["photo"], $_POST ["people"]);
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";  
  include "footer.php";
  function toBD ($result, $id, $photo, $people)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ("INSERT INTO PHOTO_PEOPLE VALUES('".$id."', '".$photo."', '".$people."')", $conn);
    if (!$result)
    {
	  echo "Can't insert into ALBUM";
	  return;
    }
    echo "<p>
      Человек успешно отмечен на фотографии.
      </p>";
  }
?>