<?php $index = 0;
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
  	  <form action='removeAlbum147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
      }
    if ($isNickname == false)
    {
      echo "<meta name='robots' content='noindex'/>";
      include "menu.php";
      echo "<p>
        Вы ввели несуществующий логин! Попробуйте авторизироваться заново.
        </p>
        <form action='removeAlbum147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["remove_album"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["remove_album"];
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
    onBD ($result, "HUSBEND_SERNAMES");
    while ($row = mysqli_fetch_array($result))
    {
      onBD ($result1, "PEOPLE");
      while ($row1 = mysqli_fetch_array($result1))
        if (($row1 [9] == $row [1]) && ($row1 [15] == $_POST["rhs"]))
          $i++;
    }
    if ($i > 0)
    {
      onBD ($result, "HUSBEND_SERNAMES");
      while ($row = mysqli_fetch_array($result))
      {
        onBD ($result1, "PEOPLE");
        while ($row1 = mysqli_fetch_array($result1))
        if (($row1 [9] == $row [1]) && ($row1 [15] == $_POST["rhs"]))
        {
          $temp = $row[0];
          break;
        }
      }
      include "footer.php";
    }
    else
      $temp = 1;
    if (!isset ($_GET ["sernames"]))
      $ind = $temp;
    else
      $ind = $_GET ["sernames"];
    if ($i > 0)
    {
      echo "<form name='sernames' method='post' action='rhsfbd147.php' onsubmit='return submitRemove (this)'>
        <p>
        Выберите из списка дополнительных фамилий людей ту, которую Вы хотите удалить:<br/>
        <select size='1' name='sernames' id='ind' onchange='submitForm(\"removeHusbendSername147\")'>";
          onBD ($result, "HUSBEND_SERNAMES");
          while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          {
            onBD ($result1, "PEOPLE");
      	    while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
      	      if (($row1 [9] == $row [1]) && ($row1 [15] == $_POST["rhs"]))
      	      {
                echo "<option value='".$row [0]."'";
                if ($ind == $row [0])
                  echo " selected";
                echo "/>".$row [2];
              }
          }
        echo "</select><br/>
        <div id='dest'>
        <p>
        Имя человека при рождении: ";
        onBD ($result, "HUSBEND_SERNAMES");
        while ($row = mysqli_fetch_array($result))
          if ($ind == $row [0])
          {
            onBD ($result1, "PEOPLE");
            while ($row1 = mysqli_fetch_array($result1))
              if ($row [1] == $row1 [9])
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
          }
        echo "</p>
        </div>
        <p>
        <input type='submit' value='Удалить'/>
        </p>
      </form>";
    }
    else
      echo "Ни у одного из Ваших родственников на сайте пока не было указано дополнительной фамилии.";  
  }  
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($accountID == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на страницу для удаления с сайта лишних собственных альбомов с родственниками. Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
      <form action='removeAlbum147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
function submitRemove (f)
{
  if (!f.NickName)
  {
    if (confirm ("Вы уверены, что хотите удалить эту дополнительную фамилию этого человека?"))
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