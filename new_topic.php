<?php
  $index = 0;
  include "menu.php";
  include "functions147.php";
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
          echo "<p>
            Вы зашли на сайт как ".$row [0]."
          </p>
          <form method='post' action='otibd147.php' onSubmit='return overify(this)'>
            <p>
              Введите название новой темы:<br/>
              <input type='text' name='head' style='width: 300px;'/><br/>
              <input type='submit' value='Добавить'/>
            </p>
          </form>
      	  <form action='exit2147.php'>      	    
      	    <p>
      	      <input type='submit' name='exit' value='Выйти из системы'/>
      	    </p>
      	  </form>";
        else
          echo "<p>
            Для того, чтобы открыть новую тему, войдите, пожалуйста, на сайт под своим аккаунтом.
            </p>
            <form method='post' action='open_topic147.php' onSubmit='return overify(this)'>
              <p>
                Никнейм:<br/>
                <input type='text' name='nickName'/><br/>
                Пароль:<br/>
                <input type='password' name='password'/><br/>
                <input type='submit' value='Войти'/>
              </p>
            </form>";
      }
    if (!$login_exist)
    {
      echo "<p>
        Для того, чтобы открыть новую тему, войдите, пожалуйста, на сайт под своим аккаунтом.
        </p>
        <form method='post' action='open_topic147.php' onSubmit='return overify(this)'>
          <p>
            Никнейм:<br/>
            <input type='text' name='nickName'/><br/>
            Пароль:<br/>
            <input type='password' name='password'/><br/>
            <input type='submit' value='Войти'/>
          </p>
        </form>";
    }
  }
  else
    echo "<p>
      Для того, чтобы открыть новую тему, войдите, пожалуйста, на сайт под своим аккаунтом.
    </p>
    <form method='post' action='open_topic147.php' onSubmit='return overify(this)'>
      <p>
        Никнейм:<br/>
        <input type='text' name='nickName'/><br/>
        Пароль:<br/>
        <input type='password' name='password'/><br/>
        <input type='submit' value='Войти'/>
      </p>
    </form>";
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
      alert("Никнейм содержит амперсант!");
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
  }
</script>