<?php
  $index = 0;
  ob_start ();
  setcookie ("account", "");
  echo "<meta name='robots' content='noindex'/>";
  include "menu.php";
  include "functions147.php";
  if ($_GET ["id"] > 0)
  {
    $nom = "connection";
    onBD ($result, "TOPICS");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_GET ["id"])
        echo "<h3>
          Форум - ".$row [1]."
          </h3>";
    $dirct = "gb".$_GET ["id"];
    $hdl = opendir ($dirct);
    while ($file = readdir ($hdl)) 
      if (strstr ($file, $nom) == true)
        $a [] = $file;
    $l = sizeof ($a);
    if ($l == 0)
      echo "<p>
        Тема пока пуста.
        </p>";
    else
    {
      rsort ($a);
      foreach ($a as $k)
      {
        echo "<table cellpadding='5' style='border: 0' align='center' width='100%'>
          <tr>
          <td width='20%'>
          <p>
          №".$l;
        $file = fopen ($dirct."/".$k, "r");
        onBD ($result, "ACCOUNTS");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        {
          if ($row [3] == substr ($k, 21, strlen ($k) - 21))
          {
            echo "&nbsp;&nbsp;".date ("d/m/Y H:i", substr ($k, 10, 10)).
              "</p>
              </td>
              <td width='700' rowspan='2' >\n";
            echo fgets ($file, 10000);
            while (!feof ($file))
            {
      	      $i = 0;
              $temp = fgets ($file, 10000);
      	      while (substr ($temp, $i, 1) == " ")
      	        $i++;
      	      for ($j = 0; $j < $i; $j++)
      	        echo "&nbsp";
              echo substr ($temp, $i, strlen ($temp) - $i);
      	      $b = true;
      	      echo "<br/>";
            }
            echo "</td>
            </tr>
            <tr>
            <td width='100'>
            <p>".
            $row [0]
            ."</p>
            </td>
            </tr>
            </table>";
          }
        }
        fclose ($file);
        $l--;
      }
    }
    echo "<form method='post' action='otziv147.php?id=".$_GET["id"]."' name='form'
      onSubmit='return overify(this)'>
        <p>
          Чтоб иметь возможность добавлять в теме собственные сообщения, войдите на сайт под своим
          аккаунтом.<br/>
          Никнейм:<br/>
          <input type='text' name='nickName'/><br/>
          Пароль:<br/>
          <input type='password' name='password'/><br/>
          Текст сообщения:<br/>
          <textarea name='otziv' cols='60' rows='10'></textarea>
          <br/>
          <br/>
          <input type='hidden' name='topic_index' value=".$_GET["id"]."/>
          <input name='submit' type='submit' value='Добавить'/>
        </p>
      </form>";    
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
  include "footer.php";
?>

<script language="javascript">
  function overify (f)
  {
	b = true;
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
	if (f.otziv.value.length == 0)
	{
	  alert ("Вы не ввели текст сообщения!");
	  b = false;
	}
	if (f.nickName.value.indexOf (">") != -1)
	{
	  alert("Никнейм содержит закрывающийся тег XML!");
	  b = false;
	}
	if (f.nickName.value.indexOf ("<") != -1)
	{
	  alert("Никнейм содержит открывающийся тег XML!");
	  b = false;
	}
	if (f.nickName.value.indexOf ("'") != -1)
	{
	  alert("Никнейм содержит одинарные кавычки!");
	  b = false;
	}
	if (f.nickName.value.indexOf ("\"") != -1)
	{
	  alert("Никнейм содержит двойные кавычки!");
	  b = false;
	}
	if (f.nickName.value.indexOf ("&") != -1)
	{
	  alert("Никнейм содержит амперсант!");
	  b = false;
	}
	if (f.password.value.indexOf (">") != -1)
	{
	  alert("Пароль содержит закрывающийся тег XML!");
	  b = false;
	}
	if (f.password.value.indexOf ("<") != -1)
	{
	  alert("Пароль содержит открывающийся тег XML!");
	  b = false;
	}
	if (f.password.value.indexOf ("'") != -1)
	{
	  alert("Пароль содержит одинарные кавычки!");
	  b = false;
	}
	if (f.password.value.indexOf ("\"") != -1)
	{
	  alert("Пароль содержит двойные кавычки!");
	  b = false;
	}
	if (f.password.value.indexOf ("&") != -1)
	{
	  alert("Пароль содержит амперсант!");
	  b = false;
	}
	if (f.otziv.value.indexOf (">") != -1)
	{
	  alert("Текст сообщения содержит закрывающийся тег XML!");
	  b = false;
	}
	if (f.otziv.value.indexOf ("<") != -1)
	{
	  alert("Текст сообщения содержит открывающийся тег XML!");
	  b = false;
	}
	if (f.otziv.value.indexOf ("'") != -1)
	{
	  alert("Текст сообщения содержит одинарные кавычки!");
	  b = false;
	}
	if (f.otziv.value.indexOf ("\"") != -1)
	{
	  alert("Текст сообщения содержит двойные кавычки!");
	  b = false;
	}
	if (f.otziv.value.indexOf ("&") != -1)
	{
	  alert("Текст сообщения содержит амперсант!");
	  b = false;
	}
	return b;
  }
</script>