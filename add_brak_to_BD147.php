<meta name="robots" content="noindex"/>
<?php $index = 0;
  include "menu.php";
  if ($_POST ["account"] > 0)
  {
    include "functions147.php";
    $id = 0;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  if ($row [9] > $id)
  	    $id = $row [9];
    toBD ($result, ($id + 1), $_POST ["wife"], $_POST ["husbend"], $_POST ["account"]);
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  function toBD ($result, $id, $mother, $father, $account)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ($conn, "INSERT INTO PEOPLE VALUES('virt', 'NULL', 'NULL', 0, 0, 0, 0, 0, 0, '".$id."', '".$mother."', '".$father."', 0, 'NULL', 'NULL', ".$account.", 0, 0, 0, 0)");
    if (!$result)
    {
	  echo "Can't insert into PEOPLE";
	  return;
    }
    echo "<p>
      Информация о браке успешно загружена.
      </p>";    
    include "footer.php";
  }
?>