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
    	    <form action='editAlbum147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
        <form action='editAlbum147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["edit_album"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["edit_album"];
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
      Отредактируйте названия своих фотоальбомов
      </h3>
      <p>
      <select name='album' size='1' id='ind' onchange='submitForm(\"editAlbum147\")'>";
      onBD ($result, "ALBUM");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ($row [2] == $accountID)
          echo "<option value='".$row [0]."'/>".$row [1];
      echo "</select>
        </p>
        <form action='edit_album_in_BD147.php' onsubmit='return overify (this)' method='post' name='form'>
        <p>
        Отредактируйте название альбома:</p>
        <div id='dest'>";    
      onBD ($result, "ALBUM");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [2] == $_POST ["edit_album"])
      {
        echo "<p>
          <input type='text' name='album_name' value='".$row [1]."'/>
          <input type='hidden' name='album_id' value='".$row [0]."'/>
          </p>";
        break;
      }
    echo "</div>
      <p>
      <input type='submit' value='OK'/>
      </p>
      </form>";
  }
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($_POST ["edit_album"] == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
  	include "menu.php";
    echo "<p>
      Вы зашли на страницу редактирования названия фотоальбомов со своими родственниками. Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
      <form action='editAlbum147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
    if (!f.NickName)
    {
      if (f.album_name.value.length == 0)
      {
        alert ("Вы стёрли название альбома вообще!");
        b = false;
      }
      if (f.album_name.value.indexOf (">") != -1)
      {
        alert ("Название альбома содержит закрывающийся тег XML!");
        b = false;
      }
      if (f.album_name.value.indexOf ("<") != -1)
      {
        alert ("Название альбома содержит открывающийся тег XML!");
        b = false;
      }
      if (f.album_name.value.indexOf (".") != -1)
      {
        alert ("Название альбома содержит точку!");
        b = false;
      }
      if (f.album_name.value.indexOf ("'") != -1)
      {
        alert ("Название альбома содержит одинарные кавычки!");
        b = false;
      }
      if (f.album_name.value.indexOf ("\"") != -1)
      {
        alert ("Название альбома содержит двойные кавычки!");
        b = false;
      }
      if (f.album_name.value.indexOf ("&") != -1)
      {
        alert ("Название альбома содержит амперсант!");
        b = false;
      }
      if (f.album_name.value.indexOf (">") != -1)
      {
        alert ("Название альбома содержит закрывающийся тег XML!");
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