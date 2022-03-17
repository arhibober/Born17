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
  	    <form action='editForumUser147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
          <form action='editForumUser147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["efu"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["efu"];
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
    echo "<h3>
      Выберите тему, в которой Вы хотите редактировать сообщение
      </h3>
      <form method='post' action='editMessageUser147.php' onSubmit='return overify(this)'>
        <p>
          <select size='1' name='topics'>";
          onBD ($result, "TOPICS");
          while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
            echo "<option value='".$row [0]."'/>".$row [1];
          echo "</select><br/>
          <input type='hidden' name='account' value='".$accountID."'/>
          <input type='submit' value='OK'/>
        </p>
      </form>";
  }  
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($_POST ["efu"] == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на выбор темы для редактирования собственного сообщения. Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
      <form action='editForumUser147.php' name='enter' onSubmit='return overify(this)' method='post'>
      <p>
      Ваш никнейм:<br/>
      <input type='text' name='nickName'/><br/>
      Ваш пароль:<br/>
      <input type='password' name='password'/><br/>
      <input type='submit' value='Войти'/>
      </p>
      </form>";
  }
  include "footer.php";
?>

<script language="javascript">
  function overify (f)
  {
    b = true;
    if (f.NickName)
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
</script>