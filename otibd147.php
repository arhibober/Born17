<?php $index = 0;
  include "menu.php";
  include "functions147.php";
  if ($_POST ["head"] != "")
  { 
    $i = 0;
    onBD ($result, "TOPICS");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] > $i)
        $i = $row [0];
    toBD ($result, $i + 1, $_POST ["head"]);
    mkdir ("gb".($i + 1));
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";
  function toBD ($result, $id, $head)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ("INSERT INTO TOPICS VALUES('".$id."', '".$head."')", $conn);
    if (!$result)
    {
      echo "Can't insert into TOPICS";
      return;
    }
    echo "<p>
      Новая тема форума успешно открыта.
      </p>";
  }
  include "footer.php";
?>