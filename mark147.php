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
  	    <form action='mark147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
          <form action='mark147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["mark"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["mark"];
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
    $isPeople = false;        
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [15] == $accountID)
        $isPeople = true;
    if ($isPeople)
    {
      echo "<h3>
        Отметьте своего родственника на фотографии:
        </h3>
        <form action='add_mark_to_BD147.php' method='post' name='form' onSubmit='return overify (this)'>
        <p>
          Выберите родственника:<br/>
          <select name='people' size='1'>";
          onBD ($result, "PEOPLE");
          while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
            if ($row [15] == $accountID)
            {
              echo "<option value='".$row [9]."'/>";
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
          Выберите фотографию:<br/>
          <select name='photo' size='1' id='ind' onchange='submitForm(\"mark147\")'>";
          onBD ($result, "PHOTO");
          while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          {
            echo "<option value='".$row [0]."'/>";
            $dirct = "Albums";
            $hdl = opendir ($dirct);
            while ($file = readdir ($hdl)) 
              if (strstr ($file, "PHOTO".$row [0].".") == true)
              {
                echo $file;
                break;
              }
          }
          echo "</select></p>
          <div id='dest'>";  
          onBD ($result, "PHOTO");
          while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          {
            $dirct = "Albums";
            $hdl = opendir ($dirct);
            while ($file = readdir ($hdl)) 
              if (strstr ($file, "PHOTO".$row [0].".") == true)
              {
                echo "<p>
                  <img src='Albums/".$file."'/ style='width: 600px'/>
                  </p>";
                break;
              }
            break;
          }
          echo "</div>
          <p>
          <input type='submit' value='OK'/><br/>
          </p>
          </form>";
    }
    else
      echo "<p>
        Вы пока не вставили на сайт данные ни об одном своём родственнике.
        </p>";
  }
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($_POST ["mark"] == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на страницу отметки своих родственников на фотографиях. Для доступа к этому сервису
        авторизируйтесь, пожалуйста, на сайте.
      </p>
  	  <form action='mark147.php' name='enter' onSubmit='return overify(this)' method='post'>
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