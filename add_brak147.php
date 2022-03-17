<?php
  $index = 0;
  include "functions147.php";
  $accounID = 0;
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["nickName"] != ""))
  {
  	$isNickname = false;
  	onBD ($result, "ACCOUNTS");
  	while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  if ($row [0] == $_POST ["nickName"])
  	  {
  	  	$isNickname = true;
  	  	if ($row [2] == $_POST ["password"])
  	  	{
  	  	  $accountID = $row [3];
  	  	  ob_start ();
      	  setcookie ("account", $_POST ["nickName"]." ".$_POST ["password"]);
  	  	}
  	  	else
  	  	{
  	  	  echo "<meta name='robots' content='noindex'/>";
  	          include "menu.php";
  	  	  echo "<p>
  	  	    Вы ввели неверный пароль! Попробуйте авторизироваться заново.
  	  	    </p>
  	  	    <form action='add_brak147.php' name='enter' onSubmit='return overify(this)' method='post'>
            <p>
            Ваш никнейм:<br/>
            <input type='text' name='nickName'/><br/>
            Ваш пароль:<br/>
            <input type='password' name='password'/><br/>
            <input type='submit' value='Войти'/>
            </p>
            </form>";
  	  	}
      }
    if ($isNickname == false)
    {
  	  echo "<meta name='robots' content='noindex'/>";
  	  include "menu.php";
      echo "<p>
        Вы ввели несуществующий логин! Попробуйте авторизироваться заново.
        </p>
  	    <form action='add_brak147.php' name='enter' onSubmit='return overify(this)' method='post'>
        <p>
        Ваш никнейм:<br/>
        <input type='text' name='nickName'/><br/>
        Ваш пароль:<br/>
        <input type='password' name='password'/><br/>
        <input type='submit' value='Войти'/>
        </p>
        </form>";
    }
  }
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["add_brak"] != ""))
  {
    $isNickname = false;
  	$accountID = $_POST ["add_brak"];
  	onBD ($result, "ACCOUNTS");
  	while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  if ($row [3] == $accountID)
  	  {
  	    ob_start ();
        setcookie ("account", $row [0]." ".$row [2]);
  	  }
  }
  if ((isset ($_COOKIE ["account"])) || ($accountID > 0))
  {
  	echo "<meta name='robots' content='noindex'/>";
  	include "menu.php";
    if (isset ($_COOKIE ["account"]))
    {
      $i = 0;
      while (substr ($_COOKIE ["account"], $i, 1) != " ")
        $i++;
      $login = substr ($_COOKIE ["account"], 0, $i);
      onBD ($result, "ACCOUNTS");
      while ($row = mysqli_fetch_array ($result))
        if ($login == $row [0])
          $accountID = $row [3];
    }
    $i = 0;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if (($row [12] == 2) && ($row [0] != "virt") && ($row [15] == $accountID))
        $i++;
    if ($i == 0)
      echo "<p>
        Вы не можете добавить бездетный брак, пока не добавили досье ни одной женщины.
      </p>";
    $j = 0;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if (($row [12] == 1) && ($row [0] != "virt") && ($row [15] == $accountID))
        $j++;
    if (($i == 0) && ($j == 0))
      echo "<br/>";
    if ($j == 0)
      echo "<p>
        Вы не можете добавить бездетный брак, пока не добавили досье ни одного мужчины.";
    if (($i != 0) && ($j != 0))
    {
      echo "<h3>
        Добавьте бездетный брак
        </h3>
        <form method='post' name='form' action='add_brak_to_BD147.php' enctype='multipart/form-data'
          onSubmit='return overify(this)'>
        <p>
        Выберите жену:<br/>   
        <select name='wife' size='1'>";
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if (($row [12] == 2) && ($row [0] != "virt") && ($row [15] == $accountID))
        {
          echo "<option value='".$row [9]."'";
          if ($row [9] == 1)
            echo " selected";
          echo "/>";   
          if ($row [2] != "NULL")
            echo $row [2];
          else
            echo "?";
        if ($row [0] != "NULL")
          echo " ".$row [0];
        else
          if ($row [2] != "NULL")
            echo " ?";
        if ($row [1] != "NULL")
          echo " ".$row [1];
        else
          echo "";
       }
      echo "</select><br/>
      Выберите мужа:<br/>  
      <select name='husbend' size='1'>";
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if (($row [12] == 1) && ($row [0] != "virt") && ($row [15] == $accountID))
        {
          echo "<option value='".$row [9]."'";
          if ($row [9] == 1)
            echo " selected";
          echo "/>";   
          if ($row [2] != "NULL")
            echo $row [2];
          else
            echo "?";
          if ($row [0] != "NULL")
            echo " ".$row [0];
          else
            if ($row [2] != "NULL")
              echo " ?";
          if ($row [1] != "NULL")
            echo " ".$row [1];
          else
            echo "";
        }
      echo "</select><br/>
      <input type='hidden' name='account' value='".$accountID."'/>
      <input type='submit' name='save' value='Добавить'/>
      </p>
      </form>";
    }
  }  
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($_POST ["add"] == ""))
  {
  	echo "<meta name='robots' content='noindex'/>";
  	include "menu.php";
    echo "<p>
      Вы зашли на страницу добавления на сайт информации о бездетном браке между своими родственников на сайт.
        Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
  	  <form action='add_brak147.php' name='enter' onSubmit='return overify(this)' method='post'>
      <p>
      Ваш никнейм:<br/>
      <input type='text' name='nickName'/><br/>
      Ваш пароль:<br/>
      <input type='password' name='password'/><br/>
      <input type='submit' value='Войти'/>
      </p>
      </form>";
  }
?>
<script language="javascript">
  function overify (f)
  {
    b = true;
    if (f.nickName)
    {
	  if (f.nickName.value.length == 0)
	  {
	    alert ("Вы не ввели никнейм!");
	    b = false;
	  }
	  if (f.password.value.length == 0)
	  {
	    alert ("Вы не ввели пароль!");
	    b = false;
	  }
	  if (f.nickName.value.indexOf (">") != -1)
	  {
	    alert ("Никнейм содержит закрывающийся тег XML!");
	    b = false;
	  }
	  if (f.nickName.value.indexOf ("<") != -1)
	  {
	    alert ("Никнейм содержит открывающийся тег XML!");
	    b = false;
	  }
	  if (f.nickName.value.indexOf ("'") != -1)
	  {
	    alert ("Никнейм содержит одинарные кавычки!");
	    b = false;
	  }
	  if (f.nickName.value.indexOf ("\"") != -1)
	  {
	    alert ("Никнейм содержит двойные кавычки!");
	    b = false;
	  }
	  if (f.nickName.value.indexOf ("&") != -1)
	  {
	    alert ("Никнейм содержит амперсант!");
	    b = false;
	  }
	  if (f.password.value.indexOf (">") != -1)
	  {
	    alert ("Пароль содержит закрывающийся тег XML!");
	    b = false;
	  }
	  if (f.password.value.indexOf ("<") != -1)
	  {
	    alert ("Пароль содержит открывающийся тег XML!");
	    b = false;
	  }
	  if (f.password.value.indexOf ("'") != -1)
	  {
	    alert ("Пароль содержит одинарные кавычки!");
	    b = false;
	  }
	  if (f.password.value.indexOf ("\"") != -1)
	  {
	    alert ("Пароль содержит двойные кавычки!");
	    b = false;
	  }
	  if (f.password.value.indexOf ("&") != -1)
	  {
	    alert ("Пароль содержит амперсант!");
	    b = false;
	  }
    }
    return b;
  }
  include "footer.php";
</script>