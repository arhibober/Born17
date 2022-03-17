<meta name="robots" content="noindex"/>
<?php $index = 0;
  include "menu.php";
  if ($_POST ["account"] != "")
  {
    include "functions147.php";
    $id = 0;
    onBD ($result, "ALBUM");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  if ($row [0] > $id)
  	    $id = $row [0];
    toBD ($result, ($id + 1), $_POST ["album_name"], $_POST ["account"]);
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  function toBD ($result, $id, $name, $account)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ("INSERT INTO ALBUM VALUES('".$id."', '".$name."', '".$account."')", $conn);
    if (!$result)
    {
	  echo "Can't insert into ALBUM";
	  return;
    }
    echo "<p>
      Альбом успешно создан.
      </p>";
  }
  include "footer.php";
?>