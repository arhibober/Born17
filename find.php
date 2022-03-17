<?php
  $index = 3;
  include "menu.php"; 
  echo "<h3>
    Введите какие-либо параметры родственника
    </h3>
    <form action='find_rel147.php' onSubmit='return overify(this)' method='post'>
      <p>
        <input type='text' name='req'/>
        <button type='submit'>
          <img src='lupa.gif' width='20' height='20'/>
        </button>
      </p>
    </form>";
  include "footer.php";
?>
<script language="javascript">
  function overify (f)
  {
    b = true;
    if (f.req.value.length == 0)
    {
      alert ("Введите запрос!");
      b = false;
    }
    if (f.req.value.indexOf (">") != -1)
    {
      alert ("Запрос содержит закрывающийся тег XML!");
      b = false;
    }
    if (f.req.value.indexOf ("<") != -1)
    {
      alert ("Запрос содержит открывающийся тег XML!");
      b = false;
    }
    if (f.req.value.indexOf ("'") != -1)
    {
      alert ("Запрос содержит одинарные кавычки!");
      b = false;
    }
    if (f.req.value.indexOf("\"") != -1)
    {
      alert ("Запрос содержит двойные кавычки!");
      b = false;
    }
    if (f.req.value.indexOf ("&") !=-1)
    {
      alert ("Запрос содержит амперсант!");
      b = false;
    }
    return b;
  }
</script>