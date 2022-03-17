<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  if ($_POST ["nickName"])
  {
    $nickNameExist = false;
    onBD ($result, "ACCOUNTS");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_POST ["nickName"])
      {
        $nickNameExist = true;
        if ($row [2] == $_POST ["password"])
        {
      	  ob_start ();
      	  setcookie ("account", $_POST ["nickName"]." ".$_POST ["password"]);
      	  echo "<meta name='robots' content='noindex'/>";
          include "menu.php";
          echo "<p>
            Вы зашли на сайт как ".$row [0].
            "</p>
          <form method='post' action='otibd147.php' onSubmit='return overify (this)'>
            <p>
              Введите название новой темы:<br/>
              <input type='text' name='head' style='width: 500px'/><br/>
              <input type='submit' value='Добавить'/>
            </p>
          </form>";
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
  function onBD ($result, $table_name)
  {
    connect_to_DB ($conn);
    $result = mysqli_query ("SELECT * FROM ".$table_name, $conn);
    if (!$result) {
	  echo " Can't select from (."$table_name.") ";
	  return;
    }
  }
?>

<script language="javascript">
  function overify (f)
  {
	b = true;
	if (f.head.value.length == 0)
	{
	  alert ("Вы не ввели название новой темы!");
	  b = false;
	}
	if (f.head.value.indexOf (">") != -1)
	{
	  alert ("Название новой темы содержит закрывающийся тег XML!");
	  b = false;
	}
	if (f.head.value.indexOf ("<") != -1)
	{
	  alert ("Название новой темы содержит открывающийся тег XML!");
	  b = false;
	}
	if (f.head.value.indexOf ("'") != -1)
	{
	  alert ("Название новой темы содержит одинарные кавычки!");
	  b = false;
	}
	if (f.head.value.indexOf ("\"") != -1)
	{
	  alert ("Название новой темы содержит двойные кавычки!");
	  b = false;
	}
	if (f.head.value.indexOf ("&") != -1)
	{
	  alert ("Название новой темы содержит амперсант!");
	  b = false;
	}
	return b;
  }  
</script>