<?php
  $index = 0;
  include "functions147.php";
  $accountID = 0;
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
  	  <form action='rlua147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
        <form action='rlua147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["list_age"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["list_age"];
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
    $i = 0;
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if (($row [0] != "virt") && ($row [15] == $accountID) && ($row [0] != "NULL") && ($row [2] != "NULL"))
    $i++;
    if ($i < 0)
      echo "<p>
        Вы пока не загрузили полное имя ни одного своего родственника.
        </p>";
    else
    {
      echo "<h3>
      Список Ваших родственников в хронологическом порядке
      </h3>
      <p>";
      onBDData ($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	if (($row [0] != "virt") && ($row [15] == $accountID) && ($row [0] != "NULL") && ($row [2] != "NULL"))
  	{
  	  echo "<a href='data.php?id=".$row [9]."'>".$row [2]." ".$row [0];
  	  if ($row [1] != "NULL")
  	    echo " ".$row [1];
          if ($row [3] != 0)
          {
            echo " (";
            if ($row [6] == 0)
              echo "р. ";
            echo $row [3];
            if ($row [6] != 0)
              echo "-";
            else
            {
              if ($row [16] != 0)
                echo "-?";
              echo ")";
            }
          }
          if ($row [6] != 0)
          {
            if ($row [3] == 0)
              echo " (ум. ";
            echo $row [6];        
            if (($row [16] != 0) || ($row [17] != 0))
              echo "-?";
            echo ")";
          }
  	      echo "<br/>";
        }
        echo "<br/>
        </p>
        <form action='rel_user147.php' method='post' name='list_abc'>
        <input type='hidden' name='list_abc' value='".$accountID."'/>
        </form>
        <p>
        <a href='javascript:document.forms[\"list_abc\"].submit();'>Список Ваших родственников по алфавиту</a>
        </p>";
      include "footer.php";
    }
  }  
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($accountID == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на страницу для вывода списка всех загруженных Вами когда-либо на сайт досье Ваших
        родственников, в порядке их рождения. Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
      <form action='rlua147.php' name='enter' onSubmit='return overify (this)' method='post'>
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

<script language="javascript">
  function submitRemove (f)
  {
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