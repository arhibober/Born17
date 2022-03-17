<?php
  $index = 0;
  session_start ();
  include "functions147.php";
  $accounID = 0;
  if ((!isset ($_COOKIE ["account"])) && (!isset ($_SESSION ["account"])) && ($_POST ["nickName"] != ""))
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
        $_SESSION ["account"] = $_POST ["nickName"]." ".$_POST ["password"];
      }
      else
      {
  	echo "<meta name='robots' content='noindex'/>";
  	include "menu.php";
  	echo "<p>
  	  Вы ввели неверный пароль! Попробуйте авторизироваться заново.
  	  </p>
  	  <form action='add147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
          <form action='add147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && (!isset ($_SESSION ["account"])) && ($_POST ["add"] != ""))
  {
    $isNickname = false;
  	$accountID = $_POST ["add"];
  	onBD ($result, "ACCOUNTS");
  	while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
  	  if ($row [3] == $accountID)
  	  {
  	  	$_SESSION ["account"] = $row [0]." ".$row [2];
  	    ob_start ();
        setcookie ("account", $row [0]." ".$row [2]);
  	  }
  }
  if ((isset ($_COOKIE ["account"])) || (isset ($_SESSION ["account"])) || ($accountID > 0))
  {
    echo "<meta name='robots' content='noindex'/>";
    include "menu.php";
    echo "<h3>
    Добавьте родственника
    </h3>
    <form method='post' name='form' action='add_rel147.php' enctype=
    'multipart/form-data' onsubmit='return overify (this)'>
    <p>
      <table style='border: 0'>
        <tr>
          <td>
            Пол родственника:
          </td>
          <td>
            <input type='radio' name='sex' value='none' checked/>Не указан<br/>
            <input type='radio' name='sex' value='male'/>Мужской<br/>
            <input type='radio' name='sex' value='female'/>Женский<br/>
          </td>
        </tr>
        <tr>
          <td>
            Имя родственника:
          </td>
          <td>
            <input type='text' name='r_name'></input>
          </td>
          </td>
        </tr>
        <tr>
          <td>
            Отчество родственника:          
          </td>
          <td>
            <input type='text' name='patronymic'></input>
          </td>
        </tr>
        <tr>
          <td>
            Фамилия родственника:
          </td>
          <td>
            <input type='text' name='sername'></input>
          </td>
        </tr>
        <tr>
          <td>
            Год рождения родственника (достоверный, или его оценка снизу):
          </td>
          <td>
            <input type='text' name='year_born'></input>
          </td>
        </tr>
        <tr>
          <td>
            Оценка сверху года рождения родственника (в случае отличия от оценки снизу):
          </td>
          <td>
            <input type='text' name='ybl'></input>
          </td>
        </tr>
        <tr>
          <td>
            Месяц рождения родственника:
          </td>
          <td>
            <select name='month_born' size='1'>
              <option value='none' selected/>Не указан
              <option value='1'/>Январь
              <option value='2'/>Февраль
              <option value='3'/>Март
              <option value='4'/>Апрель
              <option value='5'/>Май
              <option value='6'/>Июнь
              <option value='7'/>Июль
              <option value='8'/>Август
              <option value='9'/>Сентябрь
              <option value='10'/>Октябрь
              <option value='11'/>Ноябрь
              <option value='12'/>Декабрь
            </select>
          </td>
        </tr>
        <tr>
          <td>
            День рождения родственника:
          </td>
          <td>
            <select name='day_born' size='1'>
              <option value='none' selected/>Не указан";
            for ($i = 1; $i <= 31; $i++)
              echo "<option value='".$i."'/>".$i;
            echo "</select>
          </td>
        </tr>
        <tr>
          <td>
            Город рождения родственника:
          </td>
          <td>
            <input type='text' name='town_born'></input>
          </td>
        </tr>
        <tr>
          <td>
            Год смерти родственника (достоверный, или его оценка снизу):
          </td>
          <td>
            <input type='text' name='year_die'></input>
          </td>
        </tr>
        <tr>
          <td>
            Оценка сверху года смерти родственника (в случае отличия от оценки снизу):
          </td>
          <td>
            <input type='text' name='ydl'></input>
          </td>
        </tr>
        <tr>
          <td>
            Месяц смерти родственника:
          </td>
          <td>
            <select name='month_die' size='1'>
              <option value='none' selected/>Не указан
              <option value='1'/>Январь
              <option value='2'/>Февраль
              <option value='3'/>Март
              <option value='4'/>Апрель
              <option value='5'/>Май
              <option value='6'/>Июнь
              <option value='7'/>Июль
              <option value='8'/>Август
              <option value='9'/>Сентябрь
              <option value='10'/>Октябрь
              <option value='11'/>Ноябрь
              <option value='12'/>Декабрь
            </select>
          </td>
        </tr>
        <tr>
          <td>
            День смерти родственника:
          </td>
          <td> 
            <select name='day_die' size='1'>
              <option value='none' selected/>Не указан";
              for ($i = 1; $i <= 31; $i++)
                echo "<option value='".$i."'/>".$i;
            echo "</select>
          </td>
        </tr>
        <tr>
          <td>
            Город смерти родственника:
          </td>
          <td>
            <input type='text' name='town_die'></input>
          </td>
        </tr>
        <tr>
          <td>
            Выберите мать родственника:
          </td>
          <td>   
            <select name='mother' size='1'>
              <option value='none' selected/>Не указана";
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
              if (isset ($_SESSION ["account"]))
              {
                $i = 0;
                while (substr ($_SESSION ["account"], $i, 1) != " ")
                  $i++;
                $login = substr ($_SESSION ["account"], 0, $i);
                onBD ($result, "ACCOUNTS");
                while ($row = mysqli_fetch_array ($result))
                  if ($login == $row [0])
                    $accountID = $row [3];
              }
              onBD ($result, "PEOPLE");
              while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
                if (($row [12] == 2) && ($row [0] != "virt") && ($row [15] == $accountID))
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
  echo "</select>
        </td>
      </tr>
      <tr>
        <td>
          Выберите отца родственника:
        </td>
        <td> 
          <select name='father' size='1'>
            <option value='none' selected/>Не указан";
              onBD ($result, "PEOPLE");
              while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
              if (($row [12] == 1) && ($row [0] != "virt") && ($row [15] == $accountID))
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
  echo "</select>
        </td>
      </tr>
      <tr>
        <td>
          Здесь Вы можете ввести биографические сведенья о родственнике (ВУЗ, работу, ссылки на первоисточники
            и т. п.).
        </td>
        <td>";          
    $id = 0;
    onBD ($result, "PEOPLE");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [9] > $id)
        $id = $row [9];
          echo "<textarea name='bio' cols='60' rows='10' id='bio'></textarea>
        </td>
      </tr>
      <tr>
        <td>
          Здесь Вы можете загрузить фотографию родственника:
        </td>
        <td>
          <input name='myfile' type='file'/>
          <input type='hidden' name='account' value='".$accountID."'/>
        </td>
      </tr>
    </table>
    <p>
      <input type='submit' name='save' value='Добавить'/>
    </p>
    <div id='dest1'>
    </div>
    <div id='dest2'>
    </div>
    <div id='dest3'>
    </div>
  </form>";  
  include "footer.php";
  }
  if ((!isset ($_COOKIE ["account"])) && (!isset ($_SESSION ["account"])) && ($_POST ["nickName"] == "") &&
    ($_POST ["add"] == ""))
  {
  	echo "<meta name='robots' content='noindex'/>";
  	include "menu.php";
    echo "<p>
      Вы зашли на страницу добавления досье родственников на сайт. Для доступа к этому сервису
        авторизируйтесь, пожалуйста, на сайте.
      </p>
  	  <form action='add147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  CKEDITOR.replace ("bio");    
  function overify (f)
  {
    b = true;
    if (!f.nickName)
    {
      if ((f.year_born.value.length > 0) && !(f.year_born.value.match (/^\d*$/)))
      {
  	alert ("Год рожденья должен быть числом!");
  	b = false;
      }
      if ((f.ybl.value.length > 0) && !(f.year_born.value.match (/^\d*$/)))
      {
  	alert ("Оценка года рожденья должна быть числом!");
  	b = false;
      }
      if ((f.year_die.value.length > 0) && !(f.year_die.value.match (/^\d*$/)))
      {
	alert ("Год смерти должен быть числом!");
	b = false;
      }
      if ((f.ydl.value.length > 0) && !(f.year_born.value.match (/^\d*$/)))
      {
	alert ("Оценка года смерти должна быть числом!");
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
      if ((f.myfile.value.length != 0) && (!(f.myfile.value.match (reg2))) && 
    	(!(f.myfile.value.match (reg3))) && (!(f.myfile.value.match (reg4))) && 
    	(!(f.myfile.value.match (reg5))) && (!(f.myfile.value.match (reg6))) && 
    	(!(f.myfile.value.match (reg7))) && (!(f.myfile.value.match (reg8))) && 
    	(!(f.myfile.value.match (reg9))) && (!(f.myfile.value.match (reg10))) && 
    	(!(f.myfile.value.match (reg11))))
      {
    	alert ("Ошибка в расширении фотографии!"); 
    	b = false;
      }
      if ((f.photo_bio.value.length != 0) && (!(f.photo_bio.value.match (reg2))) && 
    	(!(f.photo_bio.value.match (reg3))) && (!(f.photo_bio.value.match (reg4))) && 
    	(!(f.photo_bio.value.match (reg5))) && (!(f.photo_bio.value.match (reg6))) && 
    	(!(f.photo_bio.value.match (reg7))) && (!(f.photo_bio.value.match (reg8))) && 
    	(!(f.photo_bio.value.match (reg9))) && (!(f.photo_bio.value.match (reg10))) && 
    	(!(f.photo_bio.value.match (reg11))))
      {
    	alert ("Ошибка в расширении фотографии!"); 
    	b = false;
      }
      if (f.r_name.value.indexOf (">") != -1)
      {
        alert ("Имя содержит закрывающийся тег XML!");
        b = false;
      }
      if (f.r_name.value.indexOf ("<") != -1)
      {
        alert ("Имя содержит открывающийся тег XML!");
        b = false;
      }
      if (f.r_name.value.indexOf (".") != -1)
      {
        alert ("Имя содержит точку!");
        b = false;
      }
      if (f.r_name.value.indexOf ("'") != -1)
      {
        alert ("Имя содержит одинарные кавычки!");
        b = false;
      }
      if (f.r_name.value.indexOf ("\"") != -1)
      {
        alert ("Имя содержит двойные кавычки!");
        b = false;
      }
      if (f.r_name.value.indexOf ("&") != -1)
      {
        alert ("Имя содержит амперсант!");
        b = false;
      }
      if (f.sername.value.indexOf (">") != -1)
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
      if (f.patronymic.value.indexOf (">") != -1)
      {
        alert ("Отчество содержит закрывающийся тег XML!");
        b = false;
      }
      if (f.patronymic.value.indexOf ("<") != -1)
      {
        alert ("Отчество содержит открывающийся тег XML!");
        b = false;
      }
      if (f.patronymic.value.indexOf (".") != -1)
      {
        alert ("Отчество содержит точку!");
        b = false;
      }
      if (f.patronymic.value.indexOf ("'") != -1)
      {
        alert ("Отчество содержит одинарные кавычки!");
        b = false;
      }
      if (f.patronymic.value.indexOf ("\"") != -1)
      {
        alert ("Отчество содержит двойные кавычки!");
        b = false;
      }
      if (f.patronymic.value.indexOf ("&") != -1)
      {
        alert ("Отчество содержит амперсант!");
        b = false;
      }
      if (f.town_born.value.indexOf (">") != -1)
      {
        alert ("Город рождения содержит закрывающийся тег XML!");
        b = false;
      }
      if (f.town_born.value.indexOf ("<") != -1)
      {
        alert ("Город рождения содержит открывающийся тег XML!");
        b = false;
      }
      if (f.town_born.value.indexOf (".") != -1)
      {
        alert ("Город рождения содержит точку!");
        b = false;
      }
      if (f.town_born.value.indexOf ("'") != -1)
      {
        alert ("Город рождения содержит одинарные кавычки!");
        b = false;
      }
      if (f.town_born.value.indexOf ("\"") != -1)
      {
        alert ("Город рождения содержит двойные кавычки!");
        b = false;
      }
      if (f.town_born.value.indexOf ("&") != -1)
      {
        alert ("Город рождения содержит амперсант!");
        b = false;
      }
      if (f.town_die.value.indexOf (">") != -1)
      {
        alert ("Город смерти содержит закрывающийся тег XML!");
        b = false;
      }
      if (f.town_die.value.indexOf ("<") != -1)
      {
        alert ("Город смерти содержит открывающийся тег XML!");
        b = false;
      }
      if (f.town_die.value.indexOf (".") != -1)
      {
        alert ("Город смерти содержит точку!");
        b = false;
      }
      if (f.town_die.value.indexOf ("'") != -1)
      {
        alert ("Город смерти содержит одинарные кавычки!");
        b = false;
      }
      if (f.town_die.value.indexOf ("\"") != -1)
      {
        alert ("Город смерти содержит двойные кавычки!");
        b = false;
      }
      if (f.town_die.value.indexOf ("&") != -1)
      {
        alert ("Город смерти содержит амперсант!");
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