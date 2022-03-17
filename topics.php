<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
  if ($_GET ["id"] > 0)
  {
    $nom = "connection";
    onBD ($result, "TOPICS");
    while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
      if ($row [0] == $_GET ["id"])
        echo "<h3>
          Форум - ".$row [1]."</h3>";
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
        echo "<div>
          <table cellpadding='5' style='border: 0' width='100%' align='center'>
          <tr>
          <td width='20%'>
          <p>
          №".$l;
        $file = fopen ($dirct."/".$k, "r");
        onBD ($result, "ACCOUNTS");
        while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
          if ($row [3] == substr ($k, 21, strlen ($k) - 21))
          {
            echo "&nbsp;&nbsp;".date ("d/m/Y H:i", substr ($k, 10, 10)).
              "</p>
              </td>
              <td width='700' rowspan='2'>\n";
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
              </table>
              </div>";
          }
        fclose ($file);
        $l--;
      }
    }
    if (isset ($_COOKIE ["account"]))
    {
      $i = 0;
      while (substr ($_COOKIE ["account"], $i, 1) != " ")
        $i++;
      $login = substr ($_COOKIE ["account"], 0, $i);
      $password = substr ($_COOKIE ["account"], $i + 1, strlen ($_COOKIE ["account"]) - $i - 1);
      $login_exist = false;
      onBD ($result, "ACCOUNTS");
      while ($row = mysqli_fetch_array ($result, MYSQLI_NUM))
        if ($row [0] == $login)
        {
      	  $login_exist = true;
          if ($row [2] == $password)
          {
            echo "<form method='post' action='otziv147.php?id=".$_GET ["id"]."' name='form'   
              onSubmit='return overify(this)'>
              <p>
                Вы зашли на сайт как ".$row [0]."<br/>
                <input type='hidden' name='nickName' value='".$row [0]."'/>
                <input type='hidden' name='password' value='".$row [2]."'/><br/>
                Текст сообщения:<br/>
                <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                <br/>
                <input type='hidden' name='topic_index' value=".$_GET ["id"]."/>
                <input name='submit' type='submit' value='Добавить'/>
              </p>
            </form>
            <form action='exit1147.php?id=".$_GET ["id"]."'>
      	      <p>
      	        <input type='submit' name='exit' value='Выйти из системы'/>
      	        <input type='hidden' name='id' value='".$_GET ["id"]."'/>
      	      </p>
      	    </form>";
          }
          else
            if (strlen($row2 [0]) > 0)
              echo "<form method='post' action='otziv147.php?id=".$_GET ["id"]."' name='form'                     onSubmit='return overify(this)'>
                <p>
                  Вы зашли на сайт как ".$row2 [0]."<br/>
                  <input type='hidden' name='nickName' value='".$row2 [0]."'/>
                  <input type='hidden' name='password' value='".$row2 [2]."'/><br/>
                  Текст сообщения:<br/>
                  <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                  <br/>
                  <input type='hidden' name='topic_index' value=".$_GET ["id"]."/>
                  <input name='submit' type='submit' value='Добавить'/>
                </p>
              </form>
              <form action='exit1147.php?id=".$_GET ["id"]."'>
      	        <p>
      	          <input type='submit' name='exit' value='Выйти из системы'/>
      	          <input type='hidden' name='id' value='".$_GET ["id"]."'/>
      	        </p>
      	      </form>";
          	else
              echo "<form method='post' action='otziv147.php?id=".$_GET ["id"]."' name='form'
                onSubmit='return overify(this)'>
                <p>
                  Чтоб иметь возможность добавлять в теме собственные сообщения, войдите на сайт под своим аккаунтом.<br/>
                  Никнейм:<br/>
                  <input type='text' name='nickName'><br/>
                  Пароль:<br/>
                  <input type='password' name='password'><br/>
                  Текст сообщения:<br>
                  <textarea name='otziv' cols='60' rows='10'></textarea><br/>
                  <br/>
                  <input type='hidden' name='topic_index' value=".$_GET ["id"]."/>
                  <input name='submit' type='submit' value='Добавить'/>
                </p>
              </form>";
        }
      if (!$login_exist)
      {
      	if (strlen($row2 [0]) > 0)
          echo "<form method='post' action='otziv147.php?id=".$_GET ["id"]."' name='form'                     onSubmit='return overify(this)'>
            <p>
              Вы зашли на сайт как ".$row2 [0]."<br/>
              <input type='hidden' name='nickName' value='".$row2 [0]."'/>
              <input type='hidden' name='password' value='".$row2 [2]."'/><br/>
              Текст сообщения:<br/>
              <textarea name='otziv' cols='60' rows='10'></textarea><br/>
              <br/>
              <input type='hidden' name='topic_index' value=".$_GET ["id"]."/>
              <input name='submit' type='submit' value='Добавить'/>
            </p>
            </form>
            <form action='exit1147.php?id=".$_GET ["id"]."'>
      	      <p>
      	        <input type='submit' name='exit' value='Выйти из системы'/>
      	        <input type='hidden' name='id' value='".$_GET ["id"]."'/>
      	      </p>
      	    </form>";
        else
          echo "<form method='post' action='otziv147.php?id=".$_GET ["id"]."' name='form'
            onSubmit='return overify(this)'>
            <p>
              Чтоб иметь возможность добавлять в теме собственные сообщения, войдите на сайт под своим аккаунтом.<br/>
              Никнейм:<br/>
              <input type='text' name='nickName'/><br/>
              Пароль:<br/>
              <input type='password' name='password'/><br/>
              Текст сообщения:<br/>
              <textarea name='otziv' cols='60' rows='10'></textarea><br/>
              <br/>
              <input type='hidden' name='topic_index' value=".$_GET ["id"]."/>
              <input name='submit' type='submit' value='Добавить'/>
            </p>
          </form>";
      }
    }
    else
      if (strlen($row2 [0]) > 0)
        echo "<form method='post' action='otziv147.php?id=".$_GET ["id"]."' name='form'          
          onSubmit='return overify(this)'>
          <p>
            Вы зашли на сайт как ".$row2 [0]."<br/>
            <input type='hidden' name='nickName' value='".$row2 [0]."'/>
            <input type='hidden' name='password' value='".$row2 [2]."'/><br/>
            Текст сообщения:<br/>
            <textarea name='otziv' cols='60' rows='10'></textarea><br/>
            <br/>
            <input type='hidden' name='topic_index' value=".$_GET ["id"]."/>
            <input name='submit' type='submit' value='Добавить'/>
          </p>
          </form>
          <form action='exit1147.php?id=".$_GET ["id"]."'>
          <p>
          <input type='submit' name='exit' value='Выйти из системы'/>
          <input type='hidden' name='id' value='".$_GET ["id"]."'/>
          </p>
          </form>";
      else
        echo "<form method='post' action='otziv147.php?id=".$_GET ["id"]."' name='form'
          onSubmit='return overify(this)'>
          <p>
            Чтоб иметь возможность добавлять в теме собственные сообщения, войдите на сайт под своим аккаунтом.<br/>
            Никнейм:<br/>
            <input type='text' name='nickName'/><br/>
            Пароль:<br/>
            <input type='password' name='password'/><br/>
            Текст сообщения:<br/>
            <textarea name='otziv' cols='60' rows='10'/></textarea><br/>
            <br/>
            <input type='hidden' name='topic_index' value=".$_GET ["id"]."/>
            <input name='submit' type='submit' value='Добавить'/>
          </p>
          </form>";    
  }
  else
    echo "Кажется, Вы ошиблись страницей.";
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
    return b;
    include "footer.php";
  }
</script>