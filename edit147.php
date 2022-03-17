<?php
  $index = 0;
  include "functions147.php";
  $accounID = 0;
  $monthes = array ("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
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
    	    <form action='edit147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
        <form action='edit147.php' name='enter' onSubmit='return overify (this)' method='post'>
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
  if ((!isset ($_COOKIE ["account"])) && ($_POST ["edit"] != ""))
  {
    $isNickname = false;
    $accountID = $_POST ["edit"];
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
      while($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ($row [15] == $accountID)
        {
          $temp = $row [9];
          break;
        }
    }
    else
      $temp = 1;
    if (!isset ($_GET ["rels"]))
      $ind = $temp;
    else
	  $ind = $_GET ["rels"];
    if ($i > 0)
    {
      echo "<form method='post' name='form' action='edit_rel147.php' enctype=
        'multipart/form-data' onsubmit='return overify (this)'>
        <h3>
        Выберите родственника, данные о котором Вы хотите отредактировать
        </h3>
        <p>     
        <input type='hidden' name='topic' id='ind1' value='".$accountID."'/>
        <select size='1' name='rels' id='ind' onchange='submitForm1(\"edit147\")'>";
        onBD ($result, "PEOPLE");
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
        <div id='dest1'>";
        onBD ($result, "PEOPLE");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if ($row[9] == $ind)
          {
            echo "<table style='border: 0' align='center' id='edit'>
              <tr>
              <td style='width: 335px'>
              Пол родственника:
              </td>
              <td>
              <input type='radio' name='sex' value='none'";
              if ($row [12] == 0)
                echo " checked";
              echo "/>Не указан<br/>
              <input type='radio' name='sex' value='male'";
              if ($row [12] == 1)
                echo " checked";
              echo "/>Мужской<br/>
              <input type='radio' name='sex' value='female'";
              if ($row [12] == 2)
                echo " checked";
              echo "/>Женский<br/>
                </td>
                </tr>
                <tr>
                <td>
                Имя родственника:
                </td>
                <td>
              <input type='text' name='r_name' value='";
            if ($row [0] != "NULL")
              echo $row [0];
            else
              echo "Не задано";
            echo "'/></input>
              </td>
              </tr>
              <tr>
              <td>
                Отчество родственника:
              </td>
              <td>
              <input type='text' name='patronymic' value='";
            if ($row [1] != "NULL")
              echo $row [1];
            else
              echo "Не задано";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Фамилия родственника:
              </td>
              <td>
              <input type='text' name='sername' value='";
            if ($row [2] != "NULL")
              echo $row [2];
            else
              echo "Не задана";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Год рождения родственника (достоверный, или его оценка снизу):
              </td>
              <td>
              <input type='text' name='year_born' value='";
            if ($row [3] != 0)
            {
              if ($row [16] == 0)
                echo $row [3];
              else
                echo (2 * $row [3] - $row [16] - $row [18]);
            }
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Оценка сверху года рождения рождения (в случае отличия от оценки снизу):
              </td>
              <td>
              <input type='text' name='ybl' value='";
            if ($row [16] != 0)
              echo $row [16];
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Месяц рождения родственника:
              </td>
              <td>
              <select name='month_born' size='1'>
              <option value='none'";
            if ($row [4] == 0)
              echo " selected";
            echo "/>Не указан";
            for ($i = 1; $i < 13; $i++)
            {
              echo "<option value='".$i."'";
              if ($i == $row [4])
                echo " selected";
              echo "/>".$monthes [$i - 1];
            }
            echo "</select>
              </td>
              </tr>
              <tr>
              <td>  
              День рождения родственника:
              </td>
              <td>
              <select name='day_born' size='1'>
              <option value='none'";
            if ($row [5] == 0)
              echo " selected";
            echo "/>Не указан";
            for ($i = 1; $i <= 31; $i++)
            {
              echo "<option value='".$i."'";
              if ($row [5] == $i)
                echo " selected";
              echo"/>".$i;
            }
            echo "</select>
              </td>
              </tr>
              <tr>
              <td>
              Город рождения родственника:
              </td>
              <td>
              <input type='text' name='town_born' value='";
            if ($row [13] != "NULL")
              echo $row [13];
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Год смерти родственника (достоверный, или его оценка снизу):
              </td>
              <td>
              <input type='text' name='year_die' value='";
            if ($row [6] != 0)
            {
              if ($row [17] == 0)
                echo $row [6];
              else
                echo (2 * $row [6] - $row [17] - $row [18]);
            }
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
              <tr>
              <td>
              Оценка сверху года смерти рождения (в случае отличия от оценки снизу):
              </td>
              <td>
              <input type='text' name='ydl' value='";
            if ($row [17] != 0)
              echo $row [17];
            else
              echo "Не задан";
            echo "'></input>
              </td>
              </tr>
                <tr>
                <td>
                Месяц смерти родственника:
                </td>
                <td>
                <select name='month_die' size='1'>
                <option value='none'";
              if ($row [7] == 0)
                echo " selected";
              echo "/>Не указан";
              for ($i = 1; $i < 13; $i++)
              {
                echo "<option value='".$i."'";
                if ($i == $row [7])
                   echo " selected";
                 echo "/>".$monthes [$i - 1];
               }
               echo "</select>
                 </td>
                 </tr>
                 <tr>
                 <td>  
                 День смерти родственника:
                 </td>
                 <td> 
                 <select name='day_die' size='1'>
                 <option value='none'";
               if ($row [8] == 0)
                 echo " selected";
               echo "/>Не указан";
               for ($i = 1; $i <= 31; $i++)
               {
                 echo "<option value='".$i."'";
                 if ($row [8] == $i)
                   echo " selected";
                 echo "/>".$i;
               }
               echo "</select>
                 </td>
                 </tr>
                 <tr>
                 <td>
                 Город смерти родственника:
                 </td>
                 <td>
                 <input type='text' name='town_die' value='";
               if ($row [14] != "NULL")
                 echo $row [14];
               else
                 echo "Не задан";
               echo "'></input>
                 </td>
                 </tr>
                 <tr>
                 <td>
                 Здесь Вы можете исправить выбор матери родственника:
                 </td>
                 <td> 
                 <select name='mother' size='1'>
                 <option value='none'/>Не указана";
               onBD ($result1, "PEOPLE");
               while ($row1 = mysqli_fetch_array($result1))
                 if (($row1 [12] == 2) && ($row1 [9] != $row [9]) && ($row1 [0] != "virt") && ($row [15] == $accountID))
                 {
                   echo "<option value='".$row1 [9]."'";
                   if ($row1 [9] == $row [10])
                     echo " selected";
                   echo "/>";
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
              echo "</select>
                </td>
                </tr>
                <tr>
                <td>
                Здесь Вы можете исправить выбор отца родственника:
                </td>
                <td>  
                <select name='father' size='1'>
                <option value='none'/>Не указан";
              onBD ($result1, "PEOPLE");
              while ($row1 = mysqli_fetch_array ($result1, MYSQLI_NUM))
                if (($row1 [12] == 1) && ($row1 [9] != $row [9]) && ($row1 [0] != "virt") && ($row [15] == $accountID))
                {
                  echo "<option value='".$row1 [9]."'";
                  if ($row1 [9] == $row [11])
                    echo " selected";
                  echo "/>";
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
              echo "</select>
                </td>
                </tr>
                <tr>
                <td>";
            if (file_exists ("bio".$row [9].".txt"))
            {
              echo "Здесь Вы можете отредактировать биографические сведенья о родственнике.<br/> 
                </td>
                <td>
                <textarea name='bio' cols='60' rows='10' id='bio'>";
              include "bio".$row [9].".txt";
              echo "</textarea>
                </td>
                </tr>
                <tr>
                <td>";
            }
            else
              echo "Здесь Вы можете ввести биографические сведенья о родственнике (ВУЗ, работу, ссылки на первоисточники и т. п.).
                </td>
                <td>
                  <textarea name='bio' cols='60' rows='10' id='bio'></textarea>
                </td>
              </tr>
              <tr>
            <td>";
            $b = false;
            $dirct = "portraits";
            $hdl = opendir ($dirct);
            while ($file = readdir ($hdl)) 
              if (strstr ($file, "PHOTO".$row [9].".") == true)
              {
                $b = true;
                echo "Здесь Вы можете обновить фотографию родственника:<input name='myfile' TYPE='file'/>
                  </td>
                  <td>
                  <img src='portraits/".$file."' width='300px' alt=''/><br/>
                  <input type='checkbox' name='removePhoto'/>Удалить фотографию вообще
                </td>
                </tr>
                <tr>
                <td>";
                break;
              }
			  else
				echo "<input type='hidden' name='removePhoto' value='false'/>";
            if (!$b)
			  echo "Здесь Вы можете загрузить фотографию родственника:<input name='myfile' type='file'/>
                </td>
                <td>
                  &nbsp;
                </td>
                </tr>
                </table>";  
            echo "<input type='hidden' name='n' value='".$row [9]."'/>
			  <input type='hidden' name='visHid' value='";
		    if (file_exists ("bio".$row [9].".txt"))
            {
			  echo " lll ";
			  $file = fopen ("bio".$row [9].".txt", "r");
			  $text = "";      
			  while (!feof ($file))
              {
				$k = 0;
				$temp = fgets ($file, 10000);
				while (substr ($temp, $k, 1) == " ")
      	          $k++;
				for ($j = 0; $j < $k; $j++)
      	          $text = $text."&nbsp";
				$text = $text.addLink (substr ($temp, $k, strlen ($temp) - $k))."</br>";
              }
			  echo $text;
          }
          echo "'/>";
        }
        echo "</div>
        <input type='hidden' name='account' value='".$_POST ["edit"]."'/>
    	<div id='dest1'>
    	</div>
    	<div id='dest2'>
    	</div>
    	<div id='dest3'>
    	</div>
        <p>
        <input type='submit' name='save' value='Отредактировать'/>
        </p>
        </form>";
    }
    else
      echo "<p>
      Ни об одном Вашем родственнике в базе данных сведений пока не содержится.
      </p>";
  }
  if (!isset ($_COOKIE ["account"]) && ($_POST ["nickName"] == "") && ($accountID == ""))
  {
    echo "<meta name='robots' content='noindex'/>";
  	include "menu.php";
    echo "<p>
      Вы зашли на страницу редактирования досье своих родственников на сайт. Для доступа к этому сервису
        авторизируйтесь, пожалуйста, на сайте.
      </p>
  	  <form action='edit147.php' name='enter' onSubmit='return overify(this)' method='post'>
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
  CKEDITOR.replace ("bio");
  function overify (f)
  {
    b = true;
    if (!f.nickName)
    {
      b = true;
      if ((f.year_born.value.length > 0) && !(f.year_born.value.match(/^\d*$/)) &&
       (f.year_born.value != "Не задан"))
      {
	alert ("Год рожденья должен быть числом либо стандартной надписью по умолчанию \"Не задан\"!");
	b = false;
      }
      if ((f.ybl.value.length > 0) && !(f.ybl.value.match (/^\d*$/)) && (f.ybl.value != "Не задан"))
      {
  	alert ("Оценка года рожденья должна быть числом либо стандартной надписью по умолчанию \"Не задан\"!");
  	b = false;
      }
      if ((f.year_die.value.length > 0) && !(f.year_die.value.match(/^\d*$/)) &&
        (f.year_die.value != "Не задан"))
      {
	alert ("Год смерти должен быть числом либо стандартной надписью по умолчанию \"Не задан\"!");
	b = false;
      }
      if ((f.ydl.value.length > 0) && !(f.ydl.value.match (/^\d*$/)) && (f.ydl.value != "Не задан"))
      {
  	alert ("Оценка года смерти должна быть числом либо стандартной надписью по умолчанию \"Не задан\"!");
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
        alert("Ошибка в расширении фотографии!"); 
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
        alert (".Отчество содержит точку!");
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
      if (f.town_born.value.indexOf("<") != -1)
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
        alert("Город смерти содержит закрывающийся тег XML!");
        b = false;
      }
      if (f.town_die.value.indexOf ("<") != -1)
      {
        alert ("Город смерти содержит открывающийся тег XML!");
        b = false;
      }
      if (f.town_die.value.indexOf (".") !=-1)
      {
        alert ("Город смерти содержит точку!");
        b = false;
      }
      if (f.town_die.value.indexOf ("'") !=-1)
      {
        alert("Город смерти содержит одинарные кавычки!");
        b = false;
      }
      if (f.town_die.value.indexOf("\"")!= -1)
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