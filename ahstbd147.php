<meta name="robots" content="noindex"/>
<?php
  $index = 0;  
  include "menu.php";
  if ($_POST ["account"] != "")
  {
    include "functions147.php";
    $i = 0;
    onBD ($result, "HUSBEND_SERNAMES");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] > $i)
        $i = $row [0];
    toBD ($result, $i + 1, $_POST["people"], $_POST["sername"]);
  }
  else
    echo "<p>
      Кажется, Вы ошиблись страницей.
      </p>";  
  include "footer.php";
  function toBD ($result, $index, $women, $sername)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ($conn, "INSERT INTO HUSBEND_SERNAMES VALUES('".$index."', '".$women."',       '".$sername."')");
    if (!$result)
    {
      echo "Can't insert into HUSBEND_SERNAMES";
      return;
    }
    echo "<p>
      Дополнительная фамилия человека успешно загружена.
      </p>";
  }
?>