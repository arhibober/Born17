<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  if ($_POST ["nickName"] > 0)
  {
    $isNickName = false;
    onBD ($result, "ACCOUNTS");
    $i = 0;
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      $i++;
    onBD ($result, "ACCOUNTS");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_POST ["nickName"])
        $isNickName = true;
    if ($isNickName)
      echo "<p>
        Ошибка: такой никнейм уже зарегистрирован.
      </p>";
    else
      toBD ($result, $_POST ["nickName"], $_POST ["email"], $_POST ["password"], $i + 1);
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";
  function toBD($result, $nickName, $email, $password, $id)
  
    connect_to_DB ($conn);
    $result = mysqli_query ($conn, "INSERT INTO ACCOUNTS VALUES('".$nickName."', '".$email."', '".$password."', '".$id."')");
    if (!$result)
    {
      echo "Can't insert into ACCOUNT";
      return;
    }
    echo "<p>
      Регистрация проведена успешно.
      </p>";
  }
?>