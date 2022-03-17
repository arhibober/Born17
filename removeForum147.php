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
      Выберите тему, в которой Вы хотите удалить сообщение
      </h3>
      <form method='post' action='removeMessageFromTopic147.php'>
      <p>
        <select size='1' name='topics'>";
        onBD ($result, "TOPICS");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          echo "<option value='".$row [0]."'/>".$row [1];
        echo "</select><br/>
        <input type='submit' value='OK'/>
      </p>
    </form>"; 
  }
  else
    echo "Кажется, вы ошиблись страницей.";
  include "footer.php";
?>