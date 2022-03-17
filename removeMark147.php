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
  	  <form action='removeMark147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
        <form action='removeMark147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["remove_mark"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["remove_mark"];
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
    $isCurrent = false;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [15] == $accountID)
      {
        onBD ($result1, "PHOTO_PEOPLE");
        while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
          if ($row1 [2] == $row [9])
          {
            $isCurrent = true;
            break;
          }
      }
    if ($isCurrent)
    {
      echo "<h3>
        Удалите лишние отметки своих родственников на фотографиях
        </h3>
        <p>
        Выберите номер отметки:
        <select name='mark' size='1' id='ind' onchange='submitForm(\"removeMark147\")'>";
        onBD ($result, "PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if ($row [15] == $accountID)
          {
            onBD ($result1, "PHOTO_PEOPLE");
            while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
              if ($row1 [2] == $row [9])
                echo "<option value='".$row1 [0]."'/>".$row1 [0];
          }
        echo "</select>
          </p>
          <form action='remove_mark_from_BD147.php' method='post' name='form' onSubmit='return submitRemove
            (this)'>
          <p>
          <div id='dest'>";
        $wasMark = false;
        onBD ($result, "PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if ($row [15] == $_POST ["remove_mark"])
          {
            onBD ($result1, "PHOTO_PEOPLE");
            while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
              if ($row [9] == $row1 [2])
              {
                $dirct = "Albums";
                $hdl = opendir ($dirct);
                while ($file = readdir ($hdl)) 
                  if (strstr ($file, "PHOTO".$row1 [1].".") == true)
                  {
                    echo "<p>
                      <img src='Albums/".$file."' style='width: 600px'/><br/>
                        Отмеченный родственник: ";                     
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
                    echo "<br/>
                      <input type='hidden' name='mark1' value='".$row1 [0]."'/>
                      </p>";
                  }
                $wasMark = true;
                break;
              }
            if ($wasMark)
              break;
        }
        echo "</div>
          <p>
          <input type='submit' value='OK'/>
          </p>
          </form>";
    }
    else
      echo "Вы пока не отметили на фотохостинге этого сайта ни одного своего родственника";
    include "footer.php";
  }
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($accountID == ""))
  {
  	echo "<meta name='robots' content='noindex'/>";
  	include "menu.php";
    echo "<p>
      Вы зашли на страницу для удаления с сайта лишних отметок собственных родственников с фотографий. Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
      <form action='removeMark147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if (!f.NickName)
  {
    if (confirm ("Вы уверены, что хотите удалить эту отметку?"))
      b = true;
    else
      b = false;
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