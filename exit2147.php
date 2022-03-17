<meta name="robots" content="noindex"/>
<?php
  $index = 0;
  ob_start ();
  setcookie ("account", "");
  include "menu.php";
  include "functions147.php";
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
  function overify(f)
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
    if (f.nickName.value.indexOf ("&") !=-1)
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
  }  
</script>