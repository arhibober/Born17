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
  	  	    <form action='addPhoto147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  	    <form action='addPhoto147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["add_photo"] != ""))
  {
    $isNickname = false;
  	$accountID = $_POST ["add_photo"];
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
    $isAlbum = false;        
    onBD ($result, "ALBUM");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [2] == $accountID)
        $isAlbum = true;
    if ($isAlbum)
    {
      echo "<h3>
        Загрузите новую фотографию в альбом
        </h3>
        <form action='add_photo_to_BD147.php' onsubmit='return overify (this)' method='post' name='form'
          enctype='multipart/form-data' >
        <p>
          Описание к фотографии (не обязательно):<br/>
          <input type='text' name='description'/><br/>
          Выберите альбом для фотографии:<br/>
          <select name='album' size='1'>";
          onBD ($result, "ALBUM");
          while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
            if ($row [2] == $accountID)
              echo "<option value='".$row [0]."'/>".$row [1];
          echo "</select><br/>
          Загрузите фотографию:<br/>
          <input name='myfile' type='file'/><br/>
          <input type='submit' value='OK'/><br/>
          <input type='hidden' name='account' value='".$accountID."'/>
        </p>
      </form>";
    }
    else
      echo "<p>
        Вы не можете загружать фотографии, пока не выделили для них ни одного альбома.
        </p>";
  }
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($_POST ["add_photo"] == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на страницу добавления на сайт новых фотографий со своими родственниками. Для доступа к этому
        сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
  	  <form action='addPhoto147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
    if (!f.nickName)
	{
      if (f.my_file.value.length == 0)
      {
        alert ("Вы не выбрали файл с фотографией!");
        b = false;
      }
      reg2=/.+\.jpg$/;
      reg3=/.+\.JPG$/;
      reg4=/.+\.gif$/;
      reg5=/.+\.GIF$/;
      reg6=/.+\.bmp$/;
      reg7=/.+\.BMP$/;
      reg8=/.+\.tif$/;
      reg9=/.+\.TIF$/;
      reg10=/.+\.png$/;
      reg11=/.+\.PNG$/;
      if ((f.myfile.value.length!=0) && (!(f.myfile.value.match(reg2))) && 
        (!(f.myfile.value.match(reg3))) && (!(f.myfile.value.match(reg4))) && 
        (!(f.myfile.value.match(reg5))) && (!(f.myfile.value.match(reg6))) && 
        (!(f.myfile.value.match(reg7))) && (!(f.myfile.value.match(reg8))) && 
        (!(f.myfile.value.match(reg9))) && (!(f.myfile.value.match(reg10))) && 
        (!(f.myfile.value.match(reg11))))
      {
        alert ("Ошибка в расширении фотографии!"); 
        b = false;
      }
      if (f.description.value.indexOf (">") != -1)
      {
        alert ("Описание фотографии содержит закрывающийся тег XML!");
        b = false;
      }
      if (f.description.value.indexOf ("<") !=-1)
      {
        alert("Описание фотографии содержит открывающийся тег XML!");
        b = false;
      }
      if (f.description.value.indexOf ("'") !=-1)
      {
        alert ("Описание фотографии содержит одинарные кавычки!");
        b = false;
      }
      if (f.description.value.indexOf("\"")!=-1)
      {
        alert ("Описание фотографии содержит двойные кавычки!");
        b = false;
      }
      if (f.description.value.indexOf("&")!=-1)
      {
        alert ("Описание фотографии содержит амперсант!");
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