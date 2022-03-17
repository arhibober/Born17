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
  	        <form action='addHusbandSername147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  	    <form action='addHusbandSername147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
       if ((!isset ($_COOKIE ["account"])) && ($_POST ["ahs"] != ""))
      {
        $isNickname = false;
  	$accountID = $_POST ["ahs"];
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
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array($result))
      if (($row [0] != "virt") && ($row [15] == $accountID))
        $i++;
    if ($i > 0)
    {
      echo "<h3>
        Выберите человека, для которого Вы хотите добавить дополнительную фамилию:
        </h3>
        <form method='post' name='form' action='ahstbd147.php' onSubmit='return overify (this)'>
          <p>
            <select size='1' name='people'>";
            onBD ($result, "PEOPLE");
            while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
              if (($row [0] != "virt") && ($row [15] == $accountID))
              {
                echo "<option value ='".$row [9]."'";
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
          Введите новую фамилию:<br/>
          <input type='hidden' name='account' value='".$accountID."'/>
          <input type='text' name='sername'/><br/>
          <input type='submit' value='Добавить'/>
        </p>
      </form>";
    }
    else
      echo "<p>
        Ни об одном из Ваших родственников на этом сайте данных пока нет.
      </p>";
  }
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($_POST ["ahs"] == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на страницу добавления на сайт дополнительных фамилий своих родственников. Для доступа к
        этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
  	  <form action='addHusbendSername147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
    if (!f.nickName)
    {
      b = true;
      if (f.sername.value.length == 0)
      {
        alert ("Вы не ввели новую фамилию!");
        b = false;
      }
      if (f.sername.value.indexOf(">") != -1)
      {
        alert ("Фамилия содержит закрывающийся тег XML!");
        b = false;
      }
      if (f.sername.value.indexOf ("<") != -1)
      {
        alert ("Фамилия содержит открывающийся тег XML!");
        b = false;
      }
      if (f.sername.value.indexOf (".") != -1)
      {
        alert ("Фамилия содержит точку!");
        b = false;
      }
      if (f.sername.value.indexOf ("'") != -1)
      {
        alert ("Фамилия содержит одинарные кавычки!");
        b = false;
      }
      if (f.sername.value.indexOf ("\"") != -1)
      {
        alert ("Фамилия содержит двойные кавычки!");
        b = false;
      }
      if (f.sername.value.indexOf ("&") != -1)
      {
        alert ("Фамилия содержит амперсант!");
        b = false;
      }
	}
    else
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