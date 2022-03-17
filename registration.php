<?php
  $index = 0;
  include "menu.php";
  echo "<form action='reg_people147.php' method='post' onSubmit='return overify(this)'>
    <p>
      Ваш никнейм:<br/>
      <input type='text' name='nickName'/><br/>
      Ваш e-mail:<br/>
      <input type='text' name='email'/><br/>
      Ваш пароль:<br/>
      <input type='password' name='password'/><br/>
      <input type='submit' value='Зарегистрироваться'/>
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
    if (f.email.value.length == 0)
    {
      alert ("Вы не ввели e-mail!");
      b = false;
    }
    if (f.password.value.length == 0)
    {
      alert ("Вы не ввели пароль!");
      b = false;
    }
    reg = 	/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    if ((f.email.value.length!=0) && (!(f.email.value.match(reg))))
    {
      alert ("Ошибка: некорректный e-mail!"); 
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
    if (f.email.value.indexOf (">") != -1)
    {
      alert ("e-mail содержит закрывающийся тег XML!");
      b = false;
    }
    if (f.email.value.indexOf ("<") != -1)
    {
      alert ("e-mail содержит открывающийся тег XML!");
      b = false;
    }
    if (f.email.value.indexOf ("'") != -1)
    {
      alert ("e-mail содержит одинарные кавычки!");
      b = false;
    }
    if (f.email.value.indexOf ("\"") != -1)
    {
      alert ("e-mail содержит двойные кавычки!");
      b = false;
    }
    if (f.email.value.indexOf ("&") != -1)
    {
      alert ("e-mail содержит амперсант!");
      b = false;
    }
    return b;
  }
</script>