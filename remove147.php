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
    	    <form action='remove147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
          <form action='remove147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["remove"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["remove"];
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
    while($row = mysqli_fetch_array ($result, MYSQLI_NUM))
    if ($row [15] == $accountID)
      $i++;
    if ($i > 0)
    {
      onBD ($result, "PEOPLE");
      while($row = mysqli_fetch_array( $result))
        if ($row [15] == $accountID)
        {
          $temp = $row[9];
          break;
        }
    }
    else
      $temp = 1;
    if (!isset($_GET["rels"]))
      $ind = $temp;
    else
      $ind = $_GET["rels"];
    if ($i > 0)
    {
      echo "<form method='post' name='form' action='remove_rel147.php' enctype='multipart/form-data' onSubmit='return submitRemove (this)'>
      <p>
      Выберите родственника, досье которого Вы хотите удалить<br/>
      <select size='1' name='rels' id='ind' onchange='submitForm(\"remove147\")'>";
      onBD($result, "PEOPLE");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	if (($row [0] != "virt") && ($row [15] == $accountID))
  	{      
          echo "<option value='".$row [9]."'";
          if ($row [9] == $ind)
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
      echo "</select>
      </p>
      <div id='dest'>
        <p>
          <a href='data.php?id=".$ind."'>Просмотреть дополнительные данные о родственнике</a>
        </p>
      </div>
      <p>
        <input type='submit' value='Удалить досье родственника'/>
      </p>
      </form>";
    }
    else
      echo "<p>
        Ни об одном Вашем родственнике в базе данных сведений пока не содержится.
        </p>";
    include "footer.php";      
  }
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($accountID == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<p>
      Вы зашли на страницу для удаления с сайта лишних досье своих родственников. Для доступа к этому сервису авторизируйтесь, пожалуйста, на сайте.
      </p>
  	<form action='remove147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  function submitRemove (f)
  {
    if (!f.NickName)
    {
      if (confirm ("Вы уверены, что хотите удалить досье родственника " + f.rels.options[f.rels.selectedIndex].text + "?"))
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