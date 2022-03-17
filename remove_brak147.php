<script type="text/javascript" src="ajax.js"></script>
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
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
  	  <form action='remove_brak147.php' name='enter' onSubmit='return overify(this)' method='post'>
          <p>
          Ваш никнейм:<br/>
          <input type='text' name='nickName'/><br/>
          Ваш пароль:<br/>
          <input type='password' name='password'/><br/>
          <input type='submit' value='Войти'/>
          </p>
          </form>";   
        include "footer.php";
      }
    }
    if ($isNickname == false)
    {
      echo "<meta name='robots' content='noindex'/>";
      include "menu.php";
      echo "<p>
        Вы ввели несуществующий логин! Попробуйте авторизироваться заново.
        </p>
          <form action='remove_brak147.php' name='enter' onSubmit='return overify(this)' method='post'>
        <p>
        Ваш никнейм:<br/>
        <input type='text' name='nickName'/><br/>
        Ваш пароль:<br/>
        <input type='password' name='password'/><br/>
        <input type='submit' value='Войти'/>
        </p>
        </form>";   
      include "footer.php";
    }
  }
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["remove_brak"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["remove_brak"];
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
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if (($row [0] == "virt") && ($row [15] == $accountID))
        $i++;
    if ($i > 0)
    {
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if (($row [0] == "virt") && ($row [15] == $accountID))
        {
          $temp = $row[9];
          break;
        }
    }
    else
      $temp = 1;
    if (!isset ($_GET ["virt"]))
      $ind = $temp;
    else
      $ind = $_GET ["virt"];
    if ($i > 0)
    {
      echo "<h3>
        Удалите недействительную информацию о бездетной брачной связи
        </h3>
        <form method='post' name='form' action='remove_brak_from_BD147.php' entype=
        'multipart/form-data' onSubmit='return submitRemove(this)'>
        <p>
        Выберите индекс брака (соответствует индексу так называемого \"виртуального\" ребёнка от этого брака):
        <br/>   
        <select name='virt' size='1' id='ind' onchange='submitForm(\"remove_brak147\")'>";
      onBD ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if (($row [0] == "virt") && ($row [15] == $accountID))
        {
          echo "<option value='".$row [9]."'";
          if ($row [9] == $ind)
            echo " selected";
          echo "/>".$row [9];
        }
      echo "</select><br/>
      </p>
      <div id='dest'>";
        onBD ($result, "PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if (($row [9] == $ind) && ($row [15] == $accountID))
          {
            echo "<p>
              Брак установлен между родственниками ";
      	    onBD($result1, "PEOPLE");
      	    while ($row1 = mysqli_fetch_array($result1))      	  
      	      if ($row1 [9] == $row [10])
      	      {
      	        if ($row1 [2] != "NULL")
                  echo $row1 [2];
                else
                  echo "?";
                if ($row1 [0] != "NULL")
                  echo " ".$row1 [0];
                else
                  if ($row1 [2] != "NULL")
                    echo " ?";
                if ($row1 [1] != "NULL")
                  echo " ".$row1 [1];
                else
                  echo "";
      	      }
      	    onBD ($result1, "PEOPLE");
      	    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
              if ($row1 [9] == $row [11])
      	      {
                echo " и ";
      	        if ($row1 [2] != "NULL")
                  echo $row1 [2];
                else
                  echo "?";
                if ($row1 [0] != "NULL")
                  echo " ".$row1 [0];
                else
                  if ($row1 [2] != "NULL")
                    echo " ?";
                if ($row1 [1] != "NULL")
                  echo " ".$row1 [1];
                else
                  echo "";
      	      }
          }
      echo "</p>
        </div>
        <p>
        <input type='submit' name='save' value='Удалить'/>
        </p>
        </form>";
    }
    else
      echo "<p>
        Ни об одном бездетном браке между Вашими родственниками на сайте информации не содержится.
      </p>";
  }    
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($accountID == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на страницу для удаления с сайта недействительных данных о бездетных брачных сязях между своими родственниками. Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
      <form action='remove_brak147.php' name='enter' onSubmit='return overify(this)' method='post'>
      <p>
      Ваш никнейм:<br/>
      <input type='text' name='nickName'/><br/>
      Ваш пароль:<br/>
      <input type='password' name='password'/><br/>
      <input type='submit' value='Войти'/>
      </p>
      </form>";   
    include "footer.php";
  }  
?>
<script language='javascript'>
  function submitRemove(f)
  {
    if (!f.NickName)
    {
      if (confirm("Вы уверены, что хотите удалить информацию о браке между этими родственниками?"))
	return true;
      else
	return false;
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