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
  	    <form action='editPhoto147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
         <form action='editPhoto147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["edit_photo"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["edit_photo"];
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
      Отредактируйте данные о своих фотографиях
      </h3>
      <p>
      <input type='hidden' name='account' id='ind1' value='".$accountID."'/><br/>
      <select name='photo' size='1' id='ind' onchange='submitForm1(\"editPhoto147\")'>";
      onBD ($result, "ALBUM");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ($row [2] == $_POST ["edit_photo"])
        {
          onBD ($result1, "PHOTO");
          while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
            if ($row1 [2] == $row [0])
            {
              echo "<option value='".$row1 [0]."'/>";
              $dirct = "Albums";
              $hdl = opendir ($dirct);
              while ($file = readdir ($hdl)) 
                if (strstr ($file, "PHOTO".$row1 [0].".") == true)
                {
                  echo $file;
                  break;
                }
            }
        }
      echo "</select>
        </p>
        <form action='edit_photo_in_BD147.php' method='post' name='form' onsubmit='return overify (this)'>
        <p>
        <div id='dest1'>";
      $wasPhoto = false;
      onBD ($result, "ALBUM");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ($row [2] == $_POST ["edit_photo"])
        {
          onBD ($result1, "PHOTO");
          while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
            if ($row [0] == $row1 [2])
            {
              $wasPhoto = true;
              $dirct = "Albums";
              $hdl = opendir ($dirct);
              while ($file = readdir ($hdl)) 
                if (strstr ($file, "PHOTO".$row1 [0].".") == true)
                {
                  echo "<p>
                    <img src='Albums/".$file."' style='width: 600px' alt=''/><br/>
                    Отредактируйте описание к фотографии:<br/>
                    <input type='text' name='description' value='";
                  if ($row1 [1] != "NULL")
                    echo $row1 [1];
                  echo "'/>
                    <input type='hidden' name='photo_id' value='".$row1 [0]."'/><br/>
                    Название альбома с фотографией:<br/>
                    <select name='album' size='1'>";
                  onBD ($result2, "ALBUM");
                  while ($row2 = mysqli_fetch_array ($result2, MYSQLI_NUM))
                    if ($row [2] == $_POST ["edit_photo"])
                    {
                      echo "<option value='".$row2 [0]."'";
                      if ($row2 [0] == $row1 [2])
                        echo " selected";
                      echo ">".$row2 [1];
                    }
                  echo "</select>";
              }
            echo "</p>";
            break;
          }
          if ($wasPhoto)
            break;
        }
      echo "</div>
        <p>
        <input type='submit' value='OK'/>
        </p>
        </form>";
  }  
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($_POST ["edit_photo"] == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на страницу редактирования данных о фотографиях, загруженных Вами ранее на сайт. Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
        <form action='editPhoto147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
    if (!f.NickName)
    {
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